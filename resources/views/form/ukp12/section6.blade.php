<div id="perkhidmatan-vertical" class="content">
    <div class="content-header">
        <h5 class="mb-0">Bahgaian 5 - Jawatan/Penempatan Sepanjang Perkhidmatan</h5>
        <small class="text-notice">Sila kemas kini di bahagian PENGALAMAN di portal MyKj jika ada perubahan </small>
    </div>

    <div class="row">
        {{-- <div class="form-group col-md-12">
            <br/>
            <button type="button" class="btn btn-success tambah-calon" data-toggle="modal" data-target="#modal-penempatan"><i data-feather='plus'></i>Tambah</button>
        </div> --}}
        <div class="table-responsive col-md-12">
            <table class="datatables table -table">
                <thead>
                    <th>Bil.</th>
                    <th>Gelaran Jawatan</th>
                    <th>Penempatan</th>
                    <th>Tahun Berkhidmat</th>
                </thead>
                <tbody id="tbody-khidmat">
                    @foreach ($profile['pengalaman'] as $pengalaman)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $pengalaman->gelaran_jawatan->gelaran_jawatan ?? '' }}</td>
                        <td>{{ $pengalaman->tempat }}</td>
                        <td>{{  \Carbon\Carbon::parse($pengalaman->tkh_mula )->format('Y') }}</td>
                    </tr>
                    @endforeach
                    @if($profile['pengalaman']->count() == 0)
                    <tr data-pengalaman-id="">
                        <td colspan="4" style="text-align: center; font-style: italic;">{{ 'Tiada Data' }}</td>
                    </tr>


                    @endif
                </tbody>
            </table>
        </div>

    </div>
    <br/>
    <br/>
    <div class="d-flex justify-content-between">
        <button type="button" class="btn btn-primary btn-prev">
            <i data-feather="arrow-right" class="align-middle mr-sm-25 mr-0"></i>
            <span class="align-middle d-sm-inline-block d-none">Sebelum</span>
        </button>
        <button type="button" class="btn btn-primary btn-next">
            <span class="align-middle d-sm-inline-block d-none">Selanjutnya</span>
            <i data-feather="arrow-left" class="align-middle ml-sm-25 ml-0"></i>
        </button>
    </div>
</div>
