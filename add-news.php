<?php
global $dbh;
include_once($_SERVER['DOCUMENT_ROOT'] . "/config/constants.php");

$error = '';
$name = $description = $date = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $description = $_POST["description"];
    $date = $_POST["date"];

    $folder_name = $_SERVER['DOCUMENT_ROOT'].'/'. UPLOADING;
    if(!file_exists($folder_name)){
        mkdir($folder_name, 0777);
    }
    $new_name = uniqid().'.'.pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
    $image_save = $folder_name.'/'.$new_name;
    move_uploaded_file($_FILES['image']['tmp_name'], $image_save);

    include_once $_SERVER["DOCUMENT_ROOT"] . "/connectionDB.php";
    $stmt = $dbh->prepare("SELECT COUNT(*) AS count FROM news WHERE name = :name");
    $stmt->bindParam(':name', $name);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] > 0) {
        $error = "News with this name already exists. Please choose a different name.";
    } else {
        $stmt = $dbh->prepare("INSERT INTO news (name, description, date, image) VALUES (:name, :description, :date, :image)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':image', $new_name);
        $stmt->execute();
        header("Location: /index.php");
        exit;
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add News</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
</head>
<body>
<div class="container py-3">
    <?php include_once $_SERVER["DOCUMENT_ROOT"] . "/_header.php"; ?>
    <h1 class="text-center">Add News</h1>

    <form method="post" action="add-news.php" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
            <?php
            if (!empty($error)){
                echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
            }
            ?>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description" rows="3" required><?php echo htmlspecialchars($description); ?></textarea>
        </div>
        <div class="form-group">
            <label for="date">Date:</label>
            <input type="date" class="form-control" id="date" name="date" value="<?php echo htmlspecialchars($date); ?>" required>
        </div class="form-group">
        <div>
            <label for="formFile" class="form-label">Image:</label>
            <input class="form-control" type="file" id="image" name="image" accept="image/*"/>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>