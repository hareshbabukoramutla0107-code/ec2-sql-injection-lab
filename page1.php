i<?php
$conn = mysqli_connect("localhost", "testuser", "test123", "testdb");

if (!$conn) {
    die("Database connection failed");
}

$message = "";

if(isset($_POST['username'])){

    $username = $_POST['username'];

    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if($result && mysqli_num_rows($result) > 0){
        $message = "<h2 style='color:green;'>Login Successful</h2>";
    } else {
        $message = "<h2 style='color:red;'>Login Failed</h2>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Vulnerable Login</title>
</head>
<body>
    <?php error_reporting(E_ALL);
ini_set('display_errors', 1); echo $message; ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Enter Username">
        <button type="submit">Login</button>
    </form>
</body>
</html>

