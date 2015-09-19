<?php
$hostmysql = "localhost";
$username = "root";
$password = "";
$database = "sentitweet";
//start koneksi PDO
try{
	//buka koneksi mysql
	$dbnew= new PDO("mysql:host=$hostmysql;dbname=$database",$username,$password);
			
}catch(PDOException $e){
			echo $e->getMessage();
}

function tutupkoneksi(){
	$dbnew=null;
}

?>