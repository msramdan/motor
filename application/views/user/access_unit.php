
            <div class="page-nama_unit">
                          <div class="nama_unit_left">
                          <h3>User : <?= $user['nama_user']  ?> </h3>
              </div>
              <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
        
        <div class="box-body">
            <div class='row'>
            <div class='col-md-9'>
            </div>
        
   
        <div class="row" style="margin-bottom: 10px">
            
            <div class="col-md-1 text-right">
            </div>
            <div class="col-md-3 text-right">
                
            </div>
        </div>
        <div class="box-body" style="overflow-x: scroll; ">
          <table class="table table-bordered table-striped" id="">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Grup</th>
                <th>Access Unit</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1;
              foreach ($data_grup as $key => $value) { ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $value->nama_grup ?></td>
                  <td>
                    <div class="form-check">
                      <?php
                $grupID = $value->grup_id;
                $queryUnit = "SELECT `unit`.`nama_unit`,`unit`.`grup_id`,`unit`.`unit_id`,`grup`.*
                FROM `unit` JOIN `grup` 
                  ON `unit`.`grup_id` = `grup`.`grup_id`
               WHERE `unit`.`grup_id` = $grupID
               ";
                $unitGrup = $this->db->query($queryUnit)->result_array();
                ?>
                <?php foreach ($unitGrup as $sm) : ?>
                  <input class="form-check-input" type="checkbox" <?= check_access_unit($user['user_id'],$sm['unit_id']); ?>
                        data-user="<?= $user['user_id']; ?>"
                        data-unit="<?= $sm['unit_id'] ?>"
                      >
                      <label class="" for="customCheck1"><?= $sm['nama_unit'] ?></label><br>

                <?php endforeach; ?>   
                  
                  </div>


                  </td>

                    </form>
                </tr>


              <?php
              } ?>

            </tbody>
          </table>
        </div>
                    </div>
            </div>
            </div>
            </div>
</div>

    <script type="text/javascript">
      $('.form-check-input').on('click', function() {
        const unit_id = $(this).data('unit');
        const user_id = $(this).data('user');
        $.ajax({
          url: "<?= base_url('user/changeaccess'); ?>",
          type: "post",
          data: {
            unit_id: unit_id,
            user_id: user_id,
          },
          success: function() {
            document.location.href = "<?= base_url('user/akses_unit/') ?>" + user_id;
          }

        });

      })
    </script>