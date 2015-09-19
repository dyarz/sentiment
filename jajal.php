<?php
 include("checkngram.php");
echo "<pre>";
 
$dataku = array(
 
"angka" => array(1 => "satu", 2 => "dua", 3 => "tiga"),
 
"huruf" => array("A","B","C")
 
);
 
print_r($dataku);
 
echo "</pre>";
 
$ckkata=new checkNgram();
echo $ckkata->cek_sentiment('ku','positif');
?>