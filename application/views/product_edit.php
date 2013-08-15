<div class="thumbnail span12 center well well-small text-center">
  	<FONT COLOR="BULE"> <B>Add | Update Prodcut Information</B></FONT> 
</div>
<?php
echo start_widget('Product Information', anchor('product', '<span class="icon"><i class="icon-list"></i></span>'), 'nopadding');
echo form_open($this->uri->uri_string(), 'class="form-horizontal"');
?>
	<fieldset>		
		<div class="control-group <?php echo (strlen(form_error('name')) > 0 ? 'error' : '') ?>">
			<label class="control-label">Name</label>
			<div class="controls">
				<input type="hidden"  name="id" value="<?php echo set_value('id', $id) ?>" />
				<input type="text" class="span8" id="product" placeholder="Enter Prodcut Name..." name="name" value="<?php echo set_value('name', $row['name']) ?>" />
			</div>
		</div>
		<div class="control-group <?php echo (strlen(form_error('category')) > 0 ? 'error' : '') ?>">
			<label class="control-label">Category</label>
			<div class="controls">
				<input type="text" class="span8" name="category" placeholder="Enter Produuct Category..." value="<?php echo set_value('category', $row['category']) ?>" />
			</div>
		</div>
		<div class="control-group <?php echo (strlen(form_error('active')) > 0 ? 'error' : '') ?>">
			<label class="control-label"> Active</label>
			<div class="controls">
				<label class="radio">
					<input type="radio" name="active" value="1" <?php if($row['active'] == "1") { echo "checked=checked";} ?> >Yes
				</label>
				<label class="radio">
					<input type="radio" name="active" value="0" <?php if($row['active'] == "0") { echo "checked=checked";} ?>>No
				</label>
			</div>
		</div>
	</fieldset>
<div class="form-actions">
	<button type="submit" name="submit" value="1" class="btn btn-success pull-right" id="Update">Update</button>
</div>
</form>
<script type="text/javascript">
  $(document).ready(function() {
      $("#product").focus();
      $('.control-group input').keypress(function(e){
      $(e.target).parent().parent().removeClass("error");
      });


	});
</script>
<?php echo end_widget(); ?>
