<?php
    function hasUserInfoSession($nameSession, $idSession){
        if(isset($nameSession) && isset($idSession)){
            return true;
        }
        return false;
    }

?>