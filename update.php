<?php
//echo"Hello ".$_SESSION['username'];
require_once 'db_connect.php';

if (isset($_GET['customer_id'])) {
    $customer_id = $_GET['customer_id'];

    $sql = "SELECT * FROM customers WHERE customer_id = '$customer_id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
    } else {
        echo "Record not found!";
        exit;
    }
}

if (isset($_POST['update'])) {
    $customer_id= $_POST['customer_id'];
    $customer_name = $_POST['customer_name'];
    $customer_location = $_POST['customer_location'];
    $customer_telephone = $_POST['customer_telephone'];

    $update = "UPDATE customers
               SET customer_name='$customer_name',customer_location='$customer_location',customer_telephone='$customer_telephone' WHERE customer_id='$customer_id'";

    if (mysqli_query($conn, $update)) {
        echo "<script>
                alert('Record updated successfully!');
                window.location.href='display.php';
              </script>";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>

<html>
<head>
    <title>Update Record</title>
    <style>
        body {
            background-color:#ffffff;
            font-family: Arial, sans-serif;
        }

        h2 {
            text-align: center;
            color: #007bff;
            margin-top: 50px;
            margin-bottom: 30px;
        }

        form {
            background-color:#f5f7fa;
            max-width: 500px;
            margin: 0 auto;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
            margin-bottom: 5px;
            color: #333333;
        }

        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #cccccc;
            box-sizing: border-box;
        }

        input[type="text"]:focus, input[type="number"]:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
        }

        input[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 12px 20px;
            margin-top: 20px;
            border: none;
            border-radius: 8px;
            width: 100%;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <h2>Update customer Information</h2>

    <form method="POST" action="">
        <label>customer_id:</label>
        <input type="text" name="customer_id" value="<?php echo isset($row['customer_id']) ? $row['customer_id'] : ''; ?>" required>

        <label>customer_name:</label>
        <input type="text" name="customer_name" value="<?php echo isset($row['customer_name']) ? $row['customer_name'] : ''; ?>" required>

        <label>customer_location:</label>
        <input type="text" name="customer_location" value="<?php echo isset($row['customer_location']) ? $row['customer_location'] : ''; ?>" required>

        <label>customer_telephone:</label>
        <input type="text" name="customer_telephone" value="<?php echo isset($row['customer_telephone']) ? $row['customer_telephone'] : ''; ?>" required>

        <input type="submit" name="update" value="Update">
    </form>
</body>
</html>


















