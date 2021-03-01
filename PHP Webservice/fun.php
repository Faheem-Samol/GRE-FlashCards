<?php
function clean($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

   $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
   return str_replace('-', ' ', $string);
}

include('simple_html_dom.php');


$word=$_GET["word"];

$html = new simple_html_dom();



$html->load_file('https://en.oxforddictionaries.com/definition/'.$word);

$element = $html->find(".gramb");

if($element==null)
{
  $element = $html->find(".similar-results");

  echo "did you mean.... \n";
  $row=$element[0]->find("li");

  foreach ($row as $r) {
    echo "<br>";
    echo "<a href='fun.php?word=".strip_tags($r->innertext)."'>".strip_tags($r->innertext)."</a>";
  }

}else {



$mainline = $element[0]->find(".ind");

echo $word."  ===  ";
echo $mainline[0]->innertext;
//echo $element[0]->innertext;
//echo $element->innertext;
}
?>
