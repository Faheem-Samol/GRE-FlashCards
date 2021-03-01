<?php
include('simple_html_dom.php');
$user='rajj1966_jay';
$pass='rajj1966@jay';
$db='rajj1966_jay';
$host='50.62.209.149';

$con = new mysqli($host,$user,$pass,$db);
//$con = mysqli_conect($host,$user,$pass,$db);



$html = new simple_html_dom();

$html->load_file('http://www.graduateshotline.com/gre-word-list.html');

$element = $html->find(".tablex tr");

$i=0;

$sql = "DELETE FROM words";
if (mysqli_query($con, $sql)) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . mysqli_error($con);
}


foreach ($element as $p) {

//  echo "<br>";

$word= $p->find('td',0);
$meaning= $p->find('td',1);



$sql = $con->prepare("INSERT INTO words (word, meaning)
VALUES (?,?)");

$sql->bind_param("ss",strip_tags($word->innertext),$meaning->innertext);
//echo $sql;

if ($sql->execute) {
    echo "Word - ".strip_tags($word->innertext)." entered successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($con);
}
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
    //echo "<br>";
    //echo ($word->innertext);
    //echo "   ";
    //echo $meaning->innertext;

    $sql = "INSERT INTO words (word, meaning)
    VALUES (".strip_tags($word->innertext).", ".$meaning->innertext.")";

    /*if (mysqli_query($con, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
    }
*/

}
}









 ?>
