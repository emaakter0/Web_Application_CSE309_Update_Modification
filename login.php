<?php
session_start();
require("db.php");

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Basic validation
    if (empty($username) || empty($password)) {
        $error = "Both username and password are required!";
    } else {
        // Query the database
        $sql = "SELECT * FROM users WHERE `username` = '$username' AND `password` = '$password'";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            
            // Check if user is approved (approved = 1)
            if ($user['approved'] != 1) {
                $error = "Your account is pending approval. Please contact the administrator.";
            } else {
                // Login successful
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['loggedin'] = true;
                
                // Redirect to home page or intended URL
                header("Location: index.php");
                exit();
            }
        } else {
            $error = "Invalid username or password!";
        }
    }
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | KittyPups</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .error-message {
            color: red;
            margin-bottom: 15px;
            
        }

        .abc{
            color:#eb1f48 !important;
            text-decoration : none !important;
                   
        }


    </style>
</head>
<body>
    <main>
        <section class="auth-container">
            <div class="auth-form-container">
                <h2>Welcome Back!</h2>
                
                <?php if (!empty($error)): ?>
                    <div class="error-message"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <form method="post" action="">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" placeholder="Enter your username" required
                               value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                    </div>
                    <div class="form-group password-container">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                        <i class="fa-solid fa-eye" id="togglePassword"></i>
                    </div>
                    
                    <button type="submit" class="btn-submit">Login</button>
                </form>

               <a href="index.php" class="abc">Go to Home</a>
                
            </div>
            
        </section>
    </main>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');

        if (togglePassword) {
            togglePassword.addEventListener('click', function (e) {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                this.classList.toggle('fa-eye-slash');
            });
        }
    </script>
</body>
</html>