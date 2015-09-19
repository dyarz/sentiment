<?php 
    class execTime{
        function time_start(){
            $time_start = microtime(true); 
            return $time_start;
        }
        function time_stop($time_start){
            $time_stop=microtime(true) - $time_start;
            return $time_stop;
        }
    
    }

?> 