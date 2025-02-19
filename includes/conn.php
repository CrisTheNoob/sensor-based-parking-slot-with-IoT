<?php
$servername = "localhost"; 
$username = "root";        
$password = "";            
$dbname = "parking_system_db"; 

// $servername = "localhost"; 
// $username = "u186082990_parking_db";        
// $password = "#qpj=tm6tZ";            
// $dbname = "u186082990_parking_db"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>