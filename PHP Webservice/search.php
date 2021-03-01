<?php
include('simple_html_dom.php');
$html = new simple_html_dom();

$html->load_file('http://www.graduateshotline.com/gre-word-list.html');

$element = $html->find(".tablex tr");

$i=0;

foreach ($element as $p) {

//  echo "<br>";

$word= $p->find('td',0);
$meaning= $p->find('td',1);

//$text=$word->find('a');

  //echo strip_tags($word->innertext);

  //echo "\n";
//  echo $meaning->innertext;
}

$i=2;
for($i=2;$i<=5;$i++)
{
  $html->load_file('http://www.graduateshotline.com/gre/load.php?file=list'.$i.'.html');
  $element = $html->find(".tablex tr");
  foreach ($element as $p) {
    $word= $p->find('td',0);
    $meaning= $p->find('td',1);
    echo "<br>";
    echo ($word->innertext);
    echo "   ";
    echo $meaning->innertext;
}
}







 ?>
