<?php

namespace App\Http\Controllers\Urussetia;

use App\Http\Controllers\Controller;
use App\Models\Mykj\ListPegawai2;
use App\Models\Mykj\Perkhidmatan;
use DateTime;
use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf;
use App\Http\Controllers\Common\CommonController;
use App\Models\File;
use App\Models\MyKj\Cuti;
use App\Models\Mykj\Gaji;
use App\Models\MyKj\Harta;
use App\Models\Mykj\Kelayakan;
use App\Models\MyKj\Pengalaman;
use App\Models\Mykj\Peristiwa;
use App\Models\MyKj\Waris;
use App\Models\Permohonan\Harta as PermohonanHarta;
use App\Models\Permohonan\Pemohon;
use App\Models\Permohonan\Pertubuhan;
use App\Models\Permohonan\PinjamanPendidikan;
use App\Models\Profail\Peribadi;
use App\Models\Urussetia\Calon;
use App\Models\Pink\LampiranKursus;
use App\Models\Pink\LampiranProjek;
use App\Models\Pink\LampiranBebanKerja;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Pdf;
use Yajra\DataTables\DataTables;


class ResumeController extends Controller
{
    protected $fpdf;
    public function __construct()
    {
        $this->fpdf = new Fpdf;
    }


    public function mockup4(Request $request){
   
        $model = Role::all();
        return view('mockup4')->with('roles',$model);
    }

        public function lampiran(Request $request){
             

        return view('urussetia.lampiran.lampiran',[
            
        ]);
    }

     public function open(Request $request,$id) {
        $nokp = $request->input('kp');
        $lampirankursus = LampiranKursus::where('nokp',$nokp)->get();
        $lampiranbeban = LampiranBebanKerja::where('nokp',$nokp)->get();
        $lampiranprojek = LampiranProjek::where('nokp',$nokp)->get();
 

        $user = User::where('nokp',$nokp)->first();

        return view('urussetia.lampiran.lampiran',[
            "nokp"=>$nokp,
            "lampirankursus"=>$lampirankursus,
            "lampiranbeban"=>$lampiranbeban,
            "lampiranprojek"=>$lampiranprojek,
            "user"=>$user
        ]);
    }

        public function save_kursus(Request $request) {
        $nokp = $request->input('nokp');
        $tajuk = $request->input('tajuk');
        $mula = $request->input('mula');
        $tamat = $request->input('tamat');
        $tempat = $request->input('tempat');
        $user = $request->input('user');
       //$id = $request->input('pemohonId');
        //$nokp = $request->input('nokp');
 
        $model = new LampiranKursus;
        $model->flag = 1;
        $model->delete_id = 0;
        $model->nama_kursus = $tajuk;
        $model->tkh_mula = $mula;
        $model->tkh_tamat = $tamat;
        $model->tempat = $tempat;
        $model->nokp = $nokp;
        $model->user_id = $user;
        $model->created_by = $nokp;
        $model->updated_by = $nokp;

        if($model->save()) {
            return response()->json([
                'success' => 1,
                'data' => [
                    'tajuk' => $model->nama_kursus,
                    'mula' => $model->tkh_mula,
                    'tamat' => $model->tkh_tamat,
                    'tempat' => $model->tempat,
                    'nokp' =>$model->nokp,
                    'id' => $model->id
                ]
            ]);
        } else {
            return response()->json([
                'success' => 0,
                'data' => []
            ]);
        }
    }


     public function save_projek(Request $request) {
        $tajuk = $request->input('tajuk');
        $kos = $request->input('kos');
        $nokp = $request->input('nokp');
        $user = $request->input('user');

        $model = new LampiranProjek;
        $model->flag = 1;
        $model->delete_id = 0;
        $model->nama_projek = $tajuk;
        $model->kos_projek = $kos;
        $model->created_by = $nokp;
        $model->nokp = $nokp;
        $model->user_id = $user;
        $model->created_by = $nokp;
        $model->updated_by = $nokp;

        if($model->save()) {
            return response()->json([
                'success' => 1,
                'data' => [
                    'tajuk' => $model->nama_projek,
                    'kos' => $model->kos_projek,
                    'id' => $model->id
                ]
            ]);
        } else {
            return response()->json([
                'success' => 0,
                'data' => []
            ]);
        }
    }

    public function delete_kursus(Request $request) {
        $LampiranKursusID =  $request->input('id');

        $model = LampiranKursus::find($LampiranKursusID);

        if($model->delete()) {
            return response()->json([
                'success' => 1,
                'data' => []
            ]);
        } else {
            return response()->json([
                'success' => 0,
                'data' => []
            ]);
        }
    }

