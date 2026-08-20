<?php
    require 'pdo.php';

    if (!isset($_GET['id']) || empty($_GET['id'])) {
        header("Location: customer.php");
        exit();
    }

    $id = $_GET['id'];

    $sql = "SELECT f_name, l_name, m, username, email, password FROM users WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        header("Location: customer.php?error=1");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Customer</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts --> 
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            font-family: 'Roboto Mono', monospace;
            background-color: #f4f6f9;
        }
    </style>
</head>
<body class="p-4">

    <div class="container" style="max-width: 600px;">
        <div class="card shadow-sm rounded border-0">
            <div class="card-header bg-dark text-white">
                <h3 class="mb-0 fs-5">UPDATE CUSTOMER DETAILS</h3>
            </div>
            <div class="card-body p-4">
                <form action="update_process.php" method="POST">
                    <!-- Send ID secretly to the process file -->
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

                    <div class="row mb-3">
                        <div class="col-md-5">
                            <label class="form-label">First Name</label>
                            <input type="text" name="f_name" class="form-control" value="<?php echo htmlspecialchars($user['f_name']); ?>" required>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="l_name" class="form-control" value="<?php echo htmlspecialchars($user['l_name']); ?>" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">M.I.</label>
                            <input type="text" name="m" class="form-control" maxlength="1" value="<?php echo htmlspecialchars($user['m']); ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Password</label>
                        <input type="text" name="password" class="form-control" value="<?php echo htmlspecialchars($user['password']); ?>" required>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <a href="customer.php" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Cancel
                        </a>
                        <button type="submit" name="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Correct Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>