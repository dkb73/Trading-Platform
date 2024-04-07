<?php
include_once("./php/config.php");
include_once("./header.php");

if (isset($_SESSION['userId'])) {
    $userId = mysqli_real_escape_string($conn, $_SESSION['userId']);
    $query = "SELECT us.stockSymbol, us.numberOfShares, us.purchasePrice, us.purchaseDate, s.currentPrice 
              FROM user_stocks us 
              INNER JOIN stocks s ON us.stockSymbol = s.stockSymbol 
              WHERE us.userId = '$userId'";

    $result = mysqli_query($conn, $query);

    echo "<div style='height: 150px;'></div>";
    echo "<table>";
    echo "<tr><th>Stock Symbol</th><th>Number of Shares</th><th>Purchase Price</th><th>Purchase Date</th><th>Current Price</th><th>Buy more</th><th>Sell</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>{$row['stockSymbol']}</td><td>{$row['numberOfShares']}</td><td>{$row['purchasePrice']}</td><td>{$row['purchaseDate']}</td><td>{$row['currentPrice']}</td>";
        echo "<td><form action='./php/buy_stocks.php' method='post'>
                <input type='hidden' name='stockSymbol' value='{$row['stockSymbol']}'>
                <input type='number' name='quantity' value='1' min='1'>
                <input type='submit' value='Buy'>
              </form></td>";
        echo "<td><form action='./php/sell_stocks.php' method='post'>
              <input type='hidden' name='stockSymbol' value='{$row['stockSymbol']}'>
              <input type='number' name='quantity' value='1' min='1' max='{$row['numberOfShares']}'>
              <input type='submit' value='Sell'>
            </form></td></tr>";
    }
    echo "</table>";
} else {
    echo "You are not logged in.";
}
