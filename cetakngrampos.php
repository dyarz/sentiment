<?php 
    $start=microtime(TRUE);
    ini_set('max_execution_time', 0);
    include("koneksi.php");
    include("ngram.php");
    include("checkngram.php");
//hapus data pengetahuan sebelumnya
    $op=$dbnew->prepare("TRUNCATE TABLE dok_sementara");
    $op->execute(); 
    tutupkoneksi();
    $lt=10;
    $jmldokumen=0;

    $ops=$dbnew->prepare("TRUNCATE TABLE n_gramsementara");
    $ops->execute();
    tutupkoneksi();
    $ops=$dbnew->prepare("TRUNCATE TABLE n_gram");
    $ops->execute(); 
    tutupkoneksi();
    echo "<h3>OLAH DATA TRAINING KATEGORI POSITIF</h3><br><br>";
/* Hitung data positif*/
    $ps=$dbnew->prepare("SELECT tweet_text FROM datalatih WHERE sentiment = 'positif' LIMIT $lt");
    $ps->execute();
      
    $jmlngram=0; //menghitung jmlah ngram probabilitas
    $jmlngramdok=0; //jumlah ngram 
    $jmlpos=0;
    
    while($rs=$ps->fetch(PDO::FETCH_NUM)){
        $mngram=new ngrams();
        $ckkata=new checkNgram();
        $kata=$mngram->makengrams($rs[0],2);
        echo $rs[0]."<br><br>";
    
       
        $jml=count($kata);
        $jmlngramdok=(int)$jmlngramdok+$jml;
        echo "jumlah ngram: ".$jml."<br/>";
        echo "jumlah ngram keseluruhan: ".$jmlngramdok."<br/>";
        for($i=0;$i<count($kata);$i++){
           if($ckkata->cek_sentiment($kata[$i],'positif')==1){             
               $pso=$dbnew->prepare("SELECT kd_ngram,frekuensi FROM n_gramsementara WHERE n_gram=? AND sentiment='positif'");
               $pso->bindParam(1,$kata[$i]);
               $pso->execute();
               $rs=$pso->fetch(PDO::FETCH_NUM);
               $id=(int)$rs[0];
               $frek=$rs[1];
               $frok=(int)$frek+1;
               $psi=$dbnew->prepare("UPDATE n_gramsementara SET frekuensi=? WHERE kd_ngram=?");
               
               $psi->bindParam(1,$frok);
               $psi->bindParam(2,$id);  
               $psi->execute();
               $jmlngram=$jmlngram;
               //echo $frok."+".$kata[$i]."<br>"; //jika belum ada  kata ngram di insert didatabase +frekuensi ngram 1  
           }else{
               $frek=1;
               $psa=$dbnew->prepare("INSERT INTO `n_gramsementara`(`kd_ngram`, `n_gram`, `sentiment`, `frekuensi`) VALUES ('',?,'positif',?)");
               $psa->bindParam(1,$kata[$i]);
               $psa->bindParam(2,$frek);
               $psa->execute();
               //echo $frek."+".$kata[$i]."<br>"; //jika belum ada  kata ngram di insert didatabase +frekuensi ngram 1  
               $jmlngram=$jmlngram+1;
           }
            
            
        }
        $jmlpos=$jmlpos+1;
        $jmldokumen=$jmldokumen+1;
       
        echo "<br><br>";
        echo "jumlah NgramUnik : ".$jmlngram."<br>";
        var_dump($kata);    // tambah frekuensi dokumen di database
        echo "<br><br><br>";
    }tutupkoneksi();
    /* Hitung data negatif*/
    echo "<h3>OLAH DATA TRAINING KATEGORI NEGATIF</h3><br><br>";
    $ps=$dbnew->prepare("SELECT tweet_text FROM datalatih WHERE sentiment = 'negatif' LIMIT $lt");
    $ps->execute();
  
    $jmlngram=0; //menghitung jmlah ngram probabilitas
    $jmlngramdok=0; //jumlah ngram 
    $jmlneg=0;
    while($rs=$ps->fetch(PDO::FETCH_NUM)){
        $mngram=new ngrams();
        $ckkata=new checkNgram();
        $kata=$mngram->makengrams($rs[0],2);
        echo $rs[0]."<br><br>";
    
       
        $jml=count($kata);
        $jmlngramdok=(int)$jmlngramdok+$jml;
        echo "jumlah ngram: ".$jml."<br/>";
        echo "jumlah ngram keseluruhan: ".$jmlngramdok."<br/>";
        for($i=0;$i<count($kata);$i++){
         if($ckkata->cek_sentiment($kata[$i],'negatif')==1){             
               $pso=$dbnew->prepare("SELECT kd_ngram,frekuensi FROM n_gramsementara WHERE n_gram=? AND sentiment='negatif'");
               $pso->bindParam(1,$kata[$i]);
               $pso->execute();
               $rs=$pso->fetch(PDO::FETCH_NUM);
               $id=(int)$rs[0];
               $frek=$rs[1];
               $frok=(int)$frek+1;
               $psi=$dbnew->prepare("UPDATE n_gramsementara SET frekuensi=? WHERE kd_ngram=?");
               
               $psi->bindParam(1,$frok);
               $psi->bindParam(2,$id);  
               $psi->execute();
               $jmlngram=$jmlngram;
               //echo $frok."+".$kata[$i]."<br>"; //jika belum ada  kata ngram di insert didatabase +frekuensi ngram 1  
           }else{
               $frek=1;
               $psa=$dbnew->prepare("INSERT INTO `n_gramsementara`(`kd_ngram`, `n_gram`, `sentiment`, `frekuensi`) VALUES ('',?,'negatif',?)");
               $psa->bindParam(1,$kata[$i]);
               $psa->bindParam(2,$frek);
               $psa->execute();
               //echo $frek."+".$kata[$i]."<br>"; //jika belum ada  kata ngram di insert didatabase +frekuensi ngram 1  
               $jmlngram=$jmlngram+1;
           }
            
            
        }
         $jmlneg=$jmlneg+1;
        $jmldokumen=$jmldokumen+1;
       
        echo "<br><br>";
        echo "jumlah NgramUnik : ".$jmlngram."<br>";
        var_dump($kata);    // tambah frekuensi dokumen di database
        echo "<br><br><br>";
    }tutupkoneksi();
