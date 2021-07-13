<div class="page-title">
    <div class="title_left">
        <h3>KELOLA DATA item</h3>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">

                <div class="box-body">
                    <div class='row'>
                        <div class='col-md-9'>
                            <div style="padding-bottom: 10px;">
        <?php echo show_button($menu_accessed, 'create');
        echo show_button($menu_accessed, 'export'); ?></div>
            </div>
            <div class=' col-md-3'>
                                <form action="<?php echo site_url('item/index'); ?>" class="form-inline" method="get">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                                        <span class="input-group-btn">
                                            <?php 
                                if ($q <> '')
                                {
                                    ?>
                                            <a href="<?php echo site_url('item'); ?>" class="btn btn-default">Reset</a>
                                            <?php
                                }
                            ?>
                                            <button class="btn btn-primary" type="submit">Search</button>
                                        </span>
                                    </div>
                                </form>
                            </div>
                        </div>


                        <div class="row" style="margin-bottom: 10px">

                            <div class="col-md-1 text-right">
                            </div>
                            <div class="col-md-3 text-right">

                            </div>
                        </div>
                        <div class="box-body" style="overflow-x: scroll; ">
                            <table class="table table-bordered" style="margin-bottom: 10px">
                                <tr>
                                    <th>No</th>
                                    <th>Kd Pembelian</th>

                                    <th>Kode Item</th>
                                    <th>Nama Item</th>
                                    <th>Agen</th>
                                    <th>Kategori Item</th>
                                    <th>Jenis item</th>
                                    <th>Type</th>
                                    <th>Merek</th>
                                    <th>No Stnk</th>
                                    <th>No Bpkb</th>
                                    <th>Deskripsi</th>
                                    <th>Harga Perolehan</th>
                                    <th>Harga Pokok</th>
                                    <th>Photo</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr><?php
            foreach ($item_data as $item)
            {
                ?>
                                <tr>
                                    <td width="10px"><?php echo ++$start ?></td>
                                    <td><?php echo $item->kd_pembelian ?></td>

                                    <td><?php echo $item->kd_item ?></td>
                                    <td><?php echo $item->nama_item ?></td>
                                    <td><?php echo $item->nama_agen ?></td>
                                    <td><?php echo $item->nama_kategori ?></td>
                                    <td><?php echo $item->nama_jenis_item ?></td>
                                    <td><?php echo $item->nama_type ?></td>
                                    <td><?php echo $item->nama_merek ?></td>
                                    <td><?php echo $item->no_stnk ?></td>
                                    <td><?php echo $item->no_bpkb ?></td>
                                    <td><?php echo $item->deskripsi ?></td>
                                    <td><?php echo $item->harga_beli ?></td>
                                    <td><?php echo $item->harga_beli ?></td>
                                    <td><a href="<?php echo base_url(); ?>item/download/<?php echo $item->photo?>"><i
                                                class="ace-icon fa fa-download"></i> Download Photo</td>
                                    <td><?php echo $item->status ?></td>
                                    <td style="text-align:center" width="200px">
                                        <?php 
                                        echo show_button($menu_accessed, 'update_harga', $item->item_id);
                                        echo anchor(site_url($menu_accessed.'/update_harga/'.$item->item_id),'<i class="fa fa-pencil-square-o" aria-hidden="true"></i>','class="btn btn-primary btn-sm"'); 
                                        echo '  '; 
                                        echo show_button($menu_accessed, 'read', $item->item_id);
                                        echo show_button($menu_accessed, 'update', $item->item_id);
                                        echo show_button($menu_accessed, 'delete', $item->item_id); ?>
                                    </td>
                                </tr>
                                <?php
            }
            ?>
                            </table>
                            <div class="row">
                                <div class="col-md-6">

                                </div>
                                <div class="col-md-6 text-right">
                                    <?php echo $pagination ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>