<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fred_chicken_business";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create tables if they don't exist
$sql = "CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    subject VARCHAR(100),
    message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) !== TRUE) {
    echo "Error creating table: " . $conn->error;
}

$sql = "CREATE TABLE IF NOT EXISTS newsletter (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) UNIQUE NOT NULL,
    subscribed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) !== TRUE) {
    echo "Error creating table: " . $conn->error;
}

$sql = "CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(100) NOT NULL,
    customer_email VARCHAR(100) NOT NULL,
    customer_phone VARCHAR(20) NOT NULL,
    product_name VARCHAR(200) NOT NULL,
    quantity INT NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    payment_method VARCHAR(50) NOT NULL,
    delivery_address TEXT,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(50) DEFAULT 'Pending'
)";

if ($conn->query($sql) !== TRUE) {
    echo "Error creating table: " . $conn->error;
}

$sql = "CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    category VARCHAR(50) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    old_price DECIMAL(10,2),
    image VARCHAR(255),
    badge VARCHAR(50),
    is_featured BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) !== TRUE) {
    echo "Error creating table: " . $conn->error;
}

// Insert sample products if table is empty
$result = $conn->query("SELECT COUNT(*) as count FROM products");
$row = $result->fetch_assoc();

if ($row['count'] == 0) {
    $sample_products = [
        ["Fresh Whole Chicken", "chicken", "Locally raised, free-range chicken. Processed fresh daily and delivered to your doorstep.", 6500, 7500, "fresh.jpeg", "Best Seller", 1],
        ["Premium Farm Eggs (30 pcs)", "eggs", "Nutritious eggs from free-range chickens. Rich in protein and essential nutrients.", 3200, NULL, "premium.jpeg", "Fresh", 1],
        ["Automatic Chicken Feeder", "machines", "Modern automatic feeder for 50-100 chickens. Saves time and reduces feed waste.", 120000, NULL, "feed.jpeg", NULL, 1],
        ["Chicken Parts Pack", "chicken", "Fresh chicken parts packaged for convenience. Perfect for specific recipes.", 4500, 5500, "parts.jpeg", NULL, 1],
        ["Small Chicken Incubator", "machines", "Compact incubator for 50-100 eggs. Automatic temperature and humidity control.", 450000, NULL, "incubator.jpeg", "New", 1],
        ["Poultry Feed (25kg)", "accessories", "High-quality poultry feed with essential nutrients for optimal growth.", 18000, NULL, "color.jpeg", NULL, 1]
    ];
    
    $stmt = $conn->prepare("INSERT INTO products (name, category, description, price, old_price, image, badge, is_featured) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssdissi", $name, $category, $description, $price, $old_price, $image, $badge, $is_featured);
    
    foreach ($sample_products as $product) {
        $name = $product[0];
        $category = $product[1];
        $description = $product[2];
        $price = $product[3];
        $old_price = $product[4];
        $image = $product[5];
        $badge = $product[6];
        $is_featured = $product[7];
        $stmt->execute();
    }
    $stmt->close();
}
?>