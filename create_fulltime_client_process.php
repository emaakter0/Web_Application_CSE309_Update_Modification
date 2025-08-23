<?php
include 'db_connect.php';
session_start();

// শুধুমাত্র ফুল-টাইম ক্লায়েন্টই এই পেজটি অ্যাক্সেস করতে পারবে
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'fulltime_client') {
    header("Location: login.php");
    exit;
}

// ক্লায়েন্টের তথ্য ডেটাবেস থেকে পড়া (Read Operation)
$user_id = $_SESSION['user_id'];
$user_sql = "SELECT username, email, phone FROM users WHERE id = ?";
$user_stmt = $conn->prepare($user_sql);
$user_stmt->bind_param("i", $user_id);
$user_stmt->execute();
$user_result = $user_stmt->get_result();
$client = $user_result->fetch_assoc();

// পোষা প্রাণীর তথ্য ডেটাবেস থেকে পড়া (Read Operation)
$pet_sql = "SELECT * FROM pets WHERE user_id = ?";
$pet_stmt = $conn->prepare($pet_sql);
$pet_stmt->bind_param("i", $user_id);
$pet_stmt->execute();
$pet_result = $pet_stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Full-time Client Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Welcome, <?php echo htmlspecialchars($client['username']); ?></h1>
    </header>
    <main class="dashboard-content">
        <h2>Your Profile</h2>
        <div class="profile-info">
            <p><strong>Username:</strong> <?php echo htmlspecialchars($client['username']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($client['email']); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($client['phone']); ?></p>
        </div>

        <hr>

        <h2>Your Pets</h2>
        <?php if ($pet_result->num_rows > 0) { ?>
            <div class="pet-cards-container">
                <?php while ($pet = $pet_result->fetch_assoc()) { ?>
                    <div class="pet-card">
                        <h3><?php echo htmlspecialchars($pet['pet_name']); ?></h3>
                        <p><strong>Species:</strong> <?php echo htmlspecialchars($pet['species']); ?></p>
                        <p><strong>Breed:</strong> <?php echo htmlspecialchars($pet['breed']); ?></p>
                        <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($pet['dob']); ?></p>
                        <!-- এখানে অন্যান্য অপশন যুক্ত করা হবে, যেমন মেডিকেল হিস্টরি দেখা -->
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <p>No pets found. Please contact the administrator to add a pet.</p>
        <?php } ?>
        
    </main>
    <footer>
        <a href="logout.php">Logout</a>
    </footer>
</body>
</html>

<?php
$user_stmt->close();
$pet_stmt->close();
$conn->close();
?>
