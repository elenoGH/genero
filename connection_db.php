<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = 'wp_ine_test';


$con=mysqli_connect($servername,$username,$password,$db);
// Check connection
if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
if (!mysqli_set_charset($con, "utf8")) {
//    printf("Error cargando el conjunto de caracteres utf8: %s\n", mysqli_error($con));
    exit();
} else {
//    printf("Conjunto de caracteres actual: %s\n", mysqli_character_set_name($con));
}
?>