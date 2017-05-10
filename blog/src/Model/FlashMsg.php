<?php
/**
 * User: leo
 * Date: 18/04/17
 * Time: 13:49
 */

namespace src\Model;

/**
 * With this class, we displaying all flash messages.
 * We first need use setFlash method. Next, we can use getFlash method
 * Class FlashMsg
 * @package src\Model
 */
class FlashMsg
{
    /**
     * @param $message
     * @param $type
     */
    public function setFlash($message, $type){
        $_SESSION['flash'] = [
            "message" => $message,
            "type" => $type
            ];
    }

    /**
     * Display the message
     */
    public function getFlash(){
        if(isset($_SESSION['flash'])){
            echo "<div id='flash-message' class='". $_SESSION['flash']['type'] ."'>" . $_SESSION['flash']['message'] . "</div>";
            unset($_SESSION['flash']);
        }
    }
}