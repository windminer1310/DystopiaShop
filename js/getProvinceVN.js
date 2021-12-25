var provinceApi = 'https://provinces.open-api.vn/api/?depth=3';

function startProvince() {
    getProvince(renderProvince);
}
startProvince();

function startDistrict() {
    var district = document.getElementById('district');
    district.removeAttribute("disabled");
    getProvince(renderDistrict);
}

function startWard() {
    var district = document.getElementById('ward');
    district.removeAttribute("disabled");
    getProvince(renderWard);
}

function getProvince(callback) {
    fetch(provinceApi)
        .then(function(response) {
            return response.json();
        })
        .then(callback);
}

function renderProvince(provinces) {
    var listProvincesBlock = document.querySelector('#city');
    provinces.sort(compare);
    var htmls = provinces.map(function(province) {
        return `
            <option value=${province.code}>
                ${province.name}
            </option>
        `
    });
    htmls = "<option value='' disabled selected hidden>Chọn tỉnh/thành phố</option>" + htmls.join('');
    listProvincesBlock.innerHTML = htmls;
}

function getValueSelectedDistrict() {
    var e = document.getElementById("city");
    var strUser = e.options[e.selectedIndex].value;
    return strUser;
}

function renderDistrict(districts) {
    var listDistrictsBlock = document.querySelector('#district');
    var districtssWithSelectProvince = districts.find(element => element.code == getValueSelectedDistrict());
    districtssWithSelectProvince.districts.sort(compare);
    var htmls = districtssWithSelectProvince.districts.map(function(district) {
        return `
            <option value=${district.code}>
                ${district.name}
            </option>
        `
    });
    htmls = "<option value='' disabled selected hidden>Chọn quận/huyện</option>" + htmls.join('');
    listDistrictsBlock.innerHTML = htmls;
}

function getValueSelectedWard() {
    var e = document.getElementById("district");
    var strUser = e.options[e.selectedIndex].value;
    return strUser;
}

function renderWard(wards) {
    var listDistrictsBlock = document.querySelector('#ward');
    var districtssWithSelectProvince = wards.find(element => element.code == getValueSelectedDistrict());
    var districtssWithSelectWard = districtssWithSelectProvince.districts.find(element => element.code == getValueSelectedWard());
    districtssWithSelectWard.wards.sort(compare);
    var htmls = districtssWithSelectWard.wards.map(function(ward) {
        return `
            <option value=${ward.code}>
                ${ward.name}
            </option>
        `
    });
    htmls = "<option value='' disabled selected hidden>Chọn phường/xã</option>" + htmls.join('');
    listDistrictsBlock.innerHTML = htmls;
}

function compare(firstValue, secondValue) {
    if (firstValue.name < secondValue.name) {
        return -1;
    }
    if (firstValue.name > secondValue.name) {
        return 1;
    }
    return 0;
}