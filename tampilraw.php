<html>
    <head><meta charset="utf-8">
            <title>Tampil Raw Tweet</title>
    </head>
    <body>
		<?php 
		include("koneksi.php");
		if(isset($_GET["p"])){$page=$_GET["p"];}else{$page=1;};
		$per_halaman=10;
		$awal=($page-1)*$per_halaman;
		$ps=$dbnew->prepare("SELECT * FROM rawtweets ORDER BY id ASC LIMIT $awal,$per_halaman");
		$ps->execute();	
		while($rs=$ps->fetch(PDO::FETCH_NUM)){?>
		<table padding="10" border="1">
			<tr>
				<td rowspan="2">
					<?php echo $rs[0];?>
				</td>
				<td rowspan="2">
					<img src="<?php echo $rs[6] ?>"/>
				</td>
				<td >
					<?php echo "@".$rs[5] ."&nbsp: "?> 
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
			
			
		</table>

		<?php }
		tutupkoneksi();
		$hasil=$dbnew->prepare("SELECT * FROM rawtweets");
		$hasil->execute();
		$jumlah=$hasil->rowCount();

		$total_halaman=ceil($jumlah/$per_halaman);
			
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
				echo "<a href='tampilraw.php?p=1'>";
						echo "First </a>"; 
				echo "<a href='tampilraw.php?p=".$pd."'>";
						echo "PREV </a>"; 
				
			}	
			
			for ($i=$startpage; $i<=$endpage; $i++) { 
						
						echo "<a href='tampilraw.php?p=".$i."'>";
						echo $i."</a> "; 
			}; 
			if($endpage<$total_halaman||$page<$total_halaman){
				$pd=$page+1;
				echo "<a href='tampilraw.php?p=".$pd."'>";
						echo "NEXT </a>"; 
				echo "<a href='tampilraw.php?p=".$total_halaman."'>";
						echo "Last </a>"; 
				
				
				
			}
		?>
	</body>
</html>