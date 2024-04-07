<?php
// Start the session
session_start();

// Include the database configuration file
include_once "config.php";

// Get the submitted form data
$username = $_POST["username"];
$password = $_POST["password"];

// Query the database to find the user
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // User exists, check the password
    $user = $result->fetch_assoc();

    if (password_verify($password, $user["password"])) {
        // Password is correct, log the user in
        $_SESSION["userId"] = $user["id"];
        header("Location: ../home.php");
        exit();
    } else {
        // Password is incorrect
        echo "Incorrect password.";
    }
} else {
    // User does not exist
    echo "User does not exist.";
}

$stmt->close();
$conn->close();
?>