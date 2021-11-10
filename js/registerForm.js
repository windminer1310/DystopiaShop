function success() {
    if (checkUserEmail() && checkUserName() && checkUserPhone() && checkUserPassword()) {
        save_data();
    } else {
        document.getElementById('auth-form__notify-text').innerHTML = '<div class="fail-auth__form">Nhập thông tin chưa đúng định dạng!</div>';
        setTimeout(function() {
            document.getElementById('auth-form__notify-text').innerHTML = '';
        }, 2000);
    }
}

function checkUserPhone() {
    var getPhone = document.getElementById("phone").value;
    var numberPattern = /^\d+$/;
    if (getPhone.match(numberPattern) && getPhone.length >= 10 && getPhone.length <= 12) {
        return true;
    } else return false;
}

function checkUserName() {
    var getName = document.getElementById("name").value;
    var namePattern = /^([^0-9]*)$/;
    if (namePattern.test(getName) && getName.length >= 5) {
        return true;
    } else return false;
}

function checkUserEmail() {
    var getEmail = document.getElementById("email").value;
    var emailPattern = /\S+@\S+\.\S+/;
    if (emailPattern.test(getEmail) && getEmail.length >= 5) {
        return true;
    } else return false;
}

function checkUserPassword() {
    var getPassword = document.getElementById("password").value;
    if (getPassword.length >= 5) {
        return true;
    } else return false;
}

function save_data() {
    var form_element = document.getElementsByClassName('form_data');

    var form_data = new FormData();

    for (var count = 0; count < form_element.length; count++) {
        form_data.append(form_element[count].name, form_element[count].value);
    }

    var ajax_request = new XMLHttpRequest();

    ajax_request.open('POST', 'database/userRegister.php');

    ajax_request.send(form_data);
    ajax_request.onreadystatechange = function() {
        if (ajax_request.readyState == 4 && ajax_request.status == 200) {
            document.getElementById('auth-form__notify-text').innerHTML = ajax_request.responseText;
            setTimeout(function() {
                document.getElementById('auth-form__notify-text').innerHTML = '';
            }, 10000);
        }
    }
}