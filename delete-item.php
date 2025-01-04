<?php
session_start();

require "connection.php";

$id = $_GET['id'];
$item = getItem($id);

function getItem($id) {
    $conn = connection();
    $sql = "SELECT * FROM items WHERE id = $id";

    if ($result = $conn->query($sql)) {
        return $result->fetch_assoc();
    } else {
        die("Error retrieving the product: " . $conn->error);
    }
}

function deleteItem($id) {
    $conn = connection();
    $sql = "DELETE FROM items WHERE id = $id";

    if ($conn->query($sql)) {
        header("location: view-items.php");
        exit;
    } else {
        die("Error deleteing the item " . $conn->error);
    }
}

if (isset($_POST['btn_delete'])) {
    deleteItem($id);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Product</title>

    <!-- Boostrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <?php
        include "main-nav.php";
    ?>
    
    <main class="container">
        <div class="row justify-content-center">
            <div class="col-3">
                <div class="text-center mb-4">
                    <i class="fa-solid fa-triangle-exclamation text-warning display-4"></i>
                    <h2 class="fw-light mb-3 text-danger">Delete Item</h2>
                    <p class="fw-bold mb-0">Are you sure you want to delete "<?= $item['item_name'] ?>"</p>
                </div>
                <div class="row">
                    <div class="col">
                        <a href="view-items.php" class="btn btn-secondary w-100">Cancel</a>
                    </div>
                    <div class="col">
                        <form action="" method="POST">
                            <button type="submit" class="btn btn-outline-danger w-100" name="btn_delete">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>


</body>
</html>