<?php
    session_start();
	require_once('../database/connectDB.php');

    if(isset($_SESSION['admin_name']) && isset($_SESSION['admin_id']) && isset($_SESSION['authority'])){
        $eachPartName = preg_split("/\ /",$_SESSION['admin_name']);
        $countName = count($eachPartName);
        if($countName == 1){
            $name = $eachPartName[$countName-1];
        }
        else{
            $name = $eachPartName[$countName-2] . " " . $eachPartName[$countName-1];
        }
        $user_id = $_SESSION['admin_id'];
    }
    else{
        header('Location: admin-login.html');
    }

    if($_SESSION['authority'] == 2){
        header('Location: transaction-management.php');
    }
    
    function getAuthority($authority) {
        if ($authority == 2) {
            return "Nhân viên";
        }
        else {
            return "Chủ";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Dystopia</title>

        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">

        <!-- CSS Libraries -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
        <link href="lib/slick/slick.css" rel="stylesheet">
        <link href="lib/slick/slick-theme.css" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="../css/grid.css" rel="stylesheet" >
        <link href="../css/home.css" rel="stylesheet">
        <link href="../css/base.css" rel="stylesheet">
        <link href="../css/admin.css" rel="stylesheet">


    </head>

    <body>        
           
        <!-- Header Start -->
        <header class="header ">
            <div class="grid wide">
                <div class="header-with-search">
                    <div class="header__logo">
                        <a href="./admin.php" class="header__logo-link">
                            <img src="../img/logo.png" alt="Logo" class="header__logo-img">
                        </a>
                    </div>
                    <div class="header__item">
                        <a href="admin.php" class="header__link header__link--active">
                            QUẢN LÝ NHÂN SỰ
                        </a>
                    </div>
                    <div class="header__item">
                        <a href="transaction-management.php" class="header__link">
                            QUẢN LÝ ĐƠN HÀNG
                        </a>
                    </div>
                    <div class="header__item">
                        <a href="product-management.php" class="header__link">
                            QUẢN LÝ SẢN PHẨM
                        </a>
                    </div>
                    <div class="header__item header__user">
                        <a class='header__icon-link' href=''>
                            <i class='header__icon bi bi-person'></i>
                        </a>
                        <a class='header__link header__user-login'><?php echo $name;?></a>
                        <ul class="header__user-menu">
                            <li class="header__user-item">
                                <a href="./logout.php" >Đăng xuất</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>
        <!-- Header End -->  
        
        <!-- Breadcrumb Start -->
        <div class="homepage">
            <div class="grid wide">
                <ul class="path-homepage">
                    <li class="path-link"><a href="#">QUẢN LÝ NHÂN SỰ</a></li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb End -->
        
        <div class="featured-product">
            <div class='grid wide'>
                <div class='row'>
                    <div class='col l-8'>
                        <div>
                            <div class='heading'>
                                <span class = 'heading__text' >Danh sách nhân viên</span>
                            </div>
                            <div class='admin-account__list'>
                                <div class="heading-info__row">
                                    <div class='heading-info__text col l-2'>Mã nhân viên</div>
                                    <div class='heading-info__text col l-3'>Họ tên</div>
                                    <div class='heading-info__text col l-2'>Số điện thoại</div>
                                    <div class='heading-info__text col l-2'>Vị trí</div>
                                    <div class="col l-o-3"></div>
                                </div>
                                <?php 
                                    $tableAdmin = 'admin';
                                    $getAdminRow = getRowWithTable($tableAdmin);

                                    foreach ($row = $getAdminRow->fetchAll() as $value => $row){
                                        echo "<div class='admin-account__info'>
                                            <span class='info-text col l-2'>".$row['admin_id']."</span>
                                            <span class='info-text col l-3'>".$row['admin_name']."</span>
                                            <span class='info-text col l-2'>".$row['admin_phone']."</span>
                                            <span class='info-text col l-2 info-text--fix'>";
                                                if($row['authority'] == 1) echo "Quản lý";
                                                else echo "Nhân viên";
                                            echo "</span>
                                            <a href='#change-password' id='".$row['admin_id']."' class='btn btn--size-s col l-2 margin-auto employee__change-Pw'>Đổi mật khẩu</a>
                                            <div  class='btn btn--size-s col l-1' onclick='notifyDeleteAdmin(".$row['admin_id'].");'>Xóa</div>
                                        </div>";
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col l-4">
                        <div>
                            <div class='heading with-spacebetween-icon'>
                                <span class = 'heading__text' >Thêm nhân viên</span>
                                <div id="zoom-out--form">
                                    <i class="bi bi-caret-down-fill"></i>
                                </div>
                            </div>
                            <div class='add-admin-form'>
                                <form action="../database/addAdmin.php" method="post">
                                    <div class='input-element'>
                                        <p class = 'title-input'>Tên nhân viên</p>
                                        <input class = 'input__field'  id="admin__name" name="admin__name" required>
                                    </div>
                                    <div class='input-element'>
                                        <p class = 'title-input'>Số điện thoại</p>
                                        <input class = 'input__field'  id="admin__phone" name="admin__phone" required maxlength="10">
                                    </div>
                                    <div class='input-element'>
                                        <p class = 'title-input'>Mật khẩu</p>
                                        <input class = 'input__field' type="password" id="admin_password" name="admin_password" required minlength="7">
                                    </div>
                                    <div class='input-element'>
                                        <p class = 'title-input'>Vị trí</p>
                                            <div class='radio-input'>
                                                <input class='radio-icon' type="radio" id="owner" name="authority" value=1 required>
                                                <label class='radio-label' for="owner">Quản lý</label><br>
                                            </div>
                                            <div class='radio-input'>
                                                <input class='radio-icon' type="radio" id="employee" name="authority" value=2>
                                                <label class='radio-label' for="employee">Nhân viên</label><br>
                                            </div>
                                    </div>
                                    <div class='submit-btn'>
                                        <input id='' class='btn' type='submit' value="Thêm nhân viên">
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div id="change-password">
                            <div style="margin-top: 24px;">
                                <div class='heading' style="display: flex; justify-content: space-between;">
                                    <span class = 'heading__text' >Đổi mật khẩu</span>
                                    <div class = 'heading__text' >Mã NV: <span id='heading-admin-id'></span></div>
                                </div>
                                <div class='add-admin-form'>
                                    <div class='input-element'>
                                        <p class = 'title-input'>Mật khẩu mới</p>
                                        <input type="password" disabled class = 'input__field' name='new-password__admin' id='new-password__admin' onkeyup='checkedPassword();'>
                                    </div>
                                    <div class='input-element'>
                                        <div class='with-spacebetween-icon'>
                                            <p class = 'title-input'>Nhập lại mật khẩu mới</p>
                                            <div class='status-icon'></div>
                                        </div>
                                        <input type="password" disabled class = 'input__field' name='new-password-checked__admin' id='new-password-checked__admin' onkeyup='checkedPassword();'>
                                    </div>                                  
                                    <div class='submit-btn' id='btn-form'>
                                        <button class='btn btn--disabled' id='change-password__admin' disabled type='submit'>Đổi mật khẩu</button>
                                    </div>
                                </div>
                            </div> 
                        </div>           
                    </div>
                </div>
            </div>
        </div>

        <script src="../js/changePassword.js"></script>

        <script>
            const $$ = document.querySelectorAll.bind(document);
            const items = $$('.employee__change-Pw');

            items.forEach((item, index) => {
                item.onclick = function () {
                    document.getElementById('heading-admin-id').innerHTML = this.id;
                    document.getElementById('new-password__admin').removeAttribute("disabled");
                    document.getElementById('new-password-checked__admin').removeAttribute("disabled");
                    document.getElementById('btn-form').innerHTML = 
                    "<div id='change-password__admin' onclick='changePasswordAdminStatus("+ this.id +");' class='btn btn--disabled' type='submit'>Đổi mật khẩu</div>";
                }
            });
            
            zoomOutBtn = document.getElementById('zoom-out--form');
            zoomOutBtn.addEventListener('click', function() {  
                if(document.getElementsByClassName('add-admin-form')[0].style.display == 'none'){
                    document.getElementsByClassName('add-admin-form')[0].style.display = 'block';
                    zoomOutBtn.innerHTML = '<i class="bi bi-caret-down-fill"></i>';
                }
                else{
                    document.getElementsByClassName('add-admin-form')[0].style.display = 'none';
                    zoomOutBtn.innerHTML = '<i class="bi bi-caret-up-fill"></i>';
                }
            });
        </script>
    </body>
</html>