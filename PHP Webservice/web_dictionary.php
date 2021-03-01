<?php
function clean($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

   $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
   return str_replace('-', ' ', $string);
}

////////////////////////////////////////
//
          $limit=10;
//
///////////////////////////////////////


$word=$_GET["word"];

$user='rajj1966_jay';
$pass='rajj1966@jay';
$db='rajj1966_jay';
$host='50.62.209.149';

$con = new mysqli($host,$user,$pass,$db);
//$con = mysqli_connect($host,$user,$pass,$db);

$sql = "SELECT * FROM imp_words where word='".$word."'";
$result = mysqli_query($con, $sql);


if (mysqli_num_rows($result) > 0) {
            if($row = mysqli_fetch_assoc($result)) {
                echo "word : ".$row["word"]."   =>   ".$row["meaning"];
            }
         } else {


           $sql = "SELECT * FROM words where word='".$word."'";
           $result = mysqli_query($con, $sql);


           if (mysqli_num_rows($result) > 0) {
                       if($row = mysqli_fetch_assoc($result)) {

                            $count=$row["count"];
                            $count++;

                            if($count>=$limit)
                            {
                              $sql = "DELETE FROM words where id=".$row["id"];
                              if (mysqli_query($con, $sql)) {

                                $sql = "INSERT INTO imp_words (word, meaning)
                                VALUES ('".$row["word"]."', '".$row["meaning"]."')";


                                if (mysqli_query($con, $sql)) {
                                    //echo "Word - ".strip_tags($word->innertext)."  -> inserted successfully";
                                    echo "done";

                                } else {
                                    echo "Error: " . $sql . "<br>" . mysqli_error($con);
                                }





                              } else {
                                  echo "Error deleting record: " . mysqli_error($con);
                              }


                            }
                            else {
                                //   store the new count


                                $sql = "UPDATE imp_words SET count=".$count." WHERE id=".$row["id"];
                                if (mysqli_query($con, $sql)) {
                                    //echo "Word - ".strip_tags($word->innertext)."  -> inserted successfully";
                                    echo "Count updated";

                                } else {
                                    echo "Error: " . $sql . "<br>" . mysqli_error($con);
                                }




                            }

                           echo "word : ".$row["word"]."   =>   ".$row["meaning"];
                       }
                    } else {





            //echo "0 results";



include('simple_html_dom.php');




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

$sql = "INSERT INTO words (word, meaning,count)
VALUES ('".$word."', '".$mainline[0]->innertext."',0)";


if (mysqli_query($con, $sql)) {
    //echo "Word - ".strip_tags($word->innertext)."  -> inserted successfully";
    echo "done";

} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($con);
}


echo $word."  ===  ";
echo $mainline[0]->innertext;
//echo $element[0]->innertext;
//echo $element->innertext;
}
}     //>>>>>>  Else ends here
?>
