
<div class="row-fluid">
	<div class="span10">
<?php
echo start_widget('Add Account', anchor('account', '<span class="icon"><i class="icon-list"></i></span>'), 'nopadding');
echo form_open($this->uri->uri_string(), 'class="form-horizontal"');
?>

<fieldset>	

	<div class="control-group <?php echo (strlen(form_error('holder_name')) > 0 ? 'error' : '') ?>">
		<div class="control-label">Customer Name</div>
		<div class="controls">
				<input type="hidden"  name="id" value="<?php echo set_value('id', $id) ?>" />
				<input type="text" class="span5" id="holder" name="holder_name" value="<?php echo set_value('holder_name', $row['holder_name']) ?>" placeholder="Enter Customer Name..."/>	
				
		</div>
	</div>
	<div class="control-group <?php echo (strlen(form_error('account_no')) > 0 ? 'error' : '') ?>">
		<div class="control-label">Account No</div>
		<div class="controls">
				<input type="text" class="span5" name="account_no" value="<?php echo set_value('account_no', $row['account_no']) ?>" placeholder="Enter Account No..."/>	
				
		</div>
	</div>
	<div class="control-group <?php echo (strlen(form_error('bank')) > 0 ? 'error' : '') ?>">
		<div class="control-label">Bank</div>
		<div class="controls">
			<input type="text" class="span5" name="bank" value="<?php echo set_value('bank', $row['bank']) ?>" placeholder="Enter Bank Name..."/>	
			
		</div>
	</div>
	<div class="control-group <?php echo (strlen(form_error('branch')) > 0 ? 'error' : '') ?>">
		<div class="control-label">Branch</div>
		<div class="controls">
				<input type="text" class="span5" name="branch" value="<?php echo set_value('branch', $row['branch']) ?>" placeholder="Enter Respective Branch..."/>	
			
		</div>
	</div>
	<div class="control-group <?php echo (strlen(form_error('balance')) > 0 ? 'error' : '') ?>">
		<div class="control-label">Balance
		</div>
		<div class="controls">
				<input type="text" class="span5" name="balance" value="<?php echo set_value('balance', $row['balance']) ?>" placeholder="Enter Balance..."/>	
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
  </script>
<?php echo end_widget(); ?>
</div>
</div>