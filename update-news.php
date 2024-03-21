<?php
global $dbh;
include_once $_SERVER["DOCUMENT_ROOT"] . "/connectionDB.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $description = $_POST["description"];
    $date = $_POST["date"];

    $stmt = $dbh->prepare("UPDATE news SET name = :name, description = :description, date = :date WHERE id = :id");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    header("Location: /index.php");
    exit;
}
