<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Barcode Labels</title>
    <style>
    body {
        width: 8.5in;
        margin: .3in 0 0 0;
    }
    .label{
        width: 1.525in; /* plus .6 inches from padding */
        height: .600in; /* plus .125 inches from padding */
        padding: .232in 0 0 0; /* .300in .3in 0;*/
        margin-right: .125in; /* the gutter */
        float: left;
        text-align: center;
        /*overflow: hidden;*/
        /*outline: 1px dotted;  outline doesn't occupy space like border does */
    }
	.label img { vertical-align: middle !important;  }
    .page-break  {
        clear: left;
        display:block;
        page-break-after:always;
        }
    img { padding-left: 10px;
          padding-bottom: 50px;
        }
    </style>
</head>
<body>
<body>
  <?php /*$this->firephp->info($new_barcode);exit;*/
    foreach ($new_barcode as $key => $value) {
      for ($i=0; $i < $new_quantity[$key]; $i++) { 
      /*  $this->firephp->info(base_url("barcodegen/test_1D.php?text=".$value));exit;*/
        echo '<img src="'.base_url("barcodegen/test_1D.php?text=".$value).'"alt="barcode" /> &nbsp &nbsp &nbsp &nbsp';
      }
    }
  ?>
  

</body>
</html>