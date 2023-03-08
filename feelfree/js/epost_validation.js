function epost(){
    if((epostTitle() && epostDescription() && epostAmount() && epostFile()) == 1){
        return true;
    } else{
        return false;
    }
}

function epostTitle(){
    let title = document.getElementById('title');

    if(title.value.length == 0){
        document.getElementsByClassName('line-error')[0].innerHTML = 'Title is required.';
        document.getElementsByClassName('line-error')[0].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[1].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[0].style.cssText = 'visibility: hidden;';
        title.style.cssText = 'border-color: red;';

        return false;
    } else if(title.value.length <= 3 || title.value.length > 50){
        document.getElementsByClassName('line-error')[0].innerHTML = 'Please, provide between 4-50 characters long.';
        document.getElementsByClassName('line-error')[0].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[1].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[0].style.cssText = 'visibility: hidden;';
        title.style.cssText = 'border-color: red;';

        return false;
    } else{
        document.getElementsByClassName('line-error')[0].style.cssText = 'visibility: hidden;';
        document.getElementsByClassName('cfa')[1].style.cssText = 'visibility: hidden;';
        document.getElementsByClassName('cfa')[0].style.cssText = 'visibility: visible; color: green;';
        title.style.cssText = 'border-color: green;';

        return true;
    }
}

function epostDescription(){
    let description = document.getElementById('description');

    if(description.value.length == 0){
        document.getElementsByClassName('line-error')[1].innerHTML = 'Description is required.';
        document.getElementsByClassName('line-error')[1].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[3].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[2].style.cssText = 'visibility: hidden;';
        description.style.cssText = 'border-color: red;';

        return false;
    } else if(description.value.length <= 50 || description.value.length > 1000){
        document.getElementsByClassName('line-error')[1].innerHTML = 'Please, provide between 51-1000 characters long.';
        document.getElementsByClassName('line-error')[1].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[3].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[2].style.cssText = 'visibility: hidden;';
        description.style.cssText = 'border-color: red;';

        return false;
    } else{
        document.getElementsByClassName('line-error')[1].style.cssText = 'visibility: hidden;';
        document.getElementsByClassName('cfa')[3].style.cssText = 'visibility: hidden;';
        document.getElementsByClassName('cfa')[2].style.cssText = 'visibility: visible; color: green;';
        description.style.cssText = 'border-color: green;';

        return true;
    }
}

function epostAmount(){
    let amount = document.getElementById('amount');

    if(amount.value.length == 0){
        document.getElementsByClassName('line-error')[2].innerHTML = 'Amount is required.';
        document.getElementsByClassName('line-error')[2].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[5].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[4].style.cssText = 'visibility: hidden;';
        amount.style.cssText = 'border-color: red;';

        return false;
    } else if(isNaN(amount.value)){
        document.getElementsByClassName('line-error')[2].innerHTML = 'Please, enter a valid amount.';
        document.getElementsByClassName('line-error')[2].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[5].style.cssText = 'visibility: visible; color: red;';
        document.getElementsByClassName('cfa')[4].style.cssText = 'visibility: hidden;';
        amount.style.cssText = 'border-color: red;';

        return false;
    } else{
        document.getElementsByClassName('line-error')[2].style.cssText = 'visibility: hidden;';
        document.getElementsByClassName('cfa')[5].style.cssText = 'visibility: hidden;';
        document.getElementsByClassName('cfa')[4].style.cssText = 'visibility: visible; color: green;';
        amount.style.cssText = 'border-color: green;';

        return true;
    }
}

function epostFile(){
    let file = document.getElementById('file');
    let allowExt = /(\.jpg|\.jpeg)$/i;

    if(file.files[0]){
        if(!allowExt.exec(file.value)){
            document.getElementsByClassName('line-error')[3].innerHTML = 'Please, upload jpg, jpeg format.';
            document.getElementsByClassName('line-error')[3].style.cssText = 'visibility: visible; color: red;';
            document.getElementsByClassName('cfa')[7].style.cssText = 'visibility: visible; color: red;';
            document.getElementsByClassName('cfa')[6].style.cssText = 'visibility: hidden;';
            file.style.cssText = 'border-color: red;';

            return false;
        } else if(file.files[0].size > 3072000){
            document.getElementsByClassName('line-error')[3].innerHTML = 'Please, upload within 3MB.';
            document.getElementsByClassName('line-error')[3].style.cssText = 'visibility: visible; color: red;';
            document.getElementsByClassName('cfa')[7].style.cssText = 'visibility: visible; color: red;';
            document.getElementsByClassName('cfa')[6].style.cssText = 'visibility: hidden;';
            file.style.cssText = 'border-color: red;';

            return false;
        } else{
            document.getElementsByClassName('line-error')[3].style.cssText = 'visibility: hidden;';
            document.getElementsByClassName('cfa')[7].style.cssText = 'visibility: hidden;';
            document.getElementsByClassName('cfa')[6].style.cssText = 'visibility: visible; color: green;';
            file.style.cssText = 'border-color: green;';

            return true;
        }
    } else{
        return true;
    }
}