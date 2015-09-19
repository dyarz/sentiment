<!DOCTYPE html>
<?php ini_set('max_execution_time', 0);?>
<html lang="en">
<head>
	
	<!-- start: Meta -->
	<meta charset="utf-8">
	<title>Sentiment Twitter Opinion</title>
	<meta name="description" content="Sentiment Twitter Opinion Analysis">
	<meta name="author" content="DyarsaSP">
	<meta name="keyword" content="Sentiment, Twitter, Opinion, Analysis,Opini Tweet">
	<!-- end: Meta -->
	
	<!-- start: Mobile Specific -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- end: Mobile Specific -->
	
	<!-- start: CSS -->
	<link id="bootstrap-style" href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link id="base-style" href="assets/css/style.css" rel="stylesheet">
	<link id="base-style-responsive" href="assets/css/style-responsive.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>
	<!-- end: CSS -->
	

	<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<link id="ie-style" href="css/ie.css" rel="stylesheet">
	<![endif]-->
	
	<!--[if IE 9]>
		<link id="ie9style" href="css/ie9.css" rel="stylesheet">
	<![endif]-->
		
	<!-- start: Favicon -->
	<link rel="shortcut icon" href="img/favicon.ico">
	<!-- end: Favicon -->
	
		<script src="assets/js/jquery-1.9.1.min.js"></script>
		<script src="assets/js/jquery-migrate-1.0.0.min.js"></script>
	
		<script src="assets/js/jquery-ui-1.10.0.custom.min.js"></script>
	
		<script src="assets/js/jquery.ui.touch-punch.js"></script>
	
		<script src="assets/js/modernizr.js"></script>
	
		<script src="assets/js/bootstrap.js"></script>
		<script src="assets/js/jquery.validate.min.js"></script>
    
		<script src="assets/js/additional-methods.min.js"></script>
	
		<script src="assets/js/jquery.cookie.js"></script>
	
		<script src='assets/js/fullcalendar.min.js'></script>
	
		<script src='assets/js/jquery.dataTables.min.js'></script>

		<script src="assets/js/excanvas.js"></script>
		<script src="assets/js/jquery.flot.js"></script>
		<script src="assets/js/jquery.flot.pie.js"></script>
		<script src="assets/js/jquery.flot.stack.js"></script>
		<script src="assets/js/jquery.flot.resize.min.js"></script>
	
		<script src="assets/js/jquery.chosen.min.js"></script>
	
		<script src="assets/js/jquery.uniform.min.js"></script>
		
		<script src="assets/js/jquery.cleditor.min.js"></script>
	
		<script src="assets/js/jquery.noty.js"></script>
	
		<script src="assets/js/jquery.elfinder.min.js"></script>
	
		<script src="assets/js/jquery.raty.min.js"></script>
	
		<script src="assets/js/jquery.iphone.toggle.js"></script>
	
		<script src="assets/js/jquery.uploadify-3.1.min.js"></script>
	
		<script src="assets/js/jquery.gritter.min.js"></script>
	
		<script src="assets/js/jquery.imagesloaded.js"></script>
	
		<script src="assets/js/jquery.masonry.min.js"></script>
	
		<script src="assets/js/jquery.knob.modified.js"></script>
	
		<script src="assets/js/jquery.sparkline.min.js"></script>
	
		<script src="assets/js/counter.js"></script>
	
		<script src="assets/js/retina.js"></script>

		<script src="assets/js/custom.js"></script>
		
		
</head>

