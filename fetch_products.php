<?php
header('Content-Type: application/json');

// আপনার ডাটাবেজ সংযোগ ফাইলটি এখানে অন্তর্ভুক্ত করুন
include 'db_connect.php'; 

// সংযোগে কোনো ত্রুটি হলে, db_connect.php ফাইল থেকে তা হ্যান্ডেল হবে।

// SQL কোয়েরি
$sql = "SELECT id, name, category, price, image_url, description FROM products";
$result = $conn->query($sql);

$products = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

// JSON ফরম্যাটে ডেটা পাঠানো
echo json_encode($products);

// সংযোগ বন্ধ করা
$conn->close();
?>