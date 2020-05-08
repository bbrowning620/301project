<?php

class user{
	public $username;
	public $password;
	public $first_name;
	public $last_name;
	
	public function __construct($first_name=null,$last_name=null,$username=null,$password=null){
		$this->first_name=$first_name;
		$this->last_name=$last_name;
		$this->username=$username;
		$this->password=$password;
		
	}
	public function create($data){
		// filter data
		if(!isset($data['username']{0}) || !isset($data['password']{0}) || !isset($data['first_name']{0}) || !isset($data['last_name']{0})) return 'Some fields are missing';
		// check if user is already there
		require_once(APP_ROOT.'/mysqldb.php');
		$pdo=mysqldb::connect();
		// check if the user is already there
		$query=$pdo->prepare('SELECT userid FROM users WHERE username=?');
		$query->execute([$data['username']]);
		if($query->rowCount()>0) return 'The user is already registered';
		// encrypt password
		$data['password']=password_hash($data['password'],PASSWORD_DEFAULT);
		// save the user
		$query=$pdo->prepare('INSERT INTO users(username,password,first_name,last_name) VALUES(?,?,?,?)');
		$query->execute([$data['username'],$data['password'],$data['first_name'],$data['last_name']]);
		return '';
	}
	
	public function update($data){
		// filter data
		if(!isset($data['username']{0}) || !isset($data['password']{0}) || !isset($data['first_name']{0}) || !isset($data['last_name']{0})) return 'Some fields are missing';
		if(!filter_var($data['username'],FILTER_VALIDATE_username)) return 'The username address is not valid';
		
		// update user information;
		require_once(APP_ROOT.'/mysqldb.php');
		$pdo=mysqldb::connect();
		$query=$pdo->prepare('UPDATE users SET first_name=?,last_name=?,username=?,password=?,status=? WHERE ID=?');
		$query->execute([$data['first_name'],$data['last_name'],$data['username'],$data['password'],$data['status'],$_GET['id']]);
		return '';
	}
	
	public function delete($id){
		// delete a user;
		require_once(APP_ROOT.'/mysqldb.php');
		$pdo=mysqldb::connect();
		$query=$pdo->prepare('UPDATE users SET status=-1 WHERE ID=?');
		$query->execute([$id]);
	}
	
	public function detail(){
		// show user's details;
	}
	
	public function showPreview($id){
		return '<tr><td>'.$this->first_name.' '.$this->last_name.'</td><td>'.$this->username.'</td><td><a class="btn btn-sm btn-primary" href="detail.php?id='.$id.'">See details</a></td></tr>';
	}
}