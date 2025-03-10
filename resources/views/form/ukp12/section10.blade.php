<div id="kompeten-vertical" class="content">
    <div class="content-header">
        <h5 class="mb-0">Bahagian 9 - Rekod Pensijilan Kekompetenan</h5>
        <small class="text-notice">Sila kemas kini di bahagian KELULUSAN/KOMPETENSI/SUMBANGAN di portal MyKj jika ada perubahan </small>
    </div>
    <div class="row">
        {{-- <div class="form-group col-md-12">
            <br/>
            <button type="button" class="btn btn-success tambah-profesional" data-toggle="modal" data-target="#modal-kompeten"><i data-feather='plus'></i>Tambah</button>
        </div> --}}
        <div class="table-responsive col-md-12">
            <table class="datatables table -table">
                <thead>
                    <th>Bil.</th>
                    <th>Pensijilan Kekompetenan</th>
                    <th>Tahap</th>
                    {{-- <th>Fail</th>
                    <th>Aksi</th> --}}
                </thead>
                <tbody id="tbody-kompeten">
                @foreach ($profile['kompeten'] as $k)
                <td>{{ $loop->iteration }}</td>
                <td>{{ $k->nama_kelulusan }}</td>
                <td>{{ $k->tahap }}</td>
                @endforeach
                @if($profile['kompeten']->count() == 0)
                <tr data-kompeten-id="">
                    <td colspan="3" style="text-align: center; font-style: italic;">{{ 'Tiada Data' }}</td>
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
