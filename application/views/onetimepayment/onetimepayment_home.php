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
                        <input type="text" id="tbinvoice" class="form-control" placeholder="Masukan Invoice">
                        <span class="input-group-btn">
                            <button class="btn btn-primary" id="btnsearchinvoice" type="button">Go!</button>
                        </span>
                    </div>
                    <div id="infoinvoicewrapper" style="margin-top: 3vh;">
                        <div style="display: flex; flex-direction: column;margin-top: 17vh; text-align: center;">
                            <div><i class="fa fa-search" style="font-size: 65px"></i></div>
                            <h3 style="color: #9d9d9d;s">Data invoice akan muncul disini</h3>
                        <div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        if ($('#tbinvoice').val()) {
            alert('it has value!!!')
        } else {
            alert('wohooww')
        }
    })
    
    $('#btnsearchinvoice').on('click', function() {
        const invoice = $('#tbinvoice').val()
        $.ajax({
            type : "POST",
            url  : "<?php echo base_url() ?>/R_onetimep/searchInvoice",
            data : {
                idinvoice: invoice
            },
            success: function(data){
                // const dt = JSON.parse(data)
                $('#infoinvoicewrapper').html(data);
            }
        });
    })

    $(document).on('submit','#update_otp_payment_form', function(e){
        dataString = $("#update_otp_payment_form").serialize();

        e.preventDefault()

        $.ajax({
            type: "POST",
            url: "R_onetimep/update_payment",
            data: dataString,
            success: function(data){
                // alert('Successful!');
                Swal.fire({
                  icon: 'success',
                  title: "Cicilan Lunas"
                })

                $('#infoinvoicewrapper').html(data);
            }
        });

    });


</script>