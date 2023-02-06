var panLinks = document.querySelectorAll('.panneau a');
var allContentPan = document.querySelectorAll('.contenu-panneau');

var removeActiveContents = function(elements){
    elements.forEach(element=>{
        element.style.display = 'none';
    });
}

var showContentPane = function(panLinks, contentsPan){
    panLinks.forEach(panLink => {
        panLink.addEventListener('click',function(ev){
            //ev.preventDefault();
            var activeIdContent = panLink.getAttribute('href')
            var activeContentDashboard = document.querySelector(activeIdContent);
            if(activeContentDashboard !== null){
                removeActiveContents(allContentPan)
                activeContentDashboard.style.display = 'inline-block'
            }
        });
    })
}

showContentPane(panLinks, allContentPan);
