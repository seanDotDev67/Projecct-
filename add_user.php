<?php
require_once "pdo.php";

$errors = [];
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") { 
    $id       = trim($_POST['id'] ?? '');
    $f_name   = trim($_POST['f_name'] ?? '');
    $l_name   = trim($_POST['l_name'] ?? '');
    $mi       = trim($_POST['mi'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($f_name) || empty($l_name) || empty($mi) || empty($username) || empty($email) || empty($password)) {
        $errors[] = "Please fill in all required fields.";
    }

    if (strlen($f_name) < 2 || strlen($l_name) < 2) {
        $errors[] = "First and last name must be at least 2 characters long.";
    }

    if (strlen($mi) > 2) {
        $errors[] = "Middle initial should be 1 to 2 characters.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }

    if (strlen($username) < 3) {
        $errors[] = "Username must be at least 3 characters long.";
    }

    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long.";
    }

    if (empty($errors)) {
        try { 
            $sqlCheck  = "SELECT id FROM users WHERE username = :username OR email = :email";
            $stmtCheck = $pdo->prepare($sqlCheck);
            $stmtCheck->execute([
                ':username' => $username,
                ':email'    => $email
            ]);

            if ($stmtCheck->fetch()) {
                $errors[] = "Username or email is already registered.";
            } else { 
                $sqlInsert  = "INSERT INTO users (id, f_name, l_name, m, username, email, password) 
                               VALUES (:id,:f_name, :l_name, :mi, :username, :email, :password)";
                $stmtInsert = $pdo->prepare($sqlInsert);

                $stmtInsert->execute([
                    'id' => $id,
                    ':f_name'   => $f_name,
                    ':l_name'   => $l_name,
                    ':mi'       => $mi,
                    ':username' => $username,
                    ':email'    => $email,
                    ':password' => $password
                ]);

                $success = "User registered successfully!";
                
                $f_name = $l_name = $mi = $username = $email = "";
            }
        } catch (PDOException $e) {
            $errors[] = "Database error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add a User</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto Mono', monospace;
            background-color: #f4f6f9;
        }
    </style>
</head>
<body class="py-5">
    <div class="container">
        <div class="row justify-content::center">
            <div class="col-md-8 col-lg-6 mx-auto">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body p-4">
                        <h2 class="text-center mb-4">Add User</h2>

                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0 ps-3">
                                    <?php foreach ($errors as $error): ?>
                                        <li><?php echo htmlspecialchars($error); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($success)): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?php echo htmlspecialchars($success); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <form action="" method="POST">
                            <div class="row g-2 mb-3">
                                <div class="col-md-2">
                                    <label for="f_name" class="form-label">User ID</label>
                                    <input type="text" name="id" id="id" class="form-class form-control" value="<?php echo htmlspecialchars($id ?? ''); ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="f_name" class="form-label">First Name</label>
                                    <input type="text" name="f_name" id="f_name" class="form-class form-control" value="<?php echo htmlspecialchars($f_name ?? ''); ?>">
                                </div>
                                <div class="col-md-2">
                                    <label for="mi" class="form-label">M.I.</label>
                                    <input type="text" name="mi" id="mi" class="form-control" maxlength="2" value="<?php echo htmlspecialchars($mi ?? ''); ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="l_name" class="form-label">Last Name</label>
                                    <input type="text" name="l_name" id="l_name" class="form-control" value="<?php echo htmlspecialchars($l_name ?? ''); ?>">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" name="username" id="username" class="form-control" value="<?php echo htmlspecialchars($username ?? ''); ?>">
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" name="email" id="email" class="form-control" value="<?php echo htmlspecialchars($email ?? ''); ?>">
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-dark btn-lg">Add User</button>
                                <a href="customer.php" class="btn btn-outline-secondary">View Customer List</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>