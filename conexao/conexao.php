<?php 
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "consumiveis";
$port = 3306;

$conn = new mysqli($host,$user,$pass,$dbname,$port);

if($conn -> connect_error){
echo "Conexão MySQL falhou: " . $conn->connect_error;
exit();
}
