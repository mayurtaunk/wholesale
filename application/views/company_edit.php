<div class="thumbnail span12 center well well-small text-center">
    <FONT COLOR="BULE"> <B>Update Company Details</B></FONT> 
</div>
<?php
echo start_widget('Company Information', anchor('Company', '<span class="icon"><i class="icon-list"></i></span>'), 'nopadding');
echo form_open($this->uri->uri_string(), 'class="form-horizontal"');
?>
<fieldset>


<!-- Text input-->
<div class="control-group <?php echo (strlen(form_error('code')) > 0 ? 'error' : '') ?>">
  <label class="control-label">Company Code</label>
  <div class="controls">
    <input id="code" value="<?php echo set_value('code', $row['code']) ?>" name="code" type="text" placeholder="Please Enter Company Code..." class="input-xlarge">
    
  </div>
</div>

<!-- Text input-->
<div class="control-group <?php echo (strlen(form_error('cname')) > 0 ? 'error' : '') ?>">
  <label class="control-label">Company Name</label>
  <div class="controls">
    <input id="cname" value="<?php echo set_value('cname', $row['name']) ?>" name="cname" type="text" placeholder="Please Enter Company Name.." class="input-xlarge">
    
  </div>
</div>

<!-- Textarea -->
<div class="control-group <?php echo (strlen(form_error('caddress')) > 0 ? 'error' : '') ?>">
  <label class="control-label">Company Address</label>
  <div class="controls">                     
    <textarea id="caddress" name="caddress"><?php echo set_value('caddress', $row['address']) ?></textarea>
  </div>
</div>

<!-- Text input-->
<div class="control-group <?php echo (strlen(form_error('city')) > 0 ? 'error' : '') ?>">
  <label class="control-label">City</label>
  <div class="controls">
    <input id="City" value="<?php echo set_value('city', $row['city']) ?>" name="city" type="text" placeholder="Please Enter City..." class="input-xlarge">
    
  </div>
</div>

<!-- Text input-->
<div class="control-group <?php echo (strlen(form_error('contact')) > 0 ? 'error' : '') ?>">
  <label class="control-label">Contact Number</label>
  <div class="controls">
    <input id="Contact" value="<?php echo set_value('contact', $row['contact']) ?>" name="contact" type="text" placeholder="Please Enter Contact Number..." class="input-xlarge">
    
  </div>
</div>

<!-- Prepended text-->
<div class="control-group <?php echo (strlen(form_error('mobileno')) > 0 ? 'error' : '') ?>">
  <label class="control-label">Mobile</label>
  <div class="controls">
    <div class="input-prepend">
      <span class="add-on">+91</span>
      <input id="mobileno" name="mobileno" value="<?php echo set_value('mobileno', $row['mobile']) ?>" placeholder="Enter Mobile..." type="text">
    </div>
    
  </div>
</div>

<!-- Text input-->
<div class="control-group <?php echo (strlen(form_error('email')) > 0 ? 'error' : '') ?>">
  <label class="control-label">Email Address</label>
  <div class="controls">
    <input id="email" name="email" value="<?php echo set_value('email', $row['email']) ?>" type="text" placeholder="Please Enter Email Address..." class="input-xlarge">
    
  </div>
</div>

<!-- Text input-->
<div class="control-group <?php echo (strlen(form_error('panno')) > 0 ? 'error' : '') ?>">
  <label class="control-label">Pan Number</label>
  <div class="controls">
    <input id="panno" name="panno" value="<?php echo set_value('panno', $row['pan_no']) ?>" type="text" placeholder="Please Enter Pan Number..." class="input-xlarge">
    
  </div>
</div>

<!-- Text input-->
<div class="control-group <?php echo (strlen(form_error('servicetaxno')) > 0 ? 'error' : '') ?>">
  <label class="control-label">Service Tax Number</label>
  <div class="controls">
    <input id="servicetaxno" value="<?php echo set_value('servicetaxno', $row['service_tax_no']) ?>" name="servicetaxno" type="text" placeholder="Please Enter Service Tax Number" class="input-xlarge">
    
  </div>
</div>

<!-- Textarea -->
<div class="control-group ">
  <label class="control-label">Description</label>
  <div class="controls">                     
    <textarea id="description"  name="description"><?php echo set_value('description', $row['compniescol']) ?></textarea>
  </div>
</div>
<div class="form-actions">
  <button type="submit" name="submit" value="1" class="btn btn-success" id="Update">Update</button>
</div>
</fieldset>
</form>