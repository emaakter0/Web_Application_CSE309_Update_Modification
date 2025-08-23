<?php
header('Content-Type: application/json');
include 'db_connect.php';
session_start();

// যদি ব্যবহারকারী লগইন না করে থাকেন, তাহলে এরর মেসেজ পাঠানো
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'User not authenticated']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

$userId = $_SESSION['user_id'];
$productId = isset($data['productId']) ? intval($data['productId']) : 0;
$quantity = isset($data['quantity']) ? intval($data['quantity']) : 1;

if ($productId > 0) {
    // আগের কার্ট আইটেমগুলো মুছে ফেলা
    $deleteStmt = $conn->prepare("DELETE FROM cart_items WHERE user_id = ?");
    $deleteStmt->bind_param("i", $userId);
    $deleteStmt->execute();
    $deleteStmt->close();

    // নতুন "Buy Now" আইটেমটি কার্টে যুক্ত করা
    $insertStmt = $conn->prepare("INSERT INTO cart_items (user_id, product_id, quantity) VALUES (?, ?, ?)");
    $insertStmt->bind_param("iii", $userId, $productId, $quantity);
    if ($insertStmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Product ready for checkout.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add product for checkout.']);
    }
    $insertStmt->close();
} else {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid product ID']);
}

$conn->close();
?>