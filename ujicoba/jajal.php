<?php
function ngrams($word, $min_gram_length = 2) {
        $ngrams = array();
        $word = trim($word);
        $len = strlen($word);
        $max_gram_length = $len - 1;
         
      // BEGIN N-GRAM SIZE LOOP $a
         
        for ($a = 2; $a <= 2; $a++) { //BEGIN N-GRAM SIZE LOOP $a
             
            for ($pos = 0; $pos < $len; $pos ++) {  //BEGIN POSITION WITHIN WORD $pos
                 
                if(($pos + $a -1) < $len) {  //IF THE SUBSTRING WILL NOT EXCEED THE END OF THE WORD
                 
                $ngrams[] = substr($word, $pos, $a);
 
                }  //END IF THE SUBSTRING WILL NOT EXCEED THE END OF THE WORD
             
            } //END POSITION WITHIN WORD $pos
         
        }  //END N-GRAM SIZE LOOP $a
         
        $ngrams = array_unique($ngrams);
         
	return $ngrams;
}
$original="pendidikan pemaksaan budi ombudsman kadisdik paksa kepala sekolah terapkan kurikulum 2013";
$words=ngrams($original,2);
// $input = 'bla';
// $data = array('orange', 'blue', 'green', 'red', 'pink', 'brown', 'black');
// $result = array_filter($data, function ($item) use ($input) {
    // if (stripos($item, $input) !== false) {
        // return true;
    // }
    // return false;
// });
// if($result==true){
	// echo "1";
// }else{
	// echo "2";
 // }
echo    $original."<br>";
 var_dump($words);

// $os = array("Mac", "NT", "Irix", "Linux");
// if (!in_array("Irix", $os)) {
    // echo "not got Irix";
// }else{
	    // echo "got Irix";
// }
// if (in_array("mac", $os)) {
    // echo "Got mac";
// }

?>