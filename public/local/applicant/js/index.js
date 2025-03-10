$(document).on('click','.view-form, .back-main, .verdict-applicant, .btn-verdict, .view-lnpt',function() {
    let selectedClass = $(this);
    if(selectedClass.hasClass('view-form')) {
        let pemohon_id =  selectedClass.closest('tr').attr('data-pemohon-id');
    //    let pemohonan_id = $('#hdn_id_application').val();
        window.open(getUrl() + '/form/ukp12/nview/'+pemohon_id+'?view=l','_self');
    } else if(selectedClass.hasClass('back-main')) {
        window.open(getUrl() + '/urussetia/appl/main/','_self');
    } else if(selectedClass.hasClass('verdict-applicant')) {
        let pemohon_id =  selectedClass.closest('tr').attr('data-pemohon-id');
        $('.pemohon-id-modal').val(pemohon_id);
        $.ajax({
            type:'GET',
            url: getUrl() + '/urussetia/appl/calon/info?id='+pemohon_id,
            dataType: "json",
            processData: false,
            contentType: false,
            context: this,
            success: function(data) {
                let success = data.success;
                let parseData = data.data;
                if(success == 1) {
                    $('#verdict-nama').val(parseData.nama);
                    $('#verdict-nokp').val(parseData.nokp);
                    $('#verdict-jawatan').val(parseData.jawatan);
                    $('#verdict-gred').val(parseData.gred);
                    if(parseData.status == 'LL') {
                        $('#radio-verdict-1').attr('checked','checked');
                        $('#radio-verdict-2').removeAttr('checked');
                        $('#radio-verdict-3').removeAttr('checked');
                    } else if(parseData.status == 'GL') {
                        $('#radio-verdict-1').removeAttr('checked');
                        $('#radio-verdict-2').attr('checked','checked');
                        $('#radio-verdict-3').removeAttr('checked');
                    } else if(parseData.status == 'LS') {
                        $('#radio-verdict-1').removeAttr('checked');
                        $('#radio-verdict-2').removeAttr('checked');
                        $('#radio-verdict-3').attr('checked','checked');
                    }

                    $('.verdict-modal').modal('show');
                }
            }
        });
    } else if(selectedClass.hasClass('btn-verdict')) {
        let pemohon_id =   $('.pemohon-id-modal').val();
        var data = new FormData;
        var verdict = $('.radio-verdict').filter(':checked').val();
        data.append('_token', getToken());
        data.append('pemohon_id',pemohon_id);
        data.append('verdict',verdict);
        swalAjax({
            titleText : 'Adakah Anda Pasti?',
            mainText : 'Data akan diubah',
            icon: 'info',
            confirmButtonText: 'Simpan',
            postData: {
                url : '/urussetia/appl/calon/verdict',
                data: data,
                postfunc: function(data) {
                    let success = data.success;
                    let parseData = data.data;
                    if(success == 1) {
                        //swalPostFire('success', 'Berjaya Disimpan', 'Data sudah disimpan');
                        toasting('Data sudah berjaya disimpan', 'success');
                    } else if(success == 0) {
                        //swalPostFire('error', 'Gagal Disimpan', 'Ralat telah berlaku');
                        toasting('Ralat telah berlaku, Data telah gagal disimpan', 'error');
                    }

                    $('.verdict-modal').modal('hide');
                    DatatableUI.reloadTable('.table-pemohon');
                },
            }
        });
    } else if(selectedClass.hasClass('view-lnpt')) {
        let pemohon_id =  selectedClass.closest('tr').attr('data-pemohon-id');
        window.open(getUrl() + '/form/ukp12/nview/'+pemohon_id+'?view=l','_self');
    }
});
