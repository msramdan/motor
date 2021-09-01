<table>
	<tr>
		<th>Invoice</th>
	</tr>

	<?php
	foreach($lists_data as $d)
	{
		?>
		<tr>
			<td><?php echo $d->invoice ?></td>
		</tr>
		<?php
	}
	?>
</table>