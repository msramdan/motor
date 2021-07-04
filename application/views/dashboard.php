
          <div class="">
            <div class="alert alert-success alert-dismissible fade in" role="alert" style="margin-top: 60px">
                    <strong>Selamat Datang <?= ucfirst($this->fungsi->user_login()->nama_user) ?></strong> 
                  </div>
            <div class="row top_tiles">
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-users"></i></div>
                  <div class="count"><?php echo $countpelanggan; ?></div>
                  <h3>Pelanggan</h3>
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-cube "></i></div>
                  <div class="count"><?php echo $countkendaraan; ?></div>
                  <h3>Data Item</h3>
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-shopping-cart"></i></div>
                  <div class="count"><?php echo $counttransaksi; ?></div>
                  <h3>Transaksi</h3>
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-user"></i></div>
                  <div class="count"><?php echo $countusers; ?></div>
                  <h3>User Teregistrasi</h3>
                </div>
              </div>
            </div>
          </div>
          

          