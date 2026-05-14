"use strict"
console.log(bdd);

function init_recents(){
    let zone=document.getElementById("liste");
    for(let i=0;i<bdd.length;i++){
        let new_article=document.createElement('article');

        let titre=document.createElement('h3');

        titre.textContent=bdd[bdd.length-1-i][1].nom;
        new_article.append(titre);

        let image=document.createElement('img');
        image.src='images/image'+(bdd.length-1-i)+'.jpg';
        new_article.append(image);

        let texte=document.createElement('p');
        texte.textContent=bdd[bdd.length-1-i][1].commentaire;
        new_article.append(texte);
        
        zone.append(new_article);
    }
    
}

init_recents();