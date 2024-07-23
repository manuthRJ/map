<?php
//this is for delete the ads manually for admin.But delete the data from database automatically.
session_start();
$con=mysqli_connect('localhost','root','','xmap');
$query="DELETE FROM ubettta ";
$result=mysqli_query($con,$query);
if($result){
 header('Location:bcxmapsbanadmin.html');
}
else{
 echo "What the happen !";
}
?>