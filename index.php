<?php global $dbh; ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>General</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
</head>
<body>
<div class="container py-3">
    <?php include_once $_SERVER["DOCUMENT_ROOT"]."/_header.php"; ?>
    <h1 class="text-center">News</h1>

    <?php include_once $_SERVER["DOCUMENT_ROOT"]."/connectionDB.php"; ?>

    <a href="/add-news.php" class="btn btn-primary">Add News</a>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Description</th>
            <th scope="col">Date</th>
            <th scope="col">Opt</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $stm = $dbh->query('SELECT * FROM news');
        $rows = $stm->fetchAll();
        foreach($rows as $row) {
            $id = $row["id"];
            $name = $row["name"];
            $description = $row["description"];
            $date = $row["date"];
            echo "
        <tr>
            <th scope='row'>$id</th>
            <td>$name</td>
            <td>$description</td>
            <td>$date</td>
            <td>
                <a href='/edit-news.php?id=$id' class='btn btn-primary'>Edit</a>
                <a href='/delete-news.php?id=$id' class='btn btn-primary'>Delete</a>
            </td>
        </tr>
            ";
        }
        ?>
        </tbody>
    </table>
</div>

<script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>






































