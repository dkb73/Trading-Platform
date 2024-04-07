<?php
$conn = mysqli_connect("localhost", "root", "", "trade_multiuser");
if ($conn) {
    echo mysqli_connect_error();
} else {
    echo "Error";
}

