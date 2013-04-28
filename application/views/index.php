<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Cloth Store-Main</title>
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
  $( "#datepicker" ).datepicker();
  });
  
  </script>
  
  <!-- Fav and touch icons -->
  <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
  
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="#">Cloth Store Management</a>
          <div class="nav-collapse collapse">
            <p class="navbar-text pull-right">
                <a href=<?php echo base_url("index.php/main/logout") ?>><button class="btn btn-primary"><i class="icon-off icon-white"></i>Logout</button></a>
            </p>
            <ul class="nav">
              <li class="active"><a href="#">Home</a></li>
              <li><a href="#about">About</a></li>
              <li><a href="#contact">Contact</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span2">
          <div class="well sidebar-nav">
            <ul class="nav nav-list">
              <li class="nav-header">Componets</li>
              <li class="active">
              <?php echo anchor('party', 'Party List'); ?></li>
              <li>
              <?php echo anchor('product', 'Product List'); ?></li>
              <li>
              <?php echo anchor('purchase', 'Purchase List'); ?></li>
              <li>
                <?php echo anchor('sales', 'Sales'); ?></li>
              </li>
              <li class="nav-header">Reports</li>
              <li><a href="#">Link</a></li>
              <li><a href="#">Link</a></li>
              <li><a href="#">Link</a></li>
              <li><a href="#">Link</a></li>
              <li><a href="#">Link</a></li>
              <li><a href="#">Link</a></li>
              <li class="nav-header">Sidebar</li>
              <li><a href="#">Link</a></li>
              <li><a href="#">Link</a></li>
              <li><a href="#">Link</a></li>
            </ul>
          </div><!--/.well -->
        </div><!--/span-->

        <div class="span10">
        
          <?php
         if(isset($page))
            $this->load->view($page);
          ?> 

        </div><!--/span-->
      </div><!--/row-->

      <hr>

      <footer>
        <p>&copy; Company 2013</p>
      </footer>

    </div><!--/.fluid-container-->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
   



  </body>


</html>


