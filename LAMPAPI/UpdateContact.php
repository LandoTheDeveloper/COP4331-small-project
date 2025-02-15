<?php

    include "db.php";

    //$inData = getRequestInfo();

    $inData = json_decode('{
        "userId": "21",
        "name": "landon second friend",
        "email": "lando2friend@second.com",
        "phone": "111111111111"
	}', true);

    $name = $inData["name"];
    $email = $inData["email"];
    $phone = $inData["phone"];
    $userId = $inData["userId"];

    $stmt = $conn->prepare("UPDATE Contacts SET email=?, phone=? WHERE name=? AND userId=?");
    $stmt->bind_param("ssss", $email, $phone, $name, $userId);
    $stmt->execute();
    $stmt->close();
    $conn->close();


    function getRequestInfo()
	{
		return json_decode(file_get_contents('php://input'), true);
	}
?>
