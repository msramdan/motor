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
                                    
                                    <td><?php echo $item->harga_beli ?></td>
                                    <td><?php echo $item->harga_pokok ?></td>
                                    <td><a href="<?php echo base_url(); ?>item/download/<?php echo $item->photo?>"><i
                                                class="ace-icon fa fa-download"></i> Download Photo</td>
                                    <?php if ($item->status=="Ready") { ?>
                                        <td><span class="label label-success">Ready</span></td>
                                    <?php } if ($item->status=="Proses Jual") { ?>
                                        <td><span class="label label-warning">Proses Jual</span></td>
                                    <?php } if ($item->status == 'Terjual') { ?>
                                        <td><span class="label label-danger">Terjual</span></td>
                                    <?php } ?>
                                    <td style="text-align:center" width="200px">
                                        
                                        <?php 

                                        echo show_button($menu_accessed, 'read', $item->item_id);

                                        if ($item->status !== 'Proses Jual') {
                                            echo show_button($menu_accessed,'update_harga',encrypt_url($item->item_id), NULL, 'fa-pencil-square-o');
                                            echo show_button($menu_accessed, 'update', $item->item_id);
                                            echo show_button($menu_accessed, 'delete', $item->item_id);
                                        }
                                        ?>
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