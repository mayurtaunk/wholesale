<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>CLoth Store-Log In</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href=<?php echo base_url("/css/bootstrap.css");?> rel="stylesheet">
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
    <link href=<?php echo base_url("/css/bootstrap-responsive.css");?> rel="stylesheet">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="/ico/favicon.png">
  </head>
  <body>
    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span2">
          <!--Sidebar content-->
        </div>
        <div class="span10">
          <?php
            $attr = array('class' => 'well span8 form-horizontal', 'id' => 'newcompany');
            echo form_open('newcompanyadd/edit/'.$row['user_id'],$attr);
            //echo validation_errors();
          ?>
          <div id="legend">
            <legend class="">Register Company</legend>
          </div>
          <fieldset>
            <!-- Text input-->
            <div class="control-group <?php echo (strlen(form_error('user_id')) > 0 ? 'error' : '') ?>">
              <div class="controls">
                <input id="user_id" value="<?php echo set_value('code', $row['user_id']) ?>" name="user_id" type="hidden" >
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
                <input id="servicetaxno" value="<?php echo set_value('servicetaxno', $row['service_tax_no']) ?>" name="servicetaxno" type="text" placeholder="Please Enter Service Tax Number..." class="input-xlarge">
              </div>
            </div>
            <!-- Text input-->
            <div class="control-group <?php echo (strlen(form_error('opbalance')) > 0 ? 'error' : '') ?>">
              <label class="control-label">Opeaning Balance</label>
              <div class="controls">
                <input id="opbalance" value="<?php echo set_value('opbalance', $row['opbalance']) ?>" name="opbalance" type="text" placeholder="Please Enter Opeaning Balance..." class="input-xlarge">       
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
    </div>
    <hr>
    <footer>
      <center><p>&copy; Radhe Developers 2013</p></center>
    </footer>
  </body>
</html>