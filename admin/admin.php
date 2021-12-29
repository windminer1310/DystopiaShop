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
            return "Quản lý";
        }
    }
?>
<!DOCTYPE html>
<html lang="vi">
    <head>
        <meta charset="utf-8">
        <title>Dystopia Store</title>
        <link rel="icon" href="../img/favicons/favicon-32x32.png">
        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
        <!-- CSS Libraries -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
        <!-- Template Stylesheet -->
        <link href="../css/grid.css" rel="stylesheet">
        <link href="../css/base.css" rel="stylesheet">
        <link href="../css/home.css" rel="stylesheet">
        <link href="../css/admin.css" rel="stylesheet">
    </head>
    <body>
        <div id="page-container">
            <!-- Header Start -->
            <header id="header">
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
            <div id="content-wrap">
                <!-- Breadcrumb Start -->
                <div id="breadcrumb">
                    <div class="grid wide">
                        <ul class="list-path-link">
                            <li class="path-link"><a href="#">QUẢN LÝ NHÂN SỰ</a></li>
                        </ul>
                    </div>
                </div>
                <!-- Breadcrumb End -->
                <div class="grid wide">
                    <div class='last-section' style="margin-bottom: -247px;">
                        <div class='row'>
                            <div class='col l-8'>
                                <div class="form-admin">
                                    <div class="heading">
                                        <div class="grid">
                                            <div class="row no-gutters">
                                                <div class='table__col-title col l-2'>Mã nhân viên</div>
                                                <div class='table__col-title col l-3'>Họ tên</div>
                                                <div class='table__col-title col l-2'>Số điện thoại</div>
                                                <div class='table__col-title col l-2'>Vị trí</div>
                                                <div class="col l-o-3"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='admin-account__list'>
                                        <?php 
                                            $tableAdmin = 'admin';
                                            $getAdminRow = getRowWithTable($tableAdmin);
        
                                            foreach ($row = $getAdminRow->fetchAll() as $value => $row){
                                                echo "<div class='row no-gutters admin-account__info'>
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
                                <div class="form-wrap">
                                    <div class='heading'>
                                        <span class = 'heading__text' >Thêm nhân viên</span>
                                        <div id="zoom-out--form">
                                            <i class="bi bi-caret-down-fill"></i>
                                        </div>
                                    </div>
                                    <div class='form__add-admin'>
                                        <form action="../database/addAdmin.php" method="POST">
                                            <div class='form__item'>
                                                <p class = 'form__label'>Tên nhân viên</p>
                                                <input class = 'form__input'  id="admin_name" name="admin_name" required>
                                            </div>
                                            <div class='form__item'>
                                                <p class = 'form__label'>Số điện thoại</p>
                                                <input class = 'form__input'  id="admin_phone" name="admin_phone" required maxlength="10">
                                            </div>
                                            <div class='form__item'>
                                                <p class = 'form__label'>Mật khẩu</p>
                                                <input class = 'form__input' type="password" id="admin_password" name="admin_password" required minlength="7">
                                            </div>
                                            <div class='form__item'>
                                                <p class = 'form__label'>Vị trí</p>
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
                                                <button id='' class='btn' type='submit'>Thêm nhân viên<button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div id='change-password' class='form-wrap'>        
                                    <div class='heading'>
                                        <span class = 'heading__text' >Đổi mật khẩu</span>
                                        <div class = 'heading__text' >Mã NV: <span class="heading__text--primary" id='admin-id'></span></div>
                                    </div>
                                    <div class='form__add-admin'>
                                        <div class='form__item'>
                                            <p class = 'form__label'>Mật khẩu mới</p>
                                            <input type='password' disabled class = 'form__input' name='admin-password--new' id='admin-password--new' onkeyup='checkedPassword();'>
                                        </div>
                                        <div class='form__item'>
                                            <div class='with-spacebetween-icon'>
                                                <p class = 'form__label'>Nhập lại mật khẩu mới</p>
                                                <div class='status-icon'></div>
                                            </div>
                                            <input type='password' disabled class = 'form__input' name='new-password-checked__admin' id='new-password-checked__admin' onkeyup='checkedPassword();'>
                                        </div>                                  
                                        <div class='submit-btn' id='btn-change-pass'>
                                            <button class='btn btn--disabled' id='change-password__admin' disabled type='submit'>Đổi mật khẩu</button>
                                        </div>
                                    </div>
                                </div>           
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>              
    </body>
    <script src="../js/changePassword.js"></script>
    <script>
        const $$ = document.querySelectorAll.bind(document);
        const items = $$('.employee__change-Pw');

        items.forEach((item, index) => {
            item.onclick = function () {
                document.getElementById('admin-id').innerHTML = this.id;
                document.getElementById('admin-password--new').removeAttribute("disabled");
                document.getElementById('new-password-checked__admin').removeAttribute("disabled");
                document.getElementById('btn-change-pass').innerHTML = 
                "<div id='change-password__admin' onclick='changePasswordAdmin(\""+ this.id +"\");' class='btn btn--disabled' type='submit'>Đổi mật khẩu</div>";
            }
        });
        
        zoomOutBtn = document.getElementById('zoom-out--form');
        zoomOutBtn.addEventListener('click', function() {  
            if(document.getElementsByClassName('form__add-admin')[0].style.display == 'none'){
                document.getElementsByClassName('form__add-admin')[0].style.display = 'block';
                zoomOutBtn.innerHTML = '<i class="bi bi-caret-down-fill"></i>';
            }
            else{
                document.getElementsByClassName('form__add-admin')[0].style.display = 'none';
                zoomOutBtn.innerHTML = '<i class="bi bi-caret-up-fill"></i>';
            }
        });
    </script>
</html>