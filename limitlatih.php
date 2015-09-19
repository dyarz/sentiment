<html>
        <head>
            <title></title>
        </head>
        <body>
         <div class="row-fluid sortable">
            <div class="box span12">
                <div class="box-header" data-original-title>
                    <h2><i class="halflings-icon edit"></i><span class="break"></span>Tentukan jumlah Limit Data Latih</h2>
                    
                </div>
                <div class="box-content">
                    <form class="form-horizontal" id="form" action="" method="post">
                        <label>LIMIT</label> <input type="text" name="limit" id="limit" autocomplete="off" class="inputSuccess">
                      
                        
                        <button type="submit" class="btn btn-primary" name="buatdata" id="buatdata">Buat Data Latih</button>
                        <p class="help-block">NB : Limit Data Latih</p>
                        <p class="help-block">semakin banyak data latih semakin akurat data pengetahuannya</p>
                        <p class="help-block">semakin lama proses eksekusi sistem</p>
                    </form>
                </div>
            </div><!--/span-->
          
          </div><!--/row-->
           <?php 
        
            if(isset($_POST['buatdata'])){ 
                include("execTime.php"); 
                $times=new execTime();
                $time=$times->time_start();
                ini_set('max_execution_time', 0);
                include("ngram.php");
                include("koneksi.php");
                
                include("checkngram.php");
              
                $op=$dbnew->prepare("TRUNCATE TABLE dok_sementara");
                $op->execute(); 
                tutupkoneksi();
                $lt=$_POST['limit'];
                $jmldokumen=0;
                $ops=$dbnew->prepare("TRUNCATE TABLE n_gramsementara");
                $ops->execute();
                tutupkoneksi();
                $ops=$dbnew->prepare("TRUNCATE TABLE n_gram");
                $ops->execute(); 
                tutupkoneksi();
                $pspos=$dbnew->prepare("SELECT * FROM datalatih WHERE sentiment = 'positif' LIMIT $lt");
                $pspos->execute();
                $psneg=$dbnew->prepare("SELECT * FROM datalatih WHERE sentiment = 'negatif' LIMIT $lt");
                $psneg->execute();
                $psnet=$dbnew->prepare("SELECT * FROM datalatih WHERE sentiment = 'netral' LIMIT $lt");
                $psnet->execute();
            ?>
          <div class="row-fluid sortable">
                 <div class="box span12">
                         <div class="box-header" data-original-title>
                            <h2><i class="halflings-icon edit"></i><span class="break"></span><?php echo $lt ?> Data Tweet Latih per Kategori Sentiment Yang Digunakan Untuk Data Pengetahuan</h2>

                        </div>
                       <div class="box-content">
                            <h3>Hapus data pengetahuan sebelumnya</h3>
                            <h4>Input data pengetahuan baru</h4>
                           <h3>OLAH DATA TRAINING KATEGORI POSITIF <?php echo $lt?> TWEET </h3>
                           <h3>OLAH DATA TRAINING KATEGORI NEGATIF <?php echo $lt?> TWEET</h3>
                           <h3>OLAH DATA TRAINING KATEGORI NETRAL <?php echo $lt?> TWEET</h3>
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th>Tweet ID</th>
								  <th>Username</th>
								  <th>Tweet</th>
								  <th>Sentiment</th>
							  </tr>
						  </thead>   
						  <tbody>
                           <?php  
        $jmlngram=0; //menghitung jmlah ngram probabilitas
        $jmlngramdok=0; //jumlah ngram 
        $jmlpos=0;
        while($rspos=$pspos->fetch(PDO::FETCH_NUM)){
                             
        $mngram=new ngrams();
        $ckkata=new checkNgram();
        $kata=$mngram->makengrams($rspos[1],2);
        $jml=count($kata);
        $jmlngramdok=(int)$jmlngramdok+$jml;
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
           }else{
               $frek=1;
               $psa=$dbnew->prepare("INSERT INTO `n_gramsementara`(`kd_ngram`, `n_gram`, `sentiment`, `frekuensi`) VALUES ('',?,'positif',?)");
               $psa->bindParam(1,$kata[$i]);
               $psa->bindParam(2,$frek);
               $psa->execute();
               $jmlngram=$jmlngram+1;
           }
        }
        $jmlpos=$jmlpos+1;
        $jmldokumen=$jmldokumen+1 ?>
                            <tr>
								<td class="center"><?php echo $rspos[0] ?></td>
								<td class="center"><?php echo $rspos[2] ?></td>
								<td class="center"><?php echo $rspos[1] ?></td>
								<td class="center">
                                           <i class="btn btn-success"><?php echo $rspos[3] ?></i>
                                 </td>
							</tr>
                                          
                            <?php }
                $jmlngram=0; //menghitung jmlah ngram probabilitas
        $jmlngramdok=0; //jumlah ngram 
        $jmlneg=0;
        while($rsneg=$psneg->fetch(PDO::FETCH_NUM)){
                             
        $mngram=new ngrams();
        $ckkata=new checkNgram();
        $kata=$mngram->makengrams($rsneg[1],2);
        $jml=count($kata);
        $jmlngramdok=(int)$jmlngramdok+$jml;
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
           }else{
               $frek=1;
               $psa=$dbnew->prepare("INSERT INTO `n_gramsementara`(`kd_ngram`, `n_gram`, `sentiment`, `frekuensi`) VALUES ('',?,'negatif',?)");
               $psa->bindParam(1,$kata[$i]);
               $psa->bindParam(2,$frek);
               $psa->execute();
               $jmlngram=$jmlngram+1;
           }
        }
        $jmlneg=$jmlneg+1;
        $jmldokumen=$jmldokumen+1 ?>
							<tr>
								<td class="center"><?php echo $rsneg[0] ?></td>
								<td class="center"><?php echo $rsneg[2] ?></td>
								<td class="center"><?php echo $rsneg[1] ?></td>
								<td class="center">	<i class="btn btn-info"><?php echo $rsneg[3] ?></i>
								</td>
							</tr>
                             <?php }tutupkoneksi();
                
               $jmlngram=0; //menghitung jmlah ngram probabilitas
        $jmlngramdok=0; //jumlah ngram 
        $jmlnet=0;
        while($rsnet=$psnet->fetch(PDO::FETCH_NUM)){
                             
        $mngram=new ngrams();
        $ckkata=new checkNgram();
        $kata=$mngram->makengrams($rsnet[1],2);
        $jml=count($kata);
        $jmlngramdok=(int)$jmlngramdok+$jml;
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
           }else{
               $frek=1;
               $psa=$dbnew->prepare("INSERT INTO `n_gramsementara`(`kd_ngram`, `n_gram`, `sentiment`, `frekuensi`) VALUES ('',?,'netral',?)");
               $psa->bindParam(1,$kata[$i]);
               $psa->bindParam(2,$frek);
               $psa->execute();
               $jmlngram=$jmlngram+1;
           }
        }
        $jmlnet=$jmlnet+1;
        $jmldokumen=$jmldokumen+1 ?>
							<tr>
								<td class="center"><?php echo $rsnet[0] ?></td>
								<td class="center"><?php echo $rsnet[2] ?></td>
								<td class="center"><?php echo $rsnet[1] ?></td>
								<td class="center">	<i class="btn btn-warning"><?php echo $rsnet[3] ?></i>
								</td>
							</tr>
                              <?php } ?>
						  </tbody>
					  </table> 
                    <?php 
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
	
                echo "waktu eksekusi ".$times->time_stop($time)." detik";
                           ?>       
					</div>
                     
                </div>
             </div>
        </div>
    <?php } ?>
        </body>   
</html>
