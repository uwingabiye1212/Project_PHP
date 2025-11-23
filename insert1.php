<?php
if(isset($_POST['insert'])) {
require_once 'db_connect.php';
$customer_id=$_POST['customer_id'];
$customer_name=$_POST['customer_name'];
$customer_location=$_POST['customer_location'];
$customer_telephone=$_POST['customer_telephone'];
$insert="INSERT INTO customers(customer_id,customer_name,customer_location,customer_telephone)VALUES('$customer_id','$customer_name','$customer_location','$customer_telephone')";
if (mysqli_query($conn,$insert)) {

	echo "record inserted successfully";
}
else{
	echo "record not yet inserted";
}
//mysqli_close($conn,$insert);
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>
<form action="" method="POST">
	customer_id:
	<input type="number" name="customer_id"><br>
	customer_name:
	<input type="text" name="customer_name"><br>
	customer_location:
	<input type="text" name="customer_location"><br>
	customer_telephone:
	<input type="text" name="customer_telephone"><br>
	<input type="submit" name="insert" value="insert">
</form>
</body>
</html>
