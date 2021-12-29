function startProvince() {
    getProvinces(renderProvince);
}

function startDistrict() {
    var district = document.getElementById('district');
    district.removeAttribute("disabled");
    getProvinces(renderDistrict);
    var listWards = document.querySelector('#ward');
    htmls = "<option value='' disabled selected hidden>Chọn phường/xã</option>";
    listWards.innerHTML = htmls;
    document.getElementById("address").value = '';
}

function startWard() {
    var district = document.getElementById('ward');
    district.removeAttribute("disabled");
    getProvinces(renderWard);
}

function getProvinces(callback) {
    fetch('js/ProvinceVN.json')
        .then(response => response.json())
        .then(callback);
}

function renderProvince(provinces) {
    var listProvinces = document.querySelector('#city');
    provinces.sort(compare);
    var htmls = provinces.map(function(province) {
        return `
            <option value=${province.code}>
                ${province.name}
            </option>
        `
    });
    htmls = "<option value='' disabled selected hidden>Chọn tỉnh/thành phố</option>" + htmls.join('');
    listProvinces.innerHTML = htmls;
}

function getProvinceCode() {
    var e = document.getElementById("city");
    var strUser = e.options[e.selectedIndex].value;
    return strUser;
}

function renderDistrict(districts) {
    var listDistricts = document.querySelector('#district');
    var districtWithProvinceCode = districts.find(element => element.code == getProvinceCode());
    districtWithProvinceCode.districts.sort(compare);
    var htmls = districtWithProvinceCode.districts.map(function(district) {
        return `
            <option value=${district.code}>
                ${district.name}
            </option>
        `
    });
    htmls = "<option value='' disabled selected hidden>Chọn quận/huyện</option>" + htmls.join('');
    listDistricts.innerHTML = htmls;
}

function getDistrictCode() {
    var e = document.getElementById("district");
    var strUser = e.options[e.selectedIndex].value;
    return strUser;
}

function renderWard(wards) {
    var listWards = document.querySelector('#ward');
    var districtWithProvinceCode = wards.find(element => element.code == getProvinceCode());
    var wardWithDistrictCode = districtWithProvinceCode.districts.find(element => element.code == getDistrictCode());
    wardWithDistrictCode.wards.sort(compare);
    var htmls = wardWithDistrictCode.wards.map(function(ward) {
        return `
            <option value=${ward.code}>
                ${ward.name}
            </option>
        `
    });
    htmls = "<option value='' disabled selected hidden>Chọn phường/xã</option>" + htmls.join('');
    listWards.innerHTML = htmls;
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

// 
function getAddressWithCode(getFullAddress, getCode) {
    fetch('js/ProvinceVN.json')
        .then(response => response.json())
        .then(function(data) {
            var obj = {
                code: getCode,
                data: data
            }
            return obj;
        })
        .then(getFullAddress);
}

function getAddressCode() {
    var e = document.getElementById("address");
    address = e.innerText;
    addressCode = address.split(', ');
    return addressCode;
}

function getFullAddress(obj) {
    var data = obj.data;
    var provinceCode = obj.code[0];
    var districtCode = obj.code[1];
    var wardCode = obj.code[2];

    var province = data.find(element => element.code == provinceCode);
    var district = province.districts.find(element => element.code == districtCode);
    var ward = district.wards.find(element => element.code == wardCode);

    var e = document.getElementById("address");

    var address = province.name + ", " + district.name + ", " + ward.name + ", " + obj.code[3];
    e.innerText = address;
    e.style.display = 'unset';
}