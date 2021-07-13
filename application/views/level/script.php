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

    $(document).on('click','#btndeleteAccess',function(){
        var el = $(this);
        var level_id = $(this).data('level');
        var sub_menu_id = $(this).data('menu');
        var controller = $(this).data('controller');
        var method= $(this).data('method');
        var accessname = $(this).parents('td').prev().text().trim();
        var accessdescription = $(this).parents('td').prev().children('label').children('span').children().data('original-title');
        var access_allow = 0;
        var checkelem = $(this).parents('td').prevAll().eq(1).children()

        if (checkelem.is(':checked')) {
            access_allow = 1;
        }
        checkelem.prop('disabled','disabled');
        console.log(accessname + ' ' + accessdescription + ' ' + access_allow + ' ' + level_id +' ' + sub_menu_id);
        $(this).html('<i class="fa fa-circle-o-notch fa-spin"></i>').prop('disabled',true);
        setTimeout(function(){
            $.ajax({
               url: '<?php echo base_url() ?>' + controller + '/custom_access_operation',
               type: 'post',
               dataType: 'text',
               data: {
                    access_name: accessname, 
                    access_description: accessdescription,
                    allowaccess: access_allow,
                    levelid: level_id,
                    submenuid: sub_menu_id,
                    operation: method,
                },
                fail: function() {
                    alert('Something is wrong');
                },
                error: function() {
                    alert('Something is wrong');
                },
                success: function(data) {
                    if (data == 'alreadydeleted') {
                        alert('sudah terhapus');
                    } else {
                        //console.log(data);
                        el.parents('tr').remove();
                        Toast.fire({
                          icon: 'success',
                          title: 'Hapus berhasil'
                        });
                    }
                    
                }
            });

            el.html('<i class="fa fa-trash"></i>').prop('disabled',false);
        },2000)
    });
    
    $('.form-check-input-access-smenu').change(function(){
        const menu_id = $(this).data('menu');
        const role_id = $(this).data('role');
        const elementcheck = $(this);
        const level = $(this).data('level');
        const submenu = $(this).data('submenu');
        const operation = $(this).data('operation');

            

        let accessLists;

        if (operation == 'submenu') {
            const namamenu = $(this).data('namamenu');
            $.ajax({
              url: "<?= base_url('level/changeaccess_submenu'); ?>",
              type: "html",
              type: "post",
              data: {
                menuId: menu_id,
                roleId: role_id,
                namasubmenu: submenu,
                namalevel: level,
                namamenu: namamenu
              },
              success: function(data) {
                const iconstatus = elementcheck.next().find('h4 > label > span');        
                const accesslistofmenuelement = elementcheck.nextAll(2).children('div.panel-body');

                Toast.fire({
                  icon: 'success',
                  title: 'Perubahan disimpan'
                });
                if(elementcheck.is(':checked')){
                    iconstatus.html("<i class='fa fa-unlock' aria-hidden='true' style='color: #26B99A;'></i>");
                    accesslistofmenuelement.html(data);
                } else {
                    iconstatus.html("<i class='fa fa-lock' aria-hidden='true' style='color: red;'></i>");
                    accesslistofmenuelement.html('<p class="warn"><span><i class="fa fa-warning fa-fw fa-md"></i> Aktifkan menu untuk mengatur hak akses</span></p>');
                }
              },
              error: function(request) {
                Toast.fire({
                  icon: 'error',
                  title: 'Gagal menyimpan (' + request.responseText + ')',
                })
              }

            });
        } 
    })

    $(document).on('change','.form-check-input-access',function(){

        const menu_id = $(this).data('menu');
        const role_id = $(this).data('role');
        const elementcheck = $(this);
        const level = $(this).data('level');
        const submenu = $(this).data('submenu');
        const operation = $(this).data('operation');

        if (operation == 'create' || operation == 'read' || operation == 'update' || operation == 'delete' || operation == 'export') {
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
                Swal.fire({
                  icon: 'warning',
                  title: "Something's Wrong",
                  text: 'Sepertinya menu mengalami gangguan, coba kunjungi laman terkait dan pastikan akses dapat diterapkan dengan baik, jika masih terkendala, silahkan hubungi developer (Error code: 371)',
                  footer: 'Informasi lebih lanjut dapat dilihat pada? <span style="margin: 0 0.5vh;"><a href="">FAQ</a></span> kami'
                })
              }

            });
        } else {
            $.ajax({
               url: '<?php echo base_url().$this->uri->segment(1)?>/checklink',
               type: 'post',
               data: {
                    levelid: role_id,
                    submenuid: menu_id,
                    operation: operation
                },
                error: function(request) {
                    alert('Smething is wrng');
                },
                fail: function() {
                    alert('Something is wrong');
                },
                success: function(data) {
                    var status = JSON.parse(data);

                    //console.log(data);
                    if (status == 'ok') {
                        var accessname = elementcheck.parents('td').next().text().trim();
                        var access_description = elementcheck.parents('td').next().children('label').children('span').children('button').data('original-title');
                        var allowAccess = 0;
                        if (elementcheck.is(":checked"))
                        {
                          allowAccess = 1;
                        }
                        $.ajax({
                          url: "<?= base_url('level/custom_access_operation'); ?>",
                          type: "post",
                          data: {
                            submenuid: menu_id,
                            levelid: role_id,
                            access_name: accessname,
                            access_description: access_description,
                            allowaccess: allowAccess,
                            operation: 'change_custom_access_status'
                          },
                          success: function(data) {
                            console.log(JSON.parse(data));
                            Toast.fire({
                              icon: 'success',
                              title: 'Perubahan nganu'
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
                        Swal.fire({
                          icon: 'warning',
                          title: 'Menu Tidak Berfungsi',
                          text: 'Sepertinya menu yang anda ubah statusnya tidak dapat diakses oleh user dengan level manapun (termasuk admin), silahkan hubungi developer untuk menambahkan modul/fitur yang diminta supaya hak akses dapat berfungsi (Error code: 381)',
                          footer: 'Informasi lebih lanjut dapat dilihat pada? <span style="margin: 0 0.5vh;"><a href="">FAQ</a></span> kami'
                        })
                    }
                }
            });
        }
    });

    /*function changeAccessfor(el, operation, submenu = null, level = null, menu = null) {
        
    }*/
 
    function saveCustomAccess(el,level_id,sub_menu_id,controller,method) {
        // e.preventDefault();

        var gotomodalbody = $(el).parents('div.modal-content').children('div.modal-body');

        var accessname = gotomodalbody.find("input[name='access_name']").val();
        var accessdescription = gotomodalbody.find("textarea[name='access_description']").val();
        var allowAccess = 0;

        var namasubmenu = $(el).prevAll('#nama_sub_menu');
        var namamenu = $(el).prevAll('#nama_menu');

        if (gotomodalbody.find("input[name='allowaccesscheck']").is(":checked"))
        {
          allowAccess = 1;
        }

        $(el).html('Tambah').prop('disabled',false);
        //try check here
        //console.log(accessname + ' ' + allowAccess + ' ' + accessdescription + ' ' + sub_menu_id + ' ' + level_id);

        $(el).html('<i class="fa fa-circle-o-notch fa-spin"></i>');

        $.ajax({
           url: '<?php echo base_url() ?>' + controller + '/custom_access_operation',
           type: 'POST',
           data: {
                access_name: accessname, 
                access_description: accessdescription, 
                allowaccess: allowAccess,
                levelid: level_id,
                submenuid: sub_menu_id,
                operation: method
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
                console.log(o.result);
                if (o.result == 'no') {
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

                    if (allowAccess == 0) {
                        $('#tabel' + level_id + sub_menu_id + o.dataiwant + ' tr:last').before('<tr><td style="text-align: center;"><input class="form-check-input-access" type="checkbox" style="height: 2em;width: 2em;" data-role="' + level_id + '" data-menu="' + sub_menu_id + '" data-operation="'+ accessname + '" data-level="' + level_id + '" data-submenu="' + namasubmenu.val() + '" ></td><td><label class="" for="customCheck1">' + accessname +'<span><button type="button" class="btn btn-default" data-toggle="tooltip" style="border: none;padding: 3px;color: #73879c;margin-top: 2px;" data-placement="top" title="" data-original-title="' + accessdescription + '"><i class="fa fa-question-circle"></i></button></span></label><br></td><td><button class="btn btn-danger btn-sm" data-level="' + level_id + '" data-menu="' + sub_menu_id + '" data-controller="<?php echo $this->uri->segment(1) ?>" data-method="delete_custom_access" id="btndeleteAccess"><i class="fa fa-trash" aria-hidden="true"></i></button></td></tr>');
                    } else {
                        $('#tabel' + level_id + sub_menu_id + o.dataiwant + ' tr:last').before('<tr><td style="text-align: center;"><input class="form-check-input-access" type="checkbox" style="height: 2em;width: 2em;" data-role="<?= $level_id; ?>" data-menu="<?=  $sub_menu_id ?>" data-operation="'+ accessname + '" data-level="' + level_id + '" data-submenu="' + namasubmenu.val() + '" checked="checked"></td><td><label class="" for="customCheck1">' + accessname +'<span><button type="button" class="btn btn-default" data-toggle="tooltip" style="border: none;padding: 3px;color: #73879c;margin-top: 2px;" data-placement="top" title="" data-original-title="' + accessdescription + '"><i class="fa fa-question-circle"></i></button></span></label><br></td><td><button class="btn btn-danger btn-sm" data-level="' + level_id + '" data-menu="' + sub_menu_id + '" data-controller="<?php echo $this->uri->segment(1) ?>" data-method="delete_custom_access" id="btndeleteAccess"><i class="fa fa-trash" aria-hidden="true"></i></button></td></tr>');
                    }


                    $("[data-toggle=tooltip]").tooltip();

                    gotomodalbody.find("input[name='access_name']").val('');
                    gotomodalbody.find("textarea[name='access_description']").val('');
                    $('#modalTambahAksesuntuk' + level_id + sub_menu_id + o.dataiwant).modal('toggle');
                }

            }
        });        
    	$(el).html('Tambah').prop('disabled',false);
     }
 </script>