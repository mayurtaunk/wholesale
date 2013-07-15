<div class="row-fluid">
  <div class="span10">
  
<?php
echo start_widget('Account Information', anchor('bank', '<span class="icon"><i class="icon-list"></i></span>'), 'nopadding');
echo form_open($this->uri->uri_string(), 'class="form-horizontal"');
?>
<form class="form-horizontal">
<fieldset>

<!-- Form Name -->
<legend>Add Account</legend>

<!-- Text input-->
<div class="control-group">
  <label class="control-label">Name</label>
  <div class="controls">
    <input id="b_details_name" name="b_details_name" type="text" placeholder="Holder Name" class="input-xlarge" required="">
    
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label">Account No</label>
  <div class="controls">
    <input id="b_details_acc_no" name="b_details_acc_no" type="text" placeholder="Please enter Account no" class="input-xlarge" required="">
    
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label">Bank Name</label>
  <div class="controls">
    <input id="b_details_bank" name="b_details_bank" type="text" placeholder="Enter the Bank Name" class="input-xlarge" required="">
    
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label">Bank State</label>
  <div class="controls">
    <input id="b_details_state" name="b_details_state" type="text" placeholder="Enter State" class="input-xlarge" required="">
    
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label">Bank Branch</label>
  <div class="controls">
    <input id="b_details" name="b_details" type="text" placeholder="Enter Bank Branch" class="input-xlarge" required="">
    
  </div>
</div>
<div class="control-group">
  <label class="control-label">Opeaning Balance</label>
  <div class="controls">
    <input id="b_details_op" name="b_details_op" type="text" placeholder="Enter your opeaning balance" class="input-xlarge" required="">
  </div>
</div>

<!-- Prepended text-->


<div class="control-group">
  <label class="control-label">Mobile No</label>
  <div class="controls">
    <div class="input-prepend">
      <span class="add-on">+91</span>
      <input id="b_details_mobile" name="b_details_mobile" class="span12" placeholder="" type="text" required="">
    </div>
  </div>
</div>



</fieldset>
<div class="form-actions">
  <button type="submit" name="submit" value="1" class="btn btn-success" id="Update">Add</button>
</div>
</form>
<?php echo end_widget(); ?>

</div>
</div>
