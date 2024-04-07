<?php
// Start the session
session_start();

include_once("./php/config.php");

$username = '';
if (isset($_SESSION['userId'])) {
    $userId = mysqli_real_escape_string($conn, $_SESSION['userId']);
    $result = mysqli_query($conn, "SELECT username FROM users WHERE id = '$userId'");
    $data = mysqli_fetch_assoc($result);
    $username = $data['username'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <header>
        <div class=headerContainer>
            <div class="L1">
                <a href="home.php">
                    <img class="logo" src="images/logo.jpg" alt="Logo Description">
                </a>
            </div>
            <nav>
                <ul class="nav_links">
                    <li><a href="Market.php">Market</a></li>
                    <li><a href="analyze.php">Analyse</a></li>
                    <li><a href="order.php">Orders</a></li>
                    <li><button onclick="location.href='contact.php'">Contact us</button></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle">
                            <img src="images/userIcon.png" alt="User Icon" class="user-icon">
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="portfolio.php">Portfolio</a></li>
                            <li><a href="logout.php">Logout '<?php echo $username?>'</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
</body>

</html>