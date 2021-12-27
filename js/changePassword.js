function changePasswordStatus() {
    var currentPassword = document.getElementById('current-password');
    var newPassword = document.getElementById('new-password');


    var form_data = new FormData();

    form_data.append(currentPassword.name, currentPassword.value);
    form_data.append(newPassword.name, newPassword.value);

    var ajax_request = new XMLHttpRequest();

    ajax_request.open('POST', 'database/changePassword.php');

    ajax_request.send(form_data);
    ajax_request.onreadystatechange = function() {
        if (ajax_request.readyState == 4 && ajax_request.status == 200) {
            document.getElementById('password-change__notify-text').innerHTML = ajax_request.responseText;
            setTimeout(function() {
                document.getElementById('password-change__notify-text').innerHTML = '';
            }, 10000);
        }
    }
}


function changePasswordAdminStatus($id) {
    var newPassword = document.getElementById('new-password__admin');

    console.log(newPassword)

    var form_data = new FormData();

    form_data.append(newPassword.name, newPassword.value);
    form_data.append('id__admin', $id);

    var ajax_request = new XMLHttpRequest();

    ajax_request.open('POST', '../database/changePasswordAdmin.php');

    ajax_request.send(form_data);
    ajax_request.onreadystatechange = function() {
        if (ajax_request.readyState == 4 && ajax_request.status == 200) {
            // document.getElementById('password-change__notify-text').innerHTML = ajax_request.responseText;
            // setTimeout(function() {
            //     document.getElementById('password-change__notify-text').innerHTML = '';
            // }, 10000);
            alert(ajax_request.responseText);
            
            location.reload();
        }
    }
}

function checkedPassword(){
    var newPassword = document.getElementById('new-password__admin');
    var newCheckedPassword = document.getElementById('new-password-checked__admin');
    var minLengthPw = 8;

    var btnChangePw = document.getElementById("change-password__admin");

    if(passwordForm(newPassword, minLengthPw) && 
        passwordForm(newCheckedPassword, minLengthPw)) {

        if(newPassword.value === newCheckedPassword.value) {
            document.getElementsByClassName('status-icon')[0].innerHTML = '<i class="fas fa-check-circle succes-auth__form"></i>';

            btnChangePw.removeAttribute("disabled");
            btnChangePw.classList.remove('btn--disabled');
        }
        else{
            document.getElementsByClassName('status-icon')[0].innerHTML = '';
            btnChangePw.classList.add('btn--disabled');
        }
    }
    else {

        btnChangePw.classList.add('btn--disabled');
    }
}

function passwordForm(password, minLength){
    if (password.value.length >= minLength) return true;
    return false;
}

function notifyDeleteAdmin($id){
    if (confirm('Bạn có muốn tiếp tục xóa nhân viên '+ $id)) {
        window.location.href = '../database/deleteAdmin.php?admin_id='+$id;
    }
}