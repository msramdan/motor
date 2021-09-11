<div class="page-title">
    <div class="title_left">
        <h3>HISTORY PELANGGAN</h3>
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="box-body">
                <form class="form-horizontal">
                  <fieldset>
                    <div class="col-sm-12 col-md-8 col-xs-8">
                        <div class="control-group">
                          <div class="controls">
                            <div class="input-prepend input-group">
                              <span class="add-on input-group-addon"><i class="glyphicon glyphicon-user fa fa-user"></i></span>
                              <input type="number" name="tbno" id="tbno" class="form-control" placeholder="Masukan nomor KTP/KK">
                            </div>
                          </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-2 col-xs-2">
                    	<select id="typedataselect" name="typedataselect" class="select2_single form-control" tabindex="-1">
                            <option value="KTP" >KTP</option>
                            <option value="KK">KK</option>
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-2 col-xs-2">
                        <button class="btn btn-primary btn-large btn-block btninitsearch">CARI</button>
                    </div>
                  </fieldset>
                </form>
                <div id="datawrapper" style="margin-top: 3vh;">
                    <div class="info" style="display: flex; flex-direction: column;margin-top: 17vh; text-align: center;">
                        <div class="icon"><i class="fa fa-database" style="font-size: 65px"></i></div>
                        <h3 class="title" style="color: #9d9d9d;s">Data History Pelanggan akan muncul disini</h3>
                    <div>
                </div>
                <p><span><i class="fa fa-question-circle"></i></span> Mulai dengan memilih memasukan nomor KTP atau KK</p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="<?php echo base_url()?>assets/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript">

    function fetch_history_pelanggan() {
        $('#datawrapper').html(`<div class="info" style="display: flex; flex-direction: column;margin-top: 17vh; text-align: center;">
                                <div class="icon"><i class="fa fa-circle-o-notch fa-spin" style="font-size: 65px"></i></div>
                                <h3 class="title" style="color: #9d9d9d;s">Memproses Permintaan...</h3>
                            <div>`)

        const tbno = $('#tbno').val()
        const typedataselect = $('#typedataselect').val()

        $.ajax({
            url  : "<?php echo base_url() ?>/Lap_historypel/fetch_tabel_history_pelanggan",
            type : "POST",
            data : {
                tbno: tbno,
                typedata: typedataselect,
            },
            success: function(data){
                setTimeout(function(){
                    $('#datawrapper').html(data);
                },2000)
            },
            error: function(e){
              setTimeout(function(){
                    $('#datawrapper').html('Server mengalami masalah, silahkan coba lagi');
                },2000)
            }
        });
    }

    $(document).on('click','.btninitsearch', function(e){
        e.preventDefault()
        fetch_history_pelanggan()
    });
</script>