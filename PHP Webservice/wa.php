<?php


include('simple_html_dom.php');

$html = new simple_html_dom();



$html->load_file('https://web.whatsapp.com');


echo $html;

?>