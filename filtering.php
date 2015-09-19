<?php 
class filtering{
	function remove_hashtags($string){
		return preg_replace('/#[^\s]*/i', '', 
			preg_replace('/(?:#[\w-]+\s*)+$/', '', $string));
	}
	function remove_mention($string){
		return preg_replace('/@([A-Za-z0-9_]+)/', '', 
			preg_replace('/(?:#[\w-]+\s*)+$/', '', $string));
		//$pattern[0]="/^@([A-Za-z0-9_]+)/x";
		//return preg_replace($pattern,"",$string);
				
	}
	function remove_RT($string){
		return preg_replace("/\brt\b/","",$string);
		
	}
	function remove_tbaca($string){
		$pattern[0]="/(?![.=$'€%-])\p{P}/u";
		return preg_replace($pattern,"",$string);
	}
	function remove_spechar($string){
		$str=str_replace(array( '\'', '=', '+' , '-', '<', '>','%','|' ),'', $string);
		return preg_replace('/[^A-Za-z0-9-\-]/', ' ', $str);
		//return preg_replace('/[^a-zA-Z0-9_%\[().\]\\/-]/s', '', $string);
		//return preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $string);
	}
	function remove_all_clear($string){
		$rmv=new filtering();
		return $rmv->remove_spechar($rmv->remove_hashtags($rmv->remove_tbaca($rmv->remove_RT($rmv->remove_mention($string)))));
	}
    

	function remove_URL($url) {
		 return preg_replace('/\b(https?|ftp|file):\/\/[-a-zA-Z0-9+&@#\/%?=~_|$!:,.;]*[a-zA-Z0-9+&@#\/%=~_|$]/i', '', $url);
	}
}

?>