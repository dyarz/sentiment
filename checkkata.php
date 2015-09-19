<?php 
if(isset($_REQUEST['stopword'])){
		$kata=$_REQUEST['stopword'];
		include ('koneksi.php');
		$ps=$dbnew->prepare("SELECT * FROM tb_stopword where katastopword like ?");
		$ps->bindParam(1,$kata);
		$ps->execute();	
		$jumlah= $ps->fetchAll();
		$count=count($jumlah);
		if($count==0){
			
			 echo 'true';
			
		}else{
		
			echo 'false';
		}
		tutupkoneksi();
	}
?>