<?php
session_start();

// Include the database connection file
include 'db_connect.php';

// Get the user input
$username = $_POST['username'];
$password = $_POST['password'];
$rememberMe = $_POST['rememberMe'];

// Check if the user is already logged in
if (isset($_SESSION['username'])) {
    // Redirect to the index page
    header("Location: index.php");
    exit;
}

// Check if the username and password are correct
$sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // The username and password are correct
    // Set the session variables
    $_SESSION['username'] = $username;
    $_SESSION['password'] = $password;

    // If the user checked the "Remember me" checkbox, set a cookie
    if ($rememberMe == "on") {
        setcookie("username", $username, time() + (86400 * 30), "/");
        setcookie("password", $password, time() + (86400 * 30), "/");
    }

    // Redirect to the index page
    header("Location: index.php");
    exit;
} else {
    // The username and password are incorrect
    echo "Incorrect username or password";
}

// Close the database connection
$conn->close();
?>
