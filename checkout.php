<?php
    session_start();
    require_once("db.php");

    // We boot out anyone wo isnt logged in to the login page
    if (!isset($_SESSION['user_id'])){
        header("Location: login.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $order_success = false;

    // This is for the mock payment
    if (isset($_POST['processCheckout'])){
        // Since its a mock payment we just clear the cart when the order completets
        $clear_cart_query = "DELETE FROM shoppingcartitems WHERE user_id = $user_id";
        if ($conn->query($clear_cart_query) === TRUE){
            $order_success = true;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - FootCity</title>
    <link rel="stylesheet" href="main.css">
    <!-- Add some internal styles for the checkout form -->
    <style>
        .checkoutForm { max-width: 400px; margin: 0 auto; display: flex; flex-direction: column; gap: 15px; }
        .successMessage{ text-align: center; color: green; margin-top: 50px; }
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
                <a href="#">Hello, <?php echo htmlspecialchars($_SESSION['user_name']); ?></a>
                <a href="logout.php">Logout</a>
            </div>
        </nav>
    </header>

    <main>
        <section class="checkoutPage">
            <!-- I added a php if else statement incase the order is successful or the order has not been processed yet -->
            <?php if ($order_success): ?>
                <!-- If the order was correctly processed we say a thank you  -->
                <div class="successMessage">
                    <h2>Thank you for your order!</h2>
                    <p>Your payment was successful and we are currently preparing your shoes!</p>
                    <a href="index.php" class="authenticationBtn" style="display: inline-block; margin-top: 20px; text-decoration: none;">Return to Main Page</a>

                </div>
            <?php else: ?>
                <!-- Order has not been proceesed we show the payment form -->
                <h2 style="text-align: center;">Secure Checkout</h2>

                <form action="checkout.php" method="POST" class="checkoutForm">
                    <label for="nameOnCCard">Name on Card:</label>
                    <input type="text" name="nameOnCCard" id="nameOnCCard" required placeholder="Please type in the full name..." value="<?php echo htmlspecialchars($_SESSION['user_name']); ?>">
                    <!-- We added this so the user can add their fake data for when they checkout -->
                    <label for="ccardNumber">Card Number:</label>
                    <input type="text" name="ccardNumber" id="ccardNumber" required placeholder="Please type in your Credit Card Number as it appears on the back" maxlength="19">

                    <!-- Now we added the expiration date -->
                    <label for="expirationDate">Expiration Date:</label>
                    <input type="text" name="expirationDate" id="expirationDate" required placeholder="MM/YY" maxlength="5">

                    <!-- Here they add the cvv -->
                    <label for="cvv">CVV:</label>
                    <input type="text" name="cvv" id="cvv" required placeholder="123" maxlength="3">
                    <!-- We finally added a submit button for the payment -->
                    <button type="submit" name="processCheckout" class="authenticationBtn">Pay Now!</button>
                </form>
                <!-- We end the if statement -->
            <?php endif; ?>
        </section>
    </main>
    <script src="js/script.js"></script>
</body>
</html>