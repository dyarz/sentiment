<?php 
require_once __DIR__ . '/vendor/autoload.php';
include("filtering.php");
$stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
$stemmer  = $stemmerFactory->createStemmer();
if(isset($_GET['act'])&&$_GET['act']=="positif"){
		$ids=$_GET['id'];
		include ("koneksi.php");
		$ps=$dbnew->prepare("SELECT tweet_id,tweet_text,screen_name FROM rawtweets WHERE id = ?");
		$ps->bindParam(1,$ids);
		$ps->execute();
		$rsd=$ps->fetch(PDO::FETCH_NUM);
		$twid=$rsd[0];
		$twtxt=$rsd[1];
		$scrname=$rsd[2];
		tutupkoneksi();
    
    $psa=$dbnew->prepare("SELECT * FROM tb_stopword");
    $psa->execute();
	$pattern=array();
	 while($rs=$psa->fetch(PDO::FETCH_ASSOC)){
				        array_push($pattern,"/\b".$rs['katastopword']."\b/");
	 }
	 tutupkoneksi();
   
		$twt = strtolower($twtxt);
		$hash=new filtering();
		$rem_all=$hash->remove_all_clear($twt);
		$rem_stop=preg_replace($pattern,"",$rem_all);
	
        $sentence = $rem_stop;
        $output = $stemmer->stem($sentence); 
      //  var_dump($output);
            $psi=$dbnew->prepare("INSERT INTO `datalatih`(`tweet_id`, `tweet_text`,`screen_name`,`sentiment`) VALUES (?,?,?,'positif')");
            $psi->bindParam(1,$twid);
            $psi->bindParam(2,$output);
            $psi->bindParam(3,$scrname);
            $psi->execute();	
            tutupkoneksi();
    
    
    
		$ps=$dbnew->prepare("DELETE FROM rawtweets WHERE id= ?");
		$ps->bindParam(1,$ids);
		$ps->execute();
		tutupkoneksi();	
	    echo "<script>window.alert('Artikel Berhasil di Set POSITIF !!! dan di delete pada tabel rawtweets');
							 window.location=('index.php?pid=".md5('lihatraw')."')</script>";
	}else if(isset($_GET['act'])&&$_GET['act']=="negatif"){
			$ids=$_GET['id'];
		include ("koneksi.php");
		$ps=$dbnew->prepare("SELECT tweet_id,tweet_text,screen_name FROM rawtweets WHERE id = ?");
		$ps->bindParam(1,$ids);
		$ps->execute();
		$rsd=$ps->fetch(PDO::FETCH_NUM);
		$twid=$rsd[0];
		$twtxt=$rsd[1];
		$scrname=$rsd[2];
		tutupkoneksi();
    
    $psa=$dbnew->prepare("SELECT * FROM tb_stopword");
    $psa->execute();
	$pattern=array();
	 while($rs=$psa->fetch(PDO::FETCH_ASSOC)){
				        array_push($pattern,"/\b".$rs['katastopword']."\b/");
	 }
	 tutupkoneksi();
   
		$twt = strtolower($twtxt);
		$hash=new filtering();
		$rem_all=$hash->remove_all_clear($twt);
		$rem_stop=preg_replace($pattern,"",$rem_all);
	
		 $sentence = $rem_stop;
        $output = $stemmer->stem($sentence);    
		$psi=$dbnew->prepare("INSERT INTO `datalatih`(`tweet_id`, `tweet_text`,`screen_name`,`sentiment`) VALUES (?,?,?,'negatif')");
		$psi->bindParam(1,$twid);
		$psi->bindParam(2,$output);
		$psi->bindParam(3,$scrname);
		$psi->execute();	
		tutupkoneksi();
    
		$ps=$dbnew->prepare("DELETE FROM rawtweets WHERE id= ?");
		$ps->bindParam(1,$ids);
		$ps->execute();
		tutupkoneksi();	
	    echo "<script>window.alert('Artikel Berhasil di Set NEGATIF !!! dan di delete pada tabel rawtweets');
							 window.location=('index.php?pid=".md5('lihatraw')."')</script>";
	}elseif(isset($_GET['act'])&&$_GET['act']=="netral"){
			$ids=$_GET['id'];
		include ("koneksi.php");
		$ps=$dbnew->prepare("SELECT tweet_id,tweet_text,screen_name FROM rawtweets WHERE id = ?");
		$ps->bindParam(1,$ids);
		$ps->execute();
		$rsd=$ps->fetch(PDO::FETCH_NUM);
		$twid=$rsd[0];
		$twtxt=$rsd[1];
		$scrname=$rsd[2];
		tutupkoneksi();
    
    $psa=$dbnew->prepare("SELECT * FROM tb_stopword");
    $psa->execute();
	$pattern=array();
	 while($rs=$psa->fetch(PDO::FETCH_ASSOC)){
				        array_push($pattern,"/\b".$rs['katastopword']."\b/");
	 }
	 tutupkoneksi();
   
		$twt = strtolower($twtxt);
		$hash=new filtering();
		$rem_all=$hash->remove_all_clear($twt);
		$rem_stop=preg_replace($pattern,"",$rem_all);
	
		    $sentence = $rem_stop;
        $output = $stemmer->stem($sentence); 
		$psi=$dbnew->prepare("INSERT INTO `datalatih`(`tweet_id`, `tweet_text`,`screen_name`,`sentiment`) VALUES (?,?,?,'netral')");
		$psi->bindParam(1,$twid);
		$psi->bindParam(2,$output);
		$psi->bindParam(3,$scrname);
		$psi->execute();	
		tutupkoneksi();
    
		$ps=$dbnew->prepare("DELETE FROM rawtweets WHERE id= ?");
		$ps->bindParam(1,$ids);
		$ps->execute();
		tutupkoneksi();	
	    echo "<script>window.alert('Artikel Berhasil di Set NETRAL !!! dan di delete pada tabel rawtweets');
							 window.location=('index.php?pid=".md5('lihatraw')."')</script>";
	
	}elseif(isset($_GET['act'])&&$_GET['act']=="delete"){
		$ids=$_GET['id'];
		include ("koneksi.php");
	
		$ps=$dbnew->prepare("DELETE FROM rawtweets WHERE id= ?");
		$ps->bindParam(1,$ids);
		$ps->execute();
		tutupkoneksi();	
	    echo "<script>window.alert('Artikel Berhasil di delete pada tabel rawtweets');
							 window.location=('index.php?pid=".md5('lihatraw')."')</script>";
	}elseif(isset($_POST['mtppositif'])){
		$mtpid=$_POST['cid'];
		//echo $mtpid[0];
		//count($mtpid));
		include ("koneksi.php");
		for($i=0;$i<count($mtpid);$i++){
			
			$ps=$dbnew->prepare("SELECT tweet_id,tweet_text,screen_name FROM rawtweets WHERE id = ?");
			$ps->bindParam(1,$mtpid[$i]);
			$ps->execute();
			$rsd=$ps->fetch(PDO::FETCH_NUM);
			$twid=$rsd[0];
			$twtxt=$rsd[1];
			$scrname=$rsd[2];
			tutupkoneksi();
            $psa=$dbnew->prepare("SELECT * FROM tb_stopword");
            $psa->execute();
            $pattern=array();
             while($rs=$psa->fetch(PDO::FETCH_ASSOC)){
                 array_push($pattern,"/\b".$rs['katastopword']."\b/");
             }
             tutupkoneksi();
            
            $twt = strtolower($twtxt);
            $hash=new filtering();
            $rem_all=$hash->remove_all_clear($twt);
            $rem_stop=preg_replace($pattern,"",$rem_all);
            $sentence = $rem_stop;
            $output = $stemmer->stem($sentence);
            
			$ps=$dbnew->prepare("INSERT INTO `datalatih`(`tweet_id`, `tweet_text`,`screen_name`,`sentiment`) VALUES(?,?,?,'positif')");
			$ps->bindParam(1,$twid);
			$ps->bindParam(2,$output);
			$ps->bindParam(3,$scrname);
			$ps->execute();	
			tutupkoneksi();
		
			$ps=$dbnew->prepare("DELETE FROM rawtweets WHERE id= ?");
			$ps->bindParam(1,$mtpid[$i]);
			$ps->execute();
			tutupkoneksi();	
				
		}
		 echo "<script>window.alert('Artikel Berhasil di Set POSITIF !!! dan di delete pada tabel rawtweets');
							 window.location=('index.php?pid=".md5('lihatraw')."')</script>";
	}elseif(isset($_POST['mtpnegatif'])){
        $mtpid=$_POST['cid'];
        //echo $mtpid[0];
        //count($mtpid));
        include ("koneksi.php");
        for($i=0;$i<count($mtpid);$i++){

            $ps=$dbnew->prepare("SELECT tweet_id,tweet_text,screen_name FROM rawtweets WHERE id = ?");
            $ps->bindParam(1,$mtpid[$i]);
            $ps->execute();
            $rsd=$ps->fetch(PDO::FETCH_NUM);
            $twid=$rsd[0];
            $twtxt=$rsd[1];
            $scrname=$rsd[2];
            tutupkoneksi();
            $psa=$dbnew->prepare("SELECT * FROM tb_stopword");
            $psa->execute();
            $pattern=array();
            while($rs=$psa->fetch(PDO::FETCH_ASSOC)){
                array_push($pattern,"/\b".$rs['katastopword']."\b/");
            }
            tutupkoneksi();

            $twt = strtolower($twtxt);
            $hash=new filtering();
            $rem_all=$hash->remove_all_clear($twt);
            $rem_stop=preg_replace($pattern,"",$rem_all);
            $sentence = $rem_stop;
            $output = $stemmer->stem($sentence);
            $ps=$dbnew->prepare("INSERT INTO `datalatih`(`tweet_id`, `tweet_text`,`screen_name`,`sentiment`) VALUES (?,?,?,'negatif')");
            $ps->bindParam(1,$twid);
            $ps->bindParam(2,$output);
            $ps->bindParam(3,$scrname);
            $ps->execute();	
            tutupkoneksi();

            $ps=$dbnew->prepare("DELETE FROM rawtweets WHERE id= ?");
            $ps->bindParam(1,$mtpid[$i]);
            $ps->execute();
            tutupkoneksi();	

        }
        echo "<script>window.alert('Artikel Berhasil di Set NEGATIF !!! dan di delete pada tabel rawtweets');
        window.location=('index.php?pid=".md5('lihatraw')."')</script>";
	}elseif(isset($_POST['mtpnetral'])){
        $mtpid=$_POST['cid'];
        //echo $mtpid[0];
        //count($mtpid));
        include ("koneksi.php");
        for($i=0;$i<count($mtpid);$i++){

            $ps=$dbnew->prepare("SELECT tweet_id,tweet_text,screen_name FROM rawtweets WHERE id = ?");
            $ps->bindParam(1,$mtpid[$i]);
            $ps->execute();
            $rsd=$ps->fetch(PDO::FETCH_NUM);
            $twid=$rsd[0];
            $twtxt=$rsd[1];
            $scrname=$rsd[2];
            tutupkoneksi();
            $psa=$dbnew->prepare("SELECT * FROM tb_stopword");
            $psa->execute();
            $pattern=array();
            while($rs=$psa->fetch(PDO::FETCH_ASSOC)){
                        array_push($pattern,"/\b".$rs['katastopword']."\b/");
            }
            tutupkoneksi();

            $twt = strtolower($twtxt);
            $hash=new filtering();
            $rem_all=$hash->remove_all_clear($twt);
            $rem_stop=preg_replace($pattern,"",$rem_all);
            $sentence = $rem_stop;
            $output = $stemmer->stem($sentence);
            $ps=$dbnew->prepare("INSERT INTO `datalatih`(`tweet_id`, `tweet_text`,`screen_name`,`sentiment`) VALUES (?,?,?,'netral')");
            $ps->bindParam(1,$twid);
            $ps->bindParam(2,$output);
            $ps->bindParam(3,$scrname);
            $ps->execute();	
            tutupkoneksi();

            $ps=$dbnew->prepare("DELETE FROM rawtweets WHERE id= ?");
            $ps->bindParam(1,$mtpid[$i]);
            $ps->execute();
            tutupkoneksi();	

        }
        echo "<script>window.alert('Artikel Berhasil di Set NETRAL !!! dan di delete pada tabel rawtweets');
                 window.location=('index.php?pid=".md5('lihatraw')."')</script>";
        }elseif(isset($_POST['mtpdelete'])){
        $mtpid=$_POST['cid'];
        //echo $mtpid[0];
        //count($mtpid));
        include ("koneksi.php");
        for($i=0;$i<count($mtpid);$i++){
        $ps=$dbnew->prepare("DELETE FROM rawtweets WHERE id= ?");
        $ps->bindParam(1,$mtpid[$i]);
        $ps->execute();
        tutupkoneksi();	

        }
        echo "<script>window.alert('Artikel Berhasil di delete pada tabel rawtweets');
        window.location=('index.php?pid=".md5('lihatraw')."')</script>";

	}elseif(isset($_POST['edtpositif'])){
          
            $twid=$_POST['idtweets'];
            include ("koneksi.php");
        
            $ps=$dbnew->prepare("UPDATE `datalatih` SET `sentiment`='positif' WHERE `tweet_id`=?");
            $ps->bindParam(1,$twid);
            $ps->execute();	
            tutupkoneksi();
            echo "<script>window.alert('Artikel Berhasil di positif');
            window.location=('index.php?pid=".md5('lihatlatih')."')</script>";
		
    }elseif(isset($_POST['edtnegatif'])){
           
            $twid=$_POST['idtweets'];
            include ("koneksi.php");
        
            $ps=$dbnew->prepare("UPDATE `datalatih` SET `sentiment`='negatif' WHERE `tweet_id`=?");
            $ps->bindParam(1,$twid);
            $ps->execute();	
            tutupkoneksi();
            echo "<script>window.alert('Artikel Berhasil di negatif');
            window.location=('index.php?pid=".md5('lihatlatih')."')</script>";
    }elseif(isset($_POST['edtnetral'])){
           
        $twid=$_POST['idtweets'];
            include ("koneksi.php");
        
            $ps=$dbnew->prepare("UPDATE `datalatih` SET `sentiment`='netral' WHERE `tweet_id`=?");
            $ps->bindParam(1,$twid);
            $ps->execute();	
            tutupkoneksi();
            echo "<script>window.alert('Artikel Berhasil di netral');
            window.location=('index.php?pid=".md5('lihatlatih')."')</script>";

    }elseif(isset($_POST['tambahstop'])){
          
            $stop=$_POST['stopword'];
            include ("koneksi.php");
        
            $ps=$dbnew->prepare("INSERT INTO `tb_stopword`(`id_stopword`,katastopword) VALUES('',?)");
            $ps->bindParam(1,$stop);
            $ps->execute();	
            tutupkoneksi();
            echo "<script>window.alert('Kata Berhasil Di Tambahkan');
            window.location=('index.php?pid=".md5('tambahstopword')."')</script>";
    }

?>