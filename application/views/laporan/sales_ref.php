<div class="page-title">
    <div class="title_left">
        <h3>LAPORAN PENJUALAN</h3>
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="box-body">
                <form class="form-horizontal">
                  <fieldset>
                    <div class="col-md-10">
                        <div class="control-group">
                          <div class="controls">
                            <div class="input-prepend input-group">
                              <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                              <input type="text" name="datarange-picker" id="datarange-picker" class="form-control" value="01/01/2016 - 01/25/2016" />
                              <input type="hidden" name="tbtglstart" id="tbtglstart" value="<?php echo date('Y-m-d') ?>">
                              <input type="hidden" name="tbtglend" id="tbtglend" value="<?php echo date('Y-m-d') ?>">
                            </div>
                          </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary btn-large btn-block btninitsearch">CARI</button>
                    </div>
                    <div class="col-md-12">
                        <div>
                            <div class="x_panel" style="height: auto;">
                              <div class="x_title">
                                <h2>Filter</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                  <li style="float: right;"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                  </li>
                                </ul>
                                <div class="clearfix"></div>
                              </div>
                              <div class="x_content" style="display: none;">
                                <div class="col-12">
                                    <table class="table">
                                        <tr>
                                            <td>Kategori</td>
                                            <td>:</td>
                                            <td>
                                                <select id="selectsalesref" name="selectsalesref">
                                                    <option value="">ALL</option>
                                                    <?php foreach($mitrasaleslist as $data)
                                                    {
                                                    	?>
                                                    		<option value="<?php echo 'Mitra Sales-'.$data->mitra_id ?>"><?php echo $data->nama_mitra ?></option>
                                                    	<?php
                                                    } ?>

                                                    <?php foreach($karyawanlist as $data)
                                                    {
                                                    	?>
                                                    		<option value="<?php echo 'Karyawan-'.$data->karyawan_id ?>"><?php echo $data->nama_karyawan ?></option>
                                                    	<?php
                                                    } ?>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                              </div>
                            </div>
                        </div>
                    </div>
                  </fieldset>
                </form>
                <div id="datawrapper" style="margin-top: 3vh;">
                    <div class="info" style="display: flex; flex-direction: column;margin-top: 17vh; text-align: center;">
                        <div class="icon"><i class="fa fa-database" style="font-size: 65px"></i></div>
                        <h3 class="title" style="color: #9d9d9d;s">Data Sales Referral akan muncul disini</h3>
                    <div>
                </div>
                <p><span><i class="fa fa-question-circle"></i></span> Mulai dengan memilih tanggal yang ingin dilihat pada isian diatas</p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="<?php echo base_url()?>assets/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript">

    function fetch_salesref_report() {
        $('#datawrapper').html(`<div class="info" style="display: flex; flex-direction: column;margin-top: 17vh; text-align: center;">
                                <div class="icon"><i class="fa fa-circle-o-notch fa-spin" style="font-size: 65px"></i></div>
                                <h3 class="title" style="color: #9d9d9d;s">Memproses Permintaan...</h3>
                            <div>`)

        const from = $('#tbtglstart').val()
        const end = $('#tbtglend').val()

        const namasalesref = $('#selectsalesref').val()

        $.ajax({
            type : "POST",
            url  : "<?php echo base_url() ?>/Lap_salesref/fetch_tabel_salesref",
            data : {
                fromDate: from,
                toDate: end,
                selectsalesreferral: namasalesref,
                allunit: 'false'
            },
            success: function(data){
                // const dt = JSON.parse(data)
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
        fetch_salesref_report()
    });


    $('#datarange-picker').daterangepicker({
	    "startDate": moment().format('DD-MM-YYYY'),
	    "endDate": moment().format('DD-MM-YYYY')
	}, function(start, end, label) {
	  console.log("New date range selected: " + start.format('YYYY-MM-DD') + " to " + end.format('YYYY-MM-DD') + " (predefined range: " + label + ")")
      $('#tbtglstart').val(start.format('YYYY-MM-DD'))
      $('#tbtglend').val(end.format('YYYY-MM-DD'))
	});


</script>