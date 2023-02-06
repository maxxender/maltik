document.querySelector('.file-button-bloc input').addEventListener('change',function(ev){    
    document.querySelector('.file-button-bloc button').innerText = this.files[0].name
})