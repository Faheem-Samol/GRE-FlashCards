<?PHP
header('Content-Type: application/json');

$user='rajj1966_jay';
$pass='rajj1966@jay';
$db='rajj1966_jay';
$host='50.62.209.149';

$con = new mysqli($host,$user,$pass,$db);
//$con = mysqli_connect($host,$user,$pass,$db);

$sql = 'SELECT * FROM words';
$result = mysqli_query($con, $sql);

$words = array();

if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
               $words[] = array('word' =>$row["word"] , 'meaning' =>$row["meaning"]);
            }
         } else {
            //echo "0 results";
         }


//echo $words;
/*
echo json_encode($words[1]);
echo "\n";
echo json_encode($words[0]);
echo "\n";
echo json_encode($words[2]);
echo "\n";
*/

//echo mysqli_num_rows($result)-1;
$array = array();
$array[] = $words[rand(0,mysqli_num_rows($result)-1)];
$finalwords=array('main'=>$array);

 mysqli_close($con);


//$data= new stdClass();
//$data->name="jay";
//$data->age=19;
echo json_encode($finalwords);

?>
