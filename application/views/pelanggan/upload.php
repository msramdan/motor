<div class="page-title">
                          <div class="title_left">
                          <h3>Upload Berkas</h3>
              </div>
              <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
      
      <div class="form-group">
        <form action="<?= base_url() ?>Pelanggan/upload_berkas" method="POST" enctype="multipart/form-data">
          <div class="table-responsive" style="display: inline;">
            <table class="table table-bordered" id="dynamic_field">
              <tr>
                <td><input type="text" name="nama_berkas[]" placeholder="Nama Berkas" class="form-control nama_berkas" required="" /></td>
                <input type="hidden" name="pelanggan_id[]" class="form-control" value="<?php echo $this->uri->segment(3) ?>">
                <td><input type="file" name="berkas[]" class="form-control berkas_list" required="" /></td>
                <td><button type="button" name="add" id="add" class="btn btn-success">Add More</button></td>
              </tr>
              <p style="color: red">Format File jpg | png | pdf | docx | doc</p>
              <p style="color: red">Maks : 10MB / File</p>
            </table>
            <button class="btn btn-success" type="submit">Submit</button>
          </div>
        </form>
  
    </div>
        </div>
</div>
</div>


