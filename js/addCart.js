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
    

function updateToCartInCartPage(productId) {
    var quantityProductElement = document.getElementById(productId);

    

    var addToCartData = new FormData();

    addToCartData.append('amountProduct', quantityProductElement.value);

    addToCartData.append('idProductCart', quantityProductElement.name);

    var ajax_request = new XMLHttpRequest();

    ajax_request.open('POST', 'database/updateUserCart.php');

    ajax_request.send(addToCartData);

    ajax_request.onreadystatechange = function() {
        if (ajax_request.readyState == 4 && ajax_request.status == 200) {
            alert(ajax_request.responseText);
            location.reload();
        }
    }
}