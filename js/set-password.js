(function(){
    var formPass = document.querySelector('#formSetPassword')
    formPass.addEventListener('submit',function(e){
        e.preventDefault();
        var formdata = new FormData(formPass);
        var xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function(e){
            if(xhr.readyState === 4){
                if(xhr.status === 200){
                    console.log(JSON.parse(xhr.responseText));
                }
            }
        }

        xhr.open('POST', formPass.getAttribute('action'), true);
        xhr.setRequestHeader('X-Requested-With', 'xmlhttprequest');
        xhr.send(formdata);

    });
})();