
<div class="row-fluid">
	<div class="span10">
<?php
echo start_widget('Transaction', anchor('transaction', '<span class="icon"><i class="icon-list"></i></span>'), 'nopadding');
echo form_open($this->uri->uri_string(), 'class="form-horizontal"');
?>

<fieldset>	

	<div class="control-group <?php echo (strlen(form_error('accountnumber')) > 0 ? 'error' : '') ?>">
		<div class="control-label">Account Number</div>
		<div class="controls">
				<input type="hidden"  name="id" value="<?php echo set_value('id', $id) ?>" />
				<input type="hidden" id="accountid" name="accountid" value="" />
				<input type="text" class="span5" id="accountnumber" name="accountnumber" value="<?php echo set_value('accountnumber',$row['account_id']) ?>" placeholder="Enter Customer Name..."/>	
		</div>
	</div>
	<?php
	if($showtype =='true')
	{ 
	?>
		<div class="control-group <?php echo (strlen(form_error('type')) > 0 ? 'error' : '') ?> ">
		<label class="control-label"> Transaction type</label>
			<div class="controls">
				<label class="radio">
					<input type="radio" name="type" value="credit" <?php if ($row['type'] == 'credit') { echo 'checked=checked';} ?>>Credit
				</label>
				<label class="radio">
					<input type="radio" name="type" value="debit" <?php if($row['type'] == 'debit') { echo 'checked=checked';} ?> > Debit
				</label>
			</div>
		</div>
	<?php } ?>
	<div class="control-group <?php echo (strlen(form_error('particular')) > 0 ? 'error' : '') ?>">
		<div class="control-label">Particular</div>
		<div class="controls">
				<input type="text" class="span5" name="particular" value="<?php echo $itemval ?>" <?php if ($preadonly == 'true') { echo ' readonly="true"';} ?>placeholder="Enter Respective Branch..."/>	
		</div>
	</div>
	<div class="control-group <?php echo (strlen(form_error('amount')) > 0 ? 'error' : '') ?>">
		<div class="control-label">Amount
		</div>
		<div class="controls">
				<input type="text" class="span5" name="amount" value="<?php echo $row['amount']?>" placeholder="Enter Balance..."/>	
		</div>
	</div>
	<div class="control-group <?php echo (strlen(form_error('remarks')) > 0 ? 'error' : '') ?>">
		<div class="control-label">Remarks
		</div>
		<div class="controls">
				<input type="text" class="span5" name="remarks" value="<?php echo $row['remarks']?>" placeholder="Enter Balance..."/>	
		</div>
	</div>
	
</fieldset>

<div class="form-actions">
	<button type="submit" name="submit" value="1" class="btn btn-success" id="Update">Update</button>
</div>

</form>
<script type="text/javascript">
  $(document).ready(function() {
      $("#holder").focus();
      $('.control-group input').keypress(function(e){
      $(e.target).parent().parent().removeClass("error");
      });


});
  $(document).ready(function() {
	$("#accountnumber").autocomplete({
				source: "<?php echo site_url('transaction/ajaxaccountnumber') ?>",
				minLength: 0,
				focus: function(event, ui) {
					$("#accountnumber").val(ui.item.account_no);
					return false;
				},
				select: function(event, ui) {
					$("#accountnumber").val(ui.item.account_no);
					$("#accountid").val(ui.item.id);
					return false;
				},
				response: function(event, ui) {
		         if (ui.content.length == 0) {
		            $("#accountnumber").val('');
					$("#accountid").val(0);
		         }
		        }
			})
			.data("autocomplete")._renderItem = function(ul, item) {
				return $("<li></li>")
					.data("item.autocomplete", item)
					.append('<a><span class="blueDark">' + item.account_no +  '</span></a>')
					.appendTo(ul);
			}
});

  </script>
<?php echo end_widget(); ?>
</div>
</div>