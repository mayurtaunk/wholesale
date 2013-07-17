<div class="row-fluid">
	<div class="span10">
	
<?php
echo start_widget('Purchase Information', anchor('purchase', '<span class="icon"><i class="icon-list"></i></span>'), 'nopadding');
echo form_open($this->uri->uri_string(), 'class="form-horizontal"');
?>

	<fieldset>		
	
		<div class="control-group <?php echo (strlen(form_error('party_id')) > 0 ? 'error' : '') ?>">
			<label class="control-label">Party Name</label>
			<div class="controls">
				<input type="hidden"  name="id" value="<?php echo set_value('id', $id) ?>" />
				<input type="hidden" id ="party_id"  name="party_id" value="<?php echo set_value('party_id', $row['party_id']) ?>" />
				<input type="text" class="span8" id="party_name" name="party_name" value="<?php echo set_value('name', $row['name']) ?>" />
				<span class="help-inline Tiny">* Enter Party Fullname</span>
			</div>
		</div>
		
		<div class="control-group <?php echo (strlen(form_error('date')) > 0 ? 'error' : '') ?>">
			<label class="control-label">Date</label>
			<div class="controls">
				<input type="text" class="DateTime" id="datepicker" name="date" value="<?php echo set_value('date', $row['date']) ?>" />
			</div>
		</div>
		
		<div class="control-group <?php echo (strlen(form_error('bill_no')) > 0 ? 'error' : '') ?>">
			<label class="control-label">Bill No</label>
			<div class="controls">
				<input type="text" class="span8" name="bill_no" value="<?php echo set_value('bill_no', $row['bill_no']) ?>" />			
			</div>
		</div>

		<div class="control-group <?php echo (strlen(form_error('amount')) > 0 ? 'error' : '') ?>">
			<label class="control-label">Amount</label>
			<div class="controls">
				<input type="text" class="span8" name="amount" value="<?php echo set_value('amount', $row['amount']) ?>" />			
			</div>
		</div>
		<?php if($this->session->userdata('key')==1) {?>
				<?php echo form_checkbox(array('type'=>'hidden', 'name' => 'recieved', 'checked' => $row['recieved'] == 1 ? True : False, 'class' => 'DeleteCheckbox', 'data-placement' => 'left', 'rel' => 'tooltip', 'data-original-title'=>'Selected Items will be deleted after Update...')); ?>
		<?php 
		}
		else
		{
		?>
				<?php echo form_checkbox(array( 'type'=>'hidden','name' => 'recieved','value'=>1, 'checked' => $row['recieved'] == 1 ? True : False, 'class' => 'DeleteCheckbox', 'data-placement' => 'left', 'rel' => 'tooltip', 'data-original-title'=>'Selected Items will be deleted after Update...')); ?>
		<?php } ?>
	</fieldset>

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
							<th>Purchase Price</th>
							<th>Quantity</th>
							<th width="24px" class="aligncenter"><a href="javascript: DeleteAll()"><i class="icon-trash"></i></a></th>
						</tr>
					</thead>

					<tbody>
							<?php foreach ($purchase_details as $pid) { ?>
							<tr>					
								<td><input type="hidden" class="Text span12" name="product_id[<?php echo $pid['id'] ?>]"  value="<?php echo $pid['product_id'] ?>" />
									<input type="text" class="Text span12" value="<?php echo $pid['name'] ?>" />
								</td>
								<td><input type="text" class="Numeric input-mini" name="barcode[<?php echo $pid['id'] ?>]"  value="<?php echo $pid['barcode'] ?>" /></td>
								<td><input type="text" class="Numeric input-mini" name="mrp[<?php echo $pid['id'] ?>]" value="<?php echo $pid['mrp'] ?>" /></td>
								<td><input type="text" class="Numeric input-mini" name="purchase_price[<?php echo $pid['id'] ?>]" value="<?php echo $pid['purchase_price'] ?>" />
								</td>
								<td><input type="text" class="Numeric input-mini" name="quantity[<?php echo $pid['id'] ?>]" value="<?php echo $pid['quantity'] ?>" />
								</td>
								
								<td class="aligncenter"><?php echo form_checkbox(array('name' => 'delete_id['.$pid['id'].']', 'value' => $pid['id'], 'checked' => false, 'class' => 'DeleteCheckbox', 'data-placement' => 'left', 'rel' => 'tooltip', 'data-original-title'=>'Selected Items will be deleted after Update...')); ?></td>
							</tr>
							<?php } ?> 
			 				<tr id="1" style="display: none;">
								<td><input type="hidden" class="Text span12" name="new_product_id[]"  value="" />
									<input type="text" class="Text span12" value="" />
								</td>
								<td><input type="text" class="Numeric input-mini" name="new_barcode[]"  value="" /></td>
								<td><input type="text" class="Numeric input-mini" name="new_mrp[]" value="" /></td>
								<td><input type="text" class="Numeric input-mini" name="new_purchase_price[]" value="" />
								</td>
								<td><input type="text" class="Numeric input-mini" name="new_quantity[]" value="" />
								</td>
								<td class="aligncenter"><span id="1"><a href="#" class="btn btn-danger btn-mini"><i class="icon-minus icon-white"></i></a></span></td>
							</tr>

							<tr id="Blank">
								<td><input type="hidden" class="Text span12" value="" id="ajaxProductId" />
									 <input  type="text" class="Text span12" value="" id="ajaxName" /></td>
								<td><input type="text" class="Numeric input-mini" value="" /></td>
								<td><input type="text" class="Numeric input-mini" value="" /></td>
								<td><input type="text" class="Numeric input-mini" value="" /></td>
								<td><input type="text" class="Numeric input-mini" value="" /></td>
								<td class="aligncenter"><a href="javascript:make_copy(1)" class="btn btn-success btn-mini"><i class="icon-plus icon-white"></i></a></td>
							</tr>
					</tbody>
				</table>
			</fieldset>
		</div>
	</div>

