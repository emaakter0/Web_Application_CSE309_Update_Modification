<?php
// সেশন শুরু করা হচ্ছে
session_start();
// ডেটাবেজ সংযোগ যুক্ত করা হচ্ছে
include 'db_connect.php';

// শুধুমাত্র লগইন করা ক্লায়েন্টরা এই পেজ অ্যাক্সেস করতে পারবে
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'normal_client') {
    // যদি ব্যবহারকারী ইতিমধ্যে 'fulltime_client' হয় বা লগইন না করা থাকে
    header("Location: client_dashboard.php");
    exit;
}

// সেশন থেকে ব্যবহারকারীর আইডি নেওয়া হচ্ছে
$user_id = $_SESSION['user_id'];

// ব্যবহারকারীর রোল 'fulltime_client' এ আপডেট করার জন্য SQL কোয়েরি
$sql = "UPDATE users SET role = 'fulltime_client' WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    // সেশনের রোল ডেটাও আপডেট করা হচ্ছে
    $_SESSION['role'] = 'fulltime_client';
    // সফলভাবে আপগ্রেড হলে ক্লায়েন্ট ড্যাশবোর্ডে ফিরে যাওয়া হবে
    header("Location: client_dashboard.php?message=upgraded_success");
    exit;
} else {
    // কোনো ত্রুটি হলে তা দেখানো হবে
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
