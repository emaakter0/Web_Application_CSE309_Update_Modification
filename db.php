<?php 
$conn = mysqli_connect("localhost", "root", "", "kittypups");

if($conn){
    // echo "DB Successfully Connected "; 
}
else{
    die("DB connection has broken".mysqli_error());
}
?>