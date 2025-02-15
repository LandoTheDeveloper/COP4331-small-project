<?php

    include "db.php";

    //$inData = getRequestInfo();

    $inData = json_decode('{
        "userId": "21",
        "name": "landon second friend"
	}', true);

    $name = $inData["name"];
    $userId = $inData["userId"];

    $stmt = $conn->prepare("DELETE FROM Contacts WHERE name=? AND userId=?");
    $stmt->bind_param("ss", $name, $userId);
    $stmt->execute();
    $stmt->close();
    $conn->close();


    function getRequestInfo()
	{
		return json_decode(file_get_contents('php://input'), true);
	}
?>
