<?php
session_start();

require_once 'connect.php';
require_once 'DBConn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['id'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        echo "Please fill in all fields.";
        exit;
    }

    try {
        $db = new DBConn($G_DB);

        // Fetch user by username
        $sql = "SELECT id, user_name, password FROM users WHERE user_name = ?";
        $user = $db->fetch($sql, [$username]);

        if ($user && password_verify($password, $user['password'])) {
            // Password is correct, start a session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['user_name'];

            // Redirect to a logged-in page (e.g., index.php)
            // [수정된 부분] board_list.html로 이동
            header("Location: board_list.html");
            exit;
        } else {
            echo "Invalid username or password. <a href='login.html'>Try again</a>";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>