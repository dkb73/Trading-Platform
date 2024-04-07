<?php
include('./php/config.php');
include('header.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        
    </style>
</head>

<body>
    <?php
    $query = "SELECT * FROM stocks";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    ?>

    <section class="Market">
        <h1>Market</h1>
        <table>
            <tr>
                <th>Stock</th>
                <th>Price</th>
                <th>Last Updated</th>
                <th>Buy</th>
            </tr>

            <?php foreach ($data as $row) : ?>
                <tr>
                    <td><?php echo $row['stockSymbol']; ?></td>
                    <td><?php echo $row['currentPrice']; ?></td>
                    <td><?php echo $row['lastUpdated']; ?></td>
                    <td>
                        <form class="buyMore" action="./php/buy.php" method="post">
                            <input type="hidden" name="company" value="<?php echo $row['stockSymbol']; ?>">
                            <input type="hidden" name="price" value="<?php echo $row['currentPrice']; ?>">
                            <input type="hidden" name="action" value="buy">
                            <input type="hidden" name="stockId" value="<?php echo $row['id']; ?>">
                            <input type="number" name="amount" value="1" style="width: 50px; border-radius: 4px; border: 0.5px solid grey; text-align: center;">
                            <button type="submit">Buy</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>

        </table>
        </div>
    </section>

    <script>
        var forms = document.getElementsByClassName('buyMore');

        for (var i = 0; i < forms.length; i++) {
            forms[i].addEventListener('submit', function(event) {
                event.preventDefault();

                var formData = new FormData(this);

                fetch('./php/order.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.text())
                    .then(data => {
                        let parsedData = JSON.parse(data);
                        alert(parsedData.message);
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