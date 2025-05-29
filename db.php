<?php
$dsn = "mysql:host=localhost;dbname=fitzone_fitness"; 
$dbusername = "root";  
$dbpassword = "";      

try {
    $conn = new PDO($dsn, $dbusername, $dbpassword); 
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage(); 
}
?>





