<?php
require_once('settings.php');
require_once(APP_ROOT.'/mysqldb.php');
require_once('template.php');

Template::showHeader('Create a new account');
if(count($_POST)>0){
	require_once('user.php');
	$user=new User;
	$error=$user->create($_POST);
	if(isset($error{0})){
		$message=$error;
		$alert_type='danger';
	}
	else{
		$message='The user has been added';
		$alert_type='success';
	}
}
if(count($_POST)>0) echo '<div class="alert alert-'.$alert_type.'" role="alert">'.$message.'</div>';
?>
<form method="POST">
  <div class="form-group">
    <label for="exampleInputusername1">First name</label>
    <input type="text" class="form-control" name="first_name" aria-describedby="usernameHelp">
  </div>
  <div class="form-group">
    <label for="exampleInputusername1">Last name</label>
    <input type="text" class="form-control" name="last_name" aria-describedby="usernameHelp">
  </div>
  <div class="form-group">
    <label for="exampleInputusername1">username</label>
    <input type="username" class="form-control" name="username" aria-describedby="usernameHelp">
    <small id="usernameHelp" class="form-text text-muted">We'll never share your username with anyone else.</small>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control" name="password">
  </div>
  <button type="submit" class="btn btn-primary">Create new user</button>
</form>
<?php
Template::showFooter();