<?php
include_once "config.php";

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
$InitialCredits = $_POST['InitalCredits'];


$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Check if the username already exists
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Username already exists
    echo "<script>alert('Username already exists');</script>";
} else {
    // Username does not exist, proceed with the registration
    $stmt = $conn->prepare("INSERT INTO users (username, email, password,InitialCredits) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashed_password,$InitialCredits);

    if ($stmt->execute()) {
        // Start the session
        session_start();

        // Get the ID of the newly inserted record
        $last_id = $conn->insert_id;

        // Store the user's ID in the session
        $_SESSION["userId"] = $last_id;

        echo "<script>alert('New record created successfully');</script>";
        header("Location: ../home.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

$stmt->close();
$conn->close();
?>