     public function delete_projek(Request $request) {
        $LampiranProjekID =  $request->input('id');

        $model = LampiranProjek::find($LampiranProjekID);

        if($model->delete()) {
            return response()->json([
                'success' => 1,
                'data' => []
            ]);
        } else {
            return response()->json([
                'success' => 0,
                'data' => []
            ]);
        }
    }

     public function save_beban(Request $request) {
        $lampiran = $request->file('lampiran_beban');
        $nokp = $request->input('nokp');
        $model = new LampiranBebanKerja;
        if($lampiran){
            $upload = CommonController::upload_image($lampiran, 'documents');
            
            $model->path = '/documents/'.$upload;
            $model->nokp =  $nokp;
            $model->save();
        }

        return response()->json(["success"=>true,"uploaded"=>true, "url"=>$model->path]);
    }

    

    public function senarai_pengguna(Request $request) {
        // echo '<pre>';
        // print_r($request->all()['search']['value']);
        // echo '</pre>';
        // die();

        $search = $request->all()['search']['value'];


        $model = DB::connection('pgsqlmykj')->table('list_pegawai2  as p')->select('p.nokp','p.nama','p.kod_gred','p.jawatan');

        if($search){
            $model->where('nokp','ilike', '%'.$search.'%')->orWhere('nama', 'ilike', '"%'.$search.'%"')->limit(10)->get();
        }else{
            $model->limit(10)->get();
        }

                  return DataTables::of($model)
                ->setRowAttr([
                    'data-nama' => function($data) {
                        return $data->nama;
                    },
                    'data-kod_gred' => function($data) {
                        return $data->kod_gred;
                    },
                    'data-jawatan' => function($data) {
                        return $data->jawatan;
                    },
                    'data-nokp' => function($data) {
                        return $data->nokp;
                    },
                ])
                ->addColumn('nokp', function($data) {
                    return $data->nokp;
                })
                ->addColumn('nama', function($data) {
                    return $data->nama;
                })
                ->addColumn('kod_gred', function($data) {
                    return $data->kod_gred;
                })
                ->addColumn('jawatan', function($data) {
                    return $data->jawatan;
                })
                ->addColumn('status', function($data) {
                    $lbk = LampiranBebanKerja::select('nokp')->where('nokp', $data->nokp)->first() ? true : false;
                    $lk = LampiranKursus::select('nokp')->where('nokp', $data->nokp)->first() ? true : false;
                    $lp = LampiranProjek::select('nokp')->where('nokp', $data->nokp)->first() ? true : false;

                    if($lbk && $lk && $lp){
                        return '<div class="badge badge-primary">Lengkap</div>';
                    }else{
                        return '<div class="badge badge-danger">Tidak Lengkap</div>';
                    }
                })
                ->addColumn('aksi', function($data) {
                    return 1;
                })
                ->rawColumns([ 'status'])
                ->make(true);
    }

    public function carian_pengguna(Request $request){
        $data = [];
        $search_term = $request->input('q');
        $peribadi = DB::connection('pgsqlmykj')->table('list_pegawai2 as p')->select('p.*')->where('nokp', 'ilike', '%'.$search_term.'%')
            ->orWhereRaw("LOWER(nama) ilike '%".$search_term."%'")->limit(20)->get();

        if(count($peribadi) != 0){
            foreach($peribadi as $p){
                $data[] = array(
                    'id' => $p->nokp,
                    'text' => $p->nama.' - '.$p->nokp
                );
            }
        }

        return response()->json([
            'data' => $data
        ]);
    }

   public function mockup4_b(Request $request
    ){
        $model= [];

        if($request->input('nokp')){
            $model=ListPegawai2::getMaklumatPegawai($request->input('nokp'));
           // $tmp = Perkhidmatan::where('nokp', $ic)->where('kod_gred','J41')->first();
            // echo '<pre>';
            // print_r($model);
            // echo '</pre>';            // die();
        }
        

        
        return view('mockup4_b', [
            'user' => $model
        ]);
    }


     public function senarai(Request $request,$id) {
         $model = Role::all();
        return view('mockup4')->with('roles',$model);
    }

    
public function lampiran3($ic) 
    {
    $lampiran_beban = LampiranBebanKerja::where('nokp',$ic)->orderBy('id','desc')->first();
      $pdf = Pdf::loadView('$lampiran_beban->path', compact('lampiran_beban'));
        return $pdf->stream("dompdf_out.pdf", array("Attachment" => false, 'enable_remote' => true));
        exit(0);
     }       

