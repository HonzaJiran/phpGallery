<?php

  require_once './database.php';

  $id = $_GET['id'];
  var_dump($id);

  $sql = "INSERT INTO like_table "
          . "SET image_id =".$id;
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $send_like = $stmt->fetchAll();

  $query = "UPDATE like_table "
          . "SET likes = likes + 1 "
          . "WHERE image_id =".$id;

  $statement = $conn->prepare($query);
  $result = $statement->execute();

  if ($result !== true) {
      var_dump($statement->errorInfo());
      die();
  }

  header('Location: image_detail.php?image_id='.$id);
