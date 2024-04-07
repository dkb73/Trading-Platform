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

    // Fetch the user's stocks
    $query = "SELECT numberOfShares FROM user_stocks WHERE userId = '$userId' AND stockSymbol = '$stockSymbol'";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
    $numberOfShares = $data['numberOfShares'];

    // Check if the user has enough stocks to sell
    if ($numberOfShares >= $quantity) {
        // Deduct the stocks from the user's portfolio
        $newNumberOfShares = $numberOfShares - $quantity;
        $query = "UPDATE user_stocks SET numberOfShares = '$newNumberOfShares' WHERE userId = '$userId' AND stockSymbol = '$stockSymbol'";
        mysqli_query($conn, $query);

        // Add the credits to the user's account
        $totalCredits = $currentPrice * $quantity;
        $query = "UPDATE users SET creditsLeft = creditsLeft + '$totalCredits' WHERE id = '$userId'";
        mysqli_query($conn, $query);

        echo "<script>alert('Stocks sold successfully!'); window.location.href='../portfolio.php';</script>";
    } else {
        echo "<script>alert('You do not have enough stocks to sell.'); window.location.href='../portfolio.php';</script>";
    }
} else {
    echo "Invalid request.";
}
?>