<?php
include './database.php';

if (isset($_POST['action']) && $_POST['action'] === 'create') {

    $name = $_POST['db_name'];

    $query = "INSERT INTO gallery "
            . "SET name = :name, created_at = now()";

    $statement = $conn->prepare($query);
    $result = $statement->execute([
        ':name' => $name
    ]);

    if ($result !== true) {
        var_dump($statement->errorInfo());
        die();
    }
}



$query = 'SELECT * FROM gallery';
$statement = $conn->prepare($query);
$statement->execute();
$galleries = $statement->fetchAll();

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Gallery</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
    <style media="screen">
      .card-image > a > img {
        -webkit-transition: opacity 0.3s;
      }
      .card-image > a > img:hover {
        opacity: .8;
      }
    </style>
  </head>
  <body>

    <div class="container">
      <br><br>
      <form action="index.php" method="post">
        <input class="form-control" name="db_name" type="text" placeholder="Nazev alba">
        <br>
        <button type="submit" class="btn btn-primary" name="button">Pridat</button>
        <br><br>
        <input type="hidden" name="action" value="create">
      </form>

      <hr>

      <div class="row">
        <?php foreach ($galleries as $gall): ?>
          <div class="col s12 m6 l4">
            <div class="card">
              <div class="card-image">
                <a href="album.php?id=<?= $gall['id'] ?>&gallery_name=<?= $gall['name'] ?>&datum=<?= $gall['created_at'] ?>">
                  <img src="http://iwallpapers2.free.fr/images/Espace/Nebuleuse_du_fantome.jpg">
                </a>
                <span class="card-title"><?= $gall['name'] ?></span>
              </div>
              <div class="card-action">
                <a href="delete_album.php?id=<?= $gall['id'] ?>">Delete</a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>


  </body>
</html>
