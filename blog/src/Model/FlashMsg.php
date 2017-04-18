<?php
/**
 * User: leo
 * Date: 18/04/17
 * Time: 13:49
 */

namespace src\Model;


class FlashMsg
{
    public function setFlash($message, $type){
        $_SESSION['flash'] = [
            "message" => $message,
            "type" => $type
            ];
    }

    public function getFlash(){
        if(isset($_SESSION['flash'])){
            echo "<div id='flash-message' class='". $_SESSION['flash']['type'] ."'>" . $_SESSION['flash']['message'] . "</div>";
            unset($_SESSION['flash']);
        }
    }
}