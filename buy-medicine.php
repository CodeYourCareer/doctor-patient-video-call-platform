<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "medc"; 

$conn = new mysqli($servername, $username, $password, $dbname);

// Handle search request
$search_query = '';
$medicines = [];
if (isset($_GET['search'])) {
$search_query = $conn->real_escape_string($_GET['search']);
$query = "SELECT * FROM medicines WHERE name LIKE '%$search_query%'";
} else {
$query = "SELECT * FROM medicines";
}
$result = $conn->query($query);

if ($result->num_rows > 0) {
$medicines = $result->fetch_all(MYSQLI_ASSOC);
}

// Handle purchase request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$medicine_id = intval($_POST['medicine_id']);
$quantity = intval($_POST['quantity']);

// Get medicine details
$medicine_query = $conn->query("SELECT * FROM medicines WHERE medicine_id = $medicine_id");
if ($medicine_query->num_rows > 0) {
$medicine = $medicine_query->fetch_assoc();

if ($medicine['stock'] >= $quantity) {
// Update stock
$new_stock = $medicine['stock'] - $quantity;
$conn->query("UPDATE medicines SET stock = $new_stock WHERE medicine_id = $medicine_id");

// Display success message
echo "<script>
alert('Purchase successful!');
</script>";
} else {
// Display error if insufficient stock
echo "<script>
alert('Insufficient stock for the selected medicine.');
</script>";
}
}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Medicines</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background-color: #1d2b3a;
        color: #fff;
    }

    .container {
        margin-top: 50px;
    }

    .medicine-card {
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 20px;
        background-color: rgb(17, 26, 36);
    }

    .medicine-card h5 {
        color: #17a2b8;
    }

    .btn-buy {
        background-color: #28a745;
        color: #fff;
        border: none;
        padding: 10px 15px;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .btn-buy:hover {
        background-color: #218838;
    }
    </style>
</head>

<body>
    <div class="container">
        <h3 class="mb-4 text-center">Search and Buy Medicines</h3>

        <!-- Search Form -->
        <form method="GET" action="" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search for a medicine"
                    value="<?php echo htmlspecialchars($search_query); ?>">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>

        <!-- Medicine List -->
        <div class="row">
            <?php if (count($medicines) > 0): ?>
            <?php foreach ($medicines as $medicine): ?>
            <div class="col-md-4">
                <div class="medicine-card">
                    <h5><?php echo htmlspecialchars($medicine['name']); ?></h5>
                    <p><?php echo htmlspecialchars($medicine['description']); ?></p>
                    <p>Price: ₹<?php echo htmlspecialchars($medicine['price']); ?></p>
                    <p>Stock: <?php echo htmlspecialchars($medicine['stock']); ?></p>
                    <form method="POST" action="">
                        <input type="hidden" name="medicine_id" value="<?php echo $medicine['medicine_id']; ?>">
                        <div class="input-group mb-3">
                            <input type="number" name="quantity" class="form-control" placeholder="Quantity" required
                                min="1" max="<?php echo $medicine['stock']; ?>">
                            <button type="submit" class="btn-buy">Buy Now</button>
                        </div>
                    </form>
                </div>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <p class="text-center">No medicines found.</p>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>