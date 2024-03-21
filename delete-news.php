<?php
global $dbh;
include_once $_SERVER["DOCUMENT_ROOT"] . "/connectionDB.php";
include_once($_SERVER['DOCUMENT_ROOT'] . "/config/constants.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $dbh->prepare("SELECT image FROM news WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $image_filename = $row['image'];
    if (!empty($image_filename)){
        $image_path = $_SERVER['DOCUMENT_ROOT'] . '/' . UPLOADING . '/' . $image_filename;
        if (file_exists($image_path)) {
            unlink($image_path);
        }
    }
    $stmt = $dbh->prepare("DELETE FROM news WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    header("Location: /index.php");
    exit;
}