    public function document($ic) 
    {
        $model= [];
        $mula_khidmat ='';

        $model=ListPegawai2::getMaklumatPegawai($ic);
        $mula_khidmat=Perkhidmatan::where('nokp',$ic)->where('kod_kumpulan',3)->orderBy('tkh_lantik', 'asc')->first();
        $mula_gred_hakiki=Perkhidmatan::where('nokp',$ic)->where('kod_kumpulan',3)->where('status_perkhidmatan','H')->orderBy('tkh_lantik', 'desc')->first();
        $modelp = Pengalaman::where('nokp', $ic)->where('kod_aktiviti','>=', [50])->groupBy('id_pengalaman','kod_aktiviti')->orderBy('kod_aktiviti')->get();

        // $mula_p = Pengalaman::where('nokp',$ic)->orderBy('tkh_mula','asc')->groupBy('kod_aktiviti','id_pengalaman')->first();
        // dd($mula_p);
        //SEKTOR AWAM
        $sektor_awam_mula = Perkhidmatan::where('nokp',$ic)->orderBy('tkh_lantik','asc')->first();
        $sektor_awam_tamat = Carbon::now();     
        $date2 = new DateTime($sektor_awam_mula->tkh_lantik);
        $date1 = new DateTime($sektor_awam_tamat);
        $tempoh_awam = $date1->diff($date2);

         //PNP
        $pnp = Perkhidmatan::where('nokp',$ic)->where('kod_kumpulan','>=',3)->orderBy('tkh_lantik','asc')->first();
        $sektor_awam_tamat = Carbon::now();     
        $date2 = new DateTime($pnp->tkh_lantik);
        $date1 = new DateTime($sektor_awam_tamat);
        $tempoh_pnp = $date1->diff($date2);
           // echo '<pre>';
           //  print_r($tempoh_awam);
           //  echo '</pre>';
           //  die();
        $pengalaman = DB::connection('pgsqlmykj')->table('public.pengalaman as p')
                                         ->leftJoin('public.l_aktiviti as la','p.kod_aktiviti','la.kod_aktiviti')->select('p.kod_aktiviti','la.aktiviti')
                                        ->where('p.nokp',$ic)
                                        ->where('p.kod_aktiviti','>=',23)
                                        ->orderBy('p.kod_aktiviti')
                                        ->groupBy('p.kod_aktiviti','la.aktiviti')
                                        ->distinct()
                                        ->get();
        $pengalaman_mula = DB::connection('pgsqlmykj')->table('public.pengalaman as p')
                                         ->select('p.kod_aktiviti','p.tkh_mula','p.tkh_tamat')
                                        ->where('p.nokp',$ic)
                                        ->where('p.kod_aktiviti','>=',23)
                                        ->orderBy('p.kod_aktiviti')
                                        ->groupBy('p.kod_aktiviti','p.tkh_mula','p.tkh_tamat')
                                        ->distinct()
                                        ->get();

        $lampiran_kursus = LampiranKursus::where('nokp',$ic)->get();
        $lampiran_beban = LampiranBebanKerja::where('nokp',$ic)->orderBy('id','desc')->first();
        $lampiran_projek = LampiranProjek::where('nokp',$ic)->get();
     

                    
        $pdf = Pdf::loadView('admin.user.resume.cetak', compact('model','mula_khidmat','mula_gred_hakiki','tempoh_awam','pengalaman','pengalaman_mula','lampiran_kursus','lampiran_beban','lampiran_projek','tempoh_pnp','modelp'));
        return $pdf->stream("dompdf_out.pdf", array("Attachment" => false, 'enable_remote' => true));
        exit(0);
    }







   

      public function email(Request $request) {
         $nokp = $request->input('nokp');
        //$kod_jawatan = $request->input('kod_jawatan');

         // $pegawais=DB::connection('pgsqlmykj')->table('list_pegawai_naikpangkat as np')
         //    ->select('np.nokp','np.nama','np.email')
         //    ->whereIn('np.nokp',$list_nokp)->get();
       $content = [
                     'link' => url('/')."/urussetia/resume/display/8?kp=".$nokp
                   
                ];
                Mail::mailer('smtp')->send('mail.lampiran-mail',$content,function($message) {
                    // testing purpose
                    $message->to('haryana@vn.net.my');

                    
                    $message->subject('KEMASKINI LAMPIRAN');

                });

        return response()->json([
            'success' => 1,
            'data' => [
                'nokp' => $nokp,]
        ]);
    }

    


}
