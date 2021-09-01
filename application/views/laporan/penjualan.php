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
                    <div class="control-group">
                      <div class="controls">
                        <div class="input-prepend input-group">
                          <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                          <input type="text" name="datarange-picker" id="datarange-picker" class="form-control" value="01/01/2016 - 01/25/2016" />
                        </div>
                      </div>
                    </div>
                  </fieldset>
                </form>
                <div id="datawrapper" style="margin-top: 3vh;">
                    <div class="info" style="display: flex; flex-direction: column;margin-top: 17vh; text-align: center;">
                        <div class="icon"><i class="fa fa-database" style="font-size: 65px"></i></div>
                        <h3 class="title" style="color: #9d9d9d;s">Data penjualan akan muncul disini</h3>
                    <div>
                </div>
                <p><span><i class="fa fa-question-circle"></i></span> Mulai dengan memilih tanggal penjualan yang ingin dilihat pada isian diatas</p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="<?php echo base_url()?>assets/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript">
	
  function fetch_sale_report(from, to) {

    $('#datawrapper').html(`<div class="info" style="display: flex; flex-direction: column;margin-top: 17vh; text-align: center;">
                            <div class="icon"><i class="fa fa-circle-o-notch fa-spin" style="font-size: 65px"></i></div>
                            <h3 class="title" style="color: #9d9d9d;s">Memproses Permintaan...</h3>
                        <div>`)
    $.ajax({
        type : "POST",
        url  : "<?php echo base_url() ?>/Lap_penjualan/fetch_tabel_penjualan",
        data : {
            fromDate: from,
            toDate: to,
            allunit: 'true'
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


  $('#datarange-picker').daterangepicker({
	    "startDate": moment().format('DD-MM-YYYY'),
	    "endDate": moment().format('DD-MM-YYYY')
	}, function(start, end, label) {
	  console.log("New date range selected: " + start.format('YYYY-MM-DD') + " to " + end.format('YYYY-MM-DD') + " (predefined range: " + label + ")")
    fetch_sale_report(start.format('YYYY-MM-DD'),end.format('YYYY-MM-DD'))
	});


</script>