<?php
// Assuming you have established a MySQL connection
include('includes/dbh.inc.php');
// Retrieve the base64-encoded longblob value from the database
$query = "SELECT employees_image FROM employees WHERE uID = 118";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$encodedValue = $row['employees_image'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Display Longblob in HTML</title>
</head>
<body>
<!-- Embed the encoded longblob value within an <img> tag -->
<img src="data:image/jpeg;base64,<?php echo $encodedValue; ?>" alt="Longblob Image">
</body>
</html>
