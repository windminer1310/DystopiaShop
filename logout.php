<<<<<<< Updated upstream
<?php 
    session_start();
    session_unset();
    session_destroy();
    session_write_close();
    setcookie(session_name(),'',0,'/');
    
    echo "<script>
        alert('Đăng xuất thành công!');
        window.location.href = 'index.php';
    </script>";
=======
<?php 
    session_start();
    session_unset();
    session_destroy();
    session_write_close();
    setcookie(session_name(),'',0,'/');
    echo "<script>window.location.href = 'index.php';</script>";
>>>>>>> Stashed changes
?>