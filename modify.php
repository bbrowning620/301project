<?php


  $settings=[
  'host' => 'localhost',
  'dbname' => 'rsvp',
  'user' => 'root',
  'password' => ''
];

$opt = [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_EMULATE_PREPARES => false
];

//connect
$pdo = new PDO('mysql:host='.$settings['host'].';dbname='.$settings['dbname'].';charset=utf8mb4',$settings['user'], $settings['password'],$opt );

$record='';


if(count($_POST)>0){
  $q=$pdo->prepare('UPDATE party SET name=?, address=?, rsvp=?, rsvpconfirmed=?, username=? WHERE partyid=?');
  $q->execute([$_POST['name'],$_POST['address'],$_POST['rsvp'],$_POST['rsvpconfirmed'],$_POST['username'],$_GET['partyid']]);
$record=$_POST;

}else{
  $q=$pdo->prepare('SELECT partyid, name, address, rsvp, rsvpconfirmed FROM party where partyid=?');
  $q->execute([$_GET['partyid']]);
  if($q->rowCount()==0) die('That record does not exist');
  $record=$q->fetch();
}


$title='Modify RSVP';
require_once('header.php');
?>

<div class="container">
<h1><?=$title?></h1>
<form method="POST" action="modify.php?partyid=<?= $_GET['partyid']?>">
<div class="form-group">

    <div class="col-5">
    <label>Party Name</label>
    <input type="text" class="form-control" name="name" value="<?= $record['name']?>">
  </div>
  </div>

  <div class="form-group">
    <div class="col-5">
    <label>Address</label>
    <input type="text" class="form-control" name="address" value="<?= $record['address']?>">
  </div>
  </div>

  <div class="form-group">
    <div class="col-5">
    <label>RSVP</label>
    <input type="text" class="form-control" name="rsvp" value="<?= $record['rsvp']?>">
  </div>
  </div>

  <div class="form-group">
    <div class="col-5">
    <label>RSVP Confirmed</label>
    <input type="text" class="form-control" name="rsvpconfirmed" value="<?= $record['rsvpconfirmed']?>">
  </div>
  </div>

  <div class="form-group">
    <div class="col-5">
    <label>Creator</label>
    <input type="text" class="form-control" name="username" value="<?= $record['username']?>">
  </div>
  </div>

  <div class="form-inline">
  <div class="col-1">
  <button type="submit" name="create" class="btn btn-primary" >Update</button>
  </div>
  <div class="col-1">
  <button type="button" class="btn btn-primary" onClick="document.location.href='detail.php?partyid=<?= $_GET['partyid']?>'">Back</button>
  </div>
  <a class="btn btn-outline-danger" href="delete.php?id='.$_GET['partyid'].'">Delete</a>
</div>


</form>
</div>


<?php
require_once('footer.php');