function reg(){
    if((regName() && regPhone() && regEmail()) == 1){
        return true;
    } else{
        return false;
    }
}

function regName(){
    let name = document.getElementById('name');

    if(name.value.length == 0){
        document.getElementsByClassName('line-error')[0].innerHTML = 'Name is required.';
        document.getElementsByClassName('line-error')[0].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[1].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[0].style.cssText = 'visibility: hidden;';
        name.style.cssText = 'border-color: red;';

        return false;
    } else if(!isNaN(name.value)){
        document.getElementsByClassName('line-error')[0].innerHTML = 'Please, enter a valid name.';
        document.getElementsByClassName('line-error')[0].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[1].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[0].style.cssText = 'visibility: hidden;';
        name.style.cssText = 'border-color: red;';

        return false;
    } else if(name.value.length <= 3 || name.value.length > 30){
        document.getElementsByClassName('line-error')[0].innerHTML = 'Please, provide between 4-30 characters long.';
        document.getElementsByClassName('line-error')[0].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[1].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[0].style.cssText = 'visibility: hidden;';
        name.style.cssText = 'border-color: red;';

        return false;
    } else{
        document.getElementsByClassName('line-error')[0].style.cssText = 'visibility: hidden;';
        document.getElementsByClassName('cfa')[1].style.cssText = 'visibility: hidden;';
        document.getElementsByClassName('cfa')[0].style.cssText = 'visibility: visible; color: green;';
        name.style.cssText = 'border-color: green;';

        return true;
    }
}

function regPhone(){
    let phone = document.getElementById('phone');

    if(phone.value.length == 0){
        document.getElementsByClassName('line-error')[1].innerHTML = 'Phone is required.';
        document.getElementsByClassName('line-error')[1].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[3].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[2].style.cssText = 'visibility: hidden;';
        phone.style.cssText = 'border-color: red;';

        return false;
    } else if(isNaN(phone.value) || phone.value.length < 10 || phone.value.length > 10){
        document.getElementsByClassName('line-error')[1].innerHTML = 'Please, enter a valid phone number.';
        document.getElementsByClassName('line-error')[1].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[3].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[2].style.cssText = 'visibility: hidden;';
        phone.style.cssText = 'border-color: red;';

        return false;
    } else{
        document.getElementsByClassName('line-error')[1].style.cssText = 'visibility: hidden;';
        document.getElementsByClassName('cfa')[3].style.cssText = 'visibility: hidden;';
        document.getElementsByClassName('cfa')[2].style.cssText = 'visibility: visible; color: green;';
        phone.style.cssText = 'border-color: green;';

        return true;
    }
}

function regEmail(){
    let email = document.getElementById('email');

    if(email.value.length == 0){
        document.getElementsByClassName('line-error')[2].innerHTML = 'Email  is required.';
        document.getElementsByClassName('line-error')[2].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[5].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[4].style.cssText = 'visibility: hidden;';
        email.style.cssText = 'border-color: red;';

        return false;
    } else if(email.value.length > 30){
        document.getElementsByClassName('line-error')[2].innerHTML = 'Please, provide within 30 characters long.';
        document.getElementsByClassName('line-error')[2].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[5].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[4].style.cssText = 'visibility: hidden;';
        email.style.cssText = 'border-color: red;';

        return false;
    } else{
        document.getElementsByClassName('line-error')[2].style.cssText = 'visibility: hidden;';
        document.getElementsByClassName('cfa')[5].style.cssText = 'visibility: hidden;';
        document.getElementsByClassName('cfa')[4].style.cssText = 'visibility: visible; color: green;';
        email.style.cssText = 'border-color: green;';

        return true;
    }
}

function regAcceptance(){
    let acceptance = document.getElementById('acceptance');

    if(acceptance.checked){
        document.getElementsByClassName('reg-submit')[0].style.cssText = 'pointer-events: auto;';

        return true;
    } else{
        document.getElementsByClassName('reg-submit')[0].style.cssText = 'pointer-events: none; border-color: red; background-color: white; color: red;';

        return false;
    }
}