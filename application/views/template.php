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

    <?php if ($this->session->flashdata('message') ) : ?>

    <?php endif; ?>
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col" style="transition: all 250ms ease-in-out;">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="" class="site_title"><i class="fa fa-desktop"></i> <span>Apps POS</span></a>
                    </div>

                    <div class="clearfix"></div>

                    <!-- menu profile quick info -->
                    <div class="profile clearfix">
                        <div class="profile_pic">
                            <img src="<?= base_url() ?>assets/img/user/<?= $this->fungsi->user_login()->photo?>"
                                alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span><?= $this->session->userdata('nama_unit')?></span>
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
        <?php
          $session_level_id = $this->fungsi->user_login()->level_id;
          $queryMenu = "SELECT `user_access_menu`.`user_access_menu_id`,`level_id`,`menu`.`menu`,`menu`.`icon`,`menu`.`menu_id` as menu_id
            FROM `user_access_menu` JOIN `sub_menu` 
              ON `user_access_menu`.`sub_menu_id` = `sub_menu`.`sub_menu_id`
              JOIN `menu` 
              ON `menu`.`menu_id` = `sub_menu`.`menu_id`
           WHERE `user_access_menu`.`level_id` = $session_level_id
           GROUP BY `menu`.`menu_id`
              ORDER BY `menu`.`urutan` ASC
           ";
          $menu = $this->db->query($queryMenu)->result_array();
        ?>
        <?php foreach ($menu as $m) : ?>
                <li><a><i class="<?= $m['icon'] ?>"></i> <?= $m['menu'] ?><span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
            <?php
                $menuId = $m['menu_id'];
                $querySubMenu = "SELECT `user_access_menu`.`level_id`,`user_access_menu`.`sub_menu_id`,`sub_menu`.*
                FROM `user_access_menu` JOIN `sub_menu` 
                  ON `user_access_menu`.`sub_menu_id` = `sub_menu`.`sub_menu_id`
               WHERE `sub_menu`.`menu_id` = $menuId
               AND `user_access_menu`.`level_id` = $session_level_id
               ";
                $subMenu = $this->db->query($querySubMenu)->result_array();
            ?>
                    <?php foreach ($subMenu as $sm) : ?>
                        <li><a href="<?= base_url($sm['url']) ?>"><?= $sm['nama_sub_menu'] ?></a></li>
                    <?php endforeach; ?>
                                    </ul>
                                </li>


        <?php endforeach ?>


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
                                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                                    aria-expanded="false">
                                    <img src="<?= base_url() ?>assets/img/user/<?= $this->fungsi->user_login()->photo  ?>"
                                        alt=""><?= ucfirst($this->fungsi->user_login()->nama_user) ?>
                                    <span class=" fa fa-angle-down"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-usermenu pull-right">
                                    <li><a href="<?= base_url() ?>Akun"><i class="fa fa-users pull-right"></i> Edit
                                            Informasi Akun</a></li>
                                    <li><a href="<?= base_url() ?>Auth/logout"><i class="fa fa-sign-out pull-right"></i>
                                            Log Out</a></li>
                                </ul>
                            </li>
                            <li role="presentation">
                              <a href="<?= base_url() ?>beranda/unit">
                                <i class="fa fa-refresh"></i> Switch Unit
                              </a>
                            </li>
                            <li role="presentation">
                              <a href="#">
                                <i class="fa fa-home" style="color: #26B99A"></i><span style="color: #26B99A"> Anda berada di unit <?= $this->session->userdata('nama_unit')?></span> 
                              </a>
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
                    Aplikasi POS V.1 <a href="#"></a>
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
    <!-- Validator -->
    <script src="<?= base_url()?>assets/vendors/validator/validator.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="<?= base_url()?>assets/build/js/custom.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script> <!-- untuk sweet alret -->
    <script src="<?php echo base_url();?>assets/js/dataflash.js"></script>

</body>

</html>


<script>
$(document).ready(function() {
    var i = 1;
    $('#add').click(function() {
        i++;
        $('#dynamic_field').append('<tr id="row' + i +
            '"><td><input type="text" name="nama_berkas[]" placeholder="Nama Berkas" class="form-control" required="" /></td><input type="hidden" name="pelanggan_id[]" class="form-control" value="<?php echo $this->uri->segment(3) ?>"><td><input type="file" name="berkas[]" class="form-control" required="" /></td><td><button type="button" name="remove" id="' +
            i + '" class="btn btn-danger btn_remove">X</button></td></tr>');
    });

    $(document).on('click', '.btn_remove', function() {
        var button_id = $(this).attr("id");
        $('#row' + button_id + '').remove();
    });


});
</script>


