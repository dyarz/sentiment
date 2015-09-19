<?php
class  ngrams{
     //memotong teks/kalimat menjadi potongan2 sesuai dengan gram
    function makengrams($teks, $gram = 3)
    {
        $i = 0;
        $tx=str_replace(" ","_",$teks);
        $length = strlen($tx); //hitung panjang texs
        $teksSplit = null;
        if (strlen($teks) < $gram) {
            $teksSplit[] = $tx; 
        } else {
            for ($i; $i <= $length - $gram; $i++) {
                $teksSplit[] = substr($tx, $i, $gram);
                 //   echo $teksSplit[$i]."<br>";
                if($teksSplit[$i]=="__"){
                   unset($teksSplit[$i]);
                   
                }
            }
        }
        $teksSplit=array_values($teksSplit);
        return $teksSplit;
    }

    //gram = teks yang sudah di potong, misal akusayangkamu jadi aku kus say aya ...
    //parameter berupa array
}

?>