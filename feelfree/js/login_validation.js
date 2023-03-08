function login(){
    if((loginEmail() && loginPassword()) == 1){
        return true;
    } else{
        return false;
    }
}

function loginEmail(){
    let email = document.getElementById('email');

    if(email.value.length == 0){
        document.getElementsByClassName('line-error')[0].innerHTML = 'Email is required.';
        document.getElementsByClassName('line-error')[0].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[1].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[0].style.cssText = 'visibility: hidden;';
        email.style.cssText = 'border-color: red;';

        return false;
    } else{
        document.getElementsByClassName('line-error')[0].style.cssText = 'visibility: hidden;';
        document.getElementsByClassName('cfa')[1].style.cssText = 'visibility: hidden;';
        document.getElementsByClassName('cfa')[0].style.cssText = 'visibility: visible; color: green;';
        email.style.cssText = 'border-color: green;';

        return true;
    }
}

function loginPassword(){
    let password = document.getElementById('pass');

    if(password.value.length == 0){
        document.getElementsByClassName('line-error')[1].innerHTML = 'Password is required.';
        document.getElementsByClassName('line-error')[1].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[3].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[2].style.cssText = 'visibility: hidden;';
        password.style.cssText = 'border-color: red;';

        return false;
    } else{
        document.getElementsByClassName('line-error')[1].style.cssText = 'visibility: hidden;';
        document.getElementsByClassName('cfa')[3].style.cssText = 'visibility: hidden;';
        document.getElementsByClassName('cfa')[2].style.cssText = 'visibility: visible; color: green;';
        password.style.cssText = 'border-color: green;';

        return true;
    }
}

function cntrlPassword(){
    let password = document.getElementById('pass');
    let showPassword = document.getElementById('show-pass');
    let hidePassword = document.getElementById('hide-pass');

    if(password.type === 'password'){
        password.type = 'text';
        showPassword.style.display = 'none';
        hidePassword.style.display = 'inline';
    } else{
        password.type = 'password';
        showPassword.style.display = 'inline';
        hidePassword.style.display = 'none';
    }
}