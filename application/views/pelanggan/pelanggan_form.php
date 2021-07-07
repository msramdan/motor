<div class="page-title">
    <div class="title_left">
        <h3>KELOLA DATA PELANGGAN</h3>
    </div>
    <div class="clearfix">
        
    </div>
    
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="box-body">
                <form action="<?php echo $action; ?>" method="post">            
                    <table class='table table-bordered'>        
                	    <tr>
                            <td width='200' rowspan="2">
                                No Ktp <?php echo form_error('no_ktp') ?>
                            </td>
                            <td>
                                <input type="text" class="form-control input-validation no-copas-allowed" name="no_ktp" id="no_ktp" placeholder="Input Nomor KTP" />    
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" class="form-control input-validation need_to_confirm" make-sure-it-similar-to="no_ktp" name="no_ktp_confirm" id="no_ktp_confirm" placeholder="Ketik Ulang No KTP" />
                                <p style="display: none;"></p>
                            </td>
                        </tr>
                	    <tr>
                            <td width='200' rowspan="2">
                                No Kk <?php echo form_error('no_kk') ?>
                            </td>
                            <td>
                                <input id="no_kk" class="form-control input-validation col-md-7 col-xs-12 no-copas-allowed" type="text" name="no_kk" data-validate-length="6,8" placeholder="input No KK" class="form-control input-validation col-md-7 col-xs-12" required="required">
                            
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input id="no_kk_confirm" type="text" name="no_kk_confirm" class="form-control input-validation col-md-7 col-xs-12 need_to_confirm" placeholder="ketik ulang No. KK" make-sure-it-similar-to="no_kk" required="required">
                                <p style="display: none;"></p>
                            </td>
                        </tr>
                	    <tr><td width='200'>Nama Pelanggan <?php echo form_error('nama_pelanggan') ?></td><td><input type="text" class="form-control input-validation" name="nama_pelanggan" id="nama_pelanggan" placeholder="Nama Pelanggan" value="<?php echo $nama_pelanggan; ?>" /></td></tr>
                	    <tr>
                            <td width='200' rowspan="2">
                                No Hp Pelanggan <?php echo form_error('no_hp_pelanggan') ?>
                            </td>
                            <td>
                                <input type="text" class="form-control input-validation no-copas-allowed" name="no_hp_pelanggan" id="no_hp_pelanggan" placeholder="No Hp Pelanggan" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" class="form-control input-validation need_to_confirm" make-sure-it-similar-to="no_hp_pelanggan" name="no_hp_pelanggan_confirm" id="no_hp_pelanggan_confirm" placeholder="Ketik ulang No. HP" />
                                <p style="display: none;"></p>
                            </td>
                        </tr>
                	    <tr>
                            <td width='200'>
                                Jenis Kelamin <?php echo form_error('jenis_kelamin') ?>        
                            </td>
                            <td>
                                <select name="jenis_kelamin" class="form-control input-validation" value="<?= $jenis_kelamin ?>">
                                    <option value="">- Pilih -</option>
                                    <option value="Laki Laki" <?php echo $jenis_kelamin == 'Laki Laki' ? 'selected' : 'null' ?>>Laki Laki</option>
                                    <option value="Perempuan" <?php echo $jenis_kelamin == 'Perempuan' ? 'selected' : 'null' ?>>Perempuan</option>
                              </select>
                            </td>
                        </tr>
                        <tr>
                            <td width='200'>
                                Alamat Ktp <?php echo form_error('alamat_ktp') ?>
                            </td>
                            <td>
                                <textarea class="form-control input-validation" rows="3" name="alamat_ktp" id="alamat_ktp" placeholder="Alamat Ktp"><?php echo $alamat_ktp; ?></textarea>
                            </td>
                        </tr>
                	    
                        <tr>
                            <td width='200'>
                                Alamat Domisili <?php echo form_error('alamat_domisili') ?>
                            </td>
                            <td>
                                <textarea class="form-control input-validation" rows="3" name="alamat_domisili" id="alamat_domisili" placeholder="Alamat Domisili"><?php echo $alamat_domisili; ?></textarea>
                            </td>
                        </tr>
                	    <tr>
                            <td width='200'>
                                Nama Saudara <?php echo form_error('nama_saudara') ?>
                            </td>
                            <td>
                                <input type="text" class="form-control input-validation" name="nama_saudara" id="nama_saudara" placeholder="Nama Saudara" value="<?php echo $nama_saudara; ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td width='200'>
                                Alamat Saudara <?php echo form_error('alamat_saudara') ?>
                            </td>
                            <td>
                                <textarea class="form-control input-validation" rows="3" name="alamat_saudara" id="alamat_saudara" placeholder="Alamat Saudara"><?php echo $alamat_saudara; ?></textarea>
                            </td>
                        </tr>
                	    <tr>
                            <td width='200'>
                                No Hp Saudara <?php echo form_error('no_hp_saudara') ?>
                            </td>
                            <td>
                                <input type="text" class="form-control input-validation" name="no_hp_saudara" id="no_hp_saudara" placeholder="No Hp Saudara" value="<?php echo $no_hp_saudara; ?>" />
                            </td>
                        </tr>
                	    <tr>
                            <td>
                                
                            </td>
                            <td>
                                <input type="hidden" name="pelanggan_id" value="<?php echo $pelanggan_id; ?>" /> 
                	           <button type="submit" class="btn btn-danger" id="buttonsubmit" disabled="disabled"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
                	           <a href="<?php echo site_url('pelanggan') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a>
                           </td>
                       </tr>
            	   </table>
                </form>
            </div>
        </div>
    </div>

<script type="text/javascript">

    $(document).ready(function(){

        var confirminputok = false;
        var allinputedcorrectly = false;

        $('.need_to_confirm').on('focusout', (function (e) {
            e.preventDefault();
            var similarto = $(this).attr('make-sure-it-similar-to');
            var firstinput = $('#' + similarto ).val();
            var secondinput = $(this).val();
            if (firstinput !== secondinput) {
                $(this).removeClass('parsley-error erroryahaha');
                    setTimeout(()=>{
                        $(this).addClass('parsley-error erroryahaha')
                            .next()
                            .css({
                                'display':'block',
                                'color':'red',
                                'margin': '1vh 0 0 0'})
                            .text('Inputan tidak sama, harap cek kembali')
                            .addClass('warning');
                },300);
                return;
            }
            $(this).removeClass('parsley-error erroryahaha').next().css('display','none').text('').removeClass('warning');
        }));

        $('.input-validation').on('focusout', (function(e) {
            var countemptyinput = $('.input-validation').filter(function() {
                                    return this.value.trim() == '';
                                }).length; //can't using :empty selector?

            if(countemptyinput == 0) {
                allinputedcorrectly = true;
            } else {
                allinputedcorrectly = false;
            }

            if($('.warning').length == 0) {
                confirminputok = true;
            } else {
                confirminputok = false;
            }         
            if (allinputedcorrectly == true && confirminputok == true) {
                console.log('unlocked');
                $('#buttonsubmit').removeAttr('disabled');
            } else {
                $('#buttonsubmit').attr('disabled','disabled');
            }
        }));

        $('.no-copas-allowed').bind('copy paste',function(e) {
            e.preventDefault(); return false; 
        });

        $('.no-copas-allowed').keyup(function() {
            this.value = this.value.replace(/\s/g,'');
        });
    })

</script>