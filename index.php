<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Project/PHP/PHPProject.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
include __DIR__ . "/db.php";

/* ---------- INSERT ---------- */
if (isset($_POST['add'])) {
    $name = $_POST['food_name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    $sql = "INSERT INTO foods (food_name, price, quantity)
            VALUES ('$name', '$price', '$quantity')";
    $conn->query($sql);

    header("Location: index.php");
    exit();
}

/* ---------- DELETE ---------- */
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $sql = "DELETE FROM foods WHERE id=$id";
    $conn->query($sql);

    header("Location: index.php");
    exit();
}

/* ---------- EDIT (GET DATA) ---------- */
$editMode = false;
$editData = null;

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];

    $result = $conn->query("SELECT * FROM foods WHERE id=$id");
    $editData = $result->fetch_assoc();
    $editMode = true;
}

/* ---------- UPDATE ---------- */
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['food_name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    $sql = "UPDATE foods
            SET food_name='$name', price='$price', quantity='$quantity'
            WHERE id=$id";
    $conn->query($sql);

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Food Store</title>
</head>
<body>

<h2>Food Store</h2>

<form method="post" action="">
<?php if ($editMode) { ?>
    <input type="hidden" name="id" value="<?php echo $editData['id']; ?>">
<?php } ?>

<label>Food Name:</label><br>
<input type="text" name="food_name"
value="<?php echo $editMode ? $editData['food_name'] : ''; ?>" required><br><br>

<label>Price:</label><br>
<input type="number" step="0.01" name="price"
value="<?php echo $editMode ? $editData['price'] : ''; ?>" required><br><br>

<label>Quantity:</label><br>
<input type="number" name="quantity"
value="<?php echo $editMode ? $editData['quantity'] : ''; ?>" required><br><br>

<?php if ($editMode) { ?>
    <input type="submit" name="update" value="Update Food">
<?php } else { ?>
    <input type="submit" name="add" value="Add Food">
<?php } ?>
</form>

<br><hr><br>

<h3>Available food</h3>

<table border="1" cellpadding="10">
<tr>
<th>ID</th>
<th>Name</th>
<th>Price</th>
<th>Quantity</th>
<th>Actions</th>
</tr>

<?php
$result = $conn->query("SELECT * FROM foods");

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . $row['food_name'] . "</td>";
    echo "<td>" . $row['price'] . "</td>";
    echo "<td>" . $row['quantity'] . "</td>";
    echo "<td>
        <a href='index.php?edit=" . $row['id'] . "'>Edit</a> |
        <a href='index.php?delete=" . $row['id'] . "' onclick=\"return confirm('Delete this item?')\">Delete</a>
    </td>";
    echo "</tr>";
}
?>

</table>

    </body>
</html>