<script>
$(document).ready(function() {
    var i = 1;
    $('#add_harga').click(function() {
        i++;
        $('#dynamic_field').append('<tr id="row' + i +
            '"><td><input type="text" name="nama_harga[]" placeholder="Nama Harga" class="form-control nama_harga" required="" /></td><input type="hidden" name="item_id[]" class="form-control" value="<?php echo $this->uri->segment(3) ?>"><td><input type="number" name="nominal[]" placeholder="Nominal" class="form-control nominal" required="" /></td><td><button type="button" name="remove" id="' +
            i + '" class="btn btn-danger btn_remove_harga">X</button></td></tr>');
    });

    $(document).on('click', '.btn_remove_harga', function() {
        var button_id = $(this).attr("id");
        $('#row' + button_id + '').remove();
    });

});
</script>
<script type="text/javascript">
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    function changeAccessfor(el, operation) {
        const menu_id = $(el).data('menu');
        const role_id = $(el).data('role');
        const elementcheck = $(el);
        const iconstatus = $(el).next().children(0);        
        const accesslistofmenuelement = elementcheck.parents(1).next(0).children('div.panel-body');

        if (operation == 'submenu') {
            $.ajax({
              url: "<?= base_url('level/changeaccess_submenu'); ?>",
              dataType: 'html',
              type: "post",
              data: {
                menuId: menu_id,
                roleId: role_id,
              },
              success: function(data) {

                if (elementcheck.is(':checked')) {
                    iconstatus.html("<i class='fa fa-lock' aria-hidden='true' style='color: red;'></i>");
                    elementcheck.prop('checked', false);
                    accesslistofmenuelement.html('<p class="warn"><span><i class="fa fa-warning fa-fw fa-md"></i> Aktifkan menu untuk mengatur hak akses</span></p>');
                } else {
                    iconstatus.html("<i class='fa fa-unlock' aria-hidden='true' style='color: #26B99A;'></i>");
                    elementcheck.prop('checked', true);
                    accesslistofmenuelement.html(data);
                    console.log(data);
                }
                Toast.fire({
                  icon: 'success',
                  title: 'Perubahan disimpan'
                });
              },
              error: function(request) {
                Toast.fire({
                  icon: 'error',
                  title: 'Gagal menyimpan (' + request.responseText + ')',
                })
              }

            });
        } else {
            $.ajax({
              url: "<?= base_url('level/changeaccess'); ?>_" + operation,
              type: "post",
              data: {
                menuId: menu_id,
                roleId: role_id,
              },
              success: function() {
                Toast.fire({
                  icon: 'success',
                  title: 'Perubahan disimpan'
                })
              },
              error: function(request) {
                Toast.fire({
                  icon: 'error',
                  title: 'Gagal menyimpan (' + request.responseText + ')',
                })
              }

            });
        }

    }
 </script>
 <script type="text/javascript">
     function saveCustomAccess(el,level_id,sub_menu_id,controller,method) {
        // e.preventDefault();

        var gotomodalbody = $(el).parents('div.modal-content').children('div.modal-body');

        var accessname = gotomodalbody.find("input[name='access_name']").val();
        var accessdescription = gotomodalbody.find("textarea[name='access_description']").val();
        var allowaccess = 0;
        if (gotomodalbody.find("input[name='allowaccesscheck']").is(":checked"))
        {
          allowaccess = 1;
        }

        console.log(accessname + ' ' + allowaccess + ' ' + accessdescription + ' ' + sub_menu_id + ' ' + level_id);

        $(el).html('<i class="fa fa-circle-o-notch fa-spin"></i>');

        $.ajax({
           url: '<?php echo base_url() ?>' + controller + '/' + method,
           type: 'POST',
           data: {
                access_name: accessname, 
                access_description: accessdescription, 
                allowaccess: allowaccess,
                levelid: level_id,
                submenuid: sub_menu_id
            },
            fail: function() {
                alert('Something is wrong');
                $(el).html('Tambah');
            },
            error: function() {
                alert('Something is wrong');
                $(el).html('Tambah');
            },
            success: function(data) {
                var o = JSON.parse(data);
                if (data == 'no') {
                    Toast.fire({
                      icon: 'error',
                      title: 'Akses sudah ada'
                    });
                    $(el).html('Tambah');
                } else {
                    Toast.fire({
                      icon: 'success',
                      title: 'Akses berhasil ditambahkan'
                    });

                    var ano = '<?php echo base_url().$this->uri->segment(1) ?>';

                    console.log('#tabel' + level_id + sub_menu_id + o.dataiwant + 'tr:last');

                    $(el).html('Tambah');
                    $('#tabel' + level_id + sub_menu_id + o.dataiwant + ' tr:last').before('<tr><td>' + allowaccess + '</td><td><label class="" for="customCheck1">' + accessname +'<span><button type="button" class="btn btn-default" data-toggle="tooltip" style="border: none;padding: 3px;color: #73879c;margin-top: 2px;" data-placement="top" title="" data-original-title="' + accessdescription + '"><i class="fa fa-question-circle"></i></button></span></label><br></td><td><a class="btn btn-danger btn-sm" href="' + ano + '/delete_access/' + accessname + '"><i class="fa fa-trash" aria-hidden="true"></i></a></td></tr>');

                    gotomodalbody.find("input[name='access_name']").val('');
                    gotomodalbody.find("textarea[name='access_description']").val('');
                    $('#modalTambahAksesuntuk' + level_id + sub_menu_id + o.dataiwant).modal('toggle');
                }

            }
        });        
     }
 </script>