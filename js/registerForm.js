function success() {
    if (!checkUserName() && !checkUserEmail() && !checkUserPhone() && !checkUserPassword()) {
        displayInvalidInfo();
    } else if (checkUserName() && checkUserEmail() && checkUserPhone() && checkUserPassword()) {
        save_data();
    } else {
        displayInvalidInfo();
        var arrayCheckFunction = [checkUserName(), checkUserEmail(), checkUserPhone(), checkUserPassword()];
        arrayCheckFunction.forEach(element => element);
    }
}

function displayInvalidInfo() {
    document.getElementById('auth-form__notify-text').innerHTML = '<div class="auth__form--fail">Vui lòng nhập đúng định dạng và đầy đủ thông tin</div>';
    setTimeout(function() {
        document.getElementById('auth-form__notify-text').innerHTML = '';
    }, 5000);
    return 0;
}


function clearWarningInput(id) {
    type = "instruction-box__" + id;
    document.getElementById(id).style.borderColor = "#dbdbdb";
    document.getElementById(type).style.display = "block";
}

function checkUserPhone() {
    hideInstructionBox("phone");
    var getPhone = document.getElementById("phone").value;
    var numberPattern = /^\d+$/;
    if (getPhone.match(numberPattern) && getPhone.length >= 10 && getPhone.length <= 12) {
        document.getElementById('phone').style.borderColor = "#dbdbdb";
        return true;
    }
    document.getElementById('phone').style.borderColor = "red";
    return false;
}


function checkUserName() {
    hideInstructionBox("name");
    var getName = document.getElementById("name").value;
    var namePattern = /^([^0-9]*)$/;
    if (namePattern.test(getName) && getName.length >= 5) {
        document.getElementById('name').style.borderColor = "#dbdbdb";
        return true;
    }
    document.getElementById('name').style.borderColor = "red";
    return false;
}


function checkUserEmail() {
    hideInstructionBox("email");
    var getEmail = document.getElementById("email").value;
    var emailPattern = /\S+@\S+\.\S+/;
    if (emailPattern.test(getEmail) && getEmail.length >= 5) {
        document.getElementById('email').style.borderColor = "#dbdbdb";
        return true;
    }
    document.getElementById('email').style.borderColor = "red";
    return false;
}

function checkUserPassword() {
    hideInstructionBox("password");
    var getPassword = document.getElementById("password").value;
    if (getPassword.length >= 8) {
        document.getElementById('password').style.borderColor = "#dbdbdb";
        return true;
    }
    document.getElementById('password').style.borderColor = "red";
    return false;
}

function hideInstructionBox(type) {
    type = "instruction-box__" + type;
    document.getElementById(type).style.display = "none";
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
            }, 6000);
        }
    }
}