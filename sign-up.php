<?php
require "connection.php";

function createUser($username, $password) {
    $conn = connection();
    $password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (username, password)
            VALUES (?, ?)";
    
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ss", $username, $password);
        if ($stmt->execute()) {
            header("location: sign-in.php");
            exit;
        } else {
            die("Error signing up: " . $stmt->error);
        }
        $stmt->close();
    } else {
        die("Error preparing statement: " . $conn->error);
    }
}

if (isset($_POST['btn_sign_up'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password === $confirm_password) {
        createUser($username, $password);
    } else {
        echo "<p class='alert alert-danger'>Password and Confirm Password do not match.</p>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <!-- Boostrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="bg-light">
    <div style="height: 100vh;">
        <div class="row h-100 m-0">
            <div class="card col-3 mx-auto my-auto p-0">
                <div class="card-header text-info py-3">
                    <h1 class="card-title h1 mb-0">Create your account</h1>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label small fw-bold">Username</label>
                            <input type="text" name="username" id="username" class="form-control fw-bold" maxlength="15" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label small fw-bold">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm-password" class="form-label small fw-bold">Confirm Password</label>
                            <input type="password" name="confirm_password" id="confirm-password" class="form-control">
                        </div>
    
                        <button type="submit" class="btn btn-info w-100" name="btn_sign_up">Sign up</button>
                    </form>
    
                    <div class="text-center mt-3">
                        <p class="small">Already have an account? <a href="sign-in.php">Log in.</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>