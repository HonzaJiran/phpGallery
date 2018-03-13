<?php
include './database.php';

$gallery_id = $_GET['id'];

if(isset($_FILES["file"])){

  ///////////////THEN

  $query = "INSERT INTO image "
          . "SET gallery_id = :gallery_id";

  $statement = $conn->prepare($query);
  $result = $statement->execute([
      ':gallery_id' => $gallery_id
  ]);

  if ($result !== true) {
      var_dump($statement->errorInfo());
      die();
  }

  $id = $conn->lastInsertId();

  $tmp_name = $_FILES["file"]["tmp_name"];
  $new_name = "img/".$id.".JPEG";
  move_uploaded_file($tmp_name,$new_name);

}

$query = 'SELECT * FROM image where gallery_id ='.$gallery_id;
$statement = $conn->prepare($query);
$statement->execute();
$images = $statement->fetchAll();

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Gallery</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
    <style media="screen">
      .card > a > img:hover {
        opacity: .7;
      }
      .card > a > img {
        -webkit-transition: all 0.3s;
      }
    </style>
  </head>
  <body>
    <section class="section">
    <div class="container">
      <br>
      <form method="post" enctype="multipart/form-data">
        <label>Nahrat novy obrazek</label><br>
        <div class="form-control">
          <input class="form-control-item" type="file" name="file">
          <input name="upload" class="btn btn-primary" value="Upload" type="submit">
        </div>
      </form>

        <hr>

      <h2><?php echo $_GET['gallery_name'] ?></h2>
      <p><?php echo $_GET['datum'] ?></p>

      <div class="row">
        <?php foreach ($images as $image): ?>
            <div class="col s12 m6 l4">
              <div class="card">
                <div class="card-image">
                  <a href="image_detail.php?image_id=<?= $image['id'] ?>">
                    <img class="card-img-top" src="img/<?= $image['id'] ?>.JPEG" alt="Card image cap">
                  </a>
                </div>
                <div class="card-action">
                  <a href="delete_image.php?id=<?= $image['id'] ?>&gallery_id=<?php echo $gallery_id ?>">Delete</a>
                </div>
              </div>
            </div>
        <?php endforeach; ?>
        </div>

        <footer>
          <hr>
          <a class="btn" href="clear_gallery.php?gallery_id=<?php echo $gallery_id ?>">Clear gallery</a>
        </footer>
      </div>
  </body>
</html>
