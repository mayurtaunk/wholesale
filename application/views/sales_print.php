<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Cloth Store-Main</title>
    
</head>
<body onload="window.print()">	
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

</body>
</html>