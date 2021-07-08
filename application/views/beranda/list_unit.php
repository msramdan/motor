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
    <link href="<?= base_url()?>assets/build/css/style.css" rel="stylesheet">
</head>

<body class="nav-md">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="" class="site_title"><i class="fa fa-desktop"></i> <span>Apps POS</span></a>
                    </div>

                    <div class="clearfix"></div>
                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <ul class="nav side-menu">
                                <li><a href="<?php echo base_url() ?>Beranda"><i class="fa fa-home"></i> Beranda</a></li>
                                <li><a href="<?php echo base_url() ?>Beranda/unit"><i class="fa fa-list"></i> List Unit</a></li>
                                <li><a href="<?= base_url() ?>Auth/logout"><i class="fa fa-sign-out"></i> Logout</a></li>
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
                    <div class="row">
                      <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                      </div>
                      <div class="clearfix"></div>
                      <div class="col-md-4 col-sm-4 col-xs-12 profile_details">
                        <div class="well profile_view">
                          <div class="col-sm-12">
                            <h4 class="brief"><i>Nama Grup Usaha</i></h4>
                            <div class="left col-xs-7">
                              <h2>Nama Unit</h2>
                              <ul class="list-unstyled">
                                <li><i class="fa fa-building"></i> Address: Tajur Halang Kabupaten bogor </li>
                                <li><i class="fa fa-phone"></i> Phone #: 083874731480 </li>
                              </ul>
                            </div>
                            <div class="right col-xs-5 text-center">
                              <img src="<?= base_url() ?>assets/img/show1.jpg" alt="" class="img-circle img-responsive">
                            </div>
                          </div>
                          <div class="col-xs-12 bottom text-center">
                            <div class="col-xs-12 col-sm-6 emphasis">
                              <p class="ratings">
                                <a>5.0</a>
                                <a href="#"><span class="fa fa-star"></span></a>
                                <a href="#"><span class="fa fa-star"></span></a>
                                <a href="#"><span class="fa fa-star"></span></a>
                                <a href="#"><span class="fa fa-star"></span></a>
                                <a href="#"><span class="fa fa-star"></span></a>
                              </p>
                            </div>
                            <div class="col-xs-12 col-sm-6 emphasis">
                              <a href="<?= base_url() ?>Dashboard" class="btn btn-success"><i class="fa fa-edit m-right-xs"></i> Masuk Unit</a>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-4 col-sm-4 col-xs-12 profile_details">
                        <div class="well profile_view">
                          <div class="col-sm-12">
                            <h4 class="brief"><i>Nama Grup Usaha</i></h4>
                            <div class="left col-xs-7">
                              <h2>Nama Unit</h2>
                              <ul class="list-unstyled">
                                <li><i class="fa fa-building"></i> Address: Tajur Halang Kabupaten bogor </li>
                                <li><i class="fa fa-phone"></i> Phone #: 083874731480 </li>
                              </ul>
                            </div>
                            <div class="right col-xs-5 text-center">
                              <img src="<?= base_url() ?>assets/img/show1.jpg" alt="" class="img-circle img-responsive">
                            </div>
                          </div>
                          <div class="col-xs-12 bottom text-center">
                            <div class="col-xs-12 col-sm-6 emphasis">
                              <p class="ratings">
                                <a>5.0</a>
                                <a href="#"><span class="fa fa-star"></span></a>
                                <a href="#"><span class="fa fa-star"></span></a>
                                <a href="#"><span class="fa fa-star"></span></a>
                                <a href="#"><span class="fa fa-star"></span></a>
                                <a href="#"><span class="fa fa-star"></span></a>
                              </p>
                            </div>
                            <div class="col-xs-12 col-sm-6 emphasis">
                              <a href="<?= base_url() ?>Dashboard" class="btn btn-success"><i class="fa fa-edit m-right-xs"></i> Masuk Unit</a>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-4 col-sm-4 col-xs-12 profile_details">
                        <div class="well profile_view">
                          <div class="col-sm-12">
                            <h4 class="brief"><i>Nama Grup Usaha</i></h4>
                            <div class="left col-xs-7">
                              <h2>Nama Unit</h2>
                              <ul class="list-unstyled">
                                <li><i class="fa fa-building"></i> Address: Tajur Halang Kabupaten bogor </li>
                                <li><i class="fa fa-phone"></i> Phone #: 083874731480 </li>
                              </ul>
                            </div>
                            <div class="right col-xs-5 text-center">
                              <img src="<?= base_url() ?>assets/img/show1.jpg" alt="" class="img-circle img-responsive">
                            </div>
                          </div>
                          <div class="col-xs-12 bottom text-center">
                            <div class="col-xs-12 col-sm-6 emphasis">
                              <p class="ratings">
                                <a>5.0</a>
                                <a href="#"><span class="fa fa-star"></span></a>
                                <a href="#"><span class="fa fa-star"></span></a>
                                <a href="#"><span class="fa fa-star"></span></a>
                                <a href="#"><span class="fa fa-star"></span></a>
                                <a href="#"><span class="fa fa-star"></span></a>
                              </p>
                            </div>
                            <div class="col-xs-12 col-sm-6 emphasis">
                              <a href="<?= base_url() ?>Dashboard" class="btn btn-success"><i class="fa fa-edit m-right-xs"></i> Masuk Unit</a>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-4 col-sm-4 col-xs-12 profile_details">
                        <div class="well profile_view">
                          <div class="col-sm-12">
                            <h4 class="brief"><i>Nama Grup Usaha</i></h4>
                            <div class="left col-xs-7">
                              <h2>Nama Unit</h2>
                              <ul class="list-unstyled">
                                <li><i class="fa fa-building"></i> Address: Tajur Halang Kabupaten bogor </li>
                                <li><i class="fa fa-phone"></i> Phone #: 083874731480 </li>
                              </ul>
                            </div>
                            <div class="right col-xs-5 text-center">
                              <img src="<?= base_url() ?>assets/img/show1.jpg" alt="" class="img-circle img-responsive">
                            </div>
                          </div>
                          <div class="col-xs-12 bottom text-center">
                            <div class="col-xs-12 col-sm-6 emphasis">
                              <p class="ratings">
                                <a>5.0</a>
                                <a href="#"><span class="fa fa-star"></span></a>
                                <a href="#"><span class="fa fa-star"></span></a>
                                <a href="#"><span class="fa fa-star"></span></a>
                                <a href="#"><span class="fa fa-star"></span></a>
                                <a href="#"><span class="fa fa-star"></span></a>
                              </p>
                            </div>
                            <div class="col-xs-12 col-sm-6 emphasis">
                              <a href="<?= base_url() ?>Dashboard" class="btn btn-success"><i class="fa fa-edit m-right-xs"></i> Masuk Unit</a>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-4 col-sm-4 col-xs-12 profile_details">
                        <div class="well profile_view">
                          <div class="col-sm-12">
                            <h4 class="brief"><i>Nama Grup Usaha</i></h4>
                            <div class="left col-xs-7">
                              <h2>Nama Unit</h2>
                              <ul class="list-unstyled">
                                <li><i class="fa fa-building"></i> Address: Tajur Halang Kabupaten bogor </li>
                                <li><i class="fa fa-phone"></i> Phone #: 083874731480 </li>
                              </ul>
                            </div>
                            <div class="right col-xs-5 text-center">
                              <img src="<?= base_url() ?>assets/img/show1.jpg" alt="" class="img-circle img-responsive">
                            </div>
                          </div>
                          <div class="col-xs-12 bottom text-center">
                            <div class="col-xs-12 col-sm-6 emphasis">
                              <p class="ratings">
                                <a>5.0</a>
                                <a href="#"><span class="fa fa-star"></span></a>
                                <a href="#"><span class="fa fa-star"></span></a>
                                <a href="#"><span class="fa fa-star"></span></a>
                                <a href="#"><span class="fa fa-star"></span></a>
                                <a href="#"><span class="fa fa-star"></span></a>
                              </p>
                            </div>
                            <div class="col-xs-12 col-sm-6 emphasis">
                              <a href="<?= base_url() ?>Dashboard" class="btn btn-success"><i class="fa fa-edit m-right-xs"></i> Masuk Unit</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /page content -->

            <footer>
                <div class="pull-right">
                    Aplikasi POS V.1 <a href="#"></a>
                </div>
                <div class="clearfix"></div>
            </footer>
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
    <!-- Validator -->
    <script src="<?= base_url()?>assets/vendors/validator/validator.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="<?= base_url()?>assets/build/js/custom.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/sweetalert.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/sweetalert.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script> <!-- untuk sweet alret -->
    <script src="<?php echo base_url();?>assets/js/dataflash.js"></script>

</body>

</html>
