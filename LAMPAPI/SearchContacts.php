<?php
    include "db.php";
    
	//$inData = getRequestInfo();

    // Test Data
    $inData = json_decode('{
        "userId": "21",
        "name": "lan"
	}', true);

    if ($inData === null ) {
        returnWithError("inData not set.");
    }
	
	$searchResults = "";
	$searchCount = 0;

    $stmt = $conn->prepare("SELECT name,email,phone FROM Contacts WHERE name LIKE ? AND userId=?");
    $contactName = '%' . $inData["name"] . '%';
    $stmt->bind_param("ss", $contactName, $inData["userId"]);
    $stmt->execute();
    
    $result = $stmt->get_result();
    
    while($row = $result->fetch_assoc())
    {
        if( $searchCount > 0 )
        {
            $searchResults .= ",";
        }
        $searchCount++;
        $searchResults .= 'Person: "'  . $row["name"] . '" Email: ' . $row["email"] . ' Phone: ' . $row["phone"];
    }
    
    if( $searchCount == 0 )
    {
        returnWithError( "No Records Found" );
    }
    else
    {
        returnWithInfo( $searchResults );
    }
    
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
		$retValue = '{"id":0,"firstName":"","lastName":"","error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}
	
	function returnWithInfo( $searchResults )
	{
		$retValue = '{"results":[' . $searchResults . '],"error":""}';
		sendResultInfoAsJson( $retValue );
	}
	
?>