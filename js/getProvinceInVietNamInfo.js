var provinceApi = 'https://provinces.open-api.vn/api/?depth=3';

function startProvince(){
    getProvince(renderProvince);
}

startProvince();

function startDistrict(){
    getProvince(renderDistrict);
}

function startWard(){
    getProvince(renderWard);
}


function getProvince(callback) {
    fetch(provinceApi)
        .then(function(response) {
            return response.json();
        })
        .then(callback);
}

function renderProvince(provinces){
    var listProvincesBlock = document.querySelector('#city');
    provinces.sort(compare);
    var htmls = provinces.map(function(province){
        return `
            <option value=${province.codename}>
                ${province.name}
            </option>
        `
    });
    listProvincesBlock.innerHTML = htmls.join('');
}

function getValueSelectedDistrict(){
    var e = document.getElementById("city");
    var strUser = e.options[e.selectedIndex].value;
    return strUser;
}

function renderDistrict(districts){

    var listDistrictsBlock = document.querySelector('#district');
    var districtssWithSelectProvince = districts.find(element => element.codename === getValueSelectedDistrict());

    districtssWithSelectProvince.districts.sort(compare);
    var htmls = districtssWithSelectProvince.districts.map(function(district){
        return `
            <option value=${district.codename}>
                ${district.name}
            </option>
        `
    });
    listDistrictsBlock.innerHTML = htmls.join('');
}

function getValueSelectedWard(){
    var e = document.getElementById("district");
    var strUser = e.options[e.selectedIndex].value;
    return strUser;
}


function renderWard(wards){

    var listDistrictsBlock = document.querySelector('#ward');
    var districtssWithSelectProvince = wards.find(element => element.codename === getValueSelectedDistrict());
    var districtssWithSelectWard = districtssWithSelectProvince.districts.find(element => element.codename === getValueSelectedWard());
    districtssWithSelectWard.wards.sort(compare);
    var htmls = districtssWithSelectWard.wards.map(function(ward){
        return `
            <option value=${ward.codename}>
                ${ward.name}
            </option>
        `
    });
    listDistrictsBlock.innerHTML = htmls.join('');
}



function compare( firstValue, secondValue ) {
    if ( firstValue.name < secondValue.name ){
      return -1;
    }
    if ( firstValue.name > secondValue.name ){
      return 1;
    }
    return 0;
  }
  