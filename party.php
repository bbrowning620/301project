<?php
require_once('settings.php');
require_once(APP_ROOT.'/mysqldb.php');
require_once('user.php');

class party{
	public $partyid;
	public $name;
	public $address;
	private $username;
	public $rsvp;
	public $rsvpconfirmed;
	
	function __construct($data=null,$partyid=null){
		if($data==null && $partyid==null) return;
		if(isset($partyid)){
			// RETRIEVE A RECORD BY ITS partyid
			// 1. connect to the database
			$pdo=mysqldb::connect();
			// 2. select a record by partyid
			$query=$pdo->prepare('SELECT * FROM party WHERE partyid=?');
			$query->execute([$partyid]);
			// 3. show the record
			$data=$query->fetch();

		}
		$this->partyid=$data['partyid'];
		$this->name=$data['name'];
		$this->address=$data['address'];
		$this->rsvp=$data['rsvp'];
		$this->rsvpconfirmed=$data['rsvpconfirmed'];
		//$this->status=$data['status'];
		//$this->author=new User();
		//if(isset($data['first_name'])) $this->author->first_name=$data['first_name'];
		//if(isset($data['last_name'])) $this->author->last_name=$data['first_name'];
	}


	
	public function create($data){
		//1. validate the data
		if(!isset($data['address']{0})) return 'The address is missing';
		//2. connect to the database
		$pdo=MySQLDB::connect();
		//3. insert the record
		$query=$pdo->prepare('INSERT INTO posts (address,content) VALUES (?,?)');
		$query->execute([$data['address'],$data['content']]);
	}
	
	public function update($partyid,$data){
		//1. validate the data
		if(!isset($data['address']{0})) return 'The address is missing';
		//2. connect to the database
		$pdo=MySQLDB::connect();
		//3. update the record
		$query=$pdo->prepare('UPDATE posts SET address=?,content=? WHERE partyid=?');
		$query->execute([$data['address'],$data['content'],$partyid]);
	}
	
	public function delete($partyid){
		//1. connect to the database
		$pdo=MySQLDB::connect();
		//2. delete the record
		$query=$pdo->prepare('DELETE from party where partyid=?');
		$query->execute([$partyid]);
	}
	
	public function showDetail(){
		echo '<p>Address: '.$this->address.'</p>'; 
		echo '<p>RSVP Allotted: '.$this->rsvp.'</p>'; 
		echo '<p>RSVP Confirmed: '.$this->rsvpconfirmed.'</p>'; 
		echo '<a href="modify.php?partyid='.$this->partyid.'">Edit Party        </a>';
	}
	
	public function showPreview(){
		echo '<h3>'.$this->name.'</h3>';
		echo '<a href="detail.php?partyid='.$this->partyid.'">Details</a> ';
		
		echo '<hr>';
	}
	
}
