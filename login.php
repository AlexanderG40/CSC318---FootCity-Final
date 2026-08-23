<?php
    // start the session and also connect to the database
    session_start();
    require_once("db.php");

    $error_message = "";

    // Check if the login form was submitted
    if (isset($_POST['login_user'])){
        // Get the data straight from the form
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Find the user by their email
        $sql_check = "SELECT * FROM users WHERE email = '$email'";
        $result =  $conn->query($sql_check);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // this verifies that the typed password matches the hashed password in the db
            if(password_verify($password, $user['password_hash'])) {
                // Log the user in by storing their Id and name 
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['user_name'] = $user['name'];
                
                // redirect the user back to the homepage so they can start shopping
                header("Location: index.php");
                exit();
            } else {
                $error_message = "Incorrect password";
            }
        } else {
            $error_message = "No account found with this email address";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - FootCity</title>
    <link rel="stylesheet" href="main.css">
    <style>
        /* Styles the error message  */
        .error { color: red; margin-bottom: 15px; font-weight: bold;}
    </style>
</head>
<body>
    <header>
        <!-- Added this navbar class to help make getting around my page much easier -->
        <nav class="navigationBar">
            <h1 class="logo">FootCity</h1>

            <div class="navigationLink">
                <a href="index.php">Home</a>
                <!-- Since i created a shoes section in my index we can just automatically route to show the shoes -->
                <a href="index.php#shoes">Shoes</a>
                <a href="cart.php">Cart</a>
                <a href="login.php">Login</a>
            </div>
        </nav>
    </header>

    <main>
        <section class="authenticationPage">
            <div class="loginSection">
                <h2>Welcome Back to FootCity</h2>
                <p>Please log in to view your cart and checkout</p>
                
                <form action="login.php" method="POST" class="authenticationForm">
                    <?php if ($error_message != ""): ?>
                        <p class="error"><?php echo $error_message; ?></p>
                    <?php endif; ?>

                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" required placeholder="Enter your email">

                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" required placeholder="Create a password">

                    <button type="submit" name="login_user" class="authenticationBtn">Log In</button>
                </form>

                <p class="authenticationToggle">
                    Don't have a account? <a href="register.php">Create an account today!</a>
                </p>
            </div>
        </section> 
    </main>
    <script src="js\script.js"></script>
</body>
</html>