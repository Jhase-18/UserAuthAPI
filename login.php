<?php
require_once 'db.php';

$data = json_decode(file_get_contents("php://input"));

if (isset($data->username) && isset($data->password)) {
    $username = mysqli_real_escape_string($link, $data->username);
    $password = $data->password;

    $sql = "SELECT id, username, password FROM users WHERE username = '$username'";
    $result = mysqli_query($link, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            echo json_encode(["message" => "Authentication successful"]);
        } else {
            echo json_encode(["error" => "Invalid password"]);
        }
    } else {
        echo json_encode(["error" => "No user found"]);
    }
} else {
    echo json_encode(["error" => "Invalid input"]);
}

mysqli_close($link);
?>
