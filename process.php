<?php

include("config.php");
$mysqli = new mysqli("localhost", $username, $password, $database);

if ($_SERVER["CONTENT_TYPE"] == "application/json") {
    $data = json_decode(file_get_contents("php://input"), true) ?: [];
} else {
    $data = $_REQUEST;
}

$args = isset($data["args"]) ? $data["args"] : "";
$latitude = isset($data["latitude"]) ? $data["latitude"] : 0;
$longitude = isset($data["longitude"]) ? $data["longitude"] : 0;
$notes = isset($data["notes"]) ? $data["notes"] : "";

$sql = "INSERT INTO data (args, latitude, longitude, notes) VALUES ('$args', '$latitude', '$longitude', '$notes')";

echo $sql;

if (mysqli_query($mysqli, $sql)) {
    echo "New record created successfully"."</br>";
} else {
    echo "Error: ".$sql."<br>".mysqli_error($mysqli);
}

mysqli_close($mysqli);

?>
