const $ = document.querySelector.bind(document);
var input = document.getElementById('input__file-location');

input.addEventListener('click', function() {
    deletePreviousTable();
});

var chosse = document.getElementById('choose-file');
chosse.addEventListener('click', function() {  
    deletePreviousTable();
    readXlsxFile(input.files[0]).then(function(data) {
        data.map((row, index) => {
            let table = document.getElementById('table-data');
            if(index == 0){
                generateTableHead(table, row);
            }
            else {
                generateTableRows(table, row);
            }
        })
    });
});

updateTableStatus();

function deletePreviousTable(){
    if($("#table-data thead") != null){
        $("#table-data thead").remove(); 
    }
}

function generateTableHead(table, data){
    let thead = table.createTHead();
    let row = thead.insertRow();

    for(let key of data){
        let th = document.createElement('th');
        th.setAttribute("class", "tbl--data-heading");
        let text = document.createTextNode(key);
        th.appendChild(text);
        row.appendChild(th);
    }
}

function generateTableRows(table, data){
    let newRow = table.insertRow(-1);
    data.map((row) => {
        let newCell = newRow.insertCell();
        let newText = document.createTextNode(row);
        newCell.setAttribute("class", "tbl--data-item");
        newCell.appendChild(newText);
    });
}

function updateTableStatus(){
    var submit = document.getElementById('submit');
    submit.addEventListener('click', function() { 
        var elements = document.getElementsByClassName('tbl--data-item');    
        var header = document.getElementsByClassName('tbl--data-heading');
        
        totalColumn = 2;
        if(header.length != totalColumn){
            errorInHeadingLine();
        }
        else{
            errorInItemLine(elements, header.length); 
        }
    })
}

function errorInItemLine(elements, totalColumn){
    product = []
    productId = []
    qtyErrorLine = []
    hasErrorInFile = false;
    index = 0;
    for(i = 0; i < elements.length; i+=totalColumn){
        productId.push(elements[i].innerText);

        if(isValidQuantity(elements[i+1].innerText)){
            if(!hasErrorInFile){
                product[index] = { product_id:elements[i].innerText, quantity:elements[i+1].innerText }
            }
        }
        else {
            qtyErrorLine.push(index);
            hasErrorInFile = true;
        }
        index++;
    }
    displayListInvalidProductId(productId);
    
    setTimeout(function(){
        var productIdErrorLine =  arrProductIdErrorLine();
        let mySet = [...new Set(productIdErrorLine.concat(qtyErrorLine))];
        let errorLine = Array.from(mySet);

        if(errorLine.length > 0) {
            errorItemLine(errorLine);
        }
        else{
            getMethodUrl = '';
            for(i = 0; i < elements.length/totalColumn; i++){
                getMethodUrl += 'product_id[]=' + product[i].product_id + '&';
                getMethodUrl += 'qty[]=' + product[i].quantity + '&';
            }
            window.location.href = 'update-product-qty.php?' + getMethodUrl;
        }
    }, 100);
}

function isValidQuantity(quantity){
    parseQtyToNumber = Number(quantity);
    if(!isNaN(parseQtyToNumber) && parseQtyToNumber >= 0) return true;
    return false;
}

function errorItemLine(errorLine){
    var list = document.getElementsByTagName('tr');
    alert('Mã phản phẩm không tồn tại hoặc thông tin không đúng định dạng, vui lòng kiểm tra lại các dòng được in đậm!');
    errorLine.map(
        x => list[x+1].setAttribute('class', 'error-line')
    );
}

function errorInHeadingLine(){
    var list = document.getElementsByTagName('tr');
    alert('Số lượng cột trong file hoặc tên cột không đúng định dạng!');
    list[0].setAttribute('class', 'error-line');
}

function arrProductIdErrorLine(){
    var productIdErrorLine = []
    if(document.getElementById('product__error-line').innerText != '')
        {
            productIdErrorLine = document.getElementById('product__error-line').innerText.split('-');
            productIdErrorLine = productIdErrorLine.map(function (x) { 
                return parseInt(x, 10); 
            });
        }
    return productIdErrorLine;
}

function displayListInvalidProductId(arrProductId){
    productIdString = arrProductId.join('-')

    var form_data = new FormData();
    form_data.append('product_id', productIdString);

    var ajax_request = new XMLHttpRequest();
    ajax_request.open('POST', '../database/checkValidProduct.php');
    ajax_request.send(form_data);

    ajax_request.onreadystatechange = function()
    {
        if(ajax_request.readyState == 4 && ajax_request.status == 200)
        {
            document.getElementById('product__error-line').innerHTML = ajax_request.responseText;
        }
    }
}

