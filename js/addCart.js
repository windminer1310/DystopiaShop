function addToCart() {
    var quantityProductElement = document.getElementsByClassName('quantity-product');


    var addToCartData = new FormData();

    addToCartData.append(quantityProductElement[0].name, quantityProductElement[0].value);


    var ajax_request = new XMLHttpRequest();

    ajax_request.open('POST', 'database/userCart.php');

    ajax_request.send(addToCartData);

    ajax_request.onreadystatechange = function() {
        if (ajax_request.readyState == 4 && ajax_request.status == 200) {
            alert(ajax_request.responseText);
            location.reload();
        }
    }
}