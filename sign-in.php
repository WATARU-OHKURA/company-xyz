<?php
require "connection.php";

function  login($username, $password) {
    $conn = connection();
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows >= 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            session_start();

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            header("location: view-items.php");
            exit;
        } else {
            echo "<div class='alert alert-danger'>Incorrect password</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Username not found.</div>";
    }

    $stmt->close();
    $conn->close();
}

if (isset($_POST['btn_log_in'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    login($username, $password);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in</title>
    <!-- Boostrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="bg-light">
    <div style="height: 100vh;">
        <div class="row h-100 m-0">
            <div class="card col-3 mx-auto my-auto p-0">
                <div class="card-header text-info py-3 text-center">
                    <h1 class="card-title h1 mb-0">Company XYZ</h1>
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
                        <button type="submit" class="btn btn-info w-100" name="btn_log_in">Log in</button>
                    </form>
    
                    <div class="text-center mt-3">
                        <p class="small">No account yet? <a href="sign-up.php">Create Account.</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>