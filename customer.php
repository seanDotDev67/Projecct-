<?php
require "pdo.php";

// Fetch users safely using PDO
$sql = "SELECT * FROM users";
$stmt = $pdo->query($sql);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer List</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->       
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
    <!-- ICON LINK -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            font-family: 'Roboto Mono', monospace;
            background-color: #f4f6f9;
        }
    </style>
</head>
<body class="p-4">

    <div class="container-fluid">
        <!-- Header Row with Add Customer Button -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">CUSTOMER LIST</h1>
            <a href="add_user.php" class="btn btn-primary">
                <i class="bi bi-person-plus-fill me-1"></i> Add Customer
            </a>
        </div>

        <!-- Status Alerts -->
        <?php if(isset($_GET['deleted'])): ?>
            <div id="alertMessage" class="alert alert-success py-2">
               User deleted successfully.
            </div>
        <?php elseif(isset($_GET['added'])): ?>
            <div id="alertMessage" class="alert alert-success py-2">
               New customer added successfully!
            </div>
        <?php elseif(isset($_GET['success'])): ?>
            <div id="alertMessage" class="alert alert-success py-2">
               Updated Successfully.
            </div>
        <?php elseif(isset($_GET['error'])): ?>
            <div id="alertMessage" class="alert alert-danger py-2">
               Something went wrong.
            </div>
        <?php endif; ?>

        <div class="table-responsive shadow-sm rounded">
            <table class="table table-striped table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">FIRST NAME</th>
                        <th scope="col">LAST NAME</th>
                        <th scope="col">MIDDLE INITIAL</th>
                        <th scope="col">USERNAME</th>
                        <th scope="col">EMAIL</th>
                        <th scope="col">PASSWORD</th>
                        <th scope="col">UPDATE</th>
                        <th scope="col">DELETE</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $row): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id']); ?></td>
                                <td><?php echo htmlspecialchars($row['f_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['l_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['m']); ?></td>
                                <td><?php echo htmlspecialchars($row['username']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['password']); ?></td>
                                <td>
                                    <a href="update_user.php?id=<?php echo urlencode($row['id']); ?>" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-pencil-square"></i> Update
                                    </a>
                                </td>
                                <td>
                                    <!-- Delete Button Trigger -->
                                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $row['id']; ?>">
                                        <i class="bi bi-trash3-fill"></i> Delete
                                    </button>

                                    <!-- Confirmation Modal -->
                                    <div class="modal fade" id="deleteModal<?php echo $row['id']; ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title fs-6">Confirm Delete</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-start">
                                                    Are you sure you want to delete <strong><?php echo htmlspecialchars($row['f_name'] . ' ' . $row['l_name']); ?></strong>?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                                                    <a href="delete.php?id=<?php echo urlencode($row['id']); ?>" class="btn btn-danger btn-sm">Yes, Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Modal -->
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center text-muted py-3">No records found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        setTimeout(function(){
            const alert = document.getElementById('alertMessage');
            if(alert){
                alert.remove();
            }
        }, 3000);
    </script>
</body>
</html>