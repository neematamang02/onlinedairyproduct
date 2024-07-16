<?php
$hostname="localhost";
$username="root";
$pass="";
$dbname="eproject";

$conn=new mysqli($hostname,$username,$pass,$dbname);
if(!$conn)
{
    die(mysqli_error($conn));
}

?>