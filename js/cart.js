function addToCart(productId, isInCart) {
    var qty = document.getElementById(productId);
    if (qty.value > 0) {
        var addToCartData = new FormData();
        addToCartData.append('product_id', productId);
        addToCartData.append('qty_add', qty.value);
        addToCartData.append('is_in_cart', isInCart);

        var ajax_request = new XMLHttpRequest();
        ajax_request.open('POST', 'database/userCart.php');
        ajax_request.send(addToCartData);
        ajax_request.onreadystatechange = function() {
            if (ajax_request.readyState == 4 && ajax_request.status == 200) {
                var statusDB = ajax_request.responseText;
                if (statusDB == "0") showInfoToast("Số lượng sản phẩm không đủ để cung cấp.")
                else if (statusDB == "1") showSuccessToast("Cập nhật giỏ hàng thành công.")
                else if (statusDB == "-1") showErrorToast("Cập nhật giỏ hàng thất bại.")
                else showErrorToast("Có lỗi xảy ra trong quá trình xử lý. Vui lòng thử lại sau.")
                setTimeout(function() { location.reload() }, 3000);
            }
        }
    } else {
        showWarningToast("Số lượng không phù hợp.");
        qty.value = 1;
    }
}