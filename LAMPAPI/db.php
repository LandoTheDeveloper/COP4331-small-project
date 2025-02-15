<?php
$servername = "localhost";
$username = "username";
$password = "password";

// Create connection
// $conn = new mysqli($servername, $username, $password);

$conn = new mysqli("localhost", "Group1", "COP4331", "contactmanager");
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?>
