
<div class="row-fluid">
	<div class="span10">
<?php
echo start_widget('Sales Entry', anchor('sales', '<span class="icon"><i class="icon-list"></i></span>'), 'nopadding');
echo form_open($this->uri->uri_string(), 'class="form-horizontal"');
?>

<fieldset>	

	<div class="control-group" <?php echo (strlen(form_error('barcode')) > 0 ? 'error' : '') ?>>
		<div class="control-label">Customer Name</div>
		<div class="controls">
				<input type="hidden"  name="id" value="<?php echo set_value('id', $id) ?>" />
				<input type="text" class="span5" name="customer_name" value="<?php echo set_value('name', $row['party_name']) ?>" placeholder="Enter Customer Name..."/>			
		</div>
		<div class="control-label">Contact No</div>
		<div class="controls">
				<input type="text" class="span5" name="customer_contact" value="<?php echo set_value('customer_contact', $row['party_contact']) ?>" placeholder="Enter Customer Contact No..."/>			
		</div>
	</div>
	
</fieldset>
<fieldset>
	<div class="control-group <?php echo (strlen(form_error('sel_barcode')) > 0 ? 'error' : '') ?>">
		<div class="control-label">Bar Code</div>
			<div class="controls">
				<input type="hidden" id ="purchase_autocomplete_id"  name="purchase_autocomplete_id"  />
				<input type="text" class="span8" id="barcode" name="sel_barcode" placeholder="Please Hit the Barcode..."/>
				<input type="text" class="span1" id="sel_qty" name="sel_qty" value="1" placeholder="Quantity"/>			
					<button type="submit" name="submit" value="1" class="btn btn-success" id="Update">Update</button> 
				<?php if($id > 0) : ?> 
				&nbsp;&nbsp;<?php echo anchor("sales/preview/".$id."/0", 'Print', 'class="btn Preview Popup"') ?>
				<?php  endif;  ?>		
			</div>
	<div class="row-fluid">
		<div class="span12">
			<fieldset>
			<legend>Bill Items</legend>
				<table class="table table-condensed table-striped">
					<thead>	
						<tr>
							<th>Product</th>
							<th>Barcode</th>
							<th>MRP</th>
							<th>Quantity</th>
							<th width="24px" class="aligncenter"><a href="javascript: DeleteAll()"><i class="icon-trash"></i></a></th>
						</tr>
					</thead>

					<tbody>

							<!--<?php if($noproavail==1)
							{
								?>-->
								
							<!--<?php } ?>-->	
							<?php foreach ($sale_details as $sid) { 
							?>
							<tr>					
								<td>
								<input type="hidden" class="Text span12" name="sales_detail_id[<?php echo $sid['id'] ?>]"  value="<?php echo $sid['id'] ?>" />
								<input type="hidden" class="Text span12" name="purchase_detail_id[<?php echo $sid['id'] ?>]"  value="<?php echo $sid['purchase_detail_id'] ?>" />
								<input type="text" class="Text span12" value="<?php echo $sid['name'] ?>" readonly/>
								</td>
								<td><input type="text" class="Numeric input-mini" name="barcode[<?php echo $sid['id'] ?>]"  value="<?php echo $sid['barcode'] ?>" readonly/></td>
								<td><input type="text" class="Numeric input-mini" name="price[<?php echo $sid['id'] ?>]" value="<?php echo $sid['price'] ?>" readonly/></td>
								<td><input type="text" class="Numeric input-mini" name="quantity[<?php echo $sid['id'] ?>]" value="<?php echo $sid['quantity'] ?>" readonly/></td>
								<td class="aligncenter"><?php echo form_checkbox(array('name' => 'delete_id['.$sid['id'].']', 'value' => $sid['id'], 'checked' => false, 'class' => 'DeleteCheckbox', 'data-placement' => 'left', 'rel' => 'tooltip', 'data-original-title'=>'Selected Items will be deleted after Update...')); ?></td>
							</tr>
							<?php } ?> 
							<tr>
								<td></td>
								<td>Total</td>
								<td><input type="text" class="Numeric input-mini" name="total" value="<?php echo $total?>" placeholder="Total" readonly/></td>
								<td><input type="text" class="Numeric input-mini" name="item" value="<?php echo $item?>" placeholder="Items" readonly/></td>
								<td></td>
							<tr>
							<tr>
								<td></td>
								<td>Discount</td>
								<td colspan=2><input type="text" class="Numeric span8" name="discount" value="<?php echo $discount?>" placeholder="Discount" /></td>
								
								<td></td>
							<tr>
							<tr>
								<td></td>
								<td>To Pay</td>
								<td colspan=2><input type="text" class="Numeric span8" name="topay" value="<?php echo $topay?>" placeholder="To Pay" /></td>
								
								<td></td>
							<tr>
					</tbody>
				</table>
			</fieldset>
		</div>
	</div>

	
</fieldset>



<script>
var checked = 1;

function DeleteAll() {
 	if(checked) {
 		$("input.DeleteCheckbox").attr("checked", "checked");
 		checked = 0;
 	} else {
 		$("input.DeleteCheckbox").removeAttr("checked");
 		checked = 1;
 	}
 }


$(document).ready(function() {
	$("#barcode").autocomplete({
				source: "<?php echo site_url('sales/ajaxBarcode') ?>",
				minLength: 0,
				focus: function(event, ui) {
					$("#barcode").val(ui.item.barcode);
					return false;
				},
				select: function(event, ui) {
					$("#barcode").val(ui.item.barcode);
					$("#purchase_autocomplete_id").val(ui.item.id);
					return false;
				},
				response: function(event, ui) {
		         if (ui.content.length == 0) {
		            $("#barcode").val('');
					$("#purchase_autocomplete_id").val(0);
		         }
		        }
			})
			.data("autocomplete")._renderItem = function(ul, item) {
				return $("<li></li>")
					.data("item.autocomplete", item)
					.append('<a><span class="blueDark">' + item.barcode +  '</span></a>')
					.appendTo(ul);
			}
});

    


</script>


<?php echo end_widget(); ?>