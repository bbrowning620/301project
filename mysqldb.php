<?php

class mysqldb{
	public static function connect($settings=null){
		if(!isset($settings)) $settings=DB_SETTINGS;
		$opt=[
			PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES=>false,
		];
		//connection
		return new PDO('mysql:host='.$settings['host'].';dbname='.$settings['dbname'].';charset=utf8mb4',$settings['user'],$settings['password'],$opt); 
	}
}