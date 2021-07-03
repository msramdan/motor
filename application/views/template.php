
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aplikasi POS</title>
    <link href="<?= base_url()?>assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url()?>assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?= base_url()?>assets/vendors/nprogress/nprogress.css" rel="stylesheet">
    <link href="<?= base_url()?>assets/build/css/custom.min.css" rel="stylesheet">
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
  </head>
  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="" class="site_title"><i class="fa fa-desktop"></i> <span>Apps POS</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="<?= base_url() ?>assets/img/user/<?= $this->fungsi->user_login()->photo?>" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2><?= ucfirst($this->fungsi->user_login()->nama_user) ?></h2>
              </div>
              <div class="clearfix"></div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>Menu Navigation</h3>
                <ul class="nav side-menu">
                  <li><a href="<?php echo base_url() ?>Dashboard"><i class="fa fa-home"></i> Dashboard</a>
                  </li>
                  <li><a href="<?php echo base_url() ?>Pelanggan"><i class="fa fa-users"></i> Pelanggan</a>
                  </li>
                  <li><a href="<?php echo base_url() ?>Agen"><i class="fa fa-truck"></i> Agen</a>
                  </li>
                  <li><a><i class="fa fa-motorcycle "></i> Data Kendaraan <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url() ?>Kendaraan">List Kendaraan</a></li>
                      <li><a href="<?php echo base_url() ?>Merek">Merk</a></li>
                      <li><a href="<?php echo base_url() ?>Jenis_kendaraan">Jenis Kendaraan</a></li>
                      <li><a href="<?php echo base_url() ?>Type">Type</a></li>
                    </ul>
                  </li>
                  <li><a href="<?php echo base_url() ?>Sale"><i class="fa fa-shopping-cart"></i> Transaksi Sale</a>
                  </li>
                  <li><a href="<?php echo base_url() ?>paypall"><i class="fa fa-money"></i> Pembayaran Cicilan</a>
                  </li>

                  <li><a><i class="fa fa-file"></i> Laporan <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="index.html">Penjualan</a></li>
                      <li><a href="index.html">Pembelian</a></li>
                      <li><a href="index.html">Pembayaran</a></li>
                    </ul>
                  </li>                
                </ul>
              </div>
              <div class="menu_section">
                <h3>Menu Admin</h3>
                <ul class="nav side-menu"> 
                  <li><a href="<?php echo base_url() ?>User"><i class="fa fa-user"></i> User</a>
                  </li>
                  <li><a href="<?php echo base_url() ?>Level"><i class="fa fa-list"></i> Level User</a>
                  </li>
               <!--    <li><a href=""><i class="fa fa-list"></i> History Login</a>
                  </li>
                  <li><a href=""><i class="fa fa-list"></i> Backup DB</a>
                  </li> -->
                </ul>
              </div>

            </div>
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">

          <div class="nav_menu">

            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>                
              </div>
              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="<?= base_url() ?>assets/img/user/<?= $this->fungsi->user_login()->photo  ?>" alt=""><?= ucfirst($this->fungsi->user_login()->nama_user) ?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="<?= base_url() ?>Akun"><i class="fa fa-users pull-right"></i> Edit Informasi Akun</a></li>
                    <li><a href="<?= base_url() ?>Auth/logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_content">
                     
                    <?php echo $contents ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="<?= base_url()?>assets/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?= base_url()?>assets/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?= base_url()?>assets/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?= base_url()?>assets/vendors/nprogress/nprogress.js"></script>
    
    <!-- Custom Theme Scripts -->
    <script src="<?= base_url()?>assets/build/js/custom.min.js"></script>
  </body>
</html>


<script>
$(document).ready(function(){
  var i=1;
  $('#add').click(function(){
    i++;
    $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" name="nama_berkas[]" placeholder="Nama Berkas" class="form-control" required="" /></td><input type="hidden" name="pelanggan_id[]" class="form-control" value="<?php echo $this->uri->segment(3) ?>"><td><input type="file" name="berkas[]" class="form-control" required="" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
  });
  
  $(document).on('click', '.btn_remove', function(){
    var button_id = $(this).attr("id"); 
    $('#row'+button_id+'').remove();
  });
  
  
});
</script>


<script>
$(document).ready(function(){
  var i=1;
  $('#add_harga').click(function(){
    i++;
    $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" name="nama_harga[]" placeholder="Nama Harga" class="form-control nama_harga" required="" /></td><input type="hidden" name="kendaraan_id[]" class="form-control" value="<?php echo $this->uri->segment(3) ?>"><td><input type="number" name="nominal[]" placeholder="Nominal" class="form-control nominal" required="" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove_harga">X</button></td></tr>');
  });
  
  $(document).on('click', '.btn_remove_harga', function(){
    var button_id = $(this).attr("id"); 
    $('#row'+button_id+'').remove();
  });
  
  
});
</script>
