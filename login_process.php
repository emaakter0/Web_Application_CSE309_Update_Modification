<?php
include 'db_connect.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $redirect_to = isset($_POST['redirect_to']) ? $_POST['redirect_to'] : null;

    $sql = "SELECT id, username, role, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // রোল অনুযায়ী অথবা redirect_to প্যারামিটার অনুযায়ী রিডাইরেক্ট করা হচ্ছে
            if ($redirect_to) {
                header("Location: " . $redirect_to);
            } elseif ($_SESSION['role'] == 'admin') {
                header("Location: admin_dashboard.php");
            } elseif ($_SESSION['role'] == 'doctor') {
                header("Location: doctor_dashboard.html");
            } else {
                header("Location: client_dashboard.html");
            }
            exit;
        } else {
            echo "ভুল ইউজারনেম বা পাসওয়ার্ড।";
        }
    } else {
        echo "ভুল ইউজারনেম বা পাসওয়ার্ড।";
    }



 
}
?>


