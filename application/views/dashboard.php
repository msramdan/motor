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
                        <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                          <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                          <span>July 13, 2021 - July 13, 2021</span> <b class="caret"></b>
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


             




<script type="text/javascript">
    Highcharts.chart('container', {
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
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
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
            name: 'Chrome',
            y: 61.41,
            sliced: true,
            selected: true
        }, {
            name: 'Other',
            y: 2.61
        }]
    }]
});
</script>

<script type="text/javascript">
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


    </script>

    <script type="text/javascript">
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


    <script type="text/javascript">
        Highcharts.chart('container2', {
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
            ['Datang Langsung', 10],
            ['Karyawan', 8],
            ['Mitra Sales', 12]
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
    </script>