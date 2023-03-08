function fgtpassEmail(){
    let email = document.getElementById('email');

    if (email.value.length == 0) {
        document.getElementsByClassName('line-error')[0].innerHTML = 'Email  is required.';
        document.getElementsByClassName('line-error')[0].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[1].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[0].style.cssText = 'visibility: hidden;';
        email.style.cssText = 'border-color: red;';

        return false;
    } else if (email.value.length > 30) {
        document.getElementsByClassName('line-error')[0].innerHTML = 'Please, provide within 30 characters long.';
        document.getElementsByClassName('line-error')[0].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[1].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[0].style.cssText = 'visibility: hidden;';
        email.style.cssText = 'border-color: red;';

        return false;
    } else {
        document.getElementsByClassName('line-error')[0].style.cssText = 'visibility: hidden;';
        document.getElementsByClassName('cfa')[1].style.cssText = 'visibility: hidden;';
        document.getElementsByClassName('cfa')[0].style.cssText = 'visibility: visible; color: green;';
        email.style.cssText = 'border-color: green;';

        return true;
    }
}

function fgtpassOtp(){
    let otp = document.getElementById('otp');

    if(otp.value.length == 0){
        document.getElementsByClassName('line-error')[0].innerHTML = 'OTP is required.';
        document.getElementsByClassName('line-error')[0].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[2].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[1].style.cssText = 'visibility: hidden;';
        otp.style.cssText = 'border-color: red;';

        return false;
    } else if(isNaN(otp.value) || otp.value.length < 5 || otp.value.length > 5){
        document.getElementsByClassName('line-error')[0].innerHTML = 'Please, enter a valid OTP.';
        document.getElementsByClassName('line-error')[0].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[2].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[1].style.cssText = 'visibility: hidden;';
        otp.style.cssText = 'border-color: red;';

        return false;
    } else{
        document.getElementsByClassName('line-error')[0].style.cssText = 'visibility: hidden;';
        document.getElementsByClassName('cfa')[2].style.cssText = 'visibility: hidden;';
        document.getElementsByClassName('cfa')[1].style.cssText = 'visibility: visible; color: green;';
        otp.style.cssText = 'border-color: green;';

        return true;
    }
}