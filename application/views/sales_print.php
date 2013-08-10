<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Bill NO: <?php echo $sale['id'] ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href=<?php echo base_url("css/bootstrap.css");?> rel="stylesheet">
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
    <link href=<?php echo base_url("css/bootstrap-responsive.css");?> rel="stylesheet">

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
  <body onload="window.print()">
    <div class="container-fluid">
      <div class="row-fluid">
        <table class="table table-bordered span4">
			<tr>
				<td colspan=6><center><font size=5><?php echo $company_details['name']; ?></font></center><br></td>
			</tr>
			<tr>
				<td colspan=6>
				<center>	
				<?php echo "<b> <i>".$company_details['address']." , ".$company_details['city']."</i> </b>"; ?>
				<?php echo "(".$company_details['mobile']; ?>)</center></td>
			</tr>
			<tr>
				<td colspan=3><?php 
				echo "Bill No:  <b>".$sale['id'] ?></td>
				<td>&nbsp&nbsp&nbsp</td>
				<td colspan=3><?php echo "Date:  <b>". date('d-m-Y',strtotime($sale['datetime']))?></td>
			</tr>
			<tr class="success">
				<td colspan=3><?php echo "Customer Name:  <b>". $sale['party_name']?></td>
				<td colspan=3><?php echo "Customer Name:  <b>". $sale['party_contact']?></td>
			</tr>
			<tr class="warning">
				<td colspan=6></td>
			</tr>
			<tr>
				<td><b>Name</b></td>
				<td><b>MRP</b></td>
				<td><b>Sale Price</b></td>
				<td><b>VAT (Included)</b></td>
				<td><b>Quantity</b></td>
				<td><b>Total</b></td>
			</tr>
			<?php
			/*$this->firephp->info($sale_details);exit;*/
			foreach ($sale_details as $key => $value) 
			{
				echo "<tr>";
				echo "<td>".$value['name']."</td>";
				echo "<td>".$value['mrponpro']."</td>";
				echo "<td>".$value['mrp']."</td>";
				echo "<td>".$value['vatper']."</td>";
				echo "<td>".$value['quantity']."</td>";
				echo "<td>".$value['price']."</td>";
				echo "</tr>";
			}?>
			<tr class="warning">
				<td colspan=6></td>
			</tr>
			<tr class="danger">
				<td colspan =4></td>
				<td><b><i><?php echo $total_qty['qty'] ?> Items</i></b></td>
				<td> <b>  <?php echo number_format($total_pay['pay'],2,".",",") ?></b></td>
			</tr>
			<tr>
				<td colspan =4><font align="right"><b><?php echo $sale['disnote']?> <b></font></td>
				<td><b>Discount:<b></td>
				<td><b><u><?php echo $sale['less'] ?></u></b></td>
			</tr>
			<tr class="warning">
				<td colspan =4></td>
				<td><b>Net Amount:</b></td>
				<td><b>Rupees <?php echo number_format($sale['amount'],2,".",",") ?><b></td>
			</tr>
			<tr class="warning">
				<td colspan=6><b>FOR <?php echo $company_details['name']; ?>:</b></td>
			</tr>
			<tr class="warning">
				<td colspan=4></td>
				<td colspan=2>Authority Signature</td>
			</tr>
			
			<!--<?php if($sale['amount'] != $sale['amount_recieved']) { ?>
			<tr>
				<td colspan =4></td>
				<td><b>Paid:</b></td>
				<td><b>Rupees <?php echo number_format($sale['amount_recieved'],2,".",",") ?><b></td>
			</tr>
			<tr class="warning">
				<td colspan =4></td>
				<td><b>Credit:</b></td>
				<td><b>Rupees <?php echo number_format($sale['amount'] - $sale['amount_recieved'],2,".",",") ?><b></td>
			</tr>
			<?php }?>-->
		</table>

      </div>
    </div>
  	

<!-- <body onload="window.print()">	
		<table border=1 width=500>
			<tr>
				<td colspan=4><center>Cloth Store Mundra</center></td>
			</tr>
			<tr>
				<td><?php 
				echo "Bill No:  ".$sale['id'] ?></td>
				<td>&nbsp&nbsp&nbsp</td>
				<td colspan=2><?php echo "Date:  ". date('d-m-Y',strtotime($sale['datetime']))?></td>
			</tr>
			<tr>
				<td colspan=2><?php echo "Customer Name:  ". $sale['party_name']?></td>
				<td colspan=2><?php echo "Customer Name:  ". $sale['party_contact']?></td>
			</tr>
			<tr>
				<td colspan=4>------------------------------------------------------------------------------------------</td>
			</tr>
			<tr>
				<td>Name</td>
				<td>MRP</td>
				<td>Quantity</td>
				<td>Total</td>
			</tr>
			<?php
			/*$this->firephp->info($sale_details);exit;*/
			foreach ($sale_details as $key => $value) 
			{
				echo "<tr>";
				echo "<td>".$value['name']."</td>";
				echo "<td>".$value['mrp']."</td>";
				echo "<td>".$value['quantity']."</td>";
				echo "<td>".$value['price']."</td>";
				echo "</tr>";
			}?>
			<tr>
				<td colspan=4>------------------------------------------------------------------------------------------</td>
			</tr>
			<tr>
				<td colspan =2></td>
				<td> (<?php echo $total_qty['qty'] ?>)</td>
				<td> (<?php echo $total_pay['pay'] ?>)</td>
			</tr>
			<tr>
				<td colspan =2></td>
				<td> Discount:</td>
				<td><?php echo $sale['less'] ?></td>
			</tr>
			<tr>
				<td colspan =2></td>
				<td> To Pay:</td>
				<td><?php echo $sale['amount'] ?></td>
			</tr>
			
		</table>

 --></body>
</html>