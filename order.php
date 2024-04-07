<?php
// Start the session
session_start();

// Connect to your database
include('./php/config.php');
include('./header.php');

// Get the user's ID from the session
$userId = $_SESSION['userId'];

// Fetch the stock companies
$query = "SELECT DISTINCT stockId FROM orders WHERE userId = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$stocks = $result->fetch_all(MYSQLI_ASSOC);

// Check if a filter has been applied
$stockFilter = isset($_GET['stock']) ? $_GET['stock'] : null;

// Fetch the orders for the current user, with the filter applied
$query = "SELECT orders.id,orders.orderType,orders.quantity,orders.price,orders.orderDate,stocks.stockSymbol,stocks.id as stockId from orders left join stocks on orders.stockId = stocks.id where userId= ?";
// $query = "SELECT id, orderType, quantity, price, orderDate FROM orders WHERE userId = ?";
if ($stockFilter) {
    $query .= " AND stockId = ?";
}
$stmt = $conn->prepare($query);
if ($stockFilter) {
    $stmt->bind_param("ii", $userId, $stockFilter);
} else {
    $stmt->bind_param("i", $userId);
}
$stmt->execute();
$result = $stmt->get_result();
$orders = $result->fetch_all(MYSQLI_ASSOC);
?>

<head>
    <link rel="stylesheet" href="./css/style.css">
    <style>
        .orders {
            margin-top: 150px;
        }

        .orderSection {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            margin-top: 20px;
        }

        .orderSection .orderContainer {
            width: 80%;
        }

        .orderSection .orderContainer table {
            width: 100%;
            text-align: left;
            border-collapse: collapse;
        }

        .orderSection .orderContainer th,
        .orderSection .orderContainer td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        .filter-form {
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 80%;
            padding: 10px;
            background-color: #f8f8f8;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin-left:auto;
            margin-right:auto;
        }

        .filter-form select,
        .filter-form input[type="submit"] {
            margin: 0 10px;
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
</head>

<div class="orders">
    <form method="get" class="filter-form">
        <select name="stock">
            <option value="">All</option>
            <?php foreach ($stocks as $stock) : ?>
                <option value="<?php echo $stock['stockId']; ?>" <?php if ($stock['stockId'] == $stockFilter) echo 'selected'; ?>>
                    <?php echo $stock['stockId']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input type="submit" value="Filter">
    </form>

    <!-- Orders table -->
    <section class=orderSection>
        <div class="orderContainer">
            <table>
                <tr>
                    <th>Order ID</th>
                    <th>Order Type</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Net Investment</th>
                    <th>Order Date</th>
                    <th>Stock Name</th>
                    <th>Stock Id</th>
                    <!-- <th>Stock Id</th> -->
                </tr>

                <?php foreach ($orders as $order) : ?>
                    <tr>
                        <td><?php echo $order['id']; ?></td>
                        <td><?php echo $order['orderType']; ?></td>
                        <td><?php echo $order['quantity']; ?></td>
                        <td><?php echo $order['price']; ?></td>
                        <td><?php echo $order['price']*$order['quantity']; ?></td>
                        <td><?php echo $order['orderDate']; ?></td>
                        <td><?php echo $order['stockSymbol']; ?></td>
                        <td><?php echo $order['stockId']; ?></td>
                        
                    </tr>
                <?php endforeach; ?>

            </table>
        </div>
    </section>
</div>
</body>

</html>