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

function createSection($name, $user_id) {
    $conn = connection();
    $sql = "INSERT INTO sections (name, user_id) VALUE ('$name', $user_id)";

    if ($conn->query($sql)) {
        header("refresh: 0");
    } else {
        die("Error adding a new section name: " . $conn->error);
    }
}

function deleteSection($section_id) {
    $conn = connection();
    $sql = "DELETE FROM sections WHERE id = $section_id";

    if ($conn->query($sql)) {
        header("refresh: 0");
    } else {
        die("Error deletiong the section: " . $conn->error);
    }
}

function countSection() {
    $conn = connection();
    $sql = "SELECT COUNT(*) AS total FROM sections";

    if ($result = $conn->query($sql)) {
        return $result->fetch_assoc()['total'];
    } else {
        die("Error counting section: " . $conn->error);
    }
}

if (isset($_POST['btn_add'])) {
    $name = $_POST['name'];
    $user_id = $_SESSION['user_id'];

    createSection($name, $user_id);
}

if (isset($_POST['btn_delete'])) {
    $section_id = $_POST['btn_delete'];

    deleteSection($section_id);
}

$numberOfSection = countSection();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sections</title>

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
                <h2 class="fw-light mb-3">Sections</h2>
                <div class="mb-0">
                    <P class="fw-light">Total Section: <?=  $numberOfSection ?></P>
                </div>

                <!-- form -->
                <div class="mb-3">
                    <form action="" method="POST">
                        <div class="row gx-2">
                            <div class="col">
                                <input type="text" name="name" class="form-control" placeholder="Add a new section here..." maxlength="50" required autofocus>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-info w-100 fw-bold" name="btn_add">
                                    <i class="fa-solid fa-plus"></i> Add
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Table -->
                <table class="table table-sm align-middle text-center">
                    <thead class="table-info">
                        <tr>
                            <th>ID</th>
                            <th>NAME</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $all_sections = getAllSections();

                            while($section = $all_sections->fetch_assoc()) {
                                // fetch_assoc() -----> transform the result into associative array
                                // $section = ["id" => 1, "name" => "snacks", ....]
                        ?>
                            <tr>
                                <td><?= $section['id'] ?></td>
                                <td><?= $section['name'] ?></td>
                                <td>
                                    <form action="" method="POST">
                                        <button type="submit" class="btn btn-outline-danger border-0" name="btn_delete" value="<?= $section['id'] ?>">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php
                            }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>