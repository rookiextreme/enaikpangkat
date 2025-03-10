<?php
namespace App\Http\Controllers\Segment\Pemangku\Tawaran;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Common\CommonController;
use App\Models\Mykj\ListPegawai2;
use App\Models\Permohonan\Pemohon;
use App\Models\Permohonan\PenerimaanUkp11;
use App\Models\Pink\SuratPink;
use App\Models\RoleUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use PHP_CodeSniffer\Util\Common;
use Yajra\DataTables\DataTables;
use App\Models\File;
use Pdf;
use App\Models\User;

class PemangkuTawaranController extends Controller{
    public function index(){
        return view('segment.pemangku.tawaran.index');
    }

    public function getPinkFormList(){
        $model = DB::connection('pgsql')->table('pemohon as p')
        ->join('peribadi as b','p.id_peribadi','b.id')
        ->join('permohonan_ukp12 as u','p.id_permohonan','u.id')
        ->select('p.id','b.nokp','b.nama','u.jawatan','u.gred','u.jenis','p.status')
        ->whereIn('p.status', array(Pemohon::SUCCESSED, Pemohon::WAITING_REPLY, Pemohon::ACCEPTED))
        ->where('p.flag',1)
        ->where('p.delete_id',0)
        ->get();

        return DataTables::of($model)
            ->setRowAttr([
                'data-pemohon-id' => function($data) {
                    return $data->id;
                },
                'data-person-nokp' => function($data) {
                    return $data->nokp;
                }
            ])
            ->addColumn('nokp', function($data){
                return $data->nokp;
            })
            ->addColumn('action', function($data){
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function hantar(Request $request){
        $pink = CommonController::getModel(SuratPink::class, 0);
        $pink->id_pemohon = $request->input('pemohon_id');
        $pink->no_surat = $request->input('pinkform_name');
        $pink->tkh_lapor_diri = $request->input('pinkform_tkh');
        $pink->save();

        if($request->file('pinkform_borang')){
            $upload = CommonController::base64_upload($request->file('pinkform_borang'));
            $file = new File;
            $file->content_bytes = $upload['base64'];
            $file->ext = $upload['ext'];
            $file->filename = $pink->id.'.'.$upload['ext'];
            $file->save();
        }
        $pink->fail_id = $file->id;
        $pink->save();

        $ukp11 = CommonController::getModel(PenerimaanUkp11::class, 0);
        $ukp11->id_pemohon = $pink->id_pemohon;
        $ukp11->save();

        $pemohon = CommonController::getModel(Pemohon::class, 1, $pink->id_pemohon);
        $pemohon->status = Pemohon::WAITING_REPLY;
        $pemohon->save();

        return response()->json([
            'success' => 1,
        ]);
    }

    public function preview_pdf($id){
        $data = Pemohon::find($id);

        $pdf = Pdf::loadView('segment.pemangku.tawaran.preview', compact('data'));
//        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream("preview_tawaran.pdf");
        exit(0);
    }

    public function updateTawaran($id){
        $pemohon = Pemohon::with('pemohonPeribadi', 'pemohonPink', 'pemohonPermohonan')->where('id', $id)->first();
        return view('segment.pemangku.tawaran.tawaran_update', [
            'data' => $pemohon,
            'pemohon_id' => $id
        ]);
    }

    public function updateTawaranPost(Request $request){
        $tawaran_setuju = $request->input('tawaran_setuju');
        $tawaran_tkh_kuatkuasa_baru = $request->input('tawaran_tkh_kuatkuasa_baru');
        $tawaran_tkh_lapor_diri = $request->input('tawaran_tkh_lapor_diri');
        $tawaran_tkh_mula_tugas = $request->input('tawaran_tkh_mula_tugas');
        $tawaran_ketua_bahagian = $request->input('tawaran_ketua_bahagian');
        $tawaran_ketua_jabatan = $request->input('tawaran_ketua_jabatan');
        $pemohon_id = $request->input('pemohon_id');
        $tawaran_tkh_tangguh_start = $request->input('tawaran_tkh_tangguh_start');
        $tawaran_tkh_tangguh_end = $request->input('tawaran_tkh_tangguh_end');
        $tawaran_surat_tangguh =  $request->file('tawaran_surat_tangguh');

        $pemohon = Pemohon::find($pemohon_id);
        $pemohon->status = $tawaran_setuju;

        $ukp11 = PenerimaanUkp11::where('id_pemohon', $pemohon_id)->first();
        $ukp11->status_terima_pemangkuan = $tawaran_setuju == 'TL' ? 1 : 0;
        $ukp11->tkh_status_terima_pemangkuan = date('Y-m-d');
        $ukp11->tkh_kuatkuasa_pemangkuan_pinkform = date('Y-m-d', strtotime($pemohon->pemohonPink->tkh_lapor_diri));
        $ukp11->tkh_lapor_diri = date('Y-m-d', strtotime($tawaran_tkh_lapor_diri));
        $ukp11->tkh_kuatkuasa_pemangkuan = date('Y-m-d', strtotime($tawaran_tkh_mula_tugas));
        $ukp11->id_surat_pink = $pemohon->pemohonPink->id;

        $kerani = ListPegawai2::getMaklumatPegawai($tawaran_ketua_bahagian);
        $ketuaJabatan = ListPegawai2::getMaklumatPegawai($tawaran_ketua_jabatan);

        $ukp11->nokp_kerani = $tawaran_ketua_bahagian;
        $ukp11->nama_kerani = $kerani['name'];
        $ukp11->jawatan = $kerani['jawatan'];
        $ukp11->cawangan = $kerani['waran_name']['cawangan'];

        $keraniUser = User::upsert($tawaran_ketua_bahagian);

        $ukp11->nokp_ketua_jabatan = $tawaran_ketua_jabatan;
        $ukp11->nama_ketua_jabatan = $ketuaJabatan['name'];
        $ukp11->jawatan_ketua_jabatan = $ketuaJabatan['jawatan'];
        $ukp11->cawangan_ketua_jabatan = $ketuaJabatan['waran_name']['cawangan'];

        $kbUser = User::upsert($tawaran_ketua_jabatan);

        $checkKerani = RoleUser::where('role_id', 5)->where('user_id', $keraniUser->id)->first();
        $checkKB = RoleUser::where('role_id', 6)->where('user_id', $kbUser->id)->first();

        if(!$checkKerani){
            DB::table('role_user')->insert([
                'role_id' => 5,
                'user_id' => $keraniUser->id,
                'user_type' => 'App\Models\User',
            ]);
        }

        if(!$checkKB) {
            DB::table('role_user')->insert([
                'role_id' => 6,
                'user_id' => $kbUser->id,
                'user_type' => 'App\Models\User',
            ]);
        }
        $ukp11->save();
        $pemohon->save();

//        if($tawaran_tkh_tangguh_start == '' && $tawaran_tkh_tangguh_end == ''){
//            if($tawaran_surat_tangguh){
//                $upload = CommonController::base64_upload($tawaran_surat_tangguh);
//                $file = new File;
//                $file->content_bytes = $upload['base64'];
//                $file->ext = $upload['ext'];
//                $file->filename = $ukp11->id.'.'.$upload['ext'];
//                $file->save();
//            }
//        }

        return response()->json([
            'success' => 1,
        ]);
    }
}
