<?php
namespace MediaPlatform\Controller;

class CallbackController
{
    public function check($mp)
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'POST':
                $this->responseMsg();
                break;
            case 'GET':
                $this->valid($mp);
                break;
            default:
            
            
        }
    }
    
    public function valid($mp)
    {
        $echoStr = $_GET['echostr'];
        
        if ($this->checkSignature($mp)) {
            
            echo $echoStr;
            exit;
        }
        
    }
    
    public function checkSignature($mp)
    {
        
        $signature = $_GET['signature'];
        $timestamp = $_GET['timestamp'];
        $nonce     = $_GET['nonce'];
        $mpInfo = include 'config/mediaplatform.php';
        $token = $mpInfo["$mp"]['token'];
        
        $tmpArray = array($token, $timestamp, $nonce);
        
        sort($tmpArray, SORT_STRING);
        $tmpString = implode($tmpArray);
        $tmpString = sha1($tmpString);
        
        if ($tmpString == $signature) {
            return true;
        }
        else {
            return true;
        }
    }
}

