<?php

function jsonToArray($filename){
  
  $json_string = file_get_contents($filename);
  $array = json_decode($json_string, true);
  return $array;

}

function writeAllJSON($file,$data){
	$h=fopen($file,'w');
	fwrite($h,json_encode($data));
	fclose($h);
}

function writeJSON($file,$data){
	$array=json_decode(file_get_contents($file),true);
	$array[]=$data;
	writeAllJSON($file,$array);	
}