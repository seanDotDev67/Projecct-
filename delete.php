<?php
require 'pdo.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $deleted = $stmt->execute([':id' => $id]);

        if ($deleted) {
            header("Location: customer.php?deleted=1");
            exit();
        } else {
            header("Location: customer.php?error=1");
            exit();
        }
    } catch (PDOException $e) {
        header("Location: customer.php?error=1");
        exit();
    }
} else {
    header("Location: customer.php");
    exit();
}