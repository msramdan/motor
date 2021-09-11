<div class="page-title">
    <div class="title_left">
        <h3>ONE TIME PAYMENT</h3>
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
                            <p>Tidak dapat menginput invoice? coba cari di <a class="btn btn-warning btn-xs" href="<?php echo base_url().'Sale' ?>">daftar penjualan</a></p>
                        <div>
                    </div>
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
            url  : "<?php echo base_url() ?>/R_onetimep/searchInvoice",
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

    $(document).on('submit','#update_otp_payment_form', function(e){
        dataString = $("#update_otp_payment_form").serialize();

        e.preventDefault()

        $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>R_onetimep/update_payment",
            data: dataString,
            success: function(data){
                // alert('Successful!');
                Swal.fire({
                  icon: 'success',
                  title: "Pembayaran Tersimpan"
                })

                $('#infoinvoicewrapper').html(data);
            }
        });

    });


</script>