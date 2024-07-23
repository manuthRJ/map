<?php
//This is for automatic deletion runing with ajax which loacate in bcxmapsbanadmin.html 
session_start();
$con = mysqli_connect('localhost', 'root', '', 'xmap');

// Check connection
if (mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set timezone to Sri Lanka
date_default_timezone_set('Asia/Colombo');

// Get current time
$current_time = date('Y-m-d H:i:s');
$query = "SELECT * FROM ubettta";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
// Query to delete records older than 10 seconds
$delete_sql = "DELETE FROM ubettta WHERE ctime <= DATE_SUB('$current_time', INTERVAL 10 SECOND)";
$resultDel = mysqli_query($con, $delete_sql);

if ($resultDel) {
    echo "Records deleted successfully.";
} else {
    echo "Error deleting records: " . mysqli_error($con);
}
    }
mysqli_close($con);
?>
