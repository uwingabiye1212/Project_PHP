<?php 
//echo"Hello ".$_SESSION['username'];
require_once 'db_connect.php';

$sql = "SELECT * FROM customers";
$result = mysqli_query($conn, $sql);
?>

<html>
<head>
    <title>Registered customers</title>
</head>
<body bgcolor="gray"> <center>
    <h2>REGISTERED customers</h2>
    <table border="8" cellpadding="10" bgcolor="mangenta">
        <tr>
            <th>customer_id</th>
            <th>customer_name</th>
            <th>customer_location</th>
            <th>customer_telephone</th>
            <th>UPDATE</th>
        </tr>

        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "
                <tr>
                    <td>{$row['customer_id']}</td>
                    <td>{$row['customer_name']}</td>
                    <td>{$row['customer_location']}</td>
                    <td>{$row['customer_telephone']}</td>

                    <td>
                        <a href='update.php?customer_id={$row['customer_id']}' 
                           onclick=\"return confirm('Are you sure you want to update this record?');\">
                           <button>Update</button>
                        </a>


                    </td>;
                </tr>";
            }
        } 
        ?>
    </table>
         <a href="logout.php">Logout</a>
</body>
</html>