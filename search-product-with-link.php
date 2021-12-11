<?php  
    function searchProductWithDescribeDropdownTag($price_from, $search){
        $link = "view-product-list.php?id=1";
        if (isset($_GET['price_from'])) {
            $link = $link . "&price_from=" . $price_from;
            if (isset($_GET['search']) && strlen($_GET['search']) > 0) {
                $link = $link . "&search=" . $search;
            }
        }
        else {
            if (isset($_GET['search']) && strlen($_GET['search']) > 0) {
                $link = $link . "&search=" . $search;
            }
            
        }
        echo "<a href='" . $link . "&sort=1' class='dropdown-item'>Mới nhất</a>";
        echo "<a href='" . $link . "&sort=2' class='dropdown-item'>Bán chạy nhất</a>";
        echo "<a href='" . $link . "&sort=3' class='dropdown-item'>Giá từ thấp đến cao</a>";
        echo "<a href='" . $link . "&sort=4' class='dropdown-item'>Giá từ cao đến thấp</a>";
    }

    function searchProductWithDropdownTagPriceArea($sort, $search){
        $link2 = "view-product-list.php?id=1";
        if (isset($_GET['sort'])) {
            $link2  = $link2 . "&sort=" . $sort;
            if (isset($_GET['search']) && strlen($_GET['search']) > 0) {
                $link2 = $link2 . "&search=" . $search;
            }
        }
        else {
            if (isset($_GET['search']) && strlen($_GET['search']) > 0) {
                $link2 = $link2 . "&search=" . $search;
            }
        }
        echo "<a href='" . $link2 . "&price_from=1' class='dropdown-item'>Dưới 1.000.000đ</a>";
        echo "<a href='" . $link2 . "&price_from=2' class='dropdown-item'>1.000.000đ - 10.000.000đ</a>";
        echo "<a href='" . $link2 . "&price_from=3' class='dropdown-item'>10.000.000đ - 50.000.000đ</a>";
        echo "<a href='" . $link2 . "&price_from=4' class='dropdown-item'>Trên 50.000.000đ</a>";
    }
?>