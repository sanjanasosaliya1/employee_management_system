<?php
$SERVER_NAME = "localhost";
$USER_NAME = "root";
$PASSWORD = "";
$DATABASE_NAME = "employee_management";

$conn = mysqli_connect($SERVER_NAME, $USER_NAME, $PASSWORD, $DATABASE_NAME);

if (!$conn) 
{
    die("Connection failed: " . mysqli_connect_error());
}
?>

