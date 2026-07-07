<?php 
	//$model as WorkOrderCuttingComponent component model
?>

<table style="border: 1px solid">
	<tr style="background-color: skyblue">
		<th style="text-align: center">Nama Barang</th>
		<th style="text-align: center; width: 10%">Tinggi/Dmtr</th>
		<th style="text-align: center; width: 10%">Lbr/Dmtr</th>
		<th style="text-align: center; width: 10%">Panjang</th>
	</tr>

	<?php if (isset($model->header->saleHeader)): ?>
		<?php foreach ($model->header->saleHeader->saleDetailProducts as $i => $detail): ?>
		<tr>
			<td><!--nama barang-->
				<?php echo CHtml::encode(CHtml::value($detail, 'quotationDetailProduct.product_name')); ?>
			</td>
<!--
			<td style="text-align: center"><!--height
				<?php //echo CHtml::activeTextField($detail, "[$i]height"); ?>
				<?php //echo CHtml::error($detail, 'height'); ?>
			</td>

			<td style="text-align: center"><!--width
				<?php //echo CHtml::activeTextField($detail, "[$i]width"); ?>
				<?php //echo CHtml::error($detail, 'width'); ?>
			</td>

			<td style="text-align: center"><!--length
				<?php //echo CHtml::activeTextField($detail, "[$i]length"); ?>
				<?php //echo CHtml::error($detail, 'length'); ?>
			</td>

-->
		</tr>
		<?php endforeach; ?>
	<?php endif; ?>
</table>