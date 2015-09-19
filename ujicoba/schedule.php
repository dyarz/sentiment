<?php
    
    if(get_option("cron_job_1") != null)
    {
                //run task every 1 hour.
        if(time() - get_option("cron_job_1") >= 6)
        {
            $ch = curl_init();
                    
                        //send a request to the cron.php file so that its started in a new process asynchronous to the current process.
            curl_setopt($ch, CURLOPT_URL, 'http://yourdomain/cron.php');
            curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
                        //close connection after 1 millisecond. So that we can continue current script exection without effect page load time.
            curl_setopt($ch, CURLOPT_TIMEOUT_MS, 1); 
                        //some versions of curl don't support CURLOPT_TIMEOUT_MS so we have CURLOPT_TIMEOUT for them. Here we close connection after 1 second.
                        curl_setopt($ch, CURLOPT_TIMEOUT, 1);
            curl_exec($ch);
            curl_close($ch);

            update_option("cron_job_1", time());
        }
    }
    else
    {
        update_option("cron_job_1", time());
    }
?>