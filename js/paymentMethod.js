function activePaymentMethod(typeMethod){
    var paymentMethodType = ['banking-method', 'cash-method'];
    countPaymentMethodType = paymentMethodType.length;

    for(i = 0; i < countPaymentMethodType; i++){
        if(typeMethod == paymentMethodType[i]){
            addActiveMethod(paymentMethodType[i])
        }
        else {
            removeActiveMethod(paymentMethodType[i])
        }
    }

}

function addActiveMethod(type){
    var element = document.getElementById(type);
    element.classList.add("active-method");
    element.classList.remove("checked-hover");
}

function removeActiveMethod(type){
    var element = document.getElementById(type);
    element.classList.remove("active-method");
    element.classList.add("checked-hover");
}


function activeChooseMethod(typeMethod){
    var paymentMethodType = ['momo-method', 'paypal-method'];
    countPaymentMethodType = paymentMethodType.length;

    for(i = 0; i < countPaymentMethodType; i++){
        if(typeMethod == paymentMethodType[i]){
            addActiveChooseMethod(paymentMethodType[i])
        }
        else {
            removeActiveChooseMethod(paymentMethodType[i])
        }
    }
}

function addActiveChooseMethod(type){
    var element = document.getElementById(type);
    element.classList.add("active-method__payment");
    element.classList.remove("checked-hover__payment");
}
function removeActiveChooseMethod(type){
    var element = document.getElementById(type);
    element.classList.remove("active-method__payment");
    element.classList.add("checked-hover__payment");
}
