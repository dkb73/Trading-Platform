<?php
include_once "config.php";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $company = $_POST['company'];
    $amount = $_POST['amount'];

    $sql = "SELECT * FROM yourStocks WHERE company = '$company'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $stmt2 = $conn->prepare("UPDATE yourStocks SET Quantity = Quantity + ? WHERE company = ?");
        $stmt2->bind_param("is", $amount, $company);
        $stmt2->execute();
        if ($stmt2->affected_rows == 0) {
            $response['message'] = "Failed to update stock quantity";
        } else {
            if($amount == 1) {
                $response['message'] = $amount ." Stock is bought successfully";
            } else {
                $response['message'] = $amount ." Stocks are bought successfully";
            }
        }
    } else {
        $price = $_POST['price'];
        $variation = $_POST['variation'];
        $sql2 = "INSERT INTO yourStocks (company, bought_at, bought_price, current_price, Quantity) values ('$company', now(), '$price', '$price', 1)";
        // You should execute this query
        if ($conn->query($sql2) === TRUE) {
            $response['message'] = "New stock added successfully";
        } else {
            $response['message'] = "Error: " . $sql2 . "<br>" . $conn->error;
        }
    }
}

$sql = "SELECT company, bought_at, bought_price, current_price, Quantity  FROM yourStocks";
$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    echo "0 results";
}

$conn->close();

return $data;
?>