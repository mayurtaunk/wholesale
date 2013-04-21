<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

function start_widget($title = 'Untitled', $icon = false, $class = false, $links = false) {
	return '
	<div class="widget-box">
		<div class="widget-title">
			' . ($icon ? $icon : '') . '
			<h5>' . $title . '</h5>
			' . ($links ? $links : '') . '
		</div>
		<div class="widget-content ' . ($class ? $class : '') . '">';
}

function end_widget() {
	return '</div>
</div>';
}

/* End of file */