<?php
if(isset($popup))
echo start_widget('Print Barcode');
echo form_open($this->uri->uri_string()."/do_upload", 'class="form-horizontal"');
/*echo form_open("barcodegen/test_1D.html", 'class="form-horizontal"');*/
?>
<input type="file" name="userfile" size="20" />

<br /><br />

<input type="submit" value="upload" />

</form>

</body>
</html>