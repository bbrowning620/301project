<?php
require_once('settings.php');
//require_once('../Admin.php');
//Admin::requireAdmin('index.php');
require_once(APP_ROOT.'/party.php');
$party=new party();
$party->delete($_GET['partyid']);
header('location:index.php');