const paymentMethodsRadio = $$('.payment-method__radio');
const paymentMethods = $$('.payment-method');


paymentMethodsRadio.forEach((method, index, ) => {
    const tab = paymentMethods[index];
    method.onclick = function() {
        $('.payment-method.payment-method--active').classList.remove('payment-method--active');
        tab.classList.add('payment-method--active');

    }
});