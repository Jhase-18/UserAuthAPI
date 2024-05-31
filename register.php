<?php
require_once 'db.php';

$data = json_decode(file_get_contents("php://input"));

if (isset($data->username) && isset($data->password)) {
    $username = mysqli_real_escape_string($link, $data->username);
    $password = password_hash($data->password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

    if (mysqli_query($link, $sql)) {
        echo json_encode(["message" => "Registration successful"]);
    } else {
        echo json_encode(["error" => "Error: " . $sql . "<br>" . mysqli_error($link)]);
    }
} else {
    echo json_encode(["error" => "Invalid input"]);
}

mysqli_close($link);
?>
