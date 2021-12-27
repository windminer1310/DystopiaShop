<?php
    require_once('../database/connectDB.php');
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
        <!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
        <link href="lib/slick/slick.css" rel="stylesheet">
        <link href="lib/slick/slick-theme.css" rel="stylesheet"> -->

        <!-- Template Stylesheet -->
        <link href="../css/grid.css" rel="stylesheet" >
        <link href="../css/base.css" rel="stylesheet">
        <link href="../css/home.css" rel="stylesheet">
    </head>
    <body>
        <!-- Header Start -->
        <header class="header">
            <div class="grid wide">
                <div class="header-with-search">
                    <div class="header__logo">
                        <a href="index.php" class="header__logo-link">
                            <img src="../img/logo.png" alt="Logo" class="header__logo-img">
                        </a>
                    </div>
                </div>
            </div>
        </header>
        <!-- Header End -->

        <div class="homepage">
            <div class="grid wide">
                <div class="col l-o-3 l-6">
                    <div class="header-user__account">
                        <span class="header__text-field">
                            Khởi động lại mật khẩu
                        </span>
                    </div>
                    <div class="info-account">
                        <form method="POST" action="">
                            <div class="one-field-checkout">
                                <label class="title-checkout-text" class="l-3" for="email">Email</label>
                                <input class="auth-form__input" type="text" name="email" id="email" />
                            </div>
                            <input class="btn" type="submit" value="Ok" />

                            <?php
                                function generateRandomString($length = 20) {
                                    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                                    $charactersLength = strlen($characters);
                                    $randomString = '';
                                    for ($i = 0; $i < $length; $i++) {
                                        $randomString .= $characters[rand(0, $charactersLength - 1)];
                                    }
                                    return $randomString;
                                }

                                use PHPMailer\PHPMailer\PHPMailer;
                                use PHPMailer\PHPMailer\Exception;

                                require 'PHPMailer/src/Exception.php';
                                require 'PHPMailer/src/PHPMailer.php';
                                require 'PHPMailer/src/SMTP.php';
                                require "PHPMailer/src/OAuth.php";
                                require "PHPMailer/src/POP3.php";

                                if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['email'])) {
                                    $email = $_POST["email"];
                                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                        echo "Sai định dạng Email!";
                                    }
                                    else {
                                        $checkEmailQuerry = getRowWithValue('user', 'user_email', $email);

                                        if(!$checkEmailQuerry) {
                                            echo "Email không tồn tại trong hệ thống, vui lòng kiểm tra lại!";
                                        }
                                        else {
                                            $email = $_POST['email'];
                                            $mail = new PHPMailer(true); 
                                            $email = $_POST['email'];
                                            $message = "Hello";
                                            $newPassword = generateRandomString(20);    

                                            $options = [
                                                'cost' => 10,
                                            ];
                                        
                                            $hashNewtPassword = password_hash($newPassword, PASSWORD_BCRYPT, $options);
                                            try {
                                                //Server settings
                                                $mail->SMTPDebug = 0;    
                                                $mail->isSMTP();             
                                                $mail->Host = 'smtp.gmail.com';
                                                $mail->SMTPAuth = true;  
                                                $mail->Username = 'cskh.dystopia@gmail.com';
                                                $mail->Password = '123@qwe@123'; 
                                                $mail->SMTPSecure = 'tls'; 
                                                $mail->Port = 587;
                                            
                                                //Recipients
                                                $mail->setFrom('cskh.dystopia@gmail.com', 'CSKH Dystopia Store');
                                                $mail->addAddress($email);
                                                $mail->addReplyTo('cskh.dystopia@gmail.com', 'CSKH Dystopia Store');
                                            
                                                //Content                     
                                                $mail->Subject = 'Reset password Dystopia Shop';
                                                $mail->Body    = "
                                                                <div>
                                                                    <h3 style = 'color:#222;'>Đặt lại mật khẩu</h3>
                                                                    <p style = 'color:#222;'>Xin chào quý khách! Cảm ơn quý khách đã tin tưởng dịch vụ của cửa hàng.</p>
                                                                    <p style = 'color:#222;'>Mật khẩu đã được đặt lại: </p>
                                                                    <h3>".$newPassword."</h3>
                                                                </div>
                                                                ";
                                                $mail->isHTML(true);  
                                            
                                                if ($mail->send()) {
                                                    echo 'Tin nhắn đã được gửi đến Gmail: '.$email;

                                                    $resetUserPassword = updatePasswordWithEmail($email , $hashNewtPassword);

                                                }
                                                
                                            } catch (Exception $e) {
                                                echo 'Tin nhắn không thể gửi đến Gmail. ', $mail->ErrorInfo;
                                            }
                                        }
                                    }
                                }
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>