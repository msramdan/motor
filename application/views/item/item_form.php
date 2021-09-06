<div class="page-title">
    <div class="title_left">
        <h3>KELOLA DATA item</h3>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">

                <div class="box-body">

                    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">

                        <table class='table table-bordered'>
                            <input type="hidden" class="form-control input-validation no-copas-allowed" name="unit_id" id="unit_id" value="<?= $this->session->userdata('unit_id') ?>" placeholder="" />




                            <?php if ($this->uri->segment(2) == 'create' || $this->uri->segment(2) == 'create_action' ) { ?>
                            <tr>
                                <td width='200'>Kd Pembelian <?php echo form_error('kd_pembelian') ?></td>
                                <td><input type="text" class="form-control" name="kd_pembelian" id="kd_pembelian"
                                        placeholder="Kd Pembelian" readonly="" value="B<?= $kodeunik ?>" /></td>
                            </tr>
                            <?php }else{ ?>
                            <tr>
                                <td width='200'>Kd Pembelian <?php echo form_error('kd_pembelian') ?></td>
                                <td><input type="text" class="form-control" name="kd_pembelian" id="kd_pembelian"
                                        placeholder="Kd Pembelian" readonly="" value="<?php echo $kd_pembelian ?>" />
                                </td>
                            </tr>
                            <?php } ?>



                            <?php if ($this->uri->segment(2) == 'create' || $this->uri->segment(2) == 'create_action' ) { ?>
                            <tr>
                                <td width='200'>Kode Item <?php echo form_error('kd_item') ?></td>
                                <td><input type="text" class="form-control" name="kd_item" readonly="" id="kd_item"
                                        placeholder="Kode Item"
                                        value="I<?php echo date('dmYhms').$this->session->userdata('unit_id').sprintf("%04s", $kode_barang) ?>" /></td>
                            </tr>
                            <?php }else{ ?>
                            <tr>
                                <td width='200'>Kode Item <?php echo form_error('kd_item') ?></td>
                                <td><input type="text" class="form-control" name="kd_item" readonly="" id="kd_item"
                                        placeholder="Kode Item" value="<?php echo $kd_item; ?>" /></td>
                            </tr>
                            <?php } ?>

                            <tr>
                                <td width='200'>Nama Item <?php echo form_error('nama_item') ?></td>
                                <td><input type="text" class="form-control" name="nama_item" id="nama_item"
                                        placeholder="Nama Item" value="<?php echo $nama_item; ?>" /></td>
                            </tr>
                            <tr>

                            <tr>
                                <td width='200'>Agen <?php echo form_error('agen_id') ?></td>
                                <td><select name="agen_id" class="form-control">
                                        <option value="">-- Pilih -- </option>
                                        <?php foreach ($agen as $key => $data) { ?>
                                        <?php if ($agen_id == $data->agen_id) { ?>
                                        <option value="<?php echo $data->agen_id ?>" selected>
                                            <?php echo $data->nama_agen ?></option>
                                        <?php } else { ?>
                                        <option value="<?php echo $data->agen_id ?>"><?php echo $data->nama_agen ?>
                                        </option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select></td>
                            </tr>

                            <tr>
                                <td width='200'>Kategori Item <?php echo form_error('kategori_id') ?></td>
                                <td><select name="kategori_id" class="form-control">
                                        <option value="">-- Pilih -- </option>
                                        <?php foreach ($kategori as $key => $data) { ?>
                                        <?php if ($kategori_id == $data->kategori_id) { ?>
                                        <option value="<?php echo $data->kategori_id ?>" selected>
                                            <?php echo $data->nama_kategori ?></option>
                                        <?php } else { ?>
                                        <option value="<?php echo $data->kategori_id ?>">
                                            <?php echo $data->nama_kategori ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select></td>
                            </tr>


                            <td width='200'>Jenis item <?php echo form_error('jenis_item_id') ?></td>
                            <td><select name="jenis_item_id" class="form-control">
                                    <option value="">-- Pilih -- </option>
                                    <?php foreach ($jenis as $key => $data) { ?>
                                    <?php if ($jenis_item_id == $data->jenis_item_id) { ?>
                                    <option value="<?php echo $data->jenis_item_id ?>" selected>
                                        <?php echo $data->nama_jenis_item ?></option>
                                    <?php } else { ?>
                                    <option value="<?php echo $data->jenis_item_id ?>">
                                        <?php echo $data->nama_jenis_item ?></option>
                                    <?php } ?>
                                    <?php } ?>
                                </select></td>
                            </tr>
                            <tr>
                                <td width='200'>Type <?php echo form_error('type_id') ?></td>
                                <td><select name="type_id" class="form-control">
                                        <option value="">-- Pilih -- </option>
                                        <?php foreach ($type as $key => $data) { ?>
                                        <?php if ($type_id == $data->type_id) { ?>
                                        <option value="<?php echo $data->type_id ?>" selected>
                                            <?php echo $data->nama_type ?></option>
                                        <?php } else { ?>
                                        <option value="<?php echo $data->type_id ?>"><?php echo $data->nama_type ?>
                                        </option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select></td>
                            </tr>

                            <tr>
                                <td width='200'>Merek <?php echo form_error('merek_id') ?></td>
                                <td><select name="merek_id" class="form-control">
                                        <option value="">-- Pilih -- </option>
                                        <?php foreach ($merek as $key => $data) { ?>
                                        <?php if ($merek_id == $data->merek_id) { ?>
                                        <option value="<?php echo $data->merek_id ?>" selected>
                                            <?php echo $data->nama_merek ?></option>
                                        <?php } else { ?>
                                        <option value="<?php echo $data->merek_id ?>"><?php echo $data->nama_merek ?>
                                        </option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select></td>
                            </tr>

                            <tr>
                                <td width='200'>No Stnk <?php echo form_error('no_stnk') ?></td>
                                <td><input type="text" class="form-control" name="no_stnk" id="no_stnk"
                                        placeholder="No Stnk" value="<?php echo $no_stnk; ?>" /></td>
                            </tr>

                            <tr>
                                <td width='200'>No Bpkb <?php echo form_error('no_bpkb') ?></td>
                                <td><input type="text" class="form-control" name="no_bpkb" id="no_bpkb"
                                        placeholder="No Bpkb" value="<?php echo $no_bpkb; ?>" /></td>
                            </tr>
                            <tr>
                                <td width='200'>Tahun Buat <?php echo form_error('tahun_buat') ?></td>
                                <td><input type="text" class="form-control" name="tahun_buat" id="tahun_buat" placeholder="Tahun Buat" value="<?php echo $tahun_buat; ?>"/>
                            </tr>
                            <tr>
                                <td width='200'>Warna Satu <?php echo form_error('warna1') ?></td>
                                <td><input type="text" class="form-control" name="warna1" id="warna1"
                                        placeholder="Warna Satu" value="<?php echo $warna1; ?>" /></td>
                            </tr>
                            <tr>
                                <td width='200'>Warna Dua <?php echo form_error('warna2') ?></td>
                                <td><input type="text" class="form-control" name="warna2" id="warna2"
                                        placeholder="warna Dua" value="<?php echo $warna2; ?>" /></td>
                            </tr>
                            <tr>
                                <td width='200'>Kondisi (0-100 %) <?php echo form_error('kondisi') ?></td>
                                <td style="
                                    display: grid;
                                    grid-template-columns: 0.6fr 1fr;"><input type="number" class="form-control" name="kondisi" id="kondisi" placeholder="Kondisi" value="<?php echo $kondisi; ?>" /><div class="progress" style="margin: 1vh;">
                      <div class="progress-bar progress-bar-primary progress-bar-striped active" role="progressbar"
                      aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">
                        0%
                      </div>
                    </div></td>
                            </tr>
                            <tr>
                                <td width='200'>No Mesin <?php echo form_error('no_mesin') ?></td>
                                <td><input type="text" class="form-control" name="no_mesin" id="no_mesin"
                                        placeholder="No Mesin" value="<?php echo $no_mesin; ?>" /></td>
                            </tr>
                            <tr>
                                <td width='200'>No Rangka <?php echo form_error('no_rangka') ?></td>
                                <td><input type="text" class="form-control" name="no_rangka" id="no_rangka"
                                        placeholder="No Rangka" value="<?php echo $no_rangka; ?>" /></td>
                            </tr>

                            <tr>
                                <td width='200'>Deskripsi <?php echo form_error('deskripsi') ?></td>
                                <td> <textarea class="form-control" rows="3" name="deskripsi" id="deskripsi"
                                        placeholder="Deskripsi"><?php echo $deskripsi; ?></textarea></td>
                            </tr>
                            <tr>
                                <td width='200'>Harga Perolehan <?php echo form_error('harga_beli') ?></td>
                                <td><input type="text" class="form-control" name="harga_beli" id="harga_beli"
                                        placeholder="Harga Beli" value="<?php echo $harga_beli; ?>" />
                                        <input type="hidden" class="form-control" name="harga_old" id="harga_old"
                                        placeholder="Harga Beli" value="<?php echo $harga_beli; ?>" />
                                        <input type="hidden" class="form-control" name="harga_pokok" id="harga_pokok"
                                        placeholder="Harga Beli" value="<?php echo $harga_pokok; ?>" />



                                    </td>
                            </tr>

                            <?php if ($this->uri->segment(2) == 'create' || $this->uri->segment(2) == 'create_action' ) { ?>
                            <tr>
                                <td width='200'>photo <?php echo form_error('photo') ?></td>
                                <td><input type="file" class="form-control" name="photo" id="photo" placeholder="photo"
                                        required="" value="" onchange="return validasiEkstensi()">
                                    <!-- <div id="preview"></div> -->
                                </td>
                            </tr>
                            <?php }else{ ?>
                            <div class="form-group">


                                <tr>
                                    <td width='200'>photo <?php echo form_error('photo') ?></td>
                                    <td>
                                        <img src="<?php echo base_url();?>assets/img/item/<?=$photo?>" width="200"
                                            height="150"></img>
                                        <input type="hidden" name="photo_lama" value="<?=$photo?>">
                                        <p style="color: red">Note :Pilih photo Jika Ingin Merubah photo</p>
                                        <input type="file" class="form-control" name="photo" id="photo"
                                            placeholder="photo" value="" onchange="return validasiEkstensi()" />
                                        <!-- <div id="preview"></div> -->
                                    </td>

                                </tr>


                            </div>
                            <?php } ?>

                            <input type="hidden" class="form-control" name="status" value="Ready" id="status" placeholder="Status" value="<?php echo $status; ?>" <tr>
                            <td></td>
                            <td><input type="hidden" name="item_id" value="<?php echo $item_id; ?>" />
                                <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i>
                                    <?php echo $button ?></button>
                                <a href="<?php echo site_url('item') ?>" class="btn btn-info"><i
                                        class="fa fa-sign-out"></i> Kembali</a>
                            </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="<?= base_url()?>assets/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet"/>
<script type="text/javascript">
    $("#tahun_buat").datepicker({
        format: "yyyy",
        viewMode: "years", 
        minViewMode: "years"
    });


    let statusnew = ''
    $('#kondisi').on('change input', function() {
        const condition = parseInt($(this).val())    

        $(this).next().children('.progress-bar').attr('aria-valuenow',condition).css('width', `${condition}%`).html(`${condition}%`)
    })
</script>