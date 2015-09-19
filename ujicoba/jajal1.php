<?php
include("../filtering.php");
include("../koneksi.php");

// $ps=$dbnew->prepare("SELECT * FROM tweetfilter WHERE id=6");
// $ps->execute();
// $rs=$ps->fetch(PDO::FETCH_NUM);
$email =strtolower("yadongs masih haha'@Vandarialfd: hahah sekarang sekolahmu masih pake kurikulum 2013? RT @Annisa_Andini1: dikamar:3 ohehe:3 @Vandarialfd:'");
$hash=new filtering();
$psa=$dbnew->prepare("SELECT * FROM tb_stopword");
$psa->execute();
$pattern=array();
 while($rs=$psa->fetch(PDO::FETCH_ASSOC)){
		array_push($pattern,"/\b".$rs['katastopword']."\b/");
 }
//print_r($pattern);	
	$rm=preg_replace($pattern,"",$email);
	$rem_all=$hash->remove_all_clear($rm);

// $em=$hash->remove_RT($rm);
// $td=$hash->remove_tbaca($em);
// $hstag=$hash->remove_hashtags($td);
// $math=$hash->remove_math($hstag); 
echo $email."<br>";echo $rem_all."<br>";//echo $em."<br>";
// echo $td."<br>";;echo $hstag."<br>";echo $math."<br><br>";



$adaurl="http://www.facebook.com/ <-http facebook https-> https://t.co/0nJt1hsAsx";
$ems=$hash->remove_URL($adaurl);

echo "<br>".$adaurl."<br>";
echo $ems;
?>
