<?php
include('koneksi.php');
$psa=$dbnew->prepare("SELECT * FROM tb_stopword");
$psa->execute();
	$pattern=array();
	 while($rsd=$psa->fetch(PDO::FETCH_ASSOC)){
				array_push($pattern,$rsd['katastopword']);
	 }
	 tutupkoneksi();
	

function cekKamus($kata){
	
	if(in_array($kata,$pattern,true)){
		return true; // True jika ada
	}else{
		return false; // jika tidak ada FALSE
	}
	tutupkoneksi();
}


function Del_Inflection_Suffixes($kata){
	$kataAsal = $kata;
	if(preg_match('([km]u|nya|kl]ah|pun)',$kata)){ // Cek Inflection Suffixes
		$__kata = preg_replace('[km]u|nya|[kl]ah|pun)$','',$kata);
		return $__kata;
	}
	return $kataAsal;
}

// Cek Prefix Disallowed Sufixes (Kombinasi Awalan dan Akhiran yang tidak diizinkan)
function Cek_Prefix_Disallowed_Sufixes($kata){
	if(preg_match('^(be)[[:alpha:]]+(i)',$kata)){ // be- dan -i
		return true;
	}
	if(preg_match('^(se)[[:alpha:]]+(i|kan)$',$kata)){ // se- dan -i,-kan
		return true;
	}
	return false;
}

// Hapus Derivation Suffixes (“-i”, “-an” atau “-kan”)
function Del_Derivation_Suffixes($kata){
	$kataAsal = $kata;
	if(preg_match('(i|an)',$kata)){ // Cek Suffixes
		$__kata = preg_replace('(i|an)','',$kata);
		if(cekKamus($__kata)){ // Cek Kamus
			return $__kata;
		}
	///*– Jika Tidak ditemukan di kamus –*/
	}
	return $kataAsal;
}

// Hapus Derivation Prefix (“di-”, “ke-”, “se-”, “te-”, “be-”, “me-”, atau “pe-”)
function Del_Derivation_Prefix($kata){
	$kataAsal = $kata;

	///* —— Tentukan Tipe Awalan ————*/
	if(preg_match('^(di|[ks]e)',$kata)){ // Jika di-,ke-,se-
	$__kata = preg_replace('^(di|[ks]e)','',$kata);
		if(cekKamus($__kata)){
			return $__kata; // Jika ada balik
		}
		$__kata__ = Del_Derivation_Suffixes($__kata);
		if(cekKamus($__kata__)){
			return $__kata__;
		}
		//*————end “diper-”, ———————————————*/
		if(preg_match('^(diper)',$kata)){
			$__kata = preg_replace('^(diper)','',$kata);
			if(cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
		}
		///*————end “diper-”, ———————————————*/
	}
	if(preg_match('^([tmbp]e)',$kata)){ //Jika awalannya adalah “te-”, “me-”, “be-”, atau “pe-”
	
	}
/* — Cek Ada Tidaknya Prefik/Awalan (“di-”, “ke-”, “se-”, “te-”, “be-”, “me-”, atau “pe-”) ——*/
	if(preg_match('^(di|[kstbmp]e)',$kata) == FALSE){
		return $kataAsal;
	}

	return $kataAsal;
}

function NAZIEF($kata){

	$kataAsal = $kata;

	/* 1. Cek Kata di Kamus jika Ada SELESAI */
	if(cekKamus($kata)){ // Cek Kamus
		return $kata; // Jika Ada kembalikan
	}

	/* 2. Buang Infection suffixes (\-lah”, \-kah”, \-ku”, \-mu”, atau \-nya”) */
	$kata = Del_Inflection_Suffixes($kata);

	/* 3. Buang Derivation suffix (\-i” or \-an”) */
	$kata = Del_Derivation_Suffixes($kata);

	/* 4. Buang Derivation prefix */
	$kata = Del_Derivation_Prefix($kata);

	return $kata;

}
?>