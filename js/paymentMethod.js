const $ = document.querySelector.bind(document);
const $$ = document.querySelectorAll.bind(document);

const labelPaymentMethods = $$('.payment-method__label');
const boxPaymentMethods = $$('.payment-method__box');


labelPaymentMethods.forEach((method, index, ) => {
    const tab = boxPaymentMethods[index];
    method.onclick = function () {

        $('.payment-method__box.active-method').classList.remove('active-method');

        tab.classList.add('active-method');

    }
});
