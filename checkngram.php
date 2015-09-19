<?php 
    
    class checkNgram{
      
       function cek_sentiment($kata,$sentiment){
            global $dbnew;
            $ps=$dbnew->prepare("SELECT * FROM n_gramsementara WHERE n_gram =? AND sentiment LIKE ?");
            $ps->bindParam(1,$kata);
            $ps->bindParam(2,$sentiment);
            $ps->execute();
            $jumlah=$ps->fetchAll();
            $count=count($jumlah);
            
            if($count>=1){

                return 1; //jika ada 

            }else{

                return 0; //jika tidak
            }
            tutupkoneksi();
        }
        function cek_ngram($kata,$sentiment){
            global $dbnew;
            $ps=$dbnew->prepare("SELECT * FROM n_gram WHERE n_gram =? AND sentiment=?");
            $ps->bindParam(1,$kata);
            $ps->bindParam(2,$sentiment);
            $ps->execute();
            $jumlah=$ps->fetchAll();
            $count=count($jumlah);
            
            if($count==1||$count>1){

                return 1; //jika ada 

            }else{

                return 0; //jika tidak
            }
            tutupkoneksi();
        }
        function cek_prob($kata,$sentiment){
            global $dbnew;
            $ps=$dbnew->prepare("SELECT probabilitas FROM n_gram WHERE n_gram =? AND sentiment=?");
            $ps->bindParam(1,$kata);
            $ps->bindParam(2,$sentiment);
            $ps->execute();
            $rs=$ps->fetch(PDO::FETCH_NUM);
            return $rs[0];
            tutupkoneksi();
        }
    
    }

?>