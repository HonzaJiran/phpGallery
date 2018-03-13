<?php

  require_once './database.php';

  $image_id = $_GET['image_id'];

  if (isset($_POST['action']) && $_POST['action'] === 'create') {
    $email = $_POST['email_input'];
    $text = htmlspecialchars($_POST['text']);

    $query = "INSERT INTO comment "
            . "SET text = :text, email = :email, created_at = now(), image_id = ".$image_id;

    $statement = $conn->prepare($query);
    $result = $statement->execute([
        ':text' => $text,
        ':email' => $email
    ]);

    if ($result !== true) {
        var_dump($statement->errorInfo());
        die();
    }

  }

  if (isset($_POST['like_button'])) {
    $query = "UPDATE image "
            . "SET likes = likes + 1 "
            . "WHERE id =".$image_id;

    $statement = $conn->prepare($query);
    $result = $statement->execute();

    if ($result !== true) {
        var_dump($statement->errorInfo());
        die();
    }
  }

  $query = 'SELECT * FROM comment where image_id ='.$image_id;
  $statement = $conn->prepare($query);
  $statement->execute();
  $comments = $statement->fetchAll();

  $query = 'SELECT * FROM image where id ='.$image_id;
  $statement = $conn->prepare($query);
  $statement->execute();
  $image = $statement->fetchAll();

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Gallery</title>
    <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <?php foreach ($image as $key): ?>

      <img src="img/<?= $key['id'] ?>.jpeg" class="materialboxed" width="100%" alt="Responsive image">

    <?php endforeach; ?>

    <form method="post" style="float:right;">
          <button style="margin:0;padding:0;width:0;border:none;" type="submit" name="like_button"><a style="margin:20px;margin-left:-70px;border:none;position:relative;" type="submit" name="like_button" class="btn-floating btn-large waves-effect waves-light red"><i class="far fa-heart"></i></a></button>
            <?php foreach ($image as $key): ?>
              <?= $key['likes'] ?> <p style="display:inline;padding-right:20px"> Likes</p>
            <?php endforeach; ?>
          </button>
    </form>

    <br>

    <div class="container">

      <form action="image_detail.php?image_id=<?php echo $image_id ?>" method="post">

        <div class="form-group">
          <br><br><br>
          <label>Email:</label>
          <input type="text" name="email_input" class="form-control">
          <br>
          <label >Write comment</label>
          <textarea name="text" id="textarea1" class="materialize-textarea"></textarea>

        </div>

        <button type="submit" name="send_button" class="btn btn-primary">SEND</button>
        <input type="hidden" name="action" value="create">
      </form>
      <br>
      <hr>

      <?php foreach ($comments as $comment): ?>

        <br>

        <div class="row">
        <div class="col s12">
          <div class="card yellow lighten-5 darken-1">
            <div class="card-content white-text">
              <span class="card-title"><?= $comment['email'] ?><p style="float:right"><?= $comment['created_at'] ?></p></span>
              <p><?= $comment['text'] ?></p>
            </div>
            <div class="card-action">
              <a href="delete_comment.php?id=<?= $comment['id'] ?>">Delete</a>
            </div>
          </div>
        </div>
      </div>

      <?php endforeach; ?>

    </div>

    <br><br><br><br><br>
  </body>
</html>
