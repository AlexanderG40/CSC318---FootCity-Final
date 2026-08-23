<?php 
    session_start();
    require_once("db.php");

    $error_message = "";

    // I check to see if the registration form was submitted
    if (isset($_POST['register_user'])) {
        // Get the data straight from the form
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Check if the email is already in the db
        $check_email = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($check_email);

        if ($result->num_rows > 0){
            $error_message = "An account with this email already exists";
        } else {
            // Hash the password before we save it to the database this will help prevent
            // bad actors from accessing accounts
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // I instert the new user into the databse
            $sql_insert = "INSERT INTO users (name, email, password_hash) VALUES ('$name', '$email', '$hashed_password')";

            if ($conn->query($sql_insert) === TRUE){
                // redirect the user to the login so they can sign in
                header("Location: login.php");
                exit();
            } else{
                $error_message = "Error creating account: " . $conn->error;
            }
        }

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create an Account - FootCity</title>
    <link rel="stylesheet" href="main.css">
    <style>
        /* Styles the error message  */
        .error { color: red; margin-bottom: 15px; font-weight: bold;}
    </style>
</head>
<body>
    <header>
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
                <h2>Create an Account</h2>
                <p> Join FootCity today, to start adding shoes to your shopping cart</p>
                
                <form action="register.php" method="POST" class="authenticationForm">
                    <?php if ($error_message != ""): ?>
                        <p class="error"><?php echo $error_message; ?></p>
                    <?php endif; ?>
                    
                    <label for="name">Full Name:</label>
                    <input type="text" name="name" id="name" required placeholder="Enter your full name">

                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" required placeholder="Enter your email">

                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" required placeholder="Create a password">

                    <button type="submit" name="register_user" class="authenticationBtn">Register</button>
                </form>

                <p class="authenticationToggle">
                    Already have a account? <a href="login.php">Log in here</a>
                </p>
            </div>
        </section>
    </main>

    <script src="js\script.js"></script>
</body>
</html>