<?php

  $settings=[
  'host' => 'localhost',
  'dbname' => 'rsvp',
  'user' => 'root',
  'password' => ''
];

if(count($_POST)>0){

$opt = [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_EMULATE_PREPARES => false
];

//connect
$pdo = new PDO('mysql:host='.$settings['host'].';dbname='.$settings['dbname'].';charset=utf8mb4',$settings['user'], $settings['password'],$opt );

//Create new party
$insert=$pdo->prepare('INSERT INTO party(name, address, rsvp, username) values(?,?,?,?)');
$insert->execute([$_POST['name'],$_POST['address'],$_POST['rsvp'],$_POST['username']]);

}


$title='Create Party';
require_once('header.php');
?>

<div class="container">
<h1><?=$title?></h1>
<form method="POST">
<div class="form-group">

    <div class="col-5">
    <label>Party Name</label>
    <input type="text" class="form-control" name="name">
  </div>
  </div>

  <div class="form-group">
    <div class="col-5">
    <label>Address</label>
    <input type="text" class="form-control" name="address">
  </div>
  </div>

  <div class="form-group">
    <div class="col-5">
    <label>RSVP</label>
    <input type="text" class="form-control" name="rsvp">
  </div>
  </div>

  <div class="form-group">
    <div class="col-5">
    <label>Creator</label>
    <input type="text" class="form-control" name="username">
  </div>
  </div>

  <div class="form-inline">
  <div class="col-1">
  <button type="submit" name="create" class="btn btn-primary">Create</button>
  </div>
  <div class="col-1">
  <button type="button" class="btn btn-primary" onClick="document.location.href='index.php'">Cancel</button>
  </div>
</div>
<br>
<div class="col-1">
  <button type="button" class="btn btn-primary" onClick="document.location.href='index.php'">Back</button>
</div>

</form>
</div>


<?php
require_once('footer.php');