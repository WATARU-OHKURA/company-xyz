<?php
session_start();

if (!$_SESSION['user_id']) {
    header("location: sign-out.php");
    exit;
}

require "connection.php";

function getAllItems() {
    $conn = connection();
    $sql = "SELECT items.id AS id,
                   item_name,
                   item_price,
                   quantity,
                   sections.name AS section,
                   users.username AS username
            FROM items
            INNER JOIN sections ON items.section_id = sections.id
            INNER JOIN users ON items.user_id = users.id
            ORDER BY items.id DESC";
    
    if ($result = $conn->query($sql)) {
        return $result;
    } else {
        die("Error retrieving all items: " . $conn->error);
    }
}

function countItems() {
    $conn = connection();
    $sql = "SELECT COUNT(*) as total
            FROM items";

    if ($result = $conn->query($sql)) {
        return $result->fetch_assoc()['total'];
    } else {
        die("Error counting items: " . $conn->error);
    }
}

function sumQuantity() {
    $conn = connection();
    $sql = "SELECT SUM(quantity) as sum_quantity
            FROM items";

    if ($result = $conn->query($sql)) {
        return $result->fetch_assoc()['sum_quantity'];
    } else {
        die("Error counting items: " . $conn->error);
    }
}

$numberOfItems = countItems();
$sumQuantity = sumQuantity();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item List</title>

    <!-- Boostrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <?php
        include 'main-nav.php';
    ?>

    <main class="container">
        <div class="row mb-4">
            <div class="col mb-2">
                <h2 class="fw-light">Item List</h2>
            </div>
            <div class="mb-0">
                <P class="fw-light">Total Items: <?=  $numberOfItems ?></P>
            </div>
            <div class="mb-0">
                <P class="fw-light">Total Quantity: <?=  $sumQuantity ?></P>
            </div>


            <table class="table table-hover align-middle border">
                <thead class="small table-light">
                    <th>#</th>
                    <th>Item Name</th>
                    <th>Item Price</th>
                    <th>Quantity</th>
                    <th>Section</th>
                    <th>Username</th>
                    <th style="width: 95px;"></th>
                </thead>
                <tbody>
                    <?php
                        $all_items = getAllItems();
                        while ($item = $all_items->fetch_assoc()) {
                    ?>
                        <tr>
                            <td><?= $item['id'] ?></td>
                            <td><?= $item['item_name'] ?></td>
                            <td><?= $item['item_price'] ?></td>
                            <td><?= $item['quantity'] ?></td>
                            <td><?= $item['section'] ?></td>
                            <td><?= $item['username'] ?></td>
                            <td>
                                <a href="edit-item.php?id=<?= $item['id'] ?>" class="btn btn-outline-secondary btn-sm">
                                    <i class="fa-solid fa-pencil-alt"></i>
                                </a>
                                <a href="delete-item.php?id=<?= $item['id'] ?>" class="btn btn-outline-danger btn-sm">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </td>
                        </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
            <div class="col text-end">
                <a href="add-items.php" class="btn btn-info text-light">
                    <i class="fa-solid fa-plus-circle"></i>Add New Item
                </a>
            </div>
        </div>
    </main>
</body>
</html>