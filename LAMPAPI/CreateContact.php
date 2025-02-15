<?php
	include "db.php";

	//$inData = getRequestInfo();

    // Test Data
    $inData = json_decode('{
        "userId": "21",
        "name": "landon second friend",
        "email": "lando2friend@example.com",
        "phone": "9999999999"
	}', true);
	
    // Data for adding a new contact
    $name = $inData["name"];
    $email = $inData["email"];
    $phone = $inData["phone"];
	$userId = $inData["userId"];
 
	// Insert our contacts into Contacts table
	$stmt = $conn->prepare("INSERT into Contacts (userId,name,email,phone) VALUES(?,?,?,?)");
	$stmt->bind_param("ssss", $userId, $name, $email, $phone);
	$stmt->execute();
	$stmt->close();
	$conn->close();


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
	
?>
