const $ = document.querySelector.bind(document);
var input = document.getElementById('input');

input.addEventListener('click', function() {
    deletePreviousTable();
});

var chosse = document.getElementById('choose-file');
chosse.addEventListener('click', function() {  
    deletePreviousTable();
    readXlsxFile(input.files[0]).then(function(data) {
        data.map((row, index) => {
            if(index == 0){
                let table = document.getElementById('table-data');
                generateTableHead(table, row);
            }
            else {
                let table = document.getElementById('table-data');
                generateTableRows(table, row);
            }
        })
    });
});

btnSubmitClickEvt();

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

function btnSubmitClickEvt(){
    var submit = document.getElementById('submit');
    submit.addEventListener('click', function() { 
        var elements = document.getElementsByClassName('tbl--data-item');    
        var header = document.getElementsByClassName('tbl--data-heading');
        
        totalColumn = 2;
        if(header.length == totalColumn){
            updateTableStatus(elements, header.length); 
        }
        else{
            errorHeadingLine();
        }
    })
}

function updateTableStatus(elements, totalColumn){
    product = []
    productId = []
    qtyErrorLine = []
    hasErrorInFile = false;
    index = 0;
    for(i = 0; i < elements.length; i+=totalColumn){
        productId.push(elements[i].innerText);

        if(checkValidQty(elements[i+1].innerText)){
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

    checkInvalidProductId(productId);
    
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

function checkValidQty(quantity){
    parseQtyToNumber = Number(quantity);
    if(!isNaN(parseQtyToNumber) && parseQtyToNumber >= 0) return true;
    return false;
}

function errorItemLine(errorLine){
    var list = document.getElementsByTagName('tr');
    alert('Mã phản phẩm không tồn tại hoặc thông tin không đúng định dạng!');
    errorLine.map(
        x => list[x+1].setAttribute('class', 'error-line')
    );
}

function errorHeadingLine(){
    var list = document.getElementsByTagName('tr');
    alert('Số lượng cột trong file hoặc tên cột không đúng định dạng!');
    list[0].setAttribute('class', 'error-line');
}

function arrProductIdErrorLine(){
    var productIdErrorLine = []
    if(document.getElementById('line-error').innerText != '')
        {
            productIdErrorLine = document.getElementById('line-error').innerText.split('-');
            productIdErrorLine = productIdErrorLine.map(function (x) { 
                return parseInt(x, 10); 
            });
        }
    return productIdErrorLine;
}

function checkInvalidProductId(arrProductId){
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
            document.getElementById('line-error').innerHTML = ajax_request.responseText;
        }
    }
}

