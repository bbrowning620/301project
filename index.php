<?php
require_once('settings.php');
require_once('template.php');

require_once(APP_ROOT.'/mysqldb.php');
require_once(APP_ROOT.'/party.php');

Template::showHeader('Welcome to our wedding website');

// SHOW A LIST OF POSTS
// 1. connect to the database
$pdo=MySQLDB::connect();
// 2. query the database for all the posts
$party=$pdo->query('SELECT * FROM party');
// 3. for each post, show its preview
while($parties=$party->fetch()){
	$p=new Party($parties);
	$p->showPreview();
}
Template::showFooter();