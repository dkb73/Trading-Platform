<!DOCTYPE html>
<html>

<head>
    <title>Trading Platform - Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .regContainer {
            background: #fff;
            padding:20px;
            width: 300px;
            box-shadow: 0px 0px 20px 0px rgba(0, 0, 0, 0.1);
            
            border-radius:10px;
        }

        .textContent{
            margin-bottom: 20px;
        }

        .textContent h1 {
            text-align: center;
            color: #333;
            font-size:large;
        }

        .formdetails {
            margin-top: 20px;
        }

        .formdetails label {
            display: block;
            margin-bottom: 5px;
        }

        .formdetails input[type="text"],
        .formdetails input[type="email"],
        .formdetails input[type="password"] {
            width: 90%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .formdetails input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            border: none;
            color: #fff;
            cursor: pointer;
        }

        .formdetails input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="regContainer">
        <div class="textContent">
            <h1>Register for a Brighter Future</h1>
        </div>
        <div class="formdetails">
            <form action="./php/register.php" method="POST">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required><br><br>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required><br><br>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required><br><br>

                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required><br><br>
                <input type="hidden" id = "InitalCredits" value="1000000">
                <input type="submit" value="Register">
            </form>
        </div>
    </div>
</body>

</html>