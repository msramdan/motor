<h2 style="margin-top:0px">Info Pembayaran</h2>
<?php

if($status_sale === 'Selesai')
{?>
    <label class="label label-success" style="font-size: 1em;">Lunas</label>
    <table class="table" style="margin-top: 10px;">
    	<tr><td>Harga Beli Item</td><td>: </td><td><?php echo $total_price_sale; ?></td></tr>
    	<tr><td>Biaya Admin</td><td>: </td><td><?php echo $biaya_admin; ?></td></tr>
    	<tr><td>Total</td><td>: </td><td><?php echo $total_bayar; ?></td></tr>
    	<tr><td>Dibayar</td><td>: </td><td><?php echo $dibayar; ?></td></tr>
    	<tr><td>Sisa</td><td>: </td><td><?php echo intval($total_bayar) - intval($dibayar); ?></td></tr>
    	<tr><td>Pembayaran Terakhir</td><td>: </td><td><?php echo $last_updated; ?></td></tr>
        <tr><td>Keadaan Proses Cicilan</td><td>: </td><td><?php echo $resultkeadancicilankeseluruhan ?></td></tr>
    </table>
<?php
}
if ($status_sale === 'Dalam Cicilan') {
    ?>
    <label class="label label-warning" style="font-size: 1em;">Sedang dalam Cicilan</label>
	<table class="table" style="margin-top: 10px;">
    	<tr><td>Harga Beli Item</td><td>: </td><td><?php echo $total_price_sale; ?></td></tr>
    	<tr><td>Biaya Admin</td><td>: </td><td><?php echo $biaya_admin; ?></td></tr>
    	<tr><td>Total</td><td>: </td><td><?php echo $total_bayar; ?></td></tr>
    	<tr><td>Dibayar</td><td>: </td><td><?php echo $dibayar; ?></td></tr>
    	<tr><td>Sisa</td><td>: </td><td><?php echo intval($total_bayar) - intval($dibayar); ?></td></tr>
    	<tr><td>Pembayaran Terakhir</td><td>: </td><td><?php echo $last_updated; ?></td></tr>
        <tr><td>Keadaan Proses Cicilan</td><td>: </td><td><?php echo $resultkeadancicilankeseluruhan ?></td></tr>
    </table>
<?php
}
?>
<div class="project_progress">
   <div class="progress">
      <div class="progress-bar <?php echo $progresscicilan->total_dibayar == $progresscicilan->total_angsuran ? 'progress-bar-success progress-bar-striped' : 'progress-bar-warning progress-bar-striped'; ?> active" role="progressbar"
      aria-valuenow="<?php echo $progresscicilan->total_dibayar; ?>" aria-valuemin="0" aria-valuemax="<?php echo $progresscicilan->total_angsuran; ?>" style="width:<?php echo intval($progresscicilan->total_dibayar)/ intval($progresscicilan->total_angsuran) * 100; ?>%">
        <?php echo round(intval($progresscicilan->total_dibayar)/ intval($progresscicilan->total_angsuran) * 100, 2); ?>%
      </div>
    </div>
    <small><?php echo $progresscicilan->total_dibayar; ?>/<?php echo $progresscicilan->total_angsuran; ?> Terbayar</small>
</div>
<div>
	<a class="btn btn-primary" href="<?php echo base_url().'r_cicilan/cetak_kartupiutang/'.$invoice_id ?>">Kartu Piutang</a>
</div>