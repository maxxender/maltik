function validatePass(elePass){
    if(elePass.value.length < 4){
        return false;
    }
    return true;
}

function ajaxPost(adresse, form){
    var xhr = new XMLHttpRequest();
    var formdata = new FormData(form);
    xhr.onreadystatechange = function(e){
        if(xhr.readyState === 4){
            if(xhr.status === 200){
                return JSON.parse(xhr.responseText);
            }
        }
    }
    xhr.open('POST', adresse, true);
    xhr.send(formdata);
}

(function(){
    var formPass = document.querySelector('#formSetPassword');
    var eleRecentPass = document.querySelector('#recentPass');
    var eleNewPass = document.querySelector('#newPass');
    var eleSubmitForm = formPass.querySelector('button');
    var errorsRecentPass = [];
    const errorsNewPass = [];

  

    formPass.addEventListener('submit',function(e){
        e.preventDefault();
            console.log("submit clique")
            var formdata = new FormData(formPass);
            var xhr = new XMLHttpRequest();
    
            xhr.onreadystatechange = function(e){
                if(xhr.readyState === 4){
                    if(xhr.status === 200){
                        console.log(JSON.parse(xhr.responseText));
                    }else{
                        console.log(JSON.parse(xhr.responseText));
                    }
                }
            }
    
            xhr.open('POST', formPass.getAttribute('action'), true);
            xhr.setRequestHeader('X-Requested-With', 'xmlhttprequest');
            xhr.send(formdata);

    });
})();