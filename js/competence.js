var i = 0;

document.querySelector('#link_add_competence').addEventListener('click',function(e){
    e.preventDefault();
    i++;
    console.log('add competence');
    var CompetenceEle = document.createElement('div');
    var competenceInputEle = document.createElement('input');
    var competenceButtonEle = document.createElement('button');

    competenceButtonEle.addEventListener('click',function(ev){
        ev.preventDefault();
        console.log(competenceButtonEle.innerHTML);
        console.log(this);
        competenceButtonEle.parentElement.remove();
    });

    competenceButtonEle.innerHTML = 'Supprimez';
    competenceInputEle.classList.add('competence_' + i);
    competenceInputEle.setAttribute('name','competence_' + i);
    competenceInputEle.setAttribute('id','competence_' + i);
    CompetenceEle.classList.add('competence');

    CompetenceEle.appendChild(competenceInputEle);
    CompetenceEle.appendChild(competenceButtonEle);
    document.querySelector('.competences').appendChild(CompetenceEle);
});
