<?php
if (isset($page) && ! file_exists(APPPATH.'/views/'.$page.'.php')) {
  show_error("View file \"$page\" is missing");
}
// Header important to disable Browser Back / Forward button after Logged out.
$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
$this->output->set_header('Pragma: no-cache');
$this->output->set_header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <?php
         if(isset($title))
            echo "<title>".$title."</title>";
         else
            echo "<title>Cloth Store</title>"
   ?> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="<?php echo base_url("css/bootstrap.css") ?>" rel="stylesheet"/>
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }

      @media (max-width: 980px) {
        /* Enable use of floated navbar text */
        .navbar-text.pull-right {
          float: none;
          padding-left: 5px;
          padding-right: 5px;
        }
      }
    </style>

  <!--<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
-->
 <link href="<?php echo base_url('css/jquery-ui.css') ?>" rel="stylesheet" />
   <script src="<?php echo base_url('js/jquery-1.9.1.js') ?>"></script>
   <script src="<?php echo base_url('js/jquery-ui.js') ?>"></script>

<!-- Javascript -->
  <script src="<?php echo base_url('js/jquery-1.8.3.min.js') ?>"></script>
  <script src="<?php echo base_url('js/bootstrap.min.js') ?>"></script>
  <script src="<?php echo base_url('js/bootstrap-notify.js') ?>"></script>
  <script src="<?php echo base_url('js/jquery.highlight-2.js') ?>"></script>
  <script src="<?php echo base_url('js/jquery.popupwindow.js') ?>"></script>
  <script src="<?php echo base_url('js/jquery-ui-1.9.2.min.js') ?>"></script>
  <script src="<?php echo base_url('js/chosen.jquery.min.js') ?>"></script>
  <script src="<?php echo base_url('js/jquery-timing.min.js') ?>"></script>
  <?php if (isset($javascript)) {
    foreach ($javascript as $js) {
      echo "<script src=\"" . base_url("js/$js") . "\"></script>\n\t";
    }
  } ?>

  <!-- Styles -->
  <link href="<?php echo base_url('css/bootstrap.min.css') ?>" rel="stylesheet" />
  <link href="<?php echo base_url('css/bootstrap-notify.css') ?>" rel="stylesheet" />
  <link href="<?php echo base_url('css/lightness-1.9.2/jquery-ui.min.css') ?>" rel="stylesheet" />
  <link href="<?php echo base_url('css/default.css') ?>" rel="stylesheet" />
  <link href="<?php echo base_url('css/picons.css') ?>" rel="stylesheet" />
  <link href="<?php echo base_url('css/chosen.jquery.css') ?>" rel="stylesheet" />
  <link href="<?php echo base_url('css/bootstrap-responsive.min.css') ?>" rel="stylesheet" />
  <?php if (isset($stylesheet)) {
    foreach ($stylesheet as $css) {
      echo "<link href=\"" . base_url("css/$css") . "\" rel=\"stylesheet\" />\n\t";
    }
  } ?>
   
  <script>
  $(function() {
    $(".DateTime").datepicker({
      duration: '',
      dateFormat: "dd-mm-yy",
      yearRange: "-50:+1",
      mandatory: true,
      showButtonPanel: true,
      changeMonth: true,
      changeYear: true,
      showOtherMonths: true,
      showStatus: true,
      showOn: "button",
      buttonImage: "<?php echo base_url('images/calendar.png') ?>",
      buttonImageOnly: true
    });
  });
  
  </script>
<div class="row-fluid">
<div class="span12">
<div class="span10">
  
<?php
echo start_widget('Company Information', anchor('Company', '<span class="icon"><i class="icon-list"></i></span>'), 'nopadding');
echo form_open('newcompanyadd/edit', 'class="form-horizontal"');
?>
<fieldset>

<!-- Text input-->
<div class="control-group <?php echo (strlen(form_error('userid')) > 0 ? 'error' : '') ?>">
  <label class="control-label">Company Code</label>
  <div class="controls">
    <input id="userid" value="<?php echo set_value('code', $row['userid']) ?>" name="userid" type="hidden" placeholder="Please Enter Company Code..." class="input-xlarge">
    
  </div>
</div>

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
</div>
</div><!--/span-->
</div><!--/row-->
      <hr>

      <footer>
        <p>&copy; Radhe Developers 2013</p>
      </footer>

    </div><!--/.fluid-container-->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
   



  </body>


</html>