<?php
require_once __DIR__ . '/vendor/autoload.php';
include("filtering.php");
include("koneksi.php");
ini_set('max_execution_time', 0);
 echo "<h1>Tunggu Sebentar Lagi Updating Data... .... ... !!!</h1>";
$ps=$dbnew->prepare("SELECT * FROM datalatih");
$ps->execute();
$psa=$dbnew->prepare("SELECT * FROM tb_stopword");
$psa->execute();
	
$pattern=array();
	 while($rsd=$psa->fetch(PDO::FETCH_ASSOC)){
				array_push($pattern,"/\b".$rsd['katastopword']."\b/");
	 }
	 tutupkoneksi();
	$stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
    $stemmer  = $stemmerFactory->createStemmer();
    
	while($rs=$ps->fetch(PDO::FETCH_NUM)){
        $id=$rs[0];
		$twt = strtolower($rs[1]);
		$hash=new filtering();
		$rem_all=$hash->remove_all_clear($twt);
		$rem_stop=preg_replace($pattern,"",$rem_all);
		
		$sentence = $rem_stop;
        $output   = $stemmer->stem($sentence);
		$psa=$dbnew->prepare("UPDATE `datalatih` SET `tweet_text`=? WHERE tweet_id=?");
		$psa->bindParam(1,$output);
		$psa->bindParam(2,$id);
		
		$psa->execute();	
		tutupkoneksi();
	}

   
tutupkoneksi();
?>