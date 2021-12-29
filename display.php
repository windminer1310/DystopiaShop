<?php
    define( 'ADDRESS_GOOGLE_URL', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.0835321075647!2d106.71489441488534!3d10.804914192302194!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317528a405e4245f%3A0x64cd17debf114781!2zMiBWw7UgT2FuaCwgUGjGsOG7nW5nIDI1LCBCw6xuaCBUaOG6oW5oLCBUaMOgbmggcGjhu5EgSOG7kyBDaMOtIE1pbmgsIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1627547869109!5m2!1svi!2s' );
    define( 'SHOP_ADDRESS', 'Số 2 đường Võ Oanh phường 25 quận Bình Thạnh');
    define( 'SHOP_EMAIL', 'cskh.dystopia@gmail.com');
    define( 'SHOP_PHONE', '0966-696-969');
    function showDiscountTag($discount){
        echo "
        <div class='product-item__sale-off'>
            <div class = 'product-item__sale-off-text'>GIẢM GIÁ</div>
            <div class = 'product-item__sale-off-percent'>".$discount."%</div>
        </div>";
    }

    function displayAddress($address){
        $addressForm = explode( '-', $address);

        $City = $addressForm[0];
        $District = $addressForm[1];
        $Ward = $addressForm[2];
        $specificAddress = $addressForm[3];

        return $City . ", " . $District . ", " . $Ward .", ". $specificAddress;
    }

    function statusOrder($status){
        if($status == "4"){
            echo "Đã huỷ đơn";
        }else if($status == "0"){
            echo "Đang được xử lý";
        }else if($status == "1"){
            echo "Đã được xác nhận";
        }else if($status == "2"){
            echo "Đang vận chuyển";
        }else if($status == "3"){
            echo "Giao hàng thành công";
        }else{
            echo "Không xác định";
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

    function displayImgProductView($imgLink, $totalImageProduct, $indexNumberImg){
        for($i = 1; $i <= $totalImageProduct; $i++){
            if($i == 1) echo "<img class='img-display img-display--active' src='" .substr_replace($imgLink,(string)$i, $indexNumberImg, 1). "' alt='Product Image'>";
            else echo "<img class='img-display ' src='" .substr_replace($imgLink,(string)$i, $indexNumberImg, 1). "' alt='Product Image'>";
        }
    }

    function displayListImgProduct($imgLink, $totalImageProduct, $indexNumberImg){
        for($i = 1; $i <= $totalImageProduct; $i++){
            if($i == 1) echo "<img class='list-img-item list-img-item--active' src='" .substr_replace($imgLink,(string)$i, $indexNumberImg, 1). "' alt='Product Image'>";
            else echo "<img class='list-img-item' src='" .substr_replace($imgLink,(string)$i, $indexNumberImg, 1). "' alt='Product Image'>";
        }
    }
?>