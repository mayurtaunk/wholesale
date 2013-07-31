<div class="row-fluid">
	<div class="span10">
	
<?php
echo start_widget($page_title);
echo form_open($this->uri->uri_string(), 'class="form-horizontal"');
?>

	<div class="row-fluid">
		<div class="span12">
			<fieldset>
			<legend>Stock Report</legend>
				<table class="table table-condensed table-striped">
					<thead>	
						<tr>
							<th>Prodcut</th>
							<th>Available</th>
							<th>Supplier Name</th>
							<th>Supplier Contact</th>
						</tr>
					</thead>

					<tbody>
							<?php if(isset($rows)) {
								foreach ($rows as $r) {
									echo '<tr>
											<td>'.$r['product'].'</td>
											<td>'.$r['avail'].'</td>
											<td>'.$r['name'].'</td>
											<td>'.$r['contact'].'</td>
										  </tr>';
								}
							}
							  ?>
					</tbody>
				</table>
			</fieldset>
		</div>
	</div>

<!-- <div class="form-actions">
	<button type="submit" name="submit" value="1" class="btn btn-success" id="Update">Search</button>
</div> -->

</form>

<?php echo end_widget(); ?>

	</div>
</div>


<script>

 /* $(document).ready(function() {
      $("#party_name").focus();
      $('.control-group input').keypress(function(e){
      $(e.target).parent().parent().removeClass("error");
      });


});*/
$(document).ready(function() {
	$("#ProductName").autocomplete({
				source: "<?php echo site_url('purchase/ajaxProduct') ?>",
				minLength: 0,
				focus: function(event, ui) {
					$("#ProductName").val( ui.item.name);
					return false;
				},
				select: function(event, ui) {
					$("#ProductName").val(ui.item.name);
					$("#ProductID").val(ui.item.id);
					return false;
				},
				response: function(event, ui) {
		         if (ui.content.length == 0) {
		            $("#ProductName").val('');
					$("#ProductID").val(0);
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