<?php

session_start();

function signup($database_file,$success_URL){
	if(count($_POST)>0){
	//if the user sends the form:
		// Validate the email
		if(!isset($_POST['email']{0}) || !isset($_POST['password']{0})) return 'You must enter e-mail and password';
		if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) return 'Please enter a valid email address';
		$_POST['email']=strtolower($_POST['email']);
		
		// Validate the password
		$_POST['password']=trim($_POST['password']);
		if(strlen($_POST['password'])<8) return 'Please, enter a password that is at least 8 characters long.';
		
		// Create file if it does not exist
		if(!file_exists($database_file)){
			$h=fopen($database_file,'w');
			fwrite($h,'<?php die() ?>'."\n");
			fclose($h);
		}
		// Check for duplicates
		$h=fopen($database_file,'r');
		while(!feof($h)){
			$line=fgets($h);
			if(strstr($line,$_POST['email'])) return 'The email you entered is already associated with an account.';
		}
		fclose($h);
		// Encrypt password
		$_POST['password']=password_hash($_POST['password'], PASSWORD_DEFAULT);
		
		// Store data in db
		$h=fopen($database_file,'a+');
		fwrite($h,$_POST['email'].';'.$_POST['password'].PHP_EOL);
		fclose($h);
		header('location: '.$success_URL);
	}
}
function signin($database_file,$user_key,$success_URL){
	if(count($_POST)>0){
	//if the user sends the form:
		// Validate the email
		if(!isset($_POST['email']{0}) || !isset($_POST['password']{0})) return 'You must enter e-mail and password';
		if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) return 'Please enter a valid email address';
		$_POST['email']=strtolower($_POST['email']);
		
		// Validate the password
		$_POST['password']=trim($_POST['password']);
		if(strlen($_POST['password'])<8) return 'Please, enter a password that is at least 8 characters long.';
		
		// Create file if it does not exist
		if(!file_exists($database_file)){
			$h=fopen($database_file,'w');
			fwrite($h,'');
			fclose($h);
		}
		// Check if email exists
		$h=fopen($database_file,'r');
		$userid=1;
		fgets($h);
		while(!feof($h)){
			$line=fgets($h);
			if(strstr($line,$_POST['email'])){
				$line=explode(';',$line);
				// check if passwords match
				if(!password_verify($_POST['password'],trim($line[1]))) return 'The password you entered is not correct';
				$_SESSION[$user_key]=$userid;
				header('location:'.$success_URL);
			}
			$userid++;
		}
		fclose($h);
		return 'The e-mail you entered is not associated with any account';
	}
}


function signout($destination_URL){
	$_SESSION=[];
	session_destroy();
	header('location:'.$destination_URL);
}

function is_logged($user_key){
	if(isset($_SESSION[$user_key])){
		if(is_numeric($_SESSION[$user_key])) return true;
		elseif(isset($_SESSION[$user_key]{0})) return true;
	}
	return false;
}