<?php

$poolnum = 5;

function tlog($message){
    $m = $message . posix_getpid(). "\n";
    file_put_contents("process.log", $m, FILE_APPEND);
}

$fatherpid = posix_getpid();
function pool(){
    global $poolnum;
    for($i = 0; $i < $poolnum; $i++){
        $pid = pcntl_fork();
        if($pid < 0){
            tlog("fork error");
        }else if($pid == 0){
            tlog("child ");
            break;
        }else{
           tlog("father "); 
        }
    }
    work();
} 

function work(){
    tlog("work");
}
function wait(){
    global $fatherpid;
    if(posix_getpid() == $fatherpid){
        tlog("begin wait");
        while(($pid = pcntl_wait($stat)) > 0){
            tlog("child." . $pid . ". terminated \n");
        }
    }
}

pool();
wait();
