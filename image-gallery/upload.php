<?php
session_start();

if(isset($_POST['submit'])){

    $targetDir = "uploads/";
    $fileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
    $allowedTypes = ["jpg", "jpeg", "png", "gif"];
    $maxSize = 2 * 1024 * 1024; // 2MB

    if($_FILES["image"]["error"] !== 0){
        $_SESSION['message'] = "Upload error!";
        header("Location: index.php");
        exit();
    }

    if($_FILES["image"]["size"] > $maxSize){
        $_SESSION['message'] = "File too large (Max 2MB).";
        header("Location: index.php");
        exit();
    }

    if(!in_array($fileType, $allowedTypes)){
        $_SESSION['message'] = "Invalid file type. Only JPG, PNG, GIF allowed.";
        header("Location: index.php");
        exit();
    }

    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check === false){
        $_SESSION['message'] = "File is not a real image.";
        header("Location: index.php");
        exit();
    }

    $newFileName = uniqid() . "." . $fileType;
    $targetFile = $targetDir . $newFileName;

    if(move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)){
        $_SESSION['uploads'][] = $targetFile;
        $_SESSION['message'] = "Image uploaded successfully!";
    } else {
        $_SESSION['message'] = "Something went wrong.";
    }

    header("Location: index.php");
}
?>
   