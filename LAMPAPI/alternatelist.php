<?php
include "db.php";

$contacts = [];
$inData = getRequestInfo();

// Test Data
/*
$inData = json_decode('{
    "userId": "21"
}', true);
*/

$stmt = $conn->prepare("SELECT name, email, phone FROM Contacts WHERE userId=?");
$stmt->bind_param("s", $inData['userId']);
$stmt->execute();

$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $contacts[] = [
        "name" => $row["name"],
        "email" => $row["email"],
        "phone" => $row["phone"]
    ];
}

$stmt->close();
$conn->close();

if (count($contacts) === 0) {
    returnWithError("No Records Found");
} else {
    returnWithInfo($contacts);
}

function sendResultInfoAsJson($obj)
{
    header('Content-Type: application/json');
    echo json_encode($obj);
}

function returnWithError($err)
{
    sendResultInfoAsJson(["results" => [], "error" => $err]);
}

function returnWithInfo($contacts)
{
    sendResultInfoAsJson(["results" => $contacts, "error" => ""]);
}

function getRequestInfo()
{
    return json_decode(file_get_contents('php://input'), true);
}
?>
