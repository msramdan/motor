<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

        <body>
            <h2 style="margin-top:0px">item Read</h2>
            <table class="table">
                <tr>
                    <td>Kode Pembelian</td>
                    <td><?php echo $kd_pembelian; ?></td>
                </tr>
                <tr>
                    <td>Agen</td>
                    <td><?php echo $agen_id; ?></td>
                </tr>
                <tr>
                    <td>Kode item</td>
                    <td><?php echo $kd_item; ?></td>
                </tr>
                <tr>
                    <td>Nama item</td>
                    <td><?php echo $nama_item; ?></td>
                </tr>
                <tr>
                    <td>Jenis item</td>
                    <td><?php echo $jenis_item_id; ?></td>
                </tr>
                <tr>
                    <td>Merek</td>
                    <td><?php echo $merek_id; ?></td>
                </tr>
                <tr>
                    <td>No Stnk</td>
                    <td><?php echo $no_stnk; ?></td>
                </tr>
                <tr>
                    <td>No Bpkb</td>
                    <td><?php echo $no_bpkb; ?></td>
                </tr>
                <tr>
                    <td>Deskripsi</td>
                    <td><?php echo $deskripsi; ?></td>
                </tr>
                <tr>
                    <td>Harga Perolehan</td>
                    <td><?php echo $harga_beli; ?></td>
                </tr>
                <tr>
                    <td>Photo</td>
                    <td><a class="hover-on-pic" data-toggle="modal" data-target=".bs-example-modal-lg"><img
                                src="<?php echo base_url().'/assets/img/item/'.$photo ?>" width="300" /></a></td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td><?php echo $status; ?></td>
                </tr>

                <tr>
                    <td>Detail Biaya</td>
                    <td>
                        <table class="table table-sm table-bordered">

                            <tr>
                                <th>Nama Biaya</th>
                                <th>Nominal</th>
                                <th>Hapus</th>
                            </tr>
      
                      <?php foreach ($harga->result() as $key => $data) { ?>
                            <tr>
                                <td> <?php echo $data->nama_harga ?></td>
                                <td> <?php echo $data->nominal ?></td>
                                <td><a href="<?=site_url('item/del_harga/'.$data->harga_id.'/' .$this->uri->segment(3))?>"
                                        onclick="return confirm('Yakin Akan Hapus ?')" class="btn btn-danger btn-xs"
                                        title="Delete"><i class="fa fa-trash"></i></a></td>
                            </tr>
                            <?php } ?>
                        </table>


                    </td>
                </tr>

                <tr>
                    <td></td>
                    <td><a href="<?php echo site_url('item') ?>" class="btn btn-default">Cancel</a>
                    <a href="<?php echo site_url() ?>item/cetak/<?php echo $item_id ?>" class="btn btn-warning">Cetak</a>
                    </td>
                </tr>
            </table>
        </body>
    </div>
</div>
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Preview</h4>
            </div>
            <div class="modal-body">
                <img src="<?php echo base_url().'/assets/img/item/'.$photo ?>" width="100%" />
            </div>
            <div class="modal-footer">
                <a class="btn btn-primary" href="<?php echo base_url(); ?>item/download/<?php echo $photo ?>"><i
                        class="ace-icon fa fa-download"></i> Download</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
