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
        $(this).parents('div').next('.input-group').css('margin-top','0vh')
        $(this).css('display','none')
    })

    $(document).on('click','.cancel-input-cicilan',function() {
        $(this).parents('.input-group').prev('.bton-action').children('.btn-show-input').css('display','unset')
        $(this).parents('.input-group').css('margin-top','-6vh')

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

                // if (typeof dt.denda !== 'string' || dt.denda === 'denda belum lunas') {
                //     thisel.parents('.input-group').prev('.bton-action').children('span.button-bayar-cicilan-wrapper').html('<button type="button" class="btn btn-warning btn-xs"><i class="fa fa-warning"></i></button>')

                //     alert(dt.denda)
                // }


                if (dt.statusbayarcicilanini == 'dibayar') {
                    refreshtablecicilan(invoice)
                }

                thisel.parents('.input-group').prev('.bton-action').children('.btn-show-input').css('display','unset')
                thisel.parents('.input-group').prev('.bton-action').children('span.status').html(dt.label)
                thisel.parents('.input-group').css('margin-top','-6vh')
                elemtxtdibayar.text(dt.tglinput)
                elempenginput.text(dt.penginput)

                thisel.html('<i class="fa fa-check"></i>')
                thisel.removeAttr('disabled')

                if (dt.lunaskah == 'Lunas') {
                    Swal.fire({
                      icon: 'success',
                      title: "Cicilan Lunas"
                    })
                }

                if (dt.lunaskah == 'Lunas dengan denda') {
                    Swal.fire({
                      icon: 'warning',
                      title: "Lunas tapi masih ada denda yang belom kebayar"
                    })
                }
            }
        });
    })

    function refreshtablecicilan(invoice) {
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
            refreshtablecicilan(a)
            Toast.fire({
              icon: 'success',
              title: 'Refresh Berhasil'
            })
        }, 1000)
    })

</script>