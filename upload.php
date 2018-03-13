<?php

require_once './database.php';

$tmpFile = $_FILES['image']['tmp_name'];
$destFile = __DIR__ . DIRECTORY_SEPARATOR . "img" . DIRECTORY_SEPARATOR . $_FILES['image']['name'];
move_uploaded_file($tmpFile, $destFile);
