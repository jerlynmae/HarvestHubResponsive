<?php
session_start();

$upload_dir = "../../uploads/";  
$allowed    = ['jpg','jpeg','png','gif'];
$newAvatar  = $_SESSION['avatar'] ?? '../../uploads/default-avatar.png';

if (!empty($_FILES['avatar']['name'])) {
    $fileName = basename($_FILES['avatar']['name']);
    $fileTmp  = $_FILES['avatar']['tmp_name'];
    $fileExt  = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if (in_array($fileExt, $allowed)) {
        $newName = uniqid("avatar_", true) . "." . $fileExt;
        $target  = $upload_dir . $newName;

        if (move_uploaded_file($fileTmp, $target)) {
            $newAvatar = $target;
        }
    }
}

$_SESSION['fullname'] = $_POST['fullname'];
$_SESSION['email']    = $_POST['email'];
$_SESSION['phone']    = $_POST['phone'];
$_SESSION['address']  = $_POST['address'];
$_SESSION['avatar']   = $newAvatar;

header("Location: profile.php");
exit;
