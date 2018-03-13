<?php
require_once './database.php';

$id = $_GET['id'];

$query = "DELETE FROM comment WHERE id = :id";
$statement = $conn->prepare($query);
$result = $statement->execute([
    ':id' => $_GET['id']
]);

header('Location: image_detail.php?image_id='.$id);
