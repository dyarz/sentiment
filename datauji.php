<html>
        <head>
            <title></title>
        </head>
        <body>
         <div class="row-fluid sortable">
            <div class="box span12">
                <div class="box-header" data-original-title>
                    <h2><i class="halflings-icon edit"></i><span class="break"></span>Tentukan jumlah Data Yang Akan di Ujicoba</h2>
                    
                </div>
                <div class="box-content">
                    <form class="form-horizontal" id="form" action="" method="post">
                        <label>Jumlah Data</label> <input type="text" name="limit" id="limit" autocomplete="off" class="inputSuccess">
                      
                        
                        <button type="submit" class="btn btn-primary" name="buatdata" id="buatdata">Buat Data Uji</button>
                        <p class="help-block">NB : Jumlah data ujicoba</p>
                        <p class="help-block">Digunakan untuk mencoba akurasi data latih </p>
                    </form>
                </div>
            </div><!--/span-->
          
          </div><!--/row-->
          <?php  if(isset($_POST['buatdata'])){
        
                include("execTime.php"); 
                $times=new execTime();
                $time=$times->time_start(); 
                include("koneksi.php");
                
                ini_set('max_execution_time', 0);
                
                $lt=$_POST['limit'];
                $psd=$dbnew->prepare("SELECT * FROM n_gram");
                $psd->execute();
                $jumlah=$psd->fetchAll();
                $count=count($jumlah);
                if($count>0){
                    require_once __DIR__ . '/vendor/autoload.php';
                    include("filtering.php");

                    include("checkngram.php");
                    include("ngram.php");
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
                    while($rsd=$psa->fetch(PDO::FETCH_ASSOC)){     array_push($pattern,"/\b".$rsd['katastopword']."\b/");
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
                $cnt=1;
                $totpos=0;
                $totneg=0;
                $totnet=0;    
            ?>
            <div class="row-fluid sortable">
                 <div class="box span12">
                         <div class="box-header" data-original-title>
                            <h2><i class="halflings-icon edit"></i><span class="break"></span><?php echo $lt ?> Data Ujicoba</h2>

                        </div>
                       <div class="box-content">
                        <table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th>Tweet ID</th>
								  <th>Username</th>
								  <th>Tweet</th>
								  <th>Hasil Sentiment</th>
							  </tr>
						  </thead>   
						  <tbody>
                              <?php while($cnt<=count($data)){
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
                                                $jumvmp=$prob;
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
                                                //echo $prob."<br>";\
                                                $jumvmp=$prob;
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
                                                 $jumvmp=$prob;
                                                $vmapnet=$vmapnet*$jumvmp*$pro;

                                            }
                              
                                       } 

                                ?>
                             <tr>
								  <td><?php echo $data[$i]['twid'];?></td>
								  <td><?php echo $data[$i]['nama'];?></td>
								  <td><?php echo $data[$i]['kata'];?></td>
								  <td><?php if($vmappos>$vmapneg && $vmappos>$vmapnet){?>
												<i class="btn btn-success">POSITIF</i>
										  	<?php $totpos+=1; 
                                                 }else if($vmapneg>$vmappos && $vmapneg>$vmapnet){?>
												<i class="btn btn-warning">NEGATIF</i>
											<?php  $totneg+=1;
                                                }else if($vmapnet>$vmappos && $vmapnet>$vmapneg){?>
												<i class="btn btn-info">NETRAL</i>
											<?php $totnet+=1;
                                                }
                                      $i+=1;
                                    $cnt+=1;
                                } tutupkoneksi();?></td>
							  </tr>    
                          </tbody>
                    </table>
                        <?php 
                            echo "<br><br> TOTAL SENTIMENT<br>";
                            echo "TOTAL TWEET = ".$lt."<br>";
                            echo "TOTAL POSITIF =".$totpos."<br>";
                            echo "TOTAL NEGATIF =".$totneg."<br>";
                            echo "TOTAL NETRAL =".$totnet."<br>";
                           
                          ?>    
                     </div>
                </div>
            </div>
            <?php }else{ ?>
                    <div class="row-fluid sortable">
                        <div class="box span12">
                        <div class="box-header" data-original-title>
                    <h2><i class="halflings-icon edit"></i><span class="break"></span>Warning !!!</h2>

                    </div>
                    <div class="box-content">
                        <h1>Data Latih Belum Dibuat</h1>
                        <h2>Klik <a href="?pid=<?php	echo md5('buatlatih')?>">Link</a> ini</h2>
                    </div>
                  </div>
                </div>
            <?php }
                echo "waktu eksekusi ".$times->time_stop($time)." detik"; 
        }?>
 </body>   
</html>
