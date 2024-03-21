<?php
global $dbh;
include_once $_SERVER["DOCUMENT_ROOT"] . "/connectionDB.php";

$id = $_GET['id'];

$stmt = $dbh->prepare("SELECT * FROM news WHERE id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();
$news = $stmt->fetch();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit News</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
</head>
<body>
<div class="container py-3">
    <?php include_once $_SERVER["DOCUMENT_ROOT"] . "/_header.php"; ?>
    <h1 class="text-center">Edit News</h1>

    <form method="post" action="update-news.php">
        <input type="hidden" name="id" value="<?php echo $news['id']; ?>">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $news['name']; ?>" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description" rows="3" required><?php echo $news['description']; ?></textarea>
        </div>
        <div class="form-group">
            <label for="date">Date:</label>
            <input type="date" class="form-control" id="date" value="<?php echo $news['date']; ?>" name="date" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>