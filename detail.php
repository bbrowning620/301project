<?php
require_once('settings.php');
require_once(APP_ROOT.'/MySQLDB.php');
require_once(APP_ROOT.'/party.php');

$party=new party(null,$_GET['partyid']);

require_once(APP_ROOT.'/template.php');
Template::showHeader($party->name);
$party->showDetail();
?>
<br><br>
<a class="btn btn-outline-secondary" href="index.php">Back</a>
<?php
Template::showFooter();