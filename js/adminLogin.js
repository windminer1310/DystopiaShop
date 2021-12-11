function success() {
    if(checkUserPhone(document.getElementById("phone").value) && checkUserPassword(document.getElementById("password").value)) {
        document.getElementById('submit').disabled = false; 

    } else { 
        document.getElementById('submit').disabled = true;
    }
}

function checkUserPhone(getPhone)
{
    if(getPhone.length > 0){
        return true;
    }
    else return false;
}

function checkUserPassword(getPassword)
{
    if(getPassword.length > 0){
        return true;
    }
    else return false;
}

function login()
{
    var form_element = document.getElementsByClassName('form_data');

    var form_data = new FormData();

    for(var count = 0; count < form_element.length; count++){
        form_data.append(form_element[count].name, form_element[count].value);
    }

    document.getElementById('submit').disable = true;

    var ajax_request = new XMLHttpRequest();

    ajax_request.open('POST', '../database/adminLogin.php');
    ajax_request.send(form_data);

    ajax_request.onreadystatechange = function()
    {
        if(ajax_request.readyState == 4 && ajax_request.status == 200)
        {
            document.getElementById('submit').disable = false;
            document.getElementById('submit').classList.remove('btns--disabled');
            document.getElementById('login-form').reset();

            if(ajax_request.responseText == 1){
                window.location.href = "admin.php";
            }
            if(ajax_request.responseText == 2){
                window.location.href = "transaction-management.php";
            }
            else{
                document.getElementById('auth-form__notify-text').innerHTML = ajax_request.responseText;
            }

            setTimeout(function(){

                document.getElementById('auth-form__notify-text').innerHTML = '';
            }, 10000);
        }
    }
    document.getElementById('submit').disabled = true;
    document.getElementById('submit').classList.add('btns--disabled');
}