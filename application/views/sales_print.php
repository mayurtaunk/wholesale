<?php
$height = 35;
$width = 60;
$max_items = 20;

echo "hello";


//echo str_pad($sale['type'], $width, ' ', STR_PAD_BOTH), "\n";

//echo "Party Name : ", $sale['party_name'] . "\n";
//echo $sale['type'] . " No.   : ", str_pad($sale['id2'], 10, ' ', STR_PAD_RIGHT), 
// 	str_pad("Date : ".substr($sale['datetime'], 0, 16), $width-30, ' ', STR_PAD_LEFT), "\n\n";
	
// echo  str_repeat ('=', $width), "\n";
// echo "No. Barcode   Product                     Qty Price  Amount\n";
// echo str_repeat ('-', $width), "\n";

// $a = 1;
// $total_amount = 0;
// foreach ($sale_details as $sd_row) {
// 	echo str_pad($a, 3, ' ', STR_PAD_BOTH) .
// 		str_pad($sd_row['barcode'], 10, ' ', STR_PAD_RIGHT) . ' ' .
// 		str_pad(substr($sd_row['product_name'], 0, 26), 27, ' ', STR_PAD_RIGHT) . ' ' .
// 		str_pad($sd_row['quantity'], 3, ' ', STR_PAD_LEFT) . ' ' . 
// 		str_pad($sd_row['price'], 5, ' ', STR_PAD_LEFT) . ' ' . 
// 		str_pad(number_format(round($sd_row['price'] * $sd_row['quantity'], 2), 0), 8, ' ', STR_PAD_LEFT) .
// 		"\n";
// 	$a++;
// 	$total_amount = round($sd_row['price'] * $sd_row['quantity'], 2);
// }

// echo str_repeat("\n", $max_items - $a);
// echo str_repeat ('=', $width) . "\n";

// //$total_amount = number_format($sale['amount'], 0, '.', '');
// echo str_pad("Total Amount: " . $total_amount, $width, ' ', STR_PAD_LEFT), "\n";

?>