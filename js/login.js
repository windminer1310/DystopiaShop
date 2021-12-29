function login(obj = "user") {
    href = "./index.php";
    postLink = './database/userLogin.php';
    if (obj == "admin") {
        href = "./admin.php";
        postLink = '../database/adminLogin.php';
    }

    var data = document.getElementsByClassName('form_data');
    if (data[0].value == "" || data[1].value == "") {
        document.getElementById('auth-form__notify-text').innerHTML = 'Thông tin đăng nhập chưa chính xác';
        setTimeout(function() {
            document.getElementById('auth-form__notify-text').innerHTML = '';
        }, 5000);
    } else {
        var form_data = new FormData();
        form_data.append(data[0].name, data[0].value);
        form_data.append(data[1].name, data[1].value);

        var ajax_request = new XMLHttpRequest();
        ajax_request.open('POST', postLink);
        ajax_request.send(form_data);

        ajax_request.onreadystatechange = function() {
            if (ajax_request.readyState == 4 && ajax_request.status == 200) {
                if (ajax_request.responseText == '') {
                    window.location.href = href;
                } else {
                    document.getElementById('auth-form__notify-text').innerHTML = ajax_request.responseText;
                }
                setTimeout(function() {
                    document.getElementById('auth-form__notify-text').innerHTML = '';
                }, 10000);
            }
        }
    }
}