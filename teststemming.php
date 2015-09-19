<?php
    // demo.php

    // include composer autoloader
    require_once __DIR__ . '/vendor/autoload.php';
    include "koneksi.php";
    // create stemmer
    // cukup dijalankan sekali saja, biasanya didaftarkan di service container
    $stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
    $stemmer  = $stemmerFactory->createStemmer();

    $ps=$dbnew->prepare("SELECT tweet_text FROM datalatih LIMIT 10");
    $ps->execute();

    while($rs=$ps->fetch(PDO::FETCH_NUM)){

        $sentence = $rs[0];
        $output   = $stemmer->stem($sentence);
        echo $sentence."<br>";
        echo $output . "<br><br>";
    }
?>