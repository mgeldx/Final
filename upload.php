<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve the product details from the form
  $name = $_POST['name'];
  $condition = $_POST['condition'];
  $cda = $_POST['cda'];
  $cda2 = $_POST['cda2'];
  $medicineClass = $_POST['medicine_class'];
  $activeIngredient = $_POST['active_ingredient'];
  $strength = $_POST['strength'];

  // Handle the uploaded image
  $targetDir = "uploads/";  // Directory to save the uploaded images
  $targetFile = $targetDir . basename($_FILES["image"]["name"]);

  if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
    // Image upload success
    // Save the product details and image path to an Access database

    $databaseFile = "products.accdb"; // Path to your Access database file

    // Create a PDO connection to the Access database
    $dsn = "odbc:Driver={Microsoft Access Driver (*.mdb, *.accdb)};Dbq=$databaseFile";
    $pdo = new PDO($dsn);

    // Prepare the SQL statement
    $stmt = $pdo->prepare("INSERT INTO products (name, condition, cda, cda2, medicine_class, active_ingredient, strength, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    // Bind the values to the prepared statement
    $stmt->bindValue(1, $name);
    $stmt->bindValue(2, $condition);
    $stmt->bindValue(3, $cda);
    $stmt->bindValue(4, $cda2);
    $stmt->bindValue(5, $medicineClass);
    $stmt->bindValue(6, $activeIngredient);
    $stmt->bindValue(7, $strength);
    $stmt->bindValue(8, $targetFile);

    // Execute the statement
    if ($stmt->execute()) {
      echo "Product uploaded successfully!";
    } else {
      echo "Failed to upload the product.";
    }

    // Close the statement and connection
    $stmt = null;
    $pdo = null;
  } else {
    echo "Failed to upload the image.";
  }
}
?>

