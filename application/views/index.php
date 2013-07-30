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
  
  <!-- Fav and touch icons -->
  <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
  
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href=<?php echo base_url("index.php/main/master") ?>>Cloth Store Management</a>
      
            <div class="nav-collapse collapse">
              <ul class="nav">
                  <li class="divider-vertical"></li>
                  <li><a href=<?php echo base_url("index.php/main/master") ?>><i class="icon-home icon-white"></i> Home</a></li>
              </ul>
              <div class="pull-right">
                <ul class="nav pull-right">
                    <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Welcome, <?php echo $this->session->userdata('username')?> <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href=<?php echo base_url("index.php/company") ?>><i class="icon-cog"></i> Preferences</a></li>
                            <li><a href="/help/support"><i class="icon-envelope"></i> Contact Support</a></li>
                            <li class="divider"></li>
                            <li><a href=<?php echo base_url("index.php/main/logout") ?>><i class="icon-off"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
              </div>
            </div>
        </div>
    </div>
</div>
 
    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span2">
         
          <div class="well sidebar-nav">
            <ul class="nav nav-list">
              <li class="nav-header">Feed Data</li>
              <li>
              <?php echo anchor('party', 'Party List'); ?></li>
              <li>
              <?php echo anchor('product', 'Product List'); ?></li>
              <li>
              <?php echo anchor('purchase', 'Purchase List'); ?></li>
              <li class="nav-header">Sales</li>
              <li>
                <?php echo anchor('sales', 'Sales List'); ?></li>
              </li>
              <li class="nav-header">Print</li>
              <li>
                <?php echo anchor('barcode', 'Print Barcode'); ?></li>
              </li>
              <li class="nav-header">Banking</li>
              <!-- <li><?php echo anchor('account', 'Add Account'); ?></li> -->
              <li><?php echo anchor('transaction/edit/0', 'Make a Transaction'); ?></li>
              <li class="nav-header">Reports</li>
              <li><?php echo anchor('reports/sale_report', 'Sale Report'); ?></li>
              <li><?php echo anchor('reports/account_statement', 'Account Statement'); ?></li>
              <li><a href="#">Yearly Report(Finacial)</a></li>
              <li class="nav-header">Out Bound Transaction</li>
              <li><?php echo anchor('transaction/edit/lightbill', 'Light Bills'); ?></li>
              <li><?php echo anchor('transaction/edit/telephonebill', 'Telephone Bills'); ?></li>
              <li><?php echo anchor('transaction/edit/employeesalary','Employee Salary');?></li>
              <li><?php echo anchor('transaction/edit/taxes','Taxes');?></li>
              <li><?php echo anchor('transaction/edit/other','Others');?></li>
              <li class="nav-header">In Bound Transaction</li>
              <li><?php echo anchor('transaction/edit/inbound','In Bound');?></li>
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
        <p>&copy; Radhe Developers 2013</p>
      </footer>

    </div><!--/.fluid-container-->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
   



  </body>


</html>