/* Hitung data netral*/
     echo "<h3>OLAH DATA TRAINING KATEGORI NETRAL</h3><br><br>";
    $ps=$dbnew->prepare("SELECT tweet_text FROM datalatih WHERE sentiment = 'netral' LIMIT $lt");
    $ps->execute();
  
    $jmlngram=0; //menghitung jmlah ngram probabilitas
    $jmlngramdok=0; //jumlah ngram 
    $jmlnet=0;
    while($rs=$ps->fetch(PDO::FETCH_NUM)){
        $mngram=new ngrams();
        $ckkata=new checkNgram();
        $kata=$mngram->makengrams($rs[0],2);
        echo $rs[0]."<br><br>";
    
       
        $jml=count($kata);
        $jmlngramdok=(int)$jmlngramdok+$jml;
        echo "jumlah ngram: ".$jml."<br/>";
        echo "jumlah ngram keseluruhan: ".$jmlngramdok."<br/>";
        for($i=0;$i<count($kata);$i++){
          if($ckkata->cek_sentiment($kata[$i],'netral')==1){             
               $pso=$dbnew->prepare("SELECT kd_ngram,frekuensi FROM n_gramsementara WHERE n_gram=? AND sentiment='netral'");
               $pso->bindParam(1,$kata[$i]);
               $pso->execute();
               $rs=$pso->fetch(PDO::FETCH_NUM);
               $id=(int)$rs[0];
               $frek=$rs[1];
               $frok=(int)$frek+1;
               $psi=$dbnew->prepare("UPDATE n_gramsementara SET frekuensi=? WHERE kd_ngram=?");
               
               $psi->bindParam(1,$frok);
               $psi->bindParam(2,$id);  
               $psi->execute();
               $jmlngram=$jmlngram;
               //echo $frok."+".$kata[$i]."<br>"; //jika belum ada  kata ngram di insert didatabase +frekuensi ngram 1  
           }else{
               $frek=1;
               $psa=$dbnew->prepare("INSERT INTO `n_gramsementara`(`kd_ngram`, `n_gram`, `sentiment`, `frekuensi`) VALUES ('',?,'netral',?)");
               $psa->bindParam(1,$kata[$i]);
               $psa->bindParam(2,$frek);
               $psa->execute();
               //echo $frek."+".$kata[$i]."<br>"; //jika belum ada  kata ngram di insert didatabase +frekuensi ngram 1  
               $jmlngram=$jmlngram+1;
           }
            
            
        }
        $jmlnet=$jmlnet+1;
        $jmldokumen=$jmldokumen+1;
       
        echo "<br><br>";
        echo "jumlah NgramUnik : ".$jmlngram."<br>";
        var_dump($kata);    // tambah frekuensi dokumen di database
        echo "<br><br><br>";
    }tutupkoneksi();

        $psd=$dbnew->prepare("SELECT * FROM n_gramsementara  WHERE sentiment='positif'");
        $psd->execute(); 
        while($rsa=$psd->fetch(PDO::FETCH_NUM)){
          
            $ngr=$rsa[1];
            $bagi=(int)$jmlngramdok+$jmlngram;
            $frek=$rsa[3];
            $frok=(int)$frek+1;
            $prob=(float)$frok/(int)$bagi;
             $psu=$dbnew->prepare("INSERT INTO `n_gram`(`kd_ngram`, `n_gram`, `sentiment`, `frekuensi`,probabilitas) VALUES ('',?,'positif',?,?)");
               $psu->bindParam(1,$ngr);
               $psu->bindParam(2,$frek);
               $psu->bindParam(3,$prob);
            
               $psu->execute();
               //echo $prob."+".$ngr."<br>";
        }tutupkoneksi();


        $psd=$dbnew->prepare("SELECT * FROM n_gramsementara WHERE sentiment='negatif'");
        $psd->execute(); 
        while($rsa=$psd->fetch(PDO::FETCH_NUM)){
          
            $ngr=$rsa[1];
            $bagi=(int)$jmlngramdok+$jmlngram;
            $frek=$rsa[3];
            $frok=(int)$frek+1;
            $prob=(float)$frok/(int)$bagi;
             $psu=$dbnew->prepare("INSERT INTO `n_gram`(`kd_ngram`, `n_gram`, `sentiment`, `frekuensi`,probabilitas) VALUES ('',?,'negatif',?,?)");
               $psu->bindParam(1,$ngr);
               $psu->bindParam(2,$frek);
               $psu->bindParam(3,$prob);
            
               $psu->execute();
               //echo $prob."+".$ngr."<br>";
        }tutupkoneksi();

        $psd=$dbnew->prepare("SELECT * FROM n_gramsementara  WHERE sentiment='netral'");
        $psd->execute(); 
        while($rsa=$psd->fetch(PDO::FETCH_NUM)){
          
            $ngr=$rsa[1];
            $bagi=(int)$jmlngramdok+$jmlngram;
            $frek=$rsa[3];
            $frok=(int)$frek+1;
            $prob=(float)$frok/(int)$bagi;      //P(xi|Vj)=nk+1/nk+jumlkata
             $psu=$dbnew->prepare("INSERT INTO `n_gram`(`kd_ngram`, `n_gram`, `sentiment`, `frekuensi`,probabilitas) VALUES ('',?,'netral',?,?)");
               $psu->bindParam(1,$ngr);
               $psu->bindParam(2,$frek);
               $psu->bindParam(3,$prob);
            
               $psu->execute();
               //echo $prob."+".$ngr."<br>";
        }tutupkoneksi();

        echo "<h3>OLAH DATA TRAINING MASUKAN KE DOKUMEN </h3><br><br>";
        $probdokpos=(int)$jmlpos/$jmldokumen; //p(positif)=jumlah dokumen positif/jumlah semua dokumen
        $probdokneg=(int)$jmlneg/$jmldokumen; //p(negatif)=jumlah dokumen positif/jumlah semua dokumen  
        $probdoknet=(int)$jmlnet/$jmldokumen; //p(netral)=jumlah dokumen positif/jumlah semua dokumen
        $psf=$dbnew->prepare("INSERT INTO `dok_sementara`(`probilitas`, `sentiment`, `jumdok`,jumngram) VALUES (?,'positif',?,?)");
        $psf->bindParam(1,$probdokpos);
        $psf->bindParam(2,$jmlpos);
        $psf->bindParam(3,$bagi);
        $psf->execute();
        $psf=$dbnew->prepare("INSERT INTO `dok_sementara`(`probilitas`, `sentiment`, `jumdok`,jumngram) VALUES (?,'negatif',?,?)");
        $psf->bindParam(1,$probdokneg);
        $psf->bindParam(2,$jmlneg);
        $psf->bindParam(3,$bagi);
        $psf->execute();
        $psf=$dbnew->prepare("INSERT INTO `dok_sementara`(`probilitas`, `sentiment`, `jumdok`,jumngram) VALUES (?,'netral',?,?)");
        $psf->bindParam(1,$probdoknet);
        $psf->bindParam(2,$jmlnet);
        $psf->bindParam(3,$bagi);
        $psf->execute();
        tutupkoneksi();
        echo "<h3>OLAH DATA TRAINING SELESAI</h3><br><br>";
        tutupkoneksi();
	$page_time = round(microtime(TRUE) - $start, 3) + '0.02'; // Get the time it took for the page to load
	echo "<br><br>Waktu Olah data :".$page_time. "<br>"; // Display the total time it took to load the page
?>