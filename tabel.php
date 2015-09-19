<!DOCTYPE html>
<html lang="en">
<head>
	
	
	<!-- start: CSS -->
	<link id="bootstrap-style" href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link id="base-style" href="assets/css/style.css" rel="stylesheet">
	<link id="base-style-responsive" href="assets/css/style-responsive.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>
	<!-- end: CSS -->
	
		
		
</head>

<body>
		
	
		<div class="container-fluid-full">
		<div class="row-fluid">
			<noscript>
				<div class="alert alert-block span10">
					<h4 class="alert-heading">Warning!</h4>
					<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
				</div>
			</noscript>
			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon user"></i><span class="break"></span>Tweet yang sudah di filter</h2>
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
						$ps=$dbnew->prepare("SELECT * FROM tweetfilter ORDER BY id ASC LIMIT $awal,$per_halaman");
						$ps->execute();	?>
						<table class="table table-striped table-bordered bootstrap-datatable">
						
								<tbody>
								<?php while($rs=$ps->fetch(PDO::FETCH_NUM)){?>
								<tr>
									<td rowspan="2">
										<?php echo $rs[0];?>
									</td>
								
									<td >
										<?php echo "@".$rs[4] ."&nbsp: "?> 
									</td>
									<td>
										<?php 
											echo $rs[2];																
										?>
									</td>
									<td rowspan="2">SET To Positif</td>
									<td rowspan="2">SET To Negatif</td>
									<td rowspan="2">SET To Netral</td>
									
									<td rowspan="2">Delete</td>
								</tr>
								<tr>
									<td colspan="2">
										<?php 
									
										echo $rs[3]; ?>
									</td>    
									
									
								</tr>
								
						<?php }?>
						  </tbody>
					  </table>            
					</div>
					<?php	
						$hasil=$dbnew->prepare("SELECT * FROM tweetfilter");
						$hasil->execute();
						$jumlah=$hasil->rowCount();

						$total_halaman=ceil($jumlah/$per_halaman);?>
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
										echo "<li class='first'><a href='?pid=".md5('lihatfilter')."&p=1'>";
												echo "First </a></li>"; 
										echo "<li class='prev'><a href='?pid=".md5('lihatfilter')."&p=".$pd."'>";
												echo "Prev </a></li>"; 
										
									}	
									
									for ($i=$startpage; $i<=$endpage; $i++) { 
												if($i===$page){
													echo "<li class='active'><a href='?pid=".md5('lihatfilter')."&p=".$i."'>";
													echo $i."</a></li>"; 
												}else{
													echo "<li><a href='?pid=".md5('lihatfilter')."&p=".$i."'>";
													echo $i."</a></li>"; 
												}
									};
									if($endpage<$total_halaman||$page<$total_halaman){
										echo"<li class='spaces'><a>...</a></li>";
										$pd=$page+1;
										echo "<li class='next'><a href='?pid=".md5('lihatfilter')."&p=".$pd."'>";
												echo "Next </a></li>"; 
										echo "<li class='last'><a href='?pid=".md5('lihatfilter')."&p=".$total_halaman."'>";
												echo "Last </a></li>"; 
										
										
										
									}
								?>
								</ul>
						</div>
						
					</div>
				</div><!--/span-->
			
			</div><!--/row-->

		

	</div><!--/.fluid-container-->
	
			<!-- end: Content -->
	
		</div><!--/fluid-row-->
		
	<div class="modal hide fade" id="myModal">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">×</button>
			<h3>Settings</h3>
		</div>
		<div class="modal-body">
			<p>Here settings can be configured...</p>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn" data-dismiss="modal">Close</a>
			<a href="#" class="btn btn-primary">Save changes</a>
		</div>
	</div>
	
	<div class="clearfix"></div>
	
	
	
	<!-- start: JavaScript-->

		<script src="js/jquery-1.9.1.min.js"></script>
	<script src="js/jquery-migrate-1.0.0.min.js"></script>
	
		<script src="js/jquery-ui-1.10.0.custom.min.js"></script>
	
		<script src="js/jquery.ui.touch-punch.js"></script>
	
		<script src="js/modernizr.js"></script>
	
		<script src="js/bootstrap.min.js"></script>
	
		<script src="js/jquery.cookie.js"></script>
	
		<script src='js/fullcalendar.min.js'></script>
	
		<script src='js/jquery.dataTables.min.js'></script>

		<script src="js/excanvas.js"></script>
	<script src="js/jquery.flot.js"></script>
	<script src="js/jquery.flot.pie.js"></script>
	<script src="js/jquery.flot.stack.js"></script>
	<script src="js/jquery.flot.resize.min.js"></script>
	
		<script src="js/jquery.chosen.min.js"></script>
	
		<script src="js/jquery.uniform.min.js"></script>
		
		<script src="js/jquery.cleditor.min.js"></script>
	
		<script src="js/jquery.noty.js"></script>
	
		<script src="js/jquery.elfinder.min.js"></script>
	
		<script src="js/jquery.raty.min.js"></script>
	
		<script src="js/jquery.iphone.toggle.js"></script>
	
		<script src="js/jquery.uploadify-3.1.min.js"></script>
	
		<script src="js/jquery.gritter.min.js"></script>
	
		<script src="js/jquery.imagesloaded.js"></script>
	
		<script src="js/jquery.masonry.min.js"></script>
	
		<script src="js/jquery.knob.modified.js"></script>
	
		<script src="js/jquery.sparkline.min.js"></script>
	
		<script src="js/counter.js"></script>
	
		<script src="js/retina.js"></script>

		<script src="js/custom.js"></script>
	<!-- end: JavaScript-->
	
</body>
</html>
