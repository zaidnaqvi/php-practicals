<?php
session_start();

if(isset($_GET['id'])){
    $id = $_GET['id'];

    if(isset($_SESSION['uploads'][$id])){
        $filePath = $_SESSION['uploads'][$id]['path'];

        if(file_exists($filePath)){
            unlink($filePath);
        }

        unset($_SESSION['uploads'][$id]);
        $_SESSION['uploads'] = array_values($_SESSION['uploads']);
    }
}

header("Location: gallery.php");
exit();
?>
