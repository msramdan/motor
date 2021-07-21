<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
    <body>
        <h2 style="margin-top:0px">Agen Read</h2>
        <table class="table">
	    <tr><td>Nama Agen</td><td><?php echo $nama_agen; ?></td></tr>
	    <tr><td>No Hp Agen</td><td><?php echo $no_hp_agen; ?></td></tr>
	    <tr><td>Alamat</td><td><?php echo $alamat; ?></td></tr>
	    <tr><td>Deskripsi</td><td><?php echo $deskripsi; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('agen') ?>" class="btn btn-default">Cancel</a><button type="button" class="btn btn-warning" data-toggle="modal" data-target=".bs-example-modal-sm">Cetak</button></td></tr>
	</table>
        </body>
    </div>
</div>

<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm">
	  <div class="modal-content">

	    <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
	      </button>
	      <h4 class="modal-title" id="myModalLabel2">Preview</h4>
	    </div>
	    <div class="modal-body">
	      <div class="x_panel" id="capture" style="position: relative; padding: 0;">
	      	<img src="<?php echo base_url() ?>/assets/img/backgroundcardagen.jpg" style="max-width: 420px;width: 100%;">
	      	<div style="position: absolute; display: block; top: 5px; left: 19px;">
	      		<h1 style="font-size: 18px;"><?php echo $nama_agen ?></h1>
	      		<h3 style="font-size: 14px;"><?php echo $alamat ?></h3>
	      		<p style="font-size: 14px;"><?php echo $no_hp_agen ?></p>
	      	</div>
	      	<div id="qrcode" style="height: 8vh;
        height: 90px;
	    width: 90px;
	    background: gray;
	    position: absolute;
	    right: 2vh;
	    bottom: 2vh;">
	      		
	      	</div>
	      </div>
	    </div>
	    <div class="modal-footer">
	      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      <button type="button" id="btndownloadbussinesscard" class="btn btn-primary">Download</button>
	    </div>

	  </div>
	</div>
</div>
<script src="<?php echo base_url();?>assets/js/qrcode.min.js"></script>
<script src="<?php echo base_url();?>assets/js/html2canvas.min.js"></script>
<script type="text/javascript">
	function capture() {
		const capture = document.querySelector('#capture')
		html2canvas(capture)
			.then(canvas => {
				document.body.appendChild(canvas)
				canvas.style.display = 'none'
				return canvas
			})
			.then(canvas => {
				const image = canvas.toDataURL('image/png').replace('image/png', 'image/octet-stream')
				const a = document.createElement('a')
				a.setAttribute('download', 'tandapengenalagen.png')
				a.setAttribute('href', image)
				a.click()
				canvas.remove()
			})
	}

	$('#btndownloadbussinesscard').click(capture);

	$(document).ready(function(){
	  	var QR_CODE = new QRCode("qrcode", {
		  width: 90,
		  height: 90,
		  colorDark: "#000000",
		  colorLight: "#ffffff",
		  correctLevel: QRCode.CorrectLevel.H,
		});

		QR_CODE.makeCode("<?php echo $deskripsi ?>");
	})
</script>