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
    </div>
</div>

<div class="row">


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