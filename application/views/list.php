<script type="text/javascript">
     $(function(){       
    $('*[data-href]').click(function(){
        window.location = $(this).data('href');
        return false;
    });
});
</script>


<div class="row-fluid center">
	<fieldset>		
		<table class="table table-striped ">
			<thead>
				<tr>
					<?php 
					foreach ($list['heading'] as $value) {
						echo "<th>".$value."<th>";
					}
					?>
				</tr>
			</thead>
			<tbody>
					<?php
						foreach ($rows as $value) 
						{
							echo "<tr>";
							foreach($fields as $col){
								if(isset($link_col) && isset($link_url) && $link_col == $col)
								echo "<td>".anchor($link_url . $value[$col], $value[$col])."<td>";
								else
								echo "<td>".$value[$col]."<td>";
							}
							echo "</tr>";
						}

					?>
			</tbody>
		</table>
		<br>
		<?php echo $this->pagination->create_links(); ?>
		<hr>
	<fieldset>
    	<div class="span4 offset9">
            <?php 
    			$h=$link."0";
    			echo "<a href='";
    			echo $h;
    			echo "'>"
    		?>
            <button class="btn btn-success span8">
              	<i class="icon-plus icon-white">
              	</i>  <?php echo $button_text ?></button></a></div></legend>
        </div>
    </fieldset>
	</fieldset>
</div>
