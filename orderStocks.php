<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php include('header.php') ?>
    <?php include('./php/your-stocks.php') ?>
    <section class="stdSec">
        <table>
            <tr>
                <th>Company</th>
                <th>Bought_date</th>
                <th>Bought_price</th>
                <th>Current_price</th>
                <th>Quantity</th>
                <th>Profit/Loss</th>
                <th>Order</th>
            </tr>

            <?php foreach ($data as $row) : ?>
                <tr>
                    <td><?php echo $row['stockSymbol']; ?></td>
                    <td><?php echo $row['bought_at']; ?></td>
                    <td><?php echo $row['bought_price']; ?></td>
                    <td><?php echo $row['currentPrice']; ?></td>
                    <td><?php echo $row['Quantity']; ?></td>
                    <td><?php echo (($row['currentPrice'] - $row['bought_price']) * $row['Quantity']); ?></td>
                    <td>
                        <form class="orderForm" action="./php/placeOrder.php" method="post">
                            <input type="hidden" name="stockId" value="<?php echo $row['id']; ?>">
                            <input type="hidden" name="price" value="<?php echo $row['currentPrice']; ?>">
                            <select name="orderType">
                                <option value="buy">Buy</option>
                                <option value="sell">Sell</option>
                            </select>
                            <input type="number" name="quantity" value="1" style="width: 50px; border-radius: 4px; border: 0.5px solid grey; text-align: center;">
                            <button type="submit">Place Order</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </section>
</body>
</html>