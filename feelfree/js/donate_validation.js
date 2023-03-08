function donateAmount(){
    let amount = document.getElementById('amount');

    if(amount.value.length == 0){
        document.getElementsByClassName('line-error')[0].innerHTML = 'Amount is required.';
        document.getElementsByClassName('line-error')[0].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[1].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[0].style.cssText = 'visibility: hidden;';
        amount.style.cssText = 'border-color: red;';

        return false;
    } else if(isNaN(amount.value)){
        document.getElementsByClassName('line-error')[0].innerHTML = 'Please, enter a valid amount.';
        document.getElementsByClassName('line-error')[0].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[1].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[0].style.cssText = 'visibility: hidden;';
        amount.style.cssText = 'border-color: red;';

        return false;
    } else if(amount.value < 1){
        document.getElementsByClassName('line-error')[0].innerHTML = 'Please, donate minimum 1BDT.';
        document.getElementsByClassName('line-error')[0].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[1].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[0].style.cssText = 'visibility: hidden;';
        amount.style.cssText = 'border-color: red;';

        return false;
    } else{
        document.getElementsByClassName('line-error')[0].style.cssText = 'visibility: hidden;';
        document.getElementsByClassName('cfa')[1].style.cssText = 'visibility: hidden;';
        document.getElementsByClassName('cfa')[0].style.cssText = 'visibility: visible; color: green;';
        amount.style.cssText = 'border-color: green;';

        return true;
    }
}