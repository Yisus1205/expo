<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "crud_php";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>