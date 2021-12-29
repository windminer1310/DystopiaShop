// Display
const fields = $$('.user-account__content');
const items = $$('.user-nav__item');
items.forEach((item, index) => {
    const field = fields[index];
    item.onclick = function() {
        $('.user-nav__item.user-nav__item--active').classList.remove('user-nav__item--active');
        $('.user-account__content.user-account__content--active').classList.remove('user-account__content--active');
        field.classList.add('user-account__content--active');
        this.classList.add('user-nav__item--active');
    }
});

// Check input
function passwordForm(password, minLength) {
    if (password.value.length >= minLength) return true;
    return false;
}

// Check input & display btn
function checkedPassword() {
    var currentPassword = document.getElementById('current-password');
    var newPassword = document.getElementById('new-password');
    var newCheckedPassword = document.getElementById('new-password-checked');
    var minLengthPw = 8;

    if (passwordForm(currentPassword, minLengthPw) &&
        passwordForm(newPassword, minLengthPw) &&
        passwordForm(newCheckedPassword, minLengthPw)) {
        if (newPassword.value === newCheckedPassword.value) {
            document.getElementsByClassName('status-icon')[0].innerHTML = '<i class="fas fa-check-circle auth__form--success"></i>';

            document.getElementById("change-password").removeAttribute("disabled");
            document.getElementById("change-password").classList.remove('btn--disabled');
        } else {
            document.getElementsByClassName('status-icon')[0].innerHTML = '';
            document.getElementById("change-password").classList.add('btn--disabled');
        }
    } else {

        document.getElementById("change-password").classList.add('btn--disabled');
    }
}

// Data processing
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
            var statusDB = ajax_request.responseText;
            if (statusDB == "1") showSuccessToast("Đổi mật khẩu thành công")
            else if (statusDB == "-1") showInfoToast("Mật khẩu cũ chưa chính xác")
            else showWarningToast("Đã có lỗi xảy ra. Vui lòng thử lại sau")
        }
    }
}