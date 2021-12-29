// Xử lí fillter danh sách sản phẩm
function priceFilter() {
    var price_min = document.getElementById('price_min').value;
    var price_max = document.getElementById('price_max').value;
    price_min = price_min.replaceAll('.', '') - 0;
    price_max = price_max.replaceAll('.', '') - 0;
    if (price_min > price_max && price_max != "" && price_min != "") {
        price_min = price_max;
        price_max = document.getElementById('price_min').value - 0;
    }

    var parts = window.location.search.substr(1).split("&");
    var $_GET = {};
    for (var i = 0; i < parts.length; i++) {
        var temp = parts[i].split("=");
        $_GET[decodeURIComponent(temp[0])] = decodeURIComponent(temp[1]);
    }

    var link = "./product-list.php?";
    var search = "",
        sort = "",
        priceFilter = "";
    if (price_min > 0) {
        priceFilter = "price_min=" + price_min;
    }
    if (price_max > 0) {
        priceFilter = "price_max=" + price_max;
    }
    if (price_min > 0 && price_max > 0) {
        priceFilter = "price_min=" + price_min + "&price_max=" + price_max;
    }

    if (typeof $_GET['search'] !== 'undefined') {
        search = "search=" + $_GET['search'];
    }
    if (typeof $_GET['sort'] !== 'undefined') {
        sort = "sort=" + $_GET['sort'];
    }
    var filter = [search, sort, priceFilter]

    x = filter.join('&');
    if (x[x.length - 1] == "&") {
        x = x.substring(0, x.length - 1);
    }
    if (x[0] == "&") {
        x = x.substring(1, x.length);
    }
    link = link + x;

    window.location.href = link;

}

function reverseNumber(input) {
    return [].map.call(input, function(x) {
        return x;
    }).reverse().join('');
}

function plainNumber(number) {
    return number.split('.').join('');
}

function splitInDots(input) {
    var value = input.value,
        plain = plainNumber(value),
        reversed = reverseNumber(plain),
        reversedWithDots = reversed.match(/.{1,3}/g).join('.'),
        normal = reverseNumber(reversedWithDots);
    input.value = normal;
}

function activeSortBtn() {
    var parts = window.location.search.substr(1).split("&");
    var $_GET = {};
    for (var i = 0; i < parts.length; i++) {
        var temp = parts[i].split("=");
        $_GET[decodeURIComponent(temp[0])] = decodeURIComponent(temp[1]);
    }
    if (typeof $_GET['sort'] !== 'undefinded') {
        var btn = document.getElementById("sort" + $_GET['sort']);
        if (btn) btn.classList.remove('btn--white');
    }
}

function setInputFilter(textbox, inputFilter) {
    ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
        textbox.addEventListener(event, function() {
            if (inputFilter(this.value)) {
                this.oldValue = this.value;
                this.oldSelectionStart = this.selectionStart;
                this.oldSelectionEnd = this.selectionEnd;
            } else if (this.hasOwnProperty("oldValue")) {
                this.value = this.oldValue;
                this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
            }
        });
    });
}
setInputFilter(document.getElementById("price_min"), function(value) {
    return /^\d*$/.test(value);
});
setInputFilter(document.getElementById("price_max"), function(value) {
    return /^\d*$/.test(value);
});