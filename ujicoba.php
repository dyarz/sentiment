<?php 
    require_once __DIR__ . '/vendor/autoload.php';
    include("koneksi.php");
    include("filtering.php");

    include("checkngram.php");
    include("ngram.php");
    ini_set('max_execution_time', 0);

    echo "<h1>Tunggu Sebentar Lagi Updating Data... .... ... !!!</h1>";
    $lt=1000;
    $ps=$dbnew->prepare("SELECT * FROM rawtweets ORDER BY id LIMIT $lt");
    $ps->execute();
    $psa=$dbnew->prepare("SELECT * FROM tb_stopword");
    $psa->execute();
    $pso=$dbnew->prepare("SELECT * FROM dok_sementara");
    $pso->execute();
	$rso=$pso->fetch(PDO::FETCH_NUM);
    $bagi=$rso[3];
    $pro=$rso[0];
    $pattern=array();
	 while($rsd=$psa->fetch(PDO::FETCH_ASSOC)){
				array_push($pattern,"/\b".$rsd['katastopword']."\b/");
	 }
    tutupkoneksi();
	$stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
    $stemmer  = $stemmerFactory->createStemmer();
    $i=0;
	while($rs=$ps->fetch(PDO::FETCH_NUM)){
        $id=$rs[1];
		$twt = strtolower($rs[2]);
        $scrname=$rs[5];
        // echo $twt."<br>";
		$hash=new filtering();
		$rem_all=$hash->remove_all_clear($twt);
        // echo $rem_all."<br>";
		$rem_stop=preg_replace($pattern,"",$rem_all);
		// echo $rem_stop."<br>";
		$sentence = $rem_stop;
        $output   = $stemmer->stem($sentence);
		$data[$i]['kata']=$output;
        $data[$i]['twid']=$id;
        $data[$i]['nama']=$scrname;
        $ids[]=$id;
//		//tutupkoneksi();
//        echo $data[$i]['twid']."<br>";
//        echo $data[$i]['kata']."<br>";
//        echo $data[$i]['nama']."<br>";
        $i=$i+1;
	}
   
    $i=0;
    $count=1;
      $totpos=0;
        $totneg=0;
        $totnet=0;
     while($count<=count($data)){
        $mngram=new ngrams();
        $ckkata=new checkNgram();
        $kata=$mngram->makengrams($data[$i]['kata'],2);
        $vmappos=1;
        $vmapneg=1;
        $vmapnet=1;
      
        for($a=0;$a<count($kata);$a++){
            if($ckkata->cek_ngram($kata[$a],'positif')==1){ 
                $jumvmp=$ckkata->cek_prob($kata[$a],'positif');
               // echo $ckkata->cek_prob($kata[$a],'positif')."<br>";
                $vmappos=$vmappos*$jumvmp*$pro;
                
            }else{
                $frek=0;
                $frok=(int)$frek+1;
                $prob=(float)$frok/(int)$bagi;
               // echo $prob."<br>";
                $vmappos=$vmappos*$jumvmp*$pro;
                
            }
            if($ckkata->cek_ngram($kata[$a],'negatif')==1){ 
                $jumvmp=$ckkata->cek_prob($kata[$a],'negatif');
                //echo $ckkata->cek_prob($kata[$a],'negatif')."<br>";
                $vmapneg=$vmapneg*$jumvmp*$pro;
                
            }else{
                $frek=0;
                $frok=(int)$frek+1;
                $prob=(float)$frok/(int)$bagi;
                //echo $prob."<br>";
                $vmapneg=$vmapneg*$jumvmp*$pro;
                
            }
            if($ckkata->cek_ngram($kata[$a],'netral')==1){ 
                $jumvmp=$ckkata->cek_prob($kata[$a],'netral');
                //echo $ckkata->cek_prob($kata[$a],'netral')."<br>";
                $vmapnet=$vmapnet*$jumvmp*$pro;
                
            }else{
                $frek=0;
                $frok=(int)$frek+1;
                $prob=(float)$frok/(int)$bagi;
                //echo $prob."<br>";
                $vmapnet=$vmapnet*$jumvmp*$pro;
                
            }
            //echo "<br><br>";
        }       
        echo "<br>".$data[$i]['kata']."<br>";
        echo "<br>KATA<br>";
        //var_dump($kata); 
        if($vmappos>$vmapneg && $vmappos>$vmapnet){
            echo "<br> Kata ini POSITIF<br>";
            $totpos+=1;
        }elseif($vmapneg>$vmappos && $vmapneg>$vmapnet){
            echo "<br> Kata ini NEGATIF<br>";
            $totneg+=1;
        }elseif($vmapnet>$vmappos && $vmapnet>$vmapneg){
            echo "<br> Kata ini NETRAL<br>";
            $totnet+=1;
        } 
        echo "<br>".$vmappos."<br>";
        echo "<br>".$vmapneg."<br>";
        echo "<br>".$vmapnet."<br>";
        $i+=1;
        $count+=1;
     }
    tutupkoneksi();
    
    echo "<br><br> TOTAL SENTIMENT<br>";
    echo "TOTAL TWEET = ".$lt."<br>";
    echo "TOTAL POSITIF =".$totpos."<br>";
    echo "TOTAL NEGATIF =".$totneg."<br>";
    echo "TOTAL NETRAL =".$totnet."<br>";

    echo "<br><br> DATA<br>";
    var_dump($data);
//    $key=array_search('1282',$ids);
//    print_r($data[$key]['id']);
//    unset ($data[$key]);
//    var_dump($data);




?>