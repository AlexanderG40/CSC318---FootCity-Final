<?php
    session_start();
    require_once("db.php");

    // check for the ID
    if (isset($_GET['id'])) {
        $shoe_id = $_GET['id'];

        // This query helps us get the specific shoe
        $sql_shoe = "SELECT * FROM shoes WHERE shoe_id = $shoe_id";
        $result = $conn->query($sql_shoe);

        // This is to make sure the shoe was found in the database
        if ($result->num_rows > 0) {
            $shoe =  $result->fetch_assoc();

            // this query is to select the variants of the shoes 
            $sql_variants = "SELECT * FROM shoevariants WHERE shoe_id = $shoe_id AND stock > 0";
            $variants_result = $conn->query($sql_variants);

        } else {
            // end the function from continuting if the shoe is not found
            die("Shoe not found");
        }
    } else {
        // Exit if the user doesnt select a shoe
        die("No shoe was selected");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FootCity</title>
</head>
<body>
    <!-- Reused this header from index -->
    <header>
        <!-- Added this navbar class to help make getting around my page much easier -->
        <nav class="navigationBar">
            <h1 class="logo">FootCity</h1>

            <div class="navigationLink">
                <a href="index.php">Home</a>
                <!-- Since i created a shoes section in my index we can just automatically route to show the shoes -->
                <a href="index.php#shoes">Shoes</a>
                <!-- <a href="cart.php">Cart</a>
                <a href="login.php">Login</a>
                <a href="logout.php">Logout</a> -->
                <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- We show these if the user is logged in -->
                    <a href="cart.php">Cart</a>
                    <a href="#">Hello, <?php echo htmlspecialchars($_SESSION['user_name']); ?></a>
                    <a href="logout.php">Logout</a>
                <?php else: ?>
                    <!-- Show these if the user not logged in -->
                    <a href="login.php">Login</a>
                    <a href="register.php">Register</a>
                <!-- End the if loop -->
                <?php endif; ?>
            </div>
        </nav> 
    </header>

    <main>
        <section class="productPage">
            <div class="productImage">
                <img 
                    src="images/<?php echo htmlspecialchars($shoe['shoe_image']); ?>"
                    alt="<?php echo htmlspecialchars($shoe['name']); ?>"
                    class="largeproductImage"
                >
            </div>

            <div class="productInfo">
                <h2 class="brand"><?php echo htmlspecialchars($shoe['brand']); ?></h2>
                <h1 class="productName"><?php echo htmlspecialchars($shoe['name']); ?></h1>
                <p class="price">$<?php echo number_format($shoe['price'], 2); ?></p>

                <p class="description">
                    <?php echo htmlspecialchars($shoe['description']); ?>
                </p>

                <form action="cart.php" method="POST" class="addtoCart">
                    <label for="variant">Please Select Size & Color:</label>
                    <select name="variant_id" id="variant" required>
                        <option value="" disabled selected>Choose an option</option>
                        <?php 
                            // we loop through the variants 
                            while ($variant = $variants_result->fetch_assoc()):
                        ?>
                            <option value="<?php echo $variant['variant_id']; ?>">
                                Size <?php echo $variant['size']; ?> - <?php echo htmlspecialchars($variant['color']); ?>
                                (<?php echo $variant['stock']; ?> in stock)
                            </option>
                        <?php endwhile; ?>

                    </select> <label for="quantity">Quantity:</label>
                    <input type="number" name="quantity" id="quantity" value="1" min="1" max="5" required>

                    <!-- Finally added this button for the user to submit their product to cart -->
                    <button type="submit" name="addToCart" class="addToCartBtn">
                        Add To Cart
                    </button> 
                </form>
            </div>
        </section>
    </main> 
</body>
</html>