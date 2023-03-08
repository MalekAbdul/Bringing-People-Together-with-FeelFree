function settingsPass(){
    let password = document.getElementById('password');

    if(password.value.length == 0){
        document.getElementsByClassName('line-error')[0].innerHTML = 'Password is required.';
        document.getElementsByClassName('line-error')[0].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[1].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[0].style.cssText = 'visibility: hidden;';
        password.style.cssText = 'border-color: red;';

        return false;
    } else if(password.value.length > 0 && password.value.length < 8){
        document.getElementsByClassName('line-error')[0].innerHTML = 'Please, provide minimum 8 characters long.';
        document.getElementsByClassName('line-error')[0].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[1].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[0].style.cssText = 'visibility: hidden;';
        password.style.cssText = 'border-color: red;';

        return false;
    } else if(password.value.length > 20){
        document.getElementsByClassName('line-error')[0].innerHTML = 'Please, provide maximum 20 characters long.';
        document.getElementsByClassName('line-error')[0].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[1].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[0].style.cssText = 'visibility: hidden;';
        password.style.cssText = 'border-color: red;';

        return false;
    } else{
        document.getElementsByClassName('line-error')[0].style.cssText = 'visibility: hidden;';
        document.getElementsByClassName('cfa')[1].style.cssText = 'visibility: hidden;';
        document.getElementsByClassName('cfa')[0].style.cssText = 'visibility: visible; color: green;';
        password.style.cssText = 'border-color: green;';

        return true;
    }
}