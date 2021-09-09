<div class="page-title">
    <div class="title_left">
        <h3>LAPORAN PENJUALAN</h3>
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="box-body">
                <form class="form-horizontal">
                  <fieldset>
                    <div class="col-md-10">
                        <div class="control-group">
                          <div class="controls">
                            <div class="input-prepend input-group">
                              <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                              <input type="text" name="datarange-picker" id="datarange-picker" class="form-control" value="01/01/2016 - 01/25/2016" />
                              <input type="hidden" name="tbtglstart" id="tbtglstart" value="<?php echo date('Y-m-d') ?>">
                              <input type="hidden" name="tbtglend" id="tbtglend" value="<?php echo date('Y-m-d') ?>">
                            </div>
                          </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary btn-large btn-block btninitsearch">CARI</button>
                    </div>
                    <div class="col-md-12">
                        <div>
                            <div class="x_panel">
                              <div class="x_title">
                                <h2>Filter</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                  <li style="float: right;"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                  </li>
                                </ul>
                                <div class="clearfix"></div>
                              </div>
                              <div class="x_content">
                                <div class="col-md-6">
                                    <table class="table">
                                        <tr>
                                            <td>ID Penjualan</td>
                                            <td>:</td>
                                            <td><input type="text" name="tbidpenjualan" id="tbidpenjualan"></td>
                                        </tr>
                                        <tr>
                                            <td>ID Item</td>
                                            <td>:</td>
                                            <td><input type="text" name="tbiditem" id="tbiditem"></td>
                                        </tr>
                                        <tr>
                                            <td>Nama Pelanggan</td>
                                            <td>:</td>
                                            <td><input type="text" name="tbnamapelanggan" id="tbnamapelanggan"></td>
                                        </tr>
                                        <tr>
                                            <td>Sales Referal</td>
                                            <td>:</td>
                                            <td>
                                                <select id="selectsales_referral" name="selectsales_referral">
                                                    <option value="">ALL</option>
                                                    <option value="Karyawan" >Karyawan</option>
                                                    <option value="Mitra Sales" >Mitra Sales</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Mode</td>
                                            <td>:</td>
                                            <td>
                                                <select id="selectmode" name="selectmode">
                                                    <option value="">ALL</option>
                                                    <option value="Kredit" >Angsuran</option>
                                                    <option value="Cash">One Time Payment</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Kategori</td>
                                            <td>:</td>
                                            <td>
                                                <select id="selectkategori" name="selectkategori">
                                                    <option value="">ALL</option>
                                                    <?php foreach ($kategori as $key => $data) { ?>
                                                        <option value="<?php echo $data->kategori_id ?>"><?php echo $data->nama_kategori ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Status</td>
                                            <td>:</td>
                                            <td>
                                                <select id="selectstatus" name="selectstatus">
                                                    <option value="">ALL</option>
                                                    <option value="Lunas">Lunas</option>
                                                    <option value="Kurang Lancar">Kurang Lancar</option>
                                                    <option value="Diragukan">Diragukan</option>
                                                    <option value="Macet">Macet</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table">
                                        <tr>
                                            <td colspan="3" style="font-size: 16px; font-weight: bold;">Total</td>
                                        </tr>
                                        <tr>
                                            <td width="150">DP</td>
                                            <td>:</td>
                                            <td>Rp.<span id="totaldp">-</span></td>
                                        </tr>
                                        <tr>
                                            <td width="150">TradeIn</td>
                                            <td>:</td>
                                            <td>Rp.<span id="totaltradein">-</span></td>
                                        </tr>
                                        <tr>
                                            <td width="150">Harga Beli</td>
                                            <td>:</td>
                                            <td>Rp.<span id="totalhargabeli">-</span></td>
                                        </tr>
                                        <tr>
                                            <td width="150">Harga Penjualan</td>
                                            <td>:</td>
                                            <td>Rp.<span id="totalhargapenjualan">-</span></td>
                                        </tr>
                                        <tr>
                                            <td width="150">Markup</td>
                                            <td>:</td>
                                            <td>Rp.<span id="totalmarkup">-</span></td>
                                        </tr>
                                        <tr>
                                            <td width="150">Sales Pokok</td>
                                            <td>:</td>
                                            <td>Rp.<span id="totalsalespokok">-</span></td>
                                        </tr>
                                        <tr>
                                            <td width="150">Bunga Cicilan</td>
                                            <td>:</td>
                                            <td><span id="totalbungacicilan">-</span>%</td>
                                        </tr>
                                    </table>
                                </div>
                              </div>
                            </div>
                        </div>
                    </div>
                  </fieldset>
                </form>
                <div id="datawrapper" style="margin-top: 3vh;">
                    <div class="info" style="display: flex; flex-direction: column;margin-top: 17vh; text-align: center;">
                        <div class="icon"><i class="fa fa-database" style="font-size: 65px"></i></div>
                        <h3 class="title" style="color: #9d9d9d;s">Data penjualan akan muncul disini</h3>
                    <div>
                </div>
                <p><span><i class="fa fa-question-circle"></i></span> Mulai dengan memilih tanggal penjualan yang ingin dilihat pada isian diatas</p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="<?php echo base_url()?>assets/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript">
	   
    function initSumColumn(input, output) {
        let sum = 0;

        $('.' + input + '').each(function() {
            var nilaihargaper = $(this);
            sum += parseFloat(nilaihargaper.text());
        });

        $('#' + output + '').html(sum);
    }

    function fetch_sale_report() {
        $('#datawrapper').html(`<div class="info" style="display: flex; flex-direction: column;margin-top: 17vh; text-align: center;">
                                <div class="icon"><i class="fa fa-circle-o-notch fa-spin" style="font-size: 65px"></i></div>
                                <h3 class="title" style="color: #9d9d9d;s">Memproses Permintaan...</h3>
                            <div>`)

        const from = $('#tbtglstart').val()
        const end = $('#tbtglend').val()

        const idpenjualan = $('#tbidpenjualan').val()
        const iditem = $('#tbiditem').val()
        const namapelanggan = $('#tbnamapelanggan').val()

        const selectsalesreferral = $('#selectsales_referral').val()
        const selectmode = $('#selectmode').val()
        const selectkategori = $('#selectkategori').val()
        const selectstatus = $('#selectstatus').val()

        $.ajax({
            type : "POST",
            url  : "<?php echo base_url() ?>/Lap_penjualan/fetch_tabel_penjualan",
            data : {
                fromDate: from,
                toDate: end,
                idpenjualan: idpenjualan,
                iditem: iditem,
                namapelanggan: namapelanggan,
                selectsalesreferral: selectsalesreferral,
                selectmode: selectmode,
                selectkategori: selectkategori,
                selectstatus: selectstatus,
                allunit: 'false'
            },
            success: function(data){
                // const dt = JSON.parse(data)
                console.log(idpenjualan + '-' + iditem + '-' + namapelanggan + '-' + selectsalesreferral + '-' + selectmode + '-' + selectkategori + '-' + selectstatus)
                setTimeout(function(){
                    $('#datawrapper').html(data);

                    initSumColumn('dpvalue','totaldp')
                    initSumColumn('tradeinvalue','totaltradein')
                    initSumColumn('hargabelipokokvalue','totalhargabeli')
                    initSumColumn('hargamarkupvalue','totalmarkup')
                    initSumColumn('hargapenjualanvalue','totalhargapenjualan')
                    initSumColumn('salespokokvalue','totalsalespokok')
                    initSumColumn('bungacicilanvalue','totalbungacicilan')
                },2000)
            },
            error: function(e){
              setTimeout(function(){
                    $('#datawrapper').html('Server mengalami masalah, silahkan coba lagi');
                },2000)
            }
        });
    }

    $(document).on('click','.btninitsearch', function(e){
        e.preventDefault()
        fetch_sale_report()
    });


    $('#datarange-picker').daterangepicker({
	    "startDate": moment().format('DD-MM-YYYY'),
	    "endDate": moment().format('DD-MM-YYYY')
	}, function(start, end, label) {
	  console.log("New date range selected: " + start.format('YYYY-MM-DD') + " to " + end.format('YYYY-MM-DD') + " (predefined range: " + label + ")")
      $('#tbtglstart').val(start.format('YYYY-MM-DD'))
      $('#tbtglend').val(end.format('YYYY-MM-DD'))
	});


</script>