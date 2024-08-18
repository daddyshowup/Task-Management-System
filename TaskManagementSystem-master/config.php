<?php 
//connecting to database
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'Rohitdb';
$conn = mysqli_connect($servername, $username, $password, $database) or die('sorry we failed to connect database'. mysqli_connect_error());
?>