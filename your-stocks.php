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
                <th>BuyMore</th>
                <th>Sell</th>
            </tr>

            <?php foreach ($data as $row) : ?>
                <tr>
                    <td><?php echo $row['company']; ?></td>
                    <td><?php echo $row['bought_at']; ?></td>
                    <td><?php echo $row['bought_price']; ?></td>
                    <td><?php echo $row['current_price']; ?></td>
                    <td><?php echo $row['Quantity']; ?></td>
                    <td><?php echo (($row['current_price'] - $row['bought_price']) * $row['Quantity']); ?></td>
                    <td>
                        <form class="buyMore" action="./php/your-stocks.php" method="post">
                            <input type="hidden" name="company" value="<?php echo $row['company']; ?>">
                            <input type="hidden" name="price" value="<?php echo $row['current_price']; ?>">
                            <input type="number" name="amount" value="1" style="width: 50px; border-radius: 4px; border: 0.5px solid grey; text-align: center;">
                            <button type="submit">Buy</button>
                        </form>
                    </td>
                    <td>
                        <form class="sell" action="./php/sell.php" method="post">
                            <input type="hidden" name="company" value="<?php echo $row['company']; ?>">
                            <input type="number" name="amount" value="1" style="width: 50px;border-radius: 4px;border:0.5px solid grey; text-align: center;">
                            <button type="submit">Sell</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>

        </table>
    </section>

    <script>
        var forms = document.getElementsByClassName('buyMore');

        for (var i = 0; i < forms.length; i++) {
            forms[i].addEventListener('submit', function(event) {
                event.preventDefault();

                var formData = new FormData(this);

                fetch('./php/your-stocks.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.text())
                    .then(data => {
                        alert('data.message');
                        location.reload();
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                    });
            });
        }


        var forms2 = document.getElementsByClassName('sell');

        for (var i = 0; i < forms2.length; i++) {
            forms2[i].addEventListener('submit', function(event) {
                event.preventDefault();

                var formData = new FormData(this);

                fetch('./php/sell.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                        location.reload();
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                    });
            });
        }
    </script>

</body>

</html>