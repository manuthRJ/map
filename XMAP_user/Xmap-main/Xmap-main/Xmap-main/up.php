<?php

session_start();
$con=mysqli_connect('localhost','root','','xmap');
$logo=$_FILES['logo']['name'];
$namet=$_FILES['logo']['type'];
$namett=$_FILES['logo']['tmp_name'];
$namest="png/".$logo;
move_uploaded_file($namett,$logo);
$head=$_POST['head'];
$des=$_POST['des'];
$links=$_POST['links'];
// Set timezone to Sri Lanka
date_default_timezone_set('Asia/Colombo');
// Get the current date and time
$current_datetime = date('Y-m-d H:i:s');
$query="INSERT INTO ubettta VALUES ('$logo','$head','$des','$current_datetime','$links')";
$result=mysqli_query($con,$query);
if($result){
 header('Location:bcxmapsbanadmin.html');


}
else{
 echo "Be sure that all are completedly fill.Make sure images type and letters count.";
}


?>