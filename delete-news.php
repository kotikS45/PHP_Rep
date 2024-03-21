<?php
global $dbh;
include_once $_SERVER["DOCUMENT_ROOT"] . "/connectionDB.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $dbh->prepare("DELETE FROM news WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    header("Location: /index.php");
    exit;
}