<body>
		<!-- start: Header -->
	<div class="navbar">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a class="brand" href="index.php"><span>OPINITweet</span></a>
			</div>
		</div>
	</div>
	<!-- start: Header -->
	
		<div class="container-fluid-full">
				
			<!-- start: Main Menu -->
			<div id="sidebar-left" class="span4">
				<div class="nav-collapse sidebar-nav">
					<ul class="nav nav-tabs nav-stacked main-menu">
						<li><a href="#"><i class="icon-bar-chart"></i><span class="hidden-tablet">Dashboard</span></a></li>
						<li><a href="?pid=<?php echo md5('tambahraw')?>" title="Tambah data Raw" data-rel="tooltip"><i class="icon-edit"></i><span class="hidden-tablet"> Tambah Data Raw</span></a></li>
						<li><a href="?pid=<?php	echo md5('lihatraw')?>"  title="Lihat Dan Set data Raw" data-rel="tooltip"><i class="icon-envelope"></i><span class="hidden-tablet"> Lihat Raw Tweet</span></a></li>
						<li>
                                
                            <a href="#" class="dropmenu"  title="Data Latih" data-rel="tooltip"><i class="icon-fire"></i><span class="hidden-tablet">Data Latih</span></a>
                                <ul>
                                    <li><a class="submenu" href="?pid=<?php	echo md5('lihatlatih')?>"  title="Lihat Data Latih" data-rel="tooltip"><i class="icon-dashboard"></i><span class="hidden-tablet">Lihat Data Latih</span></a></li>
                                    <li><a class="submenu" href="?pid=<?php	echo md5('buatlatih')?>"><i class="icon-file"></i><span class="hidden-tablet">Buat Data Latih</span></a></li>

                                </ul>
                        </li>
                        <li><a href="?pid=<?php	echo md5('datauji')?>"  title="Data Uji Coba" data-rel="tooltip"><i class="icon-star"></i><span class="hidden-tablet"> Data Uji Coba</span></a></li>
						<li>
                        <li>
                            <a href="#" class="dropmenu"  title="Data Stopword" data-rel="tooltip"><i class="icon-tasks"></i><span class="hidden-tablet">StopWord</span></a>
                                <ul>
                                    <li><a class="submenu" href="?pid=<?php	echo md5('lihatstopword')?>"  title="Lihat Stopword" data-rel="tooltip"><i class="icon-book"></i><span class="hidden-tablet">Lihat Stopword</span></a></li>
                                    <li><a class="submenu" href="?pid=<?php	echo md5('tambahstopword')?>"><i class="icon-file-alt"></i><span class="hidden-tablet"> Tambah StopWord</span></a></li>

                                </ul>
                        </li>
						<li><a href="?pid=<?php	echo md5('lihatdasar')?>"  title="Kata Dasar" data-rel="tooltip"><i class="icon-align-justify"></i><span class="hidden-tablet">Kata Dasar</span></a></li>
					</ul>
				</div>
			</div>
			<!-- end: Main Menu -->
			
			<noscript>
				<div class="alert alert-block span10">
					<h4 class="alert-heading">Warning!</h4>
					<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
				</div>
			</noscript>
			
			<!-- start: Content -->
			<div id="content" class="span12" >
				<?php switch($_GET['pid'])
						{
							
							case  md5('lihatraw'):include "rawtweet.php";break;
							case  md5('tambahraw'):include "sentitweet.php";break;
							case  md5('lihatstopword'):include "stopword.php";break;
							case  md5('tambahstopword'):include "tambahstop.php";break;
							case  md5('lihatlatih'):include "latih.php";break;
							case  md5('buatlatih'):include "limitlatih.php";break;
							case  md5('datauji'):include "datauji.php";break;
							case  md5('lihatdasar'):include "dasar.php";break;
                            case  "kuda":include "filtertweet.php";break;
                            
							default:include "dashboard.php";break;
						}						
				?>
				
			
				
				<div class="clearfix"></div>
								
			</div><!--/row-->
			
       

	</div><!--/.fluid-container-->
	
			<!-- end: Content -->
		</div><!--/#content.span10-->
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
	
	<footer>

		<p>
			<span style="text-align:left;float:left">&copy; 2015 OpiniTweet</span>
			
		</p>

	</footer>
	
	<!-- start: JavaScript-->

		
	<!-- end: JavaScript-->
	
</body>

</html>
