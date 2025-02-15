<?php
	$inData = getRequestInfo();
	include "db.php";	

	// DEBUG
	// $inData = json_decode('{
	//	"firstName": "John",
	//	"lastName": "Doe",
	//	"username": "johndoe",
	//	"password": "johnPassword",
	//	"email": "john@example.com"
	// }', true);

	$firstName = $inData["firstName"] ?? ""; // if doesnt exist, make empty
	$lastName = $inData["lastName"] ?? "";
	$username = $inData["username"] ?? "";
	$rawpassword = $inData["password"] ?? "";
	$email = $inData["email"] ?? "";

	// check emptiness
	if (empty($firstName) || empty($lastName) || empty($username) || empty($rawpassword) ||
	    empty($email)) {
	
	    returnWithError("Missing required fields.");
	    exit();
	}

	// Check if username already exists
	$checkStmt = $conn->prepare("SELECT ID FROM Users WHERE username = ?");
	$checkStmt->bind_param("s", $username);
	$checkStmt->execute();
	$checkStmt->store_result();

	if ($checkStmt->num_rows > 0) {
		$checkStmt->close();
		$conn->close();
		returnWithError("Username already exists.");
		exit();
	}
	$checkStmt->close();

	// hashing before storing
	$hashedpassword = md5($rawpassword);


	// include "db.php" handles the connection
	// $conn = new mysqli("localhost", "Group1", "COP4331", "contactmanager");
	// if ($conn->connect_error) 
	// {
	//	returnWithError( $conn->connect_error );
	// } 
	
	
	$stmt = $conn->prepare("INSERT into Users (FirstName,LastName,username,password,email) VALUES(?,?,?,?,?)");
	$stmt->bind_param("sssss", $firstName, $lastName, $username, $hashedpassword, $email);
	if ($stmt->execute()) {
		returnWithSuccess("User created successfully", $conn->insert_id);
	} else {
		returnWithError("Error: " . $stmt->error);
	}


	$stmt->close();
	$conn->close();

	// helper functions
	
	function getRequestInfo()
	{
		return json_decode(file_get_contents('php://input'), true);
	}

	function sendResultInfoAsJson( $obj )
	{
		header('Content-type: application/json');
		echo $obj;
	}
	
	function returnWithError( $err )
	{
		$retValue = '{"error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}
	function returnWithSuccess($msg, $userId) {
		echo json_encode(["status" => "success", "message" => $msg, "userId" => $userId]);
		exit();
	}	
?>
