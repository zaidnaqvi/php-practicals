<?php
$host = "127.0.0.1";
$port = "3307"; 
$db_name = "gmiu_shop";
$username = "root";
$password = ""; 

try {
    // FIX: Standard PDO DSN format uses port= as a separate property
    $dsn = "mysql:host=$host;port=$port;dbname=$db_name;charset=utf8mb4";
    
    $conn = new PDO($dsn, $username, $password);
    
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch(PDOException $exception) {
    // This will now catch if the port 3307 is unreachable
    die("Connection failed: " . $exception->getMessage());
}
?>