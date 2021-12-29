// TOAST
function toast({
    title = '',
    message = '',
    type = 'info',
    duration = 3000
}) {
    const main = document.getElementById('toast')
    if (main) {
        const toast = document.createElement('div')

        //Auto remove toast
        const autoRemoveId = setTimeout(function() {
            main.removeChild(toast)
        }, duration + 1000)

        //Remove toast when click
        toast.onclick = function(e) {
            if (e.target.closest('.toast__close')) {
                main.removeChild(toast)
                clearTimeout(autoRemoveId)
            }
        }

        const icons = {
            success: 'fas fa-check-circle',
            info: 'fas fa-info-circle',
            warning: 'fas fa-exclamation-circle',
            error: 'fas fa-exclamation-circle',
        }
        const icon = icons[type]

        const delay = (duration / 1000).toFixed(2)
        toast.classList.add('toast', `toast--${type}`)
        toast.style.animation = `slideInLeft ease .3s, fadeOut linear 1s ${delay}s forwards`
        toast.innerHTML = `
            <div class="toast__icon">
                <i class="${icon}"></i>
            </div>
            <div class="toast__body">
                <h3 class="toast__title">${title}</h3>
                <p class="toast__msg">${message}</p>
            </div>
            <div class="toast__close">
                <i class="fas fa-times"></i>
            </div>`
        main.appendChild(toast)
    }
}

function showInfoToast(message) {
    toast({
        title: 'Thông báo',
        message: message,
        type: 'info',
        duration: 5000
    })
}

function showSuccessToast(message) {
    toast({
        title: '',
        message: message,
        type: 'success',
        duration: 5000
    })
}

function showWarningToast(message) {
    toast({
        title: '',
        message: message,
        type: 'warning',
        duration: 3000
    })
}

function showErrorToast(message) {
    toast({
        title: '',
        message: message,
        type: 'error',
        duration: 5000
    })
}

// DOM

const $ = document.querySelector.bind(document);
const $$ = document.querySelectorAll.bind(document);

// Bắt sự kiện cuộn chuột
document.addEventListener("DOMContentLoaded", function() {
    var trangthai = "under120";
    var menu = document.getElementById('header');
    var cartList = document.querySelectorAll('div.header__cart-list');
    cartList = cartList[0];
    var userMenu = document.querySelectorAll('ul.header__user-menu');
    userMenu = userMenu[0];
    window.addEventListener("scroll", function() {
        var x = pageYOffset;
        if (x > 120) {
            if (trangthai == "under120") {
                trangthai = "over120";
                menu.classList.add('header-shrink');
                if (typeof cartList != 'undefined') cartList.classList.add('header__fix-shrink');
                if (typeof userMenu != 'undefined') userMenu.classList.add('header__fix-shrink');
            }
        } else if (x <= 120) {
            if (trangthai == "over120") {
                menu.classList.remove('header-shrink');
                if (typeof cartList != 'undefined') cartList.classList.remove('header__fix-shrink');
                if (typeof userMenu != 'undefined') userMenu.classList.remove('header__fix-shrink');

                trangthai = "under120";
            }
        }
    })
})

// Bắt sự kiện chuyển trang
const tabs = $$('.product-page-wrap');
const pages = $$('.page-item');
pages.forEach((page, index, ) => {
    const tab = tabs[index];

    page.onclick = function() {

        $('.page-item.active').classList.remove('active');
        $('.product-page-wrap.product-page__active').classList.remove('product-page__active');

        this.classList.add('active');
        tab.classList.add('product-page__active');
    }
});

// //Hiển thị ảnh trang Product Detail
const tabsImgs = $$('.img-display');
const listImgs = $$('.list-img-item');
listImgs.forEach((img, index) => {
    const tab = tabsImgs[index];
    img.onmouseover = function() {
        $('.img-display.img-display--active').classList.remove('img-display--active');
        $('.list-img-item.list-img-item--active').classList.remove('list-img-item--active');
        tab.classList.add('img-display--active');
        this.classList.add('list-img-item--active');
    }
});
// Tăng giảm số lượng trong Product Detail
function minus_qty() {
    if (document.getElementsByClassName("quantity-input")[0].value > 1) {
        document.getElementsByClassName("quantity-input")[0].value -= 1;
    }
}

function plus_qty() {
    document.getElementsByClassName("quantity-input")[0].value = document.getElementsByClassName("quantity-input")[0].value - 0 + 1;
}

// Tăng giảm số lượng trong giỏ hàng
function minusQtyInCart(productId) {
    var qtyOfProduct = Number(document.getElementById(productId).value)
    if (qtyOfProduct > 1) {
        document.getElementById(productId).value = Number(qtyOfProduct) - 1;
        addToCart(productId, "1");
    }
}

function plusQtyInCart(productId) {
    document.getElementById(productId).value = Number(document.getElementById(productId).value) + 1;
    addToCart(productId, "1");
}

function inputQtyInCart(productId) {
    var qtyOfProduct = Number(document.getElementById(productId).value)
    if (qtyOfProduct > 0) {
        addToCart(productId, "1");
    }
}

// Back to top
const backToTopButton = document.querySelector("#back-to-top");
const scrollContainer = () => {
    return document.documentElement || document.body;
};
const goToTop = () => {
    document.body.scrollIntoView({
        behavior: "smooth"
    });
};
document.addEventListener("scroll", () => {
    const showOnPx = 300;
    if (scrollContainer().scrollTop > showOnPx) {
        backToTopButton.classList.add("show");
    } else {
        backToTopButton.classList.remove("show");
    }
});
backToTopButton.addEventListener("click", goToTop);