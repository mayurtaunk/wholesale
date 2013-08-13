<?php
	echo start_widget('Party Information', anchor('party', '<span class="icon"><i class="icon-list"></i></span>'), 'nopadding');
	echo form_open($this->uri->uri_string(), 'class="form-horizontal"');
?>
<fieldset>		
	<div class="control-group <?php echo (strlen(form_error('name')) > 0 ? 'error' : '') ?>">
		<label class="control-label">Name</label>
		<div class="controls">
			<input type="hidden"  name="id" value="<?php echo set_value('id', $id) ?>" />
			<input type="text" placeholder="Enter Party Fullname..." class="span8" id="name" name="name" value="<?php echo set_value('name', $row['name']) ?>" />
		</div>
	</div>
	<div class="control-group <?php echo (strlen(form_error('address')) > 0 ? 'error' : '') ?>">
		<label class="control-label">Address</label>
		<div class="controls">
			<textarea class="span8" name="address" > <?php echo set_value('address', $row['address']) ?></textarea>
			<!-- <input type="text" class="span8" name="address" value="<?php echo set_value('address', $row['address']) ?>" /> -->
		</div>
	</div>
	<div class="control-group <?php echo (strlen(form_error('contact')) > 0 ? 'error' : '') ?>">
		<label class="control-label">Contact</label>
		<div class="controls">
			<input type="text" class="span8" name="contact" placeholder="Enter Party Contact Number..." value="<?php echo set_value('contact', $row['contact']) ?>" />
		</div>
	</div>
</fieldset>
<div class="form-actions">
	<button type="submit" name="submit" value="1" class="btn btn-success pull-right" id="Update">Update</button>
</div>
</form>
<script type="text/javascript">
  	$(document).ready(function() {
      $("#name").focus();
      $('.control-group input').keypress(function(e){
      $(e.target).parent().parent().removeClass("error");
      });
	});
</script>
<?php echo end_widget(); ?>