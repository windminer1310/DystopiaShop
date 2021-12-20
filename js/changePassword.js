


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