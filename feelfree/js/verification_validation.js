function ver(){
    if((verBCN() && verNIDN() && verBCP() && verNIDP()) == 1){
        return true;
    } else{
        return false;
    }
}

function verBCN(){
    let bcn = document.getElementById('bcn');

    if(bcn.value.length == 0){
        document.getElementsByClassName('line-error')[0].innerHTML = 'Birth registration no is required.';
        document.getElementsByClassName('line-error')[0].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[1].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[0].style.cssText = 'visibility: hidden;';
        bcn.style.cssText = 'border-color: red;';

        return false;
    } else if(isNaN(bcn.value) || bcn.value.length <= 10 || bcn.value.length > 25){
        document.getElementsByClassName('line-error')[0].innerHTML = 'Please, enter a valid birth registration no.';
        document.getElementsByClassName('line-error')[0].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[1].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[0].style.cssText = 'visibility: hidden;';
        bcn.style.cssText = 'border-color: red;';

        return false;
    } else{
        document.getElementsByClassName('line-error')[0].style.cssText = 'visibility: hidden;';
        document.getElementsByClassName('cfa')[1].style.cssText = 'visibility: hidden;';
        document.getElementsByClassName('cfa')[0].style.cssText = 'visibility: visible; color: green;';
        bcn.style.cssText = 'border-color: green;';

        return true;
    }
}

function verNIDN(){
    let nidn = document.getElementById('nidn');

    if(nidn.value.length == 0){
        document.getElementsByClassName('line-error')[1].innerHTML = 'National identity no is required.';
        document.getElementsByClassName('line-error')[1].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[3].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[2].style.cssText = 'visibility: hidden;';
        nidn.style.cssText = 'border-color: red;';

        return false;
    } else if(isNaN(nidn.value) || nidn.value.length < 10 || nidn.value.length > 17){
        document.getElementsByClassName('line-error')[1].innerHTML = 'Please, enter a valid national identity no.';
        document.getElementsByClassName('line-error')[1].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[3].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[2].style.cssText = 'visibility: hidden;';
        nidn.style.cssText = 'border-color: red;';

        return false;
    } else{
        document.getElementsByClassName('line-error')[1].style.cssText = 'visibility: hidden;';
        document.getElementsByClassName('cfa')[3].style.cssText = 'visibility: hidden;';
        document.getElementsByClassName('cfa')[2].style.cssText = 'visibility: visible; color: green;';
        nidn.style.cssText = 'border-color: green;';

        return true;
    }
}

function verBCP(){
    let bcp = document.getElementById('bcp');
    let allowExt = /(\.jpg|\.jpeg)$/i;

    if(!allowExt.exec(bcp.value)){
        document.getElementsByClassName('line-error')[2].innerHTML = 'Please, upload jpg, jpeg format.';
        document.getElementsByClassName('line-error')[2].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[5].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[4].style.cssText = 'visibility: hidden;';
        bcp.style.cssText = 'border-color: red;';

        return false;
    } else if(bcp.files[0].size > 3072000){
        document.getElementsByClassName('line-error')[2].innerHTML = 'Please, upload within 3MB.';
        document.getElementsByClassName('line-error')[2].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[5].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[4].style.cssText = 'visibility: hidden;';
        bcp.style.cssText = 'border-color: red;';

        return false;
    } else{
        document.getElementsByClassName('line-error')[2].style.cssText = 'visibility: hidden;';
        document.getElementsByClassName('cfa')[5].style.cssText = 'visibility: hidden;';
        document.getElementsByClassName('cfa')[4].style.cssText = 'visibility: visible; color: green;';
        bcp.style.cssText = 'border-color: green;';

        return true;
    }
}

function verNIDP(){
    let nidp = document.getElementById('nidp');
    let allowExt = /(\.jpg|\.jpeg)$/i;

    if(!allowExt.exec(nidp.value)){
        document.getElementsByClassName('line-error')[3].innerHTML = 'Please, upload jpg, jpeg format.';
        document.getElementsByClassName('line-error')[3].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[7].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[6].style.cssText = 'visibility: hidden;';
        nidp.style.cssText = 'border-color: red;';

        return false;
    } else if(nidp.files[0].size > 3072000){
        document.getElementsByClassName('line-error')[3].innerHTML = 'Please, upload within 3MB.';
        document.getElementsByClassName('line-error')[3].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[7].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[6].style.cssText = 'visibility: hidden;';
        nidp.style.cssText = 'border-color: red;';

        return false;
    } else{
        document.getElementsByClassName('line-error')[3].style.cssText = 'visibility: hidden;';
        document.getElementsByClassName('cfa')[7].style.cssText = 'visibility: hidden;';
        document.getElementsByClassName('cfa')[6].style.cssText = 'visibility: visible; color: green;';
        nidp.style.cssText = 'border-color: green;';

        return true;
    }
}