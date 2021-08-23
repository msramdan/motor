<div class="page-title">
    <div class="title_left">
        <h3>CICILAN/KREDIT</h3>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="box-body">
                    <div class="input-group" style="max-width: 50%; margin: auto;">
                        <input type="text" id="tbinvoice" class="form-control" placeholder="Masukan Invoice" value="<?php echo $invoice_id ?>">
                        <span class="input-group-btn">
                            <button class="btn btn-primary" id="btnsearchinvoice" type="button">Go!</button>
                        </span>
                    </div>
                    <div id="infoinvoicewrapper" style="margin-top: 3vh;">
                        <div class="info" style="display: flex; flex-direction: column;margin-top: 17vh; text-align: center;">
                            <div class="icon"><i class="fa fa-search" style="font-size: 65px"></i></div>
                            <h3 class="title" style="color: #9d9d9d;s">Data invoice akan muncul disini</h3>
                        <div>
                    </div>
                    <p>Tidak dapat menginput invoice? coba cari di <a class="btn btn-warning btn-xs" href="<?php echo base_url().'Sale' ?>">daftar penjualan</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    const initsearch = () => {
        const invoice = $('#tbinvoice').val()
        $('#infoinvoicewrapper').html(`<div class="info" style="display: flex; flex-direction: column;margin-top: 17vh; text-align: center;">
                            <div class="icon"><i class="fa fa-circle-o-notch fa-spin" style="font-size: 65px"></i></div>
                            <h3 class="title" style="color: #9d9d9d;s">Mencari data...</h3>
                        <div>`)
        $.ajax({
            type : "POST",
            url  : "<?php echo base_url() ?>/R_cicilan/searchInvoice",
            data : {
                idinvoice: invoice
            },
            success: function(data){
                // const dt = JSON.parse(data)
                setTimeout(function(){
                    $('#infoinvoicewrapper').html(data);
                },2000)
            },
            error: function(e){
              setTimeout(function(){
                    $('#infoinvoicewrapper').html('Server mengalami masalah, silahkan coba lagi');
                },2000)
            }
        });
    }

    $(document).ready(function(){
        if ($('#tbinvoice').val()) {
            console.log('it has value!!!')
            initsearch()
        } else {
            console.log('wohooww')
        }
    })

    $('#btnsearchinvoice').on('click', function() {
        initsearch()
    })

    $(document).on('submit','#update_cicilan_payment_form', function(e){
        dataString = $("#update_cicilan_payment_form").serialize();

        e.preventDefault()

        $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>R_cicilan/update_payment",
            data: dataString,
            success: function(data){
                // alert('Successful!');
                Swal.fire({
                  icon: 'success',
                  title: "Pembayaran disimpan"
                })

                $('#infoinvoicewrapper').html(data);
            }
        });
    });

    $(document).on('click','.btn-show-input', function() {
        $(this).parents('td').prev().prev().prev().children('div.input-group').css('margin-top','0vh')
        $(this).parents('div.x_content').children('button.btn.btn-primary.dropdown-toggle').prop('disabled', true)
    })

    $(document).on('click','.cancel-input-cicilan',function() {
        $(this).parents('.input-group').css('margin-top','-40px')
        $(this).parents('td').next().next().next().children('div.x_content').children('button.btn.btn-primary.dropdown-toggle').prop('disabled', false)

    })

    $(document).on('click','.submit-cicilan', function() {

        const thisel = $(this)

        thisel.html('<i class="fa fa-circle-o-notch fa-spin"></i>')
        thisel.attr('disabled','disabled')

        const id_cicilan = $(this).next().next().val()
        const bayar = $(this).parents('.container-submit-cicilan-action').prev().val()
        const invoice = $('.id_sale').val()
        const elemtxtdibayar = $(this).parents('td').next().children('span')
        const elempenginput = $(this).parents('td').next().next().children('span')
        const pembayaranke = $(this).parents('.container-submit-cicilan-action').prev().prev().val()

        $.ajax({
            type : "POST",
            url  : "<?php echo base_url() ?>/R_cicilan/update_cicilan",
            data : {
                idcicilan:id_cicilan,
                valuecicilan:bayar,
                idinvoice: invoice,
                pembayaranke: pembayaranke
            },
            success: function(data){
                const dt = JSON.parse(data)

                thisel.parents('.input-group').prev('.bton-action').children('.btn-show-input').css('display','unset')
                thisel.parents('.input-group').prev('.bton-action').children('span.status').html(dt.label)
                thisel.parents('.input-group').css('margin-top','-40px')
                elemtxtdibayar.text(dt.tglinput)
                elempenginput.text(dt.penginput)

                thisel.html('<i class="fa fa-check"></i>')
                thisel.removeAttr('disabled')
                refreshData(invoice)
                thisel.parents('td').next().next().next().children('div.x_content').children('button.btn.btn-primary.dropdown-toggle').prop('disabled', false)

                if (dt.lunaskah == 'Lunas') {
                    Swal.fire({
                      icon: 'success',
                      title: "Cicilan Lunas"
                    })
                }

                if (dt.lunaskah == 'Lunas dengan denda') {
                    Swal.fire({
                      icon: 'warning',
                      title: "Cicilan Lunas",
                      text: "Masih ada denda yang belum terbayar"
                    })
                }
            }
        });
    })

    function refreshTabel(invoice) {
        $.ajax({
            type : "POST",
            url  : "<?php echo base_url() ?>/R_cicilan/refresh_cicilan_table",
            data : {
                idinvoice: invoice
            },
            success: function(data){
                $('.tabel-pembayaran-cicilan').html(data)
            }
        })        
    }

    function refreshInfopembayaran(invoice) {
        $.ajax({
            type : "POST",
            url  : "<?php echo base_url() ?>R_cicilan/refresh_info_pembayaran",
            data : {
                idinvoice: invoice
            },
            success: function(data){
                $('.info-pembayaran-wrapper').html(data)
            }
        })        
    }

    function refreshData(invoice) {
        refreshTabel(invoice)
        refreshInfopembayaran(invoice)
    }

    $(document).on('click','#btn-reload', function() {
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
          }
        })

        const a = $(this).data('invoice')

        $('.loading-table-indicator-wrapper').css('display','flex')
        setTimeout(function() {
            $('.loading-table-indicator-wrapper').css('display','none')
            refreshTabel(a)
            Toast.fire({
              icon: 'success',
              title: 'Refresh Berhasil'
            })
        }, 1000)
    })

    $(document).on('submit','#bayar_denda_form', function(e){
        dataString = $("#bayar_denda_form").serialize();

        const thisel = $(this)

        inv = $('input[name="invoicehidden"]').val()

        e.preventDefault()
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>R_cicilan/bayarDenda",
            data: dataString,
            success: function(data){

                const a = JSON.parse(data)

                if (a.status === 'bayarnyakelebihan') {
                    thisel.children('div.modal-body').children('div.warningalert').html(`<div class="alert alert-info">
                                    <p>Pembayaran melebihi yang ditentukan, menyesuaikan pembayaran...</p>
                                </div>`)
                    thisel.children('div.modal-body').children('input[name="tbjumlahbayar"]').val('')
                    thisel.children('div.modal-body').children('input[name="tbjumlahbayar"]').val(a.recommendedvalue)
                }

                if (a.status === 'udahlunas') {
                    thisel.children('div.modal-body').children('div.alert.alert-info').html(`<div class="alert alert-success">
                                    <p>Pembayaran denda sudah lunas</p>
                                </div>`)
                }

                if (a.status === 'success') {
                    Swal.fire({
                      icon: 'success',
                      title: "Pembayaran disimpan"
                    })

                    $('.loading-table-indicator-wrapper').css('display','flex')

                    setTimeout(function() {
                        $('.loading-table-indicator-wrapper').css('display','none')
                        refreshTabel(inv)
                    }, 1000)
                    $(".modal").modal("hide")
                }
            },
            error: function(e){
                refreshTabel(inv)
                $('.loading-table-indicator-wrapper').css('display','none')
            }
        });
    });

</script>