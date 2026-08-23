<?php
    session_start();
    require_once("db.php");

    // We run this query to get all from the shoe table in the db
    $sql = "SELECT * FROM shoes";
    $result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FootCity</title>
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
        <section class="topPage">
            <h2>Find Your Next Shoe Pair</h2>

            <p>Here you will discover sneakers designed for everyday use.</p>

            <button onclick="gotoShoes()">
                Shop Now!
            </button>
        </section>

        <!-- This section will contain our current shoes from the db -->
        <section class="products" id="shoes">
            <h2>New Releases</h2>


            <div class="shoePage">
                <?php
                    // we loop through each of the shoes from the db
                    while($shoe = $result->fetch_assoc()):
                ?>

                <div class="productTeaser">
                    <!-- Display the shoe img -->
                    <img
                        src="images/<?php echo htmlspecialchars($shoe['shoe_image']); ?>"
                            
                        alt="<?php echo htmlspecialchars($shoe['name']); ?>"
                    >    
                    <div class="productInfo">
                        <!-- Display the shoe brand -->
                        <p class="brand">
                            <?php echo htmlspecialchars($shoe['brand']); ?>
                        </p>

                        <!-- Display the shoe name -->
                        <h3>
                            <?php echo htmlspecialchars($shoe['name']); ?>
                        </h3>

                        <!-- Display the shoe description -->
                        <p class="description">
                            <?php echo htmlspecialchars($shoe['description']); ?>
                        </p>
                        <!-- Here we display the price -->
                        <p class="price">
                            $<?php echo number_format($shoe['price'], 2); ?>
                        </p>

                        <a
                            class="viewShoe"
                            href="shoeProduct.php?id=<?php echo $shoe['shoe_id']; ?>"
                        >
                            View Shoe
                        </a>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
                
        </section>
    </main>

    <script src="js\script.js"></script>
</body>
</html>