<?php
global $dbh;
include_once $_SERVER["DOCUMENT_ROOT"] . "/connectionDB.php";
include_once($_SERVER['DOCUMENT_ROOT'] . "/config/constants.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $description = $_POST["description"];
    $date = $_POST["date"];

    $folder_name = $_SERVER['DOCUMENT_ROOT'].'/'. UPLOADING;
    if(!file_exists($folder_name)){
        mkdir($folder_name, 0777);
    }
    $new_name = "";
    if (!empty($_FILES['image']['name'])){
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

        $new_name = uniqid().'.'.pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
        $image_save = $folder_name.'/'.$new_name;
        move_uploaded_file($_FILES['image']['tmp_name'], $image_save);

        $stmt = $dbh->prepare("UPDATE news SET name = :name, description = :description, date = :date, image = :image WHERE id = :id");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':image', $new_name);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
    else {
        $new_name = uniqid().'.'.pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
        $image_save = $folder_name.'/'.$new_name;
        move_uploaded_file($_FILES['image']['tmp_name'], $image_save);

        $stmt = $dbh->prepare("UPDATE news SET name = :name, description = :description, date = :date WHERE id = :id");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    header("Location: /index.php");
    exit;
}
