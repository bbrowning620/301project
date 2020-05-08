<?php
require_once('mysqldb.php');

class Auth{
	static function signup($data,$success_URL){
		if(count($data)>0){
		//if the user sends the form:
			// Validate the username
			if(!isset($data['username']{0}) || !isset($data['password']{0})) return 'You must enter e-mail and password';
			if(!filter_var($data['username'], FILTER_VALIDATE_username)) return 'Please enter a valid username address';
			$data['username']=strtolower($data['username']);
			
			// Validate the password
			$data['password']=trim($data['password']);
			if(strlen($data['password'])<8) return 'Please, enter a password that is at least 8 characters long.';
			
			// Open a connection to the database
			$pdo=MySQLDB::connect();
			// Check for duplicate usernames
			$query=$pdo->prepare('SELECT ID FROM users WHERE username=?');
			$query->execute([$data['username']]);
			// if we have a duplicate: return 'The username you entered is already associated with an account.';
			if($query->rowCount()>0) return 'The username you entered is already associated with an account.';

			// Encrypt password
			$data['password']=password_hash($data['password'], PASSWORD_DEFAULT);
			if(!isset($data['first_name']{0})) $data['first_name']='';
			if(!isset($data['last_name']{0})) $data['last_name']='';
			
			// Store data in db
			$query=$pdo->prepare('INSERT INTO users(username,password,first_name,last_name,date_registered) VALUES(?,?,?,?,?)');
			$query->execute([$data['username'],$data['password'],$data['first_name'],$data['last_name'],date('Y-m-d h:i:s')]);
			header('location: '.$success_URL);
		}
	}

	static function signin($data,$success_URL){
		if(count($data)>0){
		//if the user sends the form:
			// Validate the username
			if(!isset($data['username']{0}) || !isset($data['password']{0})) return 'You must enter e-mail and password';
			if(!filter_var($data['username'])) return 'Please enter a valid username';
			$data['username']=strtolower($data['username']);
			
			// Validate the password
			$data['password']=trim($data['password']);
			if(strlen($data['password'])<8) return 'Please, enter a password that is at least 8 characters long.';
			
			// Open a connection to the database
			$pdo=MySQLDB::connect();
			// Retrieve the user information from the database
			$query=$pdo->prepare('SELECT userid,password FROM users WHERE username=?');
			$query->execute([$data['username']]);
			if($query->rowCount()==0) return 'The username you entered is not associated with any account';
			$users=$query->fetch();
			
			if(!password_verify($data['password'],$users['password'])) return 'The password you entered is not correct';
			$_SESSION['users/userid']=$users['userid'];
			header('location:'.$success_URL);
		}
	}


	static function signout($destination_URL){
		$_SESSION=[];
		session_destroy();
		header('location:'.$destination_URL);
	}

	static function is_logged($user_key='user/ID'){
		if(isset($_SESSION[$user_key])){
			if(is_numeric($_SESSION[$user_key])) return true;
			elseif(isset($_SESSION[$user_key]{0})) return true;
		}
		return false;
	}
}