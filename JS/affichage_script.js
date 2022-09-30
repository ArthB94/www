const table = document.querySelector('.central');

//créer une boite pour chacune des recettes de notre JSON
for (let i = 0; i < Lrecettes.length; i++) {
    create_box(i);
}
//créer une boite pour un index de recette entré en paramètre 
function create_box(index) {
    //création d'un nouvel element de class box
    const newelement = document.createElement('div');
    newelement.classList.add("box");
    //affiche le nom de la recette en haut de notre nouvelle box
    const nomrecette = document.createElement('h1');
    nomrecette.textContent = Lrecettes[index].nom
        //affiche la description de notre recette 
    const description = document.createElement('p');
    description.textContent = Lrecettes[index].description;
    //créer le premier élément de notre liste d'ingrédient de type strong ()
    const test = document.createElement('strong');
    test.textContent = "ingrédients:"
        //réation de la liste d'ingrédients
    const ingredients = document.createElement('ul');
    ingredients.classList.add("liste_ingredients");
    //ajoute le titre de notre liste comme premier élément de la liste
    ingredients.append(test);
    //ajoute les différents ingrédients de la liste selon les ingrédents des recettes de notre JSON
    for (let i = 0; i < Lrecettes[index].ingrédients.length; i++) {
        const ingredient = document.createElement('li');
        ingredient.textContent = Lrecettes[index].ingrédients[i]
        ingredients.append(ingredient);
    }
    //Ajout de l'image associé à notre recette
    const image = document.createElement('img')
    image.src = "../Images/" + Lrecettes[index].nom + ".jpg"
    image.style.height = '300px';
    console.log(image.src);

    newelement.appendChild(nomrecette);
    newelement.appendChild(image);
    newelement.appendChild(description);
    newelement.appendChild(ingredients);

    table.appendChild(newelement);
}