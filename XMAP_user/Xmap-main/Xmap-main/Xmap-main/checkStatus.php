<?php
//this file helps to check status of database.It's output is showing on admin panel.
session_start();
$con = mysqli_connect('localhost', 'root', '', 'xmap');
$query = "SELECT * FROM ubettta";
$result = mysqli_query($con, $query);

if (mysqli_num_rows($result) > 0) {
// Example script to check deletion status
$status = array(
    'message' => 'Click Me to Delete Now Ads',
    'timestamp' => date('Y-m-d H:i:s')
);

header('Content-Type: application/json');
echo json_encode($status);
}else{
    $status = array(
        'message' => ' Now You can Add the ADS !',
        'timestamp' => date('Y-m-d H:i:s')
    );
    
    header('Content-Type: application/json');
    echo json_encode($status);
}
?>
