<?php
require('settings.php');
require_once(__DIR__ .'/auth.php');
if(Auth::is_logged()) header('index.php');

require_once('template.php');

Template::showHeader('Access your account');
if(count($_POST)>0){
	$error=Auth::signin($_POST,'index.php');
	$message=$error;
	$alert_type='danger';
}
if(count($_POST)>0) echo '<div class="alert alert-'.$alert_type.'" role="alert">'.$message.'</div>';
?>
<form method="POST">
  <div class="form-group">
    <label for="exampleInputusername1">Username</label>
    <input type="username" class="form-control" name="username" aria-describedby="usernameHelp">
    <small id="usernameHelp" class="form-text text-muted">We'll never share your username with anyone else.</small>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control" name="password">
  </div>
  <button type="submit" class="btn btn-primary">Sign in</button>
</form>
<p class="mt-3">
Don't have an account? <a href="signup.php">Create your account</a>
</p>
<?php
Template::showFooter();