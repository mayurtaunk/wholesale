<div class="row-fluid">
	<div class="span10">
	
<?php
if(isset($popup))
echo start_widget('Print Barcode');
echo form_open($this->uri->uri_string()."/print_barcode", 'class="form-horizontal"');
/*echo form_open("barcodegen/test_1D.html", 'class="form-horizontal"');*/
?>

	
	<div class="row-fluid">
		<div class="span12">
			<fieldset>
			<legend>Barcodes</legend>
				<table class="table table-condensed table-striped">
					<thead>	
						<tr>
							<th>Barcode</th>
							<th>Quantity</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
							
			 				<tr id="1" style="display: none;">
								<td><input type="text" readonly="true" class="Numeric input-mini span12" name="new_barcode[]"  value="" /></td>
								<td><input type="text" readonly="true" class="Numeric input-mini span12" name="new_quantity[]" value="" />

								</td>
								<td class="aligncenter"><span id="1"><a href="#" class="btn btn-danger btn-mini"><i class="icon-minus icon-white"></i></a></span></td>
							</tr>

							<tr id="Blank">
								<td><input type="text" id="Barcode" class="Numeric input-mini span12" value="" /></td>
								<td><input type="text" class="Numeric input-mini span12" value="" /></td>
								<td class="aligncenter"><a href="javascript:make_copy(1)" class="btn btn-success btn-mini"><i class="icon-plus icon-white"></i></a></td>
							</tr>
					</tbody>
				</table>
			</fieldset>
		</div>
	</div>

<div class="form-actions">
	<button type="submit" name="submit" value="1" class="btn btn-success" id="Update">Print</button>
</div>

</form>

<?php echo end_widget(); ?>

	</div>
</div>


<script>

var checked = 1;

 function make_copy(id) {
 	var v0 = $("tr#Blank input:eq(0)").val();
 	var v1 = $("tr#Blank input:eq(1)").val();
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


	$("#Barcode").autocomplete({
				source: "<?php echo site_url('barcode/ajaxBarcode') ?>",
				minLength: 0,
				focus: function(event, ui) {
					$("#Barcode").val( ui.item.name);
					return false;
				},
				select: function(event, ui) {
					$("#Barcode").val(ui.item.name);
					return false;
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