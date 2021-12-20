<?php
    function displayDiscountTagWithHtml( $discount){
        echo "<div class='product-item__sale-off'>";
        echo "<div class = 'product-item__sale-off-text'>GIẢM GIÁ</div>";
        echo "<div class = 'product-item__sale-off-percent'>".$discount."%</div>";
        echo "</div>";
    }

    function dayOfDate($date){
        $timestamp = strtotime($date);
        $day = date('w', $timestamp);
        $dayInWeekArray = [
            'Chủ nhật',
            'Thứ hai',
            'Thứ ba',
            'Thứ tư',
            'Thứ năm',
            'Thứ sáu',
            'Thứ bảy'
        ];
        return $dayInWeekArray[$day];
    }

    function displayAddress($address){
        $addressForm = explode( '-', $address);

        $City = $addressForm[0];
        $District = $addressForm[1];
        $Ward = $addressForm[2];
        $specificAddress = $addressForm[3];

        return $City . ", " . $District . ", " . $Ward .", ". $specificAddress;
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

    function notifyCart($productInCart){
        echo "<div class='notify-cart'>";
        echo "<span style='color: var(--white-color); font-size: 10px;'>".$productInCart."</span>";
        echo "</div>";
    }

    function displayDescribeDropdownTag($sort){
        if (isset($_GET['sort'])) {
            $sort_name = "";
            if ($sort == 1) {
                $sort_name = "Mới nhất";
            }
            elseif ($sort == 3) {
                $sort_name = "Giá từ thấp đến cao";
            }
            elseif ($sort == 4) {
                $sort_name = "Giá từ cao đến thấp";
            }
            else {
                $sort_name = "Bán chạy nhất";
            }
            echo "<div class='dropdown-toggle' data-toggle='dropdown'>". $sort_name ."</div>";
        }
        else {
            echo "<div class='dropdown-toggle' data-toggle='dropdown'>Sắp xếp theo</div>";
        }
    }

    function displayDropdownTagPriceArea($price_from){
        if (isset($_GET['price_from'])) {
            $price_from_name = "";
            if ($price_from == 1) {
                $price_from_name = "Dưới 1.000.000đ";
            }
            elseif ($price_from == 2) {
                $price_from_name = "1.000.000đ - 10.000.000đ";
            }
            elseif ($price_from == 3) {
                $price_from_name = "10.000.000đ - 50.000.000đ";
            }
            else {
                $price_from_name = "Trên 50.000.000đ";
            }
            echo "<div class='dropdown-toggle' data-toggle='dropdown'>". $price_from_name ."</div>";
        }
        else {
            echo "<div class='dropdown-toggle' data-toggle='dropdown'>Tầm giá</div>";
        }
    }



    function displayListPageButton($totalPage, $href){
        if($totalPage > floor($totalPage)){
            for($count = 1; $count <= floor($totalPage)+1; $count++){
                if($count == 1) 
                    echo "<li class='page-item active'><a href='#".$href."' class='page-link' >" . $count . "</a></li>";
                else 
                    echo "<li class='page-item'><a href='#".$href."' class='page-link' >" . $count . "</a></li>";
            }
        }
        else {
            for($count = 1; $count < floor($totalPage)+1; $count++){
                if($count == 1) 
                    echo "<li class='page-item active'  ><a href='#".$href."' class='page-link' >" . $count . "</a></li>";
                else 
                    echo "<li class='page-item'  ><a href='#".$href."' class='page-link' >" . $count . "</a></li>";
            }
        }
    } 


    function displayUserName($nameSession){
        $eachPartName = preg_split("/\ /",$nameSession);
        $countName = count($eachPartName);
        if($countName == 1){
            $name = $eachPartName[$countName-1];
        }
        else{
            $name = $eachPartName[$countName-2] . " " . $eachPartName[$countName-1];
        }
        return $name;
    }

    

    function headToIndexPage(){
        header('Location: index.php');
    }

    function headToPage($url){
        header('Location: '. $url);
    }

    function cartIsEmpty($count){
        if($count > 0) return false;
        return true;
    }

    function displayNImgProductView($imgLink, $totalImageProduct, $indexNumberImg){
        for($i = 1; $i <= $totalImageProduct; $i++){
            if($i == 1) echo "<img class='img-display img-display--active' src='" .substr_replace($imgLink,(string)$i, $indexNumberImg, 1). "' alt='Product Image'>";
            else echo "<img class='img-display ' src='" .substr_replace($imgLink,(string)$i, $indexNumberImg, 1). "' alt='Product Image'>";
        }
    }

    function displayListNImgProduct($imgLink, $totalImageProduct, $indexNumberImg){
        for($i = 1; $i <= $totalImageProduct; $i++){
            if($i == 1) echo "<img class='list-img-item list-img-item--active' src='" .substr_replace($imgLink,(string)$i, $indexNumberImg, 1). "' alt='Product Image'>";
            else echo "<img class='list-img-item' src='" .substr_replace($imgLink,(string)$i, $indexNumberImg, 1). "' alt='Product Image'>";
        }
    }
?>