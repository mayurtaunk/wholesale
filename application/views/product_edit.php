<div class="row-fluid">
	<div class="span10">
	
<?php
echo start_widget('Product Information', anchor('product', '<span class="icon"><i class="icon-list"></i></span>'), 'nopadding');
echo form_open($this->uri->uri_string(), 'class="form-horizontal"');
?>

	<fieldset>		
	
		<div class="control-group <?php echo (strlen(form_error('name')) > 0 ? 'error' : '') ?>">
			<label class="control-label">Name</label>
			<div class="controls">
				<input type="hidden"  name="id" value="<?php echo set_value('id', $id) ?>" />
				<input type="text" class="span8" name="name" value="<?php echo set_value('name', $row['name']) ?>" />
				<span class="help-inline Tiny">*Enter Prodcut Name</span>
			</div>
		</div>
		
		<div class="control-group <?php echo (strlen(form_error('category')) > 0 ? 'error' : '') ?>">
			<label class="control-label">Category</label>
			<div class="controls">
				<input type="text" class="span8" name="category" value="<?php echo set_value('category', $row['category']) ?>" />
			</div>
		</div>
		
		<div class="control-group <?php echo (strlen(form_error('active')) > 0 ? 'error' : '') ?>">
			<label class="control-label">Active</label>
			<div class="controls">
				<input type="text" class="span8" name="active" value="<?php echo set_value('active', $row['active']) ?>" />
			</div>
		</div>
	</fieldset>

<div class="form-actions">
	<button type="submit" name="submit" value="1" class="btn btn-success" id="Update">Update</button>
</div>

</form>

<?php echo end_widget(); ?>

	</div>
</div>
