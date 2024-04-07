<?php
include_once("./config.php");
session_start();

if (isset($_SESSION['userId'], $_POST['stockSymbol'], $_POST['quantity'])) {
    $userId = mysqli_real_escape_string($conn, $_SESSION['userId']);
    $stockSymbol = mysqli_real_escape_string($conn, $_POST['stockSymbol']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);

    // Fetch the current price of the stock
    $query = "SELECT currentPrice FROM stocks WHERE stockSymbol = '$stockSymbol'";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
    $currentPrice = $data['currentPrice'];

    // Calculate the total cost of the stocks
    $totalCost = $currentPrice * $quantity;

    // Fetch the user's credits
    $query = "SELECT creditsLeft FROM users WHERE id = '$userId'";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
    $creditsLeft = $data['creditsLeft'];

    // Check if the user has enough credits to buy the stocks
    if ($creditsLeft >= $totalCost) {
        // Deduct the cost of the stocks from the user's credits
        $newCredits = $creditsLeft - $totalCost;
        $query = "UPDATE users SET creditsLeft = '$newCredits' WHERE id = '$userId'";
        mysqli_query($conn, $query);

        // Add the stocks to the user's portfolio
        $query = "INSERT INTO user_stocks (userId, stockSymbol, numberOfShares, purchasePrice, purchaseDate) 
                  VALUES ('$userId', '$stockSymbol', '$quantity', '$currentPrice', NOW())";
        mysqli_query($conn, $query);

        echo "<script>alert('Stocks bought successfully!'); window.location.href='../portfolio.php';</script>";
    } else {
        echo "<script>alert('You do not have enough credits to buy these stocks.'); window.location.href='../portfolio.php';</script>";
    }
} else {
    echo "Invalid request.";
}
?>