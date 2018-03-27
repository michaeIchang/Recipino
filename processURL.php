<?php
$url = $_POST['url'];

include('./simple_html_dom.php');

// get DOM from URL or file
$html = file_get_html('http://www.google.com/');

?>