<div class="form-actions">
	<button type="submit" name="submit" value="1" class="btn btn-success" id="Update">Update</button>
</div>

</form>

<?php echo end_widget(); ?>

	</div>
</div>


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

 function make_copy(id) {
 	var v0 = $("tr#Blank input:eq(0)").val();
 	var v1 = $("tr#Blank input:eq(1)").val();
 	var v2 = $("tr#Blank input:eq(2)").val();
 	var v3 = $("tr#Blank input:eq(3)").val();
 	var v4 = $("tr#Blank input:eq(4)").val();
 	var v5 = $("tr#Blank input:eq(5)").val();
 	
 	if (!v0) return;

 	if (id > 1) {
 		$("tr#1").clone().insertBefore("tr#Blank").attr("id", id);
 	}

 	$("tr#Blank input").each(function(index) {
 		$(this).val("");
 	});
 	$("tr#Blank textarea").each(function(index) {
 		$(this).val("");
 	});
 	$("tr#Blank a").attr("href", "javascript:make_copy("+(id+1)+")");
 	$("#Add").unbind('click');
 	$("#Add").bind('click', function() {
 		make_copy(id+1);
 		return false;
 	});

 	$("tr#"+id+" input:eq(0)").val(v0);
 	$("tr#"+id+" input:eq(1)").val(v1);
 	$("tr#"+id+" input:eq(2)").val(v2);
 	$("tr#"+id+" input:eq(3)").val(v3);
	$("tr#"+id+" input:eq(4)").val(v4);
	$("tr#"+id+" input:eq(5)").val(v5);
	
	$("tr#"+id+" span").attr("id", id);
	$("tr#"+id+" span a").attr("href", "javascript:remove_copy("+id+")");
	$("tr#"+id).removeAttr("style");
	
	$("tr#Blank input:eq(0)").focus();
}

function remove_copy(id) {
	if (id == 1) {
		$("tr#1 input").each(function(index) {
			$(this).val("");
		});
		$("tr#1").attr("style", "display: none");
	}
	else {
		$("tr#"+id).remove();
	}
}


$(document).ready(function() {


	$("#party_name").autocomplete({
				source: "<?php echo site_url('purchase/ajaxParty') ?>",
				minLength: 0,
				focus: function(event, ui) {
					$("#party_name").val( ui.item.name);
					return false;
				},
				select: function(event, ui) {
					$("#party_name").val(ui.item.name);
					$("#party_id").val(ui.item.id);
					return false;
				}
				
			})
			.data("autocomplete")._renderItem = function(ul, item) {
				return $("<li></li>")
					.data("item.autocomplete", item)
					.append('<a><span class="blueDark">' + item.name +  '</span></a>')
					.appendTo(ul);
			}

	$("#ajaxName").autocomplete({
				source: "<?php echo site_url('purchase/ajaxProduct') ?>",
				minLength: 0,
				focus: function(event, ui) {
					$("#ajaxName").val( ui.item.name);
					return false;
				},
				select: function(event, ui) {
					$("#ajaxName").val(ui.item.name);
					$("#ajaxProductId").val(ui.item.id);
					return false;
				},
				response: function(event, ui) {
		         if (ui.content.length == 0) {
		            $("#ajaxName").val('');
						$("#ajaxProductId").val(0);
		         }
		        }
			})
			.data("autocomplete")._renderItem = function(ul, item) {
				return $("<li></li>")
					.data("item.autocomplete", item)
					.append('<a><span class="blueDark">' + item.name +  '</span></a>')
					.appendTo(ul);
			}

});

</script>