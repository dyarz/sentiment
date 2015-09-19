<?php
/*
SOURCE CODE
Oleh : Arfian Hidayat
Situs : http://arfianhidayat.com
*/

//cara menggunakan
$r = new Rabinkarp_model();
$kesamaan = $r->rabinkarp('News: Kadisdik Depok: Mau Tak Mau Sekolah Pakai Kurikulum 2013 | Sindo News','Depok: Mau Tak Mau Sekolah Pakai Kurikulum 2013 mataramnwes',2);
echo $kesamaan;

class Rabinkarp_model
{

    //ALGORITMA RABIN KARP
    function rabinkarp($teks1, $teks2, $gram)
    {
        $data['teks1White'] = $this->whiteInsensitive($teks1);
        $data['teks2White'] = $this->whiteInsensitive($teks2);
        $data['teks1Gram'] = $this->kGram($data['teks1White'], $gram);
        $data['teks2Gram'] = $this->kGram($data['teks2White'], $gram);
        $data['teks1Hash'] = $this->hash($data['teks1Gram']);
        $data['teks2Hash'] = $this->hash($data['teks2Gram']);
        $data['teks1FingerPrint'] = $this->fingerPrint1($data['teks1Hash']);
        $data['teks2FingerPrint'] = $this->fingerPrint1($data['teks2Hash']);
        $data['fingerprint'] = $this->fingerprint($data['teks1FingerPrint'], $data['teks2FingerPrint']);
        $data['similiarity'] = $this->SimilarityCoefficient($data['fingerprint'], $data['teks1FingerPrint'], $data['teks2FingerPrint']);
        return $data['similiarity'];
    }

    function whiteInsensitive($teks)
    {
        //    Dapatkan inputan teks / definisi suatu teks
        //Simbol � simbol / special character yang ada aku ganti dengan tanda � � �
        //Hasil dari pergantian simbol diatas, aku jadikan suatu variabel bertipe array
        //Lakukan perulangan : 
        //- Cek apakah setiap elemen array tadi bernilai null / kosong 
        //- Jika iya, maka simpan pada suatu variabel temp ditambah dengan spasi. 
        //- Jika tidak lanjutkan perulangan hingga sampai batas akhir jumlah elemen array tadi
        //Tampilkan hasil proses perulangan diatas dan selesai
        $a = $teks;
        $b = preg_replace("/[^a-z0-9_\-\.]/i", "-", $a);
        $c = explode("-", $b); //misah string berdasarkan -
        $e = '';
        $f = '';
        for ($d = 0; $d < count($c); $d++) {
            if (trim($c[$d]) != "")
                $e .= $c[$d] . " ";
        }
        $e = strtolower(substr($e, 0, strlen($e) - 1));
        $f = str_replace(array(".", "_"), "", $e);
        return $f;
    }

    //memotong teks/kalimat menjadi potongan2 sesuai dengan gram
    function kGram($teks, $gram = 3)
    {
        $i = 0;
        $length = strlen($teks);
        $teksSplit = null;
        if (strlen($teks) < $gram) {
            $teksSplit[] = $teks;
        } else {
            for ($i; $i <= $length - $gram; $i++) {
                $teksSplit[] = substr($teks, $i, $gram);
            }
        }
        return $teksSplit;
    }

    //gram = teks yang sudah di potong, misal akusayangkamu jadi aku kus say aya ...
    //parameter berupa array
    function hash($gram)
    {
        $hashGram = null;
        foreach ($gram as $a => $teks) {
            $hashGram[] = $this->rollingHash($teks);
        }
        return $hashGram;
    }

    //ini merupakan rolling hash dengan basis 110
    //string = kata yang akan di hash, misal aku hasnya 111022
    function rollingHash($string)
    {
        $basis = 11;
        $pjgKarakter = strlen($string);
        $hash = 0;
        for ($i = 0; $i < $pjgKarakter; $i++) {
            $ascii = ord($string[$i]);
            $hash += $ascii * pow($basis, $pjgKarakter - ($i + 1));
        }
        return $hash;
    }

    function fingerPrint1($hash)
    {
        $fingerprint = null;
        $sudah = false;
        for ($i = 0; $i < count($hash); $i++) {
            if ($fingerprint != null) {
                //mengecek apakah hash sudah ada di fingerprint
                foreach ($fingerprint as $row => $value) {
                    if ($value == $hash[$i]) {
                        $sudah = true;
                    }
                }
            }
            //jika hash sudah ada, maka tidak perlu dimasukkan lagi ke fingerprint
            if ($sudah == false) {
                $fingerprint[] = $hash[$i];
            }
            $sudah = false;
        }
        return $fingerprint;
    }

    //menghasilkan hash yang sama, return dalam bentuk array
    //hash1 dan hash2 berupa array
    function fingerprint($hash1, $hash2)
    {
        $fingerprint = null;
        $hashUdahDicek = null;
        $sama = false;
        $countHash1 = count($hash2);
        for ($i = 0; $i < count($hash1); $i++) {
            for ($j = 0; $j < $countHash1; $j++) {
                if ($hash1[$i] == $hash2[$j]) {
                    $fingerprint[] = $hash1[$i];
                }
            }
        }
        return $fingerprint;
    }

    //=================================================== END ALGORITMA RABIN KARP
    //menggunakan Dice�s Similarity Coefficient
    function similarityCoefficient($fingerprint, $hash1, $hash2)
    {
//        echo '2 * ' . count($fingerprint) . '/' . (count($hash1)) . '+' . count($hash2);
        return number_format(((2 * count($fingerprint) / (count($hash1) + count($hash2))) * 100), 2, '.', '');
    }

}
