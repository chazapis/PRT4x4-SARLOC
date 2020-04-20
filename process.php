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

$args = iconv_substr($args, 0, 5);
$notes = iconv_substr($notes, 0, 64);

$args = $mysqli->real_escape_string($args);
$latitude = $mysqli->real_escape_string($latitude);
$longitude = $mysqli->real_escape_string($longitude);
$notes = $mysqli->real_escape_string($notes);

$sql = "INSERT INTO data (args, latitude, longitude, notes) VALUES ('$args', '$latitude', '$longitude', '$notes')";

if (mysqli_query($mysqli, $sql)) {
    echo "New record created successfully";
} else {
    // echo "Error: ".$sql."<br>".mysqli_error($mysqli);
    echo "Error in creating new record";
}

mysqli_close($mysqli);

?>
