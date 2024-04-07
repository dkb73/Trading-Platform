<?php
// Connect to your database
include('config.php');

// Get the form data
$stockSymbol = $_POST['company'];
$price = $_POST['price'];
$amount = $_POST['amount'];
$action = $_POST['action'];
$stockId = $_POST['stockId'];

// Assuming you have the user's ID stored in a session variable
session_start();
$userId = $_SESSION['userId'];

// Get the current date
$orderDate = date('Y-m-d H:i:s');
$response = array();

if ($action == 'buy') {
    // Calculate the total cost of the order
    $totalCost = $price * $amount;

    // Get the user's credits
    $query = "SELECT creditsLeft FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $creditsLeft = $row['creditsLeft'];

    // Check if the user has enough credits
    if ($creditsLeft >= $totalCost) {
        // Perform the buy operation
        $query = "INSERT INTO orders (userId, stockId, orderType, quantity, price, orderDate, status) VALUES ('$userId', '$stockId', 'buy', '$amount', '$price', '$orderDate', 'pending')";

        if ($conn->query($query) === TRUE) {
            $response['message'] = "New order created successfully";
        } else {
            $response['message'] = "Error: " . $query . "<br>" . $conn->error;
        }
    } else {
        $response['message'] = "You do not have enough credits to place this order";
    }
} else {
    $response['message'] = "Invalid action";
}

$conn->close();

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>