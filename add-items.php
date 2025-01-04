<?php
session_start();

require "connection.php";

function getAllSections() {
    $conn = connection();
    $sql = "SELECT * FROM sections";
    
    if ($result = $conn->query($sql)) {
        return $result;
    } else {
        die("Error retrieving all sections: " . $conn->error);
    }
}

function addItem($item_name, $item_price, $quantity, $section_id, $user_id) {
    $conn = connection();
    $sql = "INSERT INTO items (item_name, item_price, quantity, section_id, user_id)
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("siiii", $item_name, $item_price, $quantity, $section_id, $user_id);
        if ($stmt->execute()) {
            header("location: view-items.php");
            exit;
        } else {
            die("Error adding a new item: " . $stmt->error);
        }
    } else {
        die("Error preparing statemant: " . $conn->error);
    }
}

if (isset($_POST['btn_add'])) {
    $item_name = $_POST['name'];
    $item_price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $section_id = $_POST['section_id'];
    $user_id = $_SESSION['user_id'];

    addItem($item_name, $item_price, $quantity, $section_id, $user_id);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Item</title>

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
        <div class="card mx-auto" style="width: 25rem;">
            <div class="card-header bg-info text-white text-center">
                <h2 class="fw-light">New Product</h2>
            </div>
            <div class="card-body">
                <form action="" method="POST">
                    <div class="mb-3">
                        <lable class="form-lable">Item Name</lable>
                        <input type="text" name="name" id="name" class="form-control mt-2" maxlength="50" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label fw-bodl">Item Price</label>
                        <div class="input-group">
                            <div class="input-group-text">$</div>
                            <input type="number" name="price" id="price" class="form-control" min="0" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label fw-bodl">Quantity</label>
                        <input type="number" name="quantity" id="quantity" class="form-control" min="1" required>
                    </div>

                    <div class="mb-4">
                        <label for="section-id" class="form-label small fw-bold">Section</label>
                        <select name="section_id" id="section-id" class="form-select" required>
                            <option value="" hidden>Select Section</option>
                            <?php
                                $all_sections = getAllSections();
                            ?>
                            <?php
                                while ($section = $all_sections->fetch_assoc()) {
                            ?>
                                <option value="<?= $section['id'] ?>"><?= $section['name'] ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
    
                    <a href="view-items.php" class="btn btn-outline-info">Cancel</a>
                    <button type="submit" name="btn_add" class="btn btn-info fw-bold px-5 text-white">
                        <i class="fa-solid fa-plus text-white"></i> Add
                    </button>
                </form>
            </div>
            
            </div>
        </div>
    </main>
    
</body>
</html>