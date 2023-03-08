function ppUpdate(){
    let file = document.getElementById('file');
    if(file.files[0]){
        document.getElementById('update').style.cssText = 'display: inline;';
    }
}

function profileFile(){
    let file = document.getElementById('file');
    let userImg = document.getElementById('user-img');
    let allowExt = /(\.jpg|\.jpeg)$/i;

    if(!allowExt.exec(file.value)){
        document.getElementsByClassName('line-error')[0].innerHTML = 'Please, upload jpg, jpeg format.';
        document.getElementsByClassName('line-error')[0].style.cssText = 'display: block; color: red;';
        userImg.style.cssText = 'border-color: red;';

        return false;
    } else if(file.files[0].size > 3072000){
        document.getElementsByClassName('line-error')[0].innerHTML = 'Please, upload within 3MB.';
        document.getElementsByClassName('line-error')[0].style.cssText = 'display: block; color: red;';
        userImg.style.cssText = 'border-color: red;';

        return false;
    } else{
        document.getElementsByClassName('line-error')[0].style.cssText = 'display: none;';
        userImg.style.cssText = 'border-color: green;';

        return true;
    }
}