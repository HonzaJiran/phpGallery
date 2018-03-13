<?php
require_once './database.php';

$id = $_GET['gallery_id'];

$query = "DELETE FROM image WHERE gallery_id = :id";
$statement = $conn->prepare($query);
$result = $statement->execute([
    ':id' => $id
]);

header('Location: album.php?id=<?php echo $id ?>');
