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

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="/ico/favicon.png">
  </head>
  <body>
    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span4">
          <!--Sidebar content-->
        </div>
        <div class="span8">
          <?php
            $attr = array('class' => 'well span6', 'id' => 'signup');
            echo form_open('main/signup_validation',$attr);
            echo validation_errors();
          ?>
          <fieldset>
          <div id="legend">
            <legend class="">Sign Up</legend>
            </div>
            <div class="control-group <?php echo (strlen(form_error('username')) > 0 ? 'error' : '') ?>">
              <label class="control-label" for="username">Username</label>
              <div class="controls">
                <input type="text" id="username" name="username"  placeholder="Enter a user name..." class="input-xlarge">
              </div>
            </div>
            <div class="control-group <?php echo (strlen(form_error('password')) > 0 ? 'error' : '') ?>">
                <label class="control-label" for="password" >Password</label>
                <div class="controls">
                  <input type="password" id="password" name="password" placeholder="Enter Password..." class="input-xlarge">
                </div>
            </div>
            <div class="control-group <?php echo (strlen(form_error('cpassword')) > 0 ? 'error' : '') ?>">
                <label class="control-label" for="cpassword" >Confirm Password</label>
                <div class="controls">
                  <input type="password" id="cpassword" name="cpassword" placeholder="Renter Password..." class="input-xlarge">
                </div>
            </div>
            <div id="legend">
            <legend class="">Other Details</legend>
            </div>
            <div class="control-group <?php echo (strlen(form_error('email')) > 0 ? 'error' : '') ?>">
                <label class="control-label" for="email">Email</label>
                <div class="controls">
                  <input type="text" id="email" name="email" placeholder="Enter Email Address..." class="input-xlarge">
                </div>
            </div>
            <div class="control-group <?php echo (strlen(form_error('fullname')) > 0 ? 'error' : '') ?>">
                <label class="control-label" for="fullname">Full Name</label>
                <div class="controls">
                  <input type="text" id="fullname" name="fullname" placeholder="Enter Full Name..." class="input-xlarge">
                </div>
            </div>
            <div class="control-group">
              <div class="controls">
                <button class="btn btn-submit">SignUp</button>
              </div>
            </div>
          </fieldset>
          </form>
        </div>
      </div>
    </div>
  	
</body>
</html>
