<?php
    include_once 'Signal.class.php';
    tlog('im start run');
    
    pcntl_signal(SIGTERM, 'signalHandler');
    
    $myids = array();
    
    while(true){
        for($i = 0; $i < 5; $i++){
            tlog('!');
            $pid = pcntl_fork();
            tlog('#');

            if($pid < 0){
                log('error fork');
            }else if($pid == 0){
                log('im child');
                sleep(1000);
                exit;
            }else{
                log('success'.$pid);
                $myids[] = $pid;
                sleep(1); 
            }
        }
    }
    
    sleep(10);
    if($myids) {
        foreach ($myids as $key => $pid) {
            log('kill' . $pid);
            posix_kill($pid, SIGTERM);
            unset($myids[$key]);
            sleep(2);
        }
    }
    
    
    
    function tlog($message) {
        $m = posix_getpid() . $message;
        file_put_contents("debug.log", $m, FILE_APPEND);
    }
?>
