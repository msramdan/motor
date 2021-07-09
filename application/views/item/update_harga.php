<div class="page-title">
    <div class="title_left">
        <h3>Infor Harga</h3>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">

                <div class="form-group">
                    <form action="<?= base_url() ?>item/action_update_harga" method="POST"
                        enctype="multipart/form-data">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dynamic_field">
                                <tr>
                                    <td><input type="text" name="nama_harga[]" placeholder="Nama Biaya"
                                            class="form-control nama_harga" required="" /></td>
                                    <td><input type="number" name="nominal[]" placeholder="Nominal"
                                            class="form-control nominal" required="" /></td>
                                    <input type="hidden" name="item_id[]" class="form-control"
                                        value="<?php echo $this->uri->segment(3) ?>">
                                    <td><button type="button" name="add_harga" id="add_harga"
                                            class="btn btn-success">Add More</button></td>
                                </tr>
                            </table>
                            <button class="btn btn-success" type="submit">Submit</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>