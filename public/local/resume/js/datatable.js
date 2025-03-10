$('.table-resume').DataTable({
    processing: true,
    serverSide: true,
    ajax: getUrl() + '/urussetia/resume/senarairesume',
    lengthChange:true,
    columns: [
        {data: 'nokp'},
        {data: 'nama'},
        {data: 'kod_gred'},
        {data: 'jawatan'},
        {data: 'status'},
        {data: 'aksi'},
    ],
    createdRow: function( row, data, dataIndex ) {
        $(row).addClass('pinkform-row');
    },
    columnDefs: [
       
        // {
        //     targets: -2,
        //     title: 'Status',
        //     orderable: false,
        //     render: function (data, type, full, meta) {
        //         console.log(full);
        //         let row_flag = full.status;
        //         if(row_flag == 'L') {
        //             return (
        //                 '<div class="badge badge-primary">Lengkap</div>'
        //             );
        //         } else if(row_flag == 'TL'){
        //             return (
        //                 '<div class="badge badge-warning">Tidak Lengkap</div>'
        //             );
               
        //         }

        //     }
        // },
        {
            // Actions
            targets: -1,
            title: 'Tindakan',
            orderable: false,
            render: function (data, type, full, meta) {
                let row_status = full.status;
                let nokp = full.nokp;
                let btn = '';
          
                    btn += 
                    '<button type="button" class="btn btn-icon btn-outline-info mr-1 mb-1 waves-effect waves-light hantar-signal" >'+ feather.icons['send'].toSvg() +' Hantar</button>' +
                    '<a href="/urussetia/resume/resume/'+nokp+'" class="btn btn-icon btn-outline-danger mr-1 mb-1 waves-effect waves-light data-toggle="_blank" data-target=">'+ feather.icons['printer'].toSvg() +' Cetak</a>' +
                    '<a href="/urussetia/resume/lampiran3/'+nokp+'" class="btn btn-icon btn-outline-success mr-1 mb-1 waves-effect waves-light data-toggle="_blank" data-target=">'+ feather.icons['printer'].toSvg() +' Lampiran 3</a>'

               
                return btn;
            }
        }
    ],
    dom:
        '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-right"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
    lengthMenu: [10, 15, 25, 50, 75, 100],
    buttons: [,
        // {
        //     text: feather.icons['plus'].toSvg({ class: 'mr-50 font-small-4' }) + 'Tambah Kumpulan',
        //     className: 'create-new btn btn-primary add-kumpulan',
        //     attr: {
        //         'data-toggle': 'modal',
        //         'data-target': '#modals-slide-in'
        //     },
        //     init: function (api, node, config) {
        //         $(node).removeClass('btn-secondary');
        //     }
        // }
    ],
    responsive: {
        details: {
            display: $.fn.dataTable.Responsive.display.modal({
                header: function (row) {
                    var data = row.data();
                    return 'Details of ' + data['full_name'];
                }
            }),
            type: 'column',
            renderer: function (api, rowIdx, columns) {
                var data = $.map(columns, function (col, i) {
                    return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                        ? '<tr data-dt-row="' +
                        col.rowIndex +
                        '" data-dt-column="' +
                        col.columnIndex +
                        '">' +
                        '<td>' +
                        col.title +
                        ':' +
                        '</td> ' +
                        '<td>' +
                        col.data +
                        '</td>' +
                        '</tr>'
                        : '';
                }).join('');

                return data ? $('<table class="table"/>').append(data) : false;
            }
        }
    },
    language: {
        paginate: {
            // remove previous & next text from pagination
            previous: '&nbsp;',
            next: '&nbsp;'
        }
    }
});
