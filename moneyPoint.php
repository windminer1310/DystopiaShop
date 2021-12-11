<?php
    function moneyPoint($money){
        $caseString = "";

        $thousandPoint = 3;
        $milionPoint = 6;
        $bilionPoint = 9;
        $thousandBilionPoint = 12;
        $milionBilionPoint = 15;

        $money_str = (string)$money;
        $money_str = strrev($money_str);

        $moneyLength = strlen($money_str);
        for($i = 0; $i < $moneyLength; $i++){
            if($i == $thousandPoint or $i == $milionPoint or $i == $bilionPoint or $i == $thousandBilionPoint or $i == $milionBilionPoint){
                $caseString .= ("." . $money_str[$i] ) ;
            }
            else{
                $caseString .= $money_str[$i];
            }
        }
        $money_point = strrev($caseString);
        return $money_point ;
    }

    function dayOfDate($date){
        $timestamp = strtotime($date);
        $day = date('w', $timestamp);
        if($day == '8'){
            return 'Chủ nhật ';
        }
        else {
            return 'Thứ ' . $day;
        }
    }

    function approveStatus($status){
        if($status == 0){
            return '<div>Chưa xác nhận</div>';
        }
        elseif($status == 1){
            return '<div class="succes-auth__form">Đã xác nhận</div>';
        } 
        elseif ($status == 2) {
            return '<div class="progress-auth__form">Đang giao hàng</div>';
        }
        elseif ($status == 3) {
            return '<div class="succes-auth__form">Đã giao hàng</div>';
        }
        else{
        	return '<div class="fail-auth__form">Đã hủy đơn</div>';
        }
    }

    function changeStatus($status){
        if($status == 0){
            return '<div class="not-submit-auth__form">Xác nhận</div>';
        }
        elseif($status == 1){
            return '<div class="succes-auth__form">Giao hàng</div>';
        } 
        elseif ($status == 2) {
            return '<div class="progress-auth__form">Giao hàng thành công</div>';
        }
    }

    function dateFormat($date){
        $dateFormat = explode('-', $date);
        return ($dateFormat[2]. "-" . $dateFormat[1]. "-" .$dateFormat[0]);
    }
?>