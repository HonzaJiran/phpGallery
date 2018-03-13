<?php
require_once './database.php';

$id = $_GET['id'];
$gallery_id = $_GET['gallery_id'];

$query = "DELETE FROM image WHERE id = :id";
$statement = $conn->prepare($query);
$result = $statement->execute([
    ':id' => $_GET['id']
]);

header('Location: album.php?id='.$gallery_id);
