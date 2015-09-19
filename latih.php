<!DOCTYPE html>
<?php include("execTime.php"); 
    $times=new execTime();
    $time=$times->time_start();
   
?>

<html lang="en">
<head>
	
	
	<!-- start: CSS -->
	<link id="bootstrap-style" href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link id="base-style" href="assets/css/style.css" rel="stylesheet">
	<link id="base-style-responsive" href="assets/css/style-responsive.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>
	<!-- end: CSS -->
		
	<!-- start: JavaScript-->
        <script>
              

            $(document).on("click", ".open-AddBookDialog", function () {
                 var myBookId = $(this).data('id');
                 var sentId= $(this).data('sent-id');
                $(".modal-header #coba").text ( myBookId);
                
                 $(".modal-body #idtweets").val( myBookId );
                if(sentId=="positif"){
                     document.getElementById("edtpositif").disabled = true;
                     document.getElementById("edtnetral").disabled = false;
                     document.getElementById("edtnegatif").disabled = false;
                }else if(sentId=="netral"){
                     document.getElementById("edtpositif").disabled = false;
                     document.getElementById("edtnetral").disabled = true;
                     document.getElementById("edtnegatif").disabled = false;
                }else if(sentId=="negatif"){
                    document.getElementById("edtpositif").disabled = false;
                     document.getElementById("edtnetral").disabled = false;
                     document.getElementById("edtnegatif").disabled = true;
                }
            });



        </script>
       
	<!-- end: JavaScript-->
		
		
</head>

<body>
		<div class="modal hide" id="addBookDialog">
             <div class="modal-header">
                <button class="close" data-dismiss="modal">×</button>
                 <h3>Tweet id : <b id="coba"></b> <span id="senti"></span></h3>
             </div>
             <div class="modal-body">
                <center>
                 <form action="ai.php" method="POST">
                     <input type="hidden" name="idtweets" id="idtweets" value=""/>
                     <button class="btn btn-large btn-success btn-round" name="edtpositif" id="edtpositif" >Set Positif</button>	
                     <button class="btn btn-large btn-warning btn-round" name="edtnegatif" id="edtnegatif">Set Negatif</button>
                    <button class="btn btn-large btn-info btn-round" name="edtnetral" id="edtnetral">Set Netral</i></button>    
                 </form>
                 </center>
             </div>
        </div>
	
		<div class="container-fluid-full">
		<div class="row-fluid">
			<noscript>
				<div class="alert alert-block span10">
					<h4 class="alert-heading">Warning!</h4>
					<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
				</div>
			</noscript>
			<div class="row-fluid sortable">		
				<div class="box span11">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon tag"></i><span class="break"></span>Tweet yang sudah di filter</h2>
						<div class="box-icon">
							<a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
							<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
						</div>
					</div>
					<div class="box-content">
					<?php 
						include("koneksi.php");
						if(isset($_GET["p"])){$page=$_GET["p"];}else{$page=1;};
						$per_halaman=10;
						$awal=($page-1)*$per_halaman;
						$ps=$dbnew->prepare("SELECT * FROM datalatih ORDER BY tweet_id DESC LIMIT $awal,$per_halaman");
						$ps->execute();	?>
						<table class="table table-striped table-bordered bootstrap-datatable">
								<thead>
									<tr>
										<th>Tweet ID</th>
										<th>Username</th>
										<th>Tweet</th>
										<th>Sentiment</th>
										<th>Edit</th>
									</tr>
								</thead>
								<tbody>
								<?php while($rs=$ps->fetch(PDO::FETCH_NUM)){?>
								<tr>
									<td >
										<?php echo $rs[0];?>
									</td>
									<td >
										<?php echo "@".$rs[2];?>
									</td>
									<td >
										<?php echo $rs[1]?> 
									</td>
									
									<td >	<?php if($rs[3]=="positif"){?>
												<i class="btn btn-success"><?php echo $rs[3];?></i>
										  	<?php }else if($rs[3]=="negatif"){?>
												<i class="btn btn-warning"><?php echo $rs[3];?></i>
											<?php }else if($rs[3]=="netral"){?>
												<i class="btn btn-info"><?php echo $rs[3];?></i>
											<?php }?>
									</td>
                                    <td>
                                    <a data-toggle="modal" data-sent-id="<?php echo $rs[3] ?>" data-id="<?php echo $rs[0] ?>" class="open-AddBookDialog btn btn-primary" href="#addBookDialog">EDIT</a>


 
                                    </td>
								</tr>
								
						<?php }?>
						  </tbody>
					  </table>            
                    <?php 
                            $pos=$dbnew->prepare("SELECT * FROM datalatih WHERE sentiment='positif'");
                            $pos->execute();
                            $jumlahpos=$pos->rowCount();
                            echo "Jumlah Positif = ".$jumlahpos."<br>";
                            $neg=$dbnew->prepare("SELECT * FROM datalatih WHERE sentiment='negatif'");
                            $neg->execute();
                            $jumlahneg=$neg->rowCount();
                            echo "Jumlah Negatif = ".$jumlahneg."<br>";
                            $net=$dbnew->prepare("SELECT * FROM datalatih WHERE sentiment='netral'");
                            $net->execute();
                            $jumlahnet=$net->rowCount();
                            echo "Jumlah Netral = ".$jumlahnet."<br>";

                            $hasil=$dbnew->prepare("SELECT * FROM datalatih");
                            $hasil->execute();
                            $jumlah=$hasil->rowCount();
                            echo "Jumlah Tweet Latih : ".$jumlah."<br>";
                            
						$total_halaman=ceil($jumlah/$per_halaman);
						echo $page." dari ".$total_halaman." halaman <br>";
                       
                        ?>
                      
					</div>
													
						<div class="pagination">
								<ul>	
									<?php 
									$startpage=$page-4;
									$endpage=$page+4;
									if($startpage<=0){
										$endpage-=($startpage-1);
										$startpage=1;
									}
									if($endpage>$total_halaman){
										$endpage=$total_halaman;
									}
									
									if($startpage>1||$page>1){
										$pd=$page-1;
										echo "<li class='first'><a href='?pid=".md5('lihatlatih')."&p=1'>";
												echo "First </a></li>"; 
										echo "<li class='prev'><a href='?pid=".md5('lihatlatih')."&p=".$pd."'>";
												echo "Prev </a></li>"; 
										
									}	
									
									for ($i=$startpage; $i<=$endpage; $i++) { 
												if($i===$page){
													echo "<li class='active'><a href='?pid=".md5('lihatlatih')."&p=".$i."'>";
													echo $i."</a></li>"; 
												}else{
													echo "<li><a href='?pid=".md5('lihatlatih')."&p=".$i."'>";
													echo $i."</a></li>"; 
												}
									};
									if($endpage<$total_halaman||$page<$total_halaman){
										echo"<li class='spaces'><a>...</a></li>";
										$pd=$page+1;
										echo "<li class='next'><a href='?pid=".md5('lihatlatih')."&p=".$pd."'>";
												echo "Next </a></li>"; 
										echo "<li class='last'><a href='?pid=".md5('lihatlatih')."&p=".$total_halaman."'>";
												echo "Last </a></li>"; 
										
										
										
									}
								?>
								</ul>
						</div>
						
					</div>
				</div><!--/span-->
			
			</div><!--/row-->

		

	</div><!--/.fluid-container-->
	           <?php  echo "waktu eksekusi ".$times->time_stop($time)." detik";?>
			<!-- end: Content -->
	
		</div><!--/fluid-row-->
		
	   
	
	<div class="clearfix"></div>
	
	

	
</body>
</html>
