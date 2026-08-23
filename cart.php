<?php
    session_start();
    require_once("db.php");


    // if the user is not logged in we return to the login page
    if (!isset($_SESSION['user_id'])){
        header("Location: login.php");
        exit();
    }

    // get the user id
    $user_id = $_SESSION['user_id'];

    if (isset($_POST['addToCart'])){
        $variant_id = $_POST['variant_id'];
        $quantity = $_POST['quantity'];

        $check_query = "SELECT * FROM shoppingcartitems WHERE user_id = $user_id AND variant_id = $variant_id";
        $check_result = $conn->query($check_query);

        if ($check_result->num_rows > 0){
            // if the same variant of shoes exists in the cart we update the quntity
            $existing_item = $check_result->fetch_assoc();
            $new_quantity = $existing_item['quantity'] + $quantity;

            $update_query = "UPDATE shoppingcartitems SET quantity = $new_quantity WHERE user_id = $user_id AND variant_id = $variant_id";
            $conn->query($update_query);
        } else {
            // If its a new item we insert a new row
            $insert_query = "INSERT INTO shoppingcartitems (user_id, variant_id, quantity) VALUES ($user_id, $variant_id, $quantity)";
            $conn->query($insert_query);
        }
        // This just refreshes the page so the user doesnt accidentally submit it twice 
        header("Location: cart.php");
        exit();
    }

    // We fetch the cart
    $cart_query = "
        SELECT
            cart.quantity,
            variant.size, variant.color,
            shoe.name, shoe.brand, shoe.price, shoe.shoe_image
        FROM shoppingcartitems cart
        JOIN shoevariants variant ON cart.variant_id = variant.variant_id
        JOIN shoes shoe ON variant.shoe_id = shoe.shoe_id
        WHERE cart.user_id = $user_id
    ";

    $cart_items = $conn->query($cart_query);
    $cart_total = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart - FootCity</title>
    <link rel="stylesheet" href="main.css">
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
                <!-- Here we display the users name if they are logged in -->
                <a href="#">Hello, <?php echo htmlspecialchars($_SESSION['user_name']); ?></a>
                <a href="logout.php">Logout</a>
            </div>
        </nav>
    </header>

    <main>
        <section class="cartPage">
            <h2>Your shopping cart</h2>

            <div class="cartContent">
                <?php if ($cart_items->num_rows > 0): ?>
                    <table class="cartTable">
                        <thead>
                            <tr>
                                <th>Products</th>
                                <th>Details</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($item = $cart_items->fetch_assoc()): ?>
                                <?php
                                    // Calculate the subtotal for this specific row
                                    $item_subtotal = $item['price'] * $item['quantity'];
                                    // Add it to the grand total
                                    $cart_total += $item_subtotal;
                            ?>
                            <tr>
                                <td>
                                    <img src="images/<?php echo htmlspecialchars($item['shoe_image']); ?>" alt="Shoe" width="80">
                                </td>
                            <td>
                                <!-- I used the strong element since i really want the user to be able to see the brand of the shoe it makes it nike and bold-->
                                <!-- We also use the . to join strings such as the brand and name -->
                                <!-- the quotes help us not smash text together -->
                                <strong><?php echo htmlspecialchars($item['brand'] . " " . $item['name']); ?></strong><br>
                                Size: <?php echo htmlspecialchars($item['size']); ?><br>
                                Color: <?php echo htmlspecialchars($item['color']); ?>
                            </td>
                            <!-- This first displays the price, then the quantity of said shoe and finally the subtotal -->
                            <td>$<?php echo number_format($item['price'], 2); ?></td>
                            <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                            <td>$<?php echo number_format($item_subtotal, 2); ?></td>
                          </tr>
                          <!-- We use the endwhile to end the loop -->
                        <?php endwhile; ?>
                    </tbody>
                    </table>

                    <div class="cartSummary">
                        <h3>Total: $<?php echo number_format($cart_total, 2); ?></h3>
                        <a href="checkout.php" class="checkoutBtn" style="display: inline-block; text-align: center; text-decoration: none;">Proceed to Checkout</a>
                    </div>

                <?php else: ?>
                    <p>Your cart is currently empty. <a href="index.php#shoes">Find our shoes!</a></p>
                <?php endif; ?>
                    
            </div>
        </section>
    </main>
    <script src="js/script.js"></script>
</body>
</html>