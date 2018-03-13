<?php
require_once './database.php';

$id = $_GET['id'];

$query = "DELETE FROM gallery WHERE id = :id";
$statement = $conn->prepare($query);
$result = $statement->execute([
    ':id' => $_GET['id']
]);

header('Location: index.php');
