<?php
require_once __DIR__ . '/../config/db.php';

// 1. Initialize session for protection
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Security Check (Only Admin can delete)
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// 3. Delete Action
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Secure against SQL injection

    try {
        $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute([$id]);
        
        // Success redirect
        header("Location: dashboard.php?status=deleted");
        exit();
    } catch (PDOException $e) {
        // Error redirect
        header("Location: dashboard.php?status=error");
        exit();
    }
} else {
    // If no ID is provided, go back
    header("Location: dashboard.php");
    exit();
}