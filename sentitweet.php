<?php	//error_reporting(0);
    include("execTime.php"); 
    $times=new execTime();
    $time=$times->time_start();
	include ("api/twitteroauth/twitteroauth.php");
	include("filtering.php");
	$consumer="IAZgBvQsokLVt5S9NifJSxRBX";
	$consumerapi="PWRD0KrXcGQeUUwppXb8aD9VnbFPZZ9nnhbJpcWcI1kNdW0DDy" ;
	$accesstoken="59553480-QrcGHAbZsnwgcJTjSD4RkA409RQfzOeaA55d2NrkR";
	$accestokenscr="zjmcK7TL7UygddxTl2guJfvnJRaCGdCmORRR5CPznm6Ur";
	
	$twitter= new TwitterOAuth($consumer,$consumerapi,$accesstoken,$accestokenscr);
	ini_set('max_execution_time', 0);
 ?>
<html>
    <head><meta charset="utf-8">
            <title>Search Sentiment</title>
<!-- start: CSS -->
	<link id="bootstrap-style" href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link id="base-style" href="assets/css/style.css" rel="stylesheet">
	<link id="base-style-responsive" href="assets/css/style-responsive.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>
	<!-- end: CSS -->
    </head>
    <body>
        <form action="" method="post">
                Topik   :
                <input type="text" name="searchkey" autocomplete="off" class="inputSuccess">
                <button>Cari</button>
        </form>
            <?php include("koneksi.php");
				
                if(isset($_POST['searchkey'])){
                    $searching= $_POST['searchkey'];
                    $search=urlencode($searching);  
					$sid=array("567250000000000000","567260000000000000","567270000000000000","567280000000000000","567290000000000000",
					"567300000000000000","567310000000000000","567320000000000000","567330000000000000","567340000000000000",
					"567350000000000000","567360000000000000","567370000000000000","567380000000000000","567390000000000000",
					"567400000000000000","567410000000000000","567420000000000000","567430000000000000","567440000000000000",
					"567450000000000000","567460000000000000","567470000000000000","567480000000000000","567490000000000000",
					"567500000000000000","567510000000000000","567520000000000000","567530000000000000","567540000000000000",
					"567550000000000000","567560000000000000","567570000000000000","567580000000000000","567590000000000000",
					"567600000000000000","567610000000000000","567620000000000000","567630000000000000","567640000000000000",
					"567650000000000000","567660000000000000","567670000000000000","567680000000000000","567690000000000000");
					$i=1;
					//for($a=0;$a<44;$a++){
						
						$tweets=$twitter->get("https://api.twitter.com/1.1/search/tweets.json?q=".$search."&count=100");
						//&since_id=".$sid[$a]."&max_id=".$sid[$a+1]);
						if(isset($tweets->statuses)&& is_array($tweets->statuses)){
							if(count($tweets->statuses)){
									$temp=array();
									$remo=new filtering();
								foreach($tweets->statuses as $t){
										$tword=$t->text;
										$twordend=$remo->remove_hashtags($remo->remove_URL($tword));
										$wod=$twordend;
										$words="%".$twordend."%";
										$ps=$dbnew->prepare("SELECT * FROM rawtweets where tweet_text like ?");
										$ps->bindParam(1,$words);
										$ps->execute();	
										$row=$ps->rowCount();
										tutupkoneksi();
										//echo $row."<br/>";
										if($row===0 && !in_array($wod,$temp)){	//---menghilangkan tweet yang sama									
										?>
											
										<table padding="10">
											<tr>
												<td><?php echo $i." ".$t->id_str ;
													$twid=$t->id_str;
													$usid=$t->user->id;
													$dp=$t->user->profile_image_url;
													$scrname=$t->user->screen_name;
												?></td>
												<td rowspan="2">
													<img src="<?php echo $t->user->profile_image_url ?>"/>
												</td>
												<td>
													<?php echo "@".$t->user->screen_name ."&nbsp: "?> 
												</td>
												<td>
													<?php 
														$word=$t->text;										//---start bold kata
														// $sbold="<strong>".$searching."</strong>";
														// $wordend=str_ireplace($searching, $sbold, $word); //---end bold kata 
														$wordend=$remo->remove_hashtags($remo->remove_URL($word));
														echo $wordend;																
														$temp[]=$wordend;
													 ?>
												</td>
											</tr>
											<tr>
												<td></td>
												<td colspan="2">
													<?php 
													$date=date_create($t->created_at);
													$twd=date_format($date,'Y-m-d H:i:s');
													
													echo date_format($date,'d-m-Y H:i:s'); $i++; ?>
												</td>    
											</tr>
										</table>
							 <?php 
											$ps=$dbnew->prepare("INSERT INTO rawtweets(`id`, `tweet_id`, `tweet_text`,`created_at`,`user_id`,`screen_name`,`profile_image_url`) VALUES ('',?,?,?,?,?,?)");
											$ps->bindParam(1,$twid);
											$ps->bindParam(2,$wordend);
											$ps->bindParam(3,$twd);
											$ps->bindParam(4,$usid);
											$ps->bindParam(5,$scrname);
											$ps->bindParam(6,$dp);
											
											$ps->execute();	
											tutupkoneksi();
										}else{
											continue;
										}
										
								}
							}
						}
                   //}
                }
  echo "waktu eksekusi ".$times->time_stop($time)." detik";
        
        ?>

   </body>
</html>