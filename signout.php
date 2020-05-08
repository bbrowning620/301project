<?php
require('settings.php');
require_once(__DIR__ .'/auth.php');
if(!Auth::is_logged()) header('location:index.php');
Auth::signout('location: signin.php');
header('location:index.php');