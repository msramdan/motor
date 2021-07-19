<div class="">
    <div class="alert alert-success alert-dismissible fade in" role="alert" style="margin-top: 60px">
        <strong>Selamat Datang <?= ucfirst($this->fungsi->user_login()->nama_user)?> || <?= $this->session->userdata('nama_unit')?></strong>
    </div>
    <div class="row top_tiles">
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-users"></i></div>
                <div class="count"><?php echo $countpelanggan; ?></div>
                <h3>Pelanggan</h3>
            </div>
        </div>
        
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-truck"></i></div>
                <div class="count"><?php echo $countagen; ?></div>
                <h3>Agen</h3>
            </div>
        </div>
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-cube "></i></div>
                <div class="count"><?php echo $countitem; ?></div>
                <h3>Data Item</h3>
            </div>
        </div>
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-user"></i></div>
                <div class="count"><?php echo $countkaryawan; ?></div>
                <h3>Karyawan</h3>
            </div>
        </div>
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12" id="update_admin_fee"
                    data-ramdan="<?=$admin_fee->nominal ?>"
                    data-toggle="modal" data-target=".bs-example-modal-sm">
            <div class="tile-stats">
                <div class="count"><?= rupiah($admin_fee->nominal) ?></div>
                <h3><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <span>Admin Fee</span></h3>
            </div>
        </div>
         <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12" id="update_bunga"
                    data-bunga="<?=$bunga->nominal ?>"
                    data-toggle="modal" data-target=".bs-example-modal-sm2">
            <div class="tile-stats">
                <div class="count"><?= $bunga->nominal ?> %</div>
                <h3><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <span>Bunga Cicilan</span></h3>
            </div>
        </div>

        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-money"></i></div>
                <div class="count"><?php echo $countjenispembayaran; ?></div>
                <h3><span>Jenis Pembayaran</span></h3>
            </div>
        </div>
    </div>
</div>

<!-- Small modal -->

                  <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel2">Admin Fee</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="number" name="ramdan2" class="form-control" id="ramdan2" min="0" >
                            </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          <button type="button" class="btn btn-primary" id="submit_update">Update</button>
                        </div>

                      </div>
                    </div>
                  </div>
                  <!-- /modals -->

                   <!-- modal bunga -->
                  <div class="modal fade bs-example-modal-sm2" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel2">Bunga Cicilan</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="number" name="bunga_cicilan" class="form-control" id="bunga_cicilan" min="0" >
                            </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          <button type="button" class="btn btn-primary" id="submit_update_bunga">Update</button>
                        </div>

                      </div>
                    </div>
                  </div>
                  <!-- /modals -->

                  <div class="x_panel" style="">
                  <div class="x_content">
                    <div class="well" style="overflow: auto">
                      <div class="col-md-12">
                        <div class="control-group">
                              <div class="controls">
                                <div class="input-prepend input-group">
                                    <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                                    <input type="text" name="datepickerreport" id="datepickerreport" class="form-control" value="01/01/2016 - 01/25/2016" />
                                </div>
                            </div>
                        </div>
                      </div>
                    </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="x_panel tile">
                                <div class="x_content">
                                    <script src="https://code.highcharts.com/highcharts.js"></script>
                                    <script src="https://code.highcharts.com/modules/exporting.js"></script>
                                    <script src="https://code.highcharts.com/modules/export-data.js"></script>
                                    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
                                    <figure class="highcharts-figure">
                                    <div id="container"></div>
                                    </figure>
                                </div>
                            </div>
                        </div>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="x_panel tile">
                                <div class="x_content">
                                    <figure class="highcharts-figure">
                                        <div id="container2"></div>
                                    </figure>

                            </div>
                          </div>
                      </div>
                  </div>
              </div>


             


<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="<?= base_url()?>assets/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript">

const today = moment().format('MM-DD-YYYY');
const yesterday = moment().day(-1);
const sevendays = moment().day(-7);
const thirtydays = moment().day(-30);

const startOfMonth = moment().startOf('month');
const endOfMonth = moment().endOf('month');

const prevMonthFirstDay = moment().subtract(1, 'months').startOf('month')
const nextMonthLastDay = moment().subtract(1, 'months').endOf('month')

var chartsalesreferal = Highcharts.chart('container2', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Sales Referral'
    },
    xAxis: {
        type: 'category',
        labels: {
            rotation: -45,
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Jumlah Transaksi Sale'
        }
    },
    legend: {
        enabled: false
    },
    tooltip: {
        pointFormat: 'Jumlah Transaksi Sale: <b>{point.y:f} Transaksi Sale</b>'
    },
    series: [{
        name: 'Population',
        data: [
            ['Datang Langsung', <?php echo $sales_referal_chart ? $sales_referal_chart->datang_langsung : 0 ?>],
            ['Karyawan', <?php echo $sales_referal_chart ? $sales_referal_chart->karyawan : 0 ?>],
            ['Mitra Sales', <?php echo $sales_referal_chart ? $sales_referal_chart->mitra_sales : 0 ?>]
        ],
        dataLabels: {
            enabled: true,
            rotation: -90,
            color: '#FFFFFF',
            align: 'right',
            format: '{point.y:f}', // one decimal
            y: 10, // 10 pixels down from the top
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    }]
});

var umukchart = Highcharts.chart('container', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Uang masuk Vs Uang Keluar'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b><br>total: <b>Rp.{point.y}</b>'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %'
            }
        }
    },
    series: [{
        name: 'Brands',
        colorByPoint: true,
        data: [{
            name: 'Uang Masuk',
            y: <?php echo $uang_masup->uang_masuk === NULL ? 0 : $uang_masup->uang_masuk ?>
        }, {
            name: 'Uang Keluar',
            y: <?php echo $uang_kuwar->uang_keluar === NULL ? 0 : $uang_kuwar->uang_keluar ?>
        }]
    }]
});

$('#datepickerreport').daterangepicker({
    "autoApply": true,
    "timePicker": true,
    "timePicker": true,
    "timePicker24Hour": true,
    "timePickerSeconds": true,
    "ranges": {
        "Today": [
            today,
            today
        ],
        "Yesterday": [
            today,
            yesterday
        ],
        "Last 7 Days": [
            today,
            sevendays
        ],
        "Last 30 Days": [
            today,
            thirtydays
        ],
        "This Month": [
            startOfMonth,
            endOfMonth
        ],
        "Last Month": [
            prevMonthFirstDay,
            nextMonthLastDay
        ]
    },
    "startDate": today,
    "endDate": today,
    "applyClass": "btn-primary"
    }, function(start, end, label) {
        console.log('New date range selected: ' + start.format('YYYY-MM-DD HH:mm:ss') + ' to ' + end.format('YYYY-MM-DD HH:mm:ss') + ' (predefined range: ' + label + ')');
        $.ajax({
            type:'POST',
            url : '<?=site_url('dashboard/update_report') ?>',
            data : {
                type: 'sales_referal',
                startdate: start.format('YYYY-MM-DD HH:mm:ss'),
                enddate: end.format('YYYY-MM-DD HH:mm:ss')
            },
            dataType : 'json',
            success: function(result){
                if (!result) {
                    chartsalesreferal.series[0].setData([
                        ['Datang Langsung',0],
                        ['Karyawan',0],
                        ['Mitra Sales',0]
                    ])
                    return
                }
                chartsalesreferal.series[0].setData([
                    ['Datang Langsung',parseFloat(result.datang_langsung)],
                    ['Karyawan',parseFloat(result.karyawan)],
                    ['Mitra Sales',parseFloat(result.mitra_sales)]
                ])
                return
            }
        })

        $.ajax({
            type:'POST',
            url : '<?=site_url('dashboard/update_report') ?>',
            data : {
                type: 'umuk',
                startdate: start.format('YYYY-MM-DD HH:mm:ss'),
                enddate: end.format('YYYY-MM-DD HH:mm:ss')
            },
            dataType : 'json',
            success: function(result){
                if (!result) {
                    umuk.series[0].setData([
                        ['Datang Langsung',0],
                        ['Karyawan',0],
                        ['Mitra Sales',0]
                    ])
                    return
                }
                chartsalesreferal.series[0].setData([
                    ['Datang Langsung',parseFloat(result.datang_langsung)],
                    ['Karyawan',parseFloat(result.karyawan)],
                    ['Mitra Sales',parseFloat(result.mitra_sales)]
                ])
                return
            }
        })

       
});

$(document).on('click','#update_admin_fee',function(){
  $('#ramdan2').val($(this).data('ramdan'))
})

$(document).on('click','#submit_update', function(){
  var nominal = $('#ramdan2').val()
  if (nominal == '') {
    alert('Minimum Rp.0')
    $('#ramdan2').focus()
  }else {
    $.ajax({
        type:'POST',
        url : '<?=site_url('dashboard/update_admin_fee') ?>',
        data :{'update_nominal' : true,'nominal' : nominal},
        dataType : 'json',
        success: function(result){
            if (result.success) {
            alert('Admin fee berhasil di Update');
            $('#update_admin_fee').modal('hide')
            }else{
                alert('Admin fee gagal di Update')
            }
            location.href='<?=site_url('Dashboard') ?>'

        }
    })
  }
})

$(document).on('click','#update_bunga',function(){
  $('#bunga_cicilan').val($(this).data('bunga'))
})

$(document).on('click','#submit_update_bunga', function(){
  var nominal = $('#bunga_cicilan').val()
  if (nominal == '') {
    alert('Minimum 0 %')
    $('#bunga_cicilan').focus()
  }else {
    $.ajax({
        type:'POST',
        url : '<?=site_url('dashboard/update_bunga') ?>',
        data :{'update_bunga' : true,'nominal' : nominal},
        dataType : 'json',
        success: function(result){
            if (result.success) {
            alert('Bunga Cicilan berhasil di Update');
            $('#update_bunga').modal('hide')
            }else{
                alert('Bunga Cicilan gagal di Update')
            }
            location.href='<?=site_url('Dashboard') ?>'

        }
    })
  }
})
</script>