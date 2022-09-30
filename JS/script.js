var newCommandForm = document.forms.newIng;


function modifier_recette(ID_recette) {
    console.log(ID_recette);
    window.open("../Modifier_recette");

}


function ajouterIng() {

    var table = document.querySelector('#datatableI tbody')

    let run = 1
        //ne peut prendre qu'une seule foi le mm ingrédient
    if (table.rows[0] != undefined) {
        Array.prototype.forEach.call(table.rows, function(i) {

            if (i.cells[0].firstChild.value == document.getElementById("Ingr").value) {
                run = 0
            }
        });
    }

    if (run == 1) {
        //création des variable pour la création d'une nouvelle ligne dans le tableau
        var newItem = document.createElement('tr')

        var Ingr = document.createElement('td')
        var qtt = document.createElement('td')
        var unité = document.createElement('td')


        var inputIngr = document.createElement('input')
        var inputqtt = document.createElement('input')
        var inputunité = document.createElement('input')



        inputIngr.type = "text"
        inputqtt.type = "text"
        inputunité.type = "text"




        if (table.lastElementChild) {
            inputIngr.name = (parseFloat(table.lastElementChild.children[0].lastElementChild.name) + 1) + "inputIngr"
            inputqtt.name = (parseFloat(table.lastElementChild.children[1].lastElementChild.name) + 1) + "inputqtt"
            inputunité.name = (parseFloat(table.lastElementChild.children[2].lastElementChild.name) + 1) + "inputunité"
        } else {
            inputIngr.name = "1inputIngr"
            inputqtt.name = "1inputqtt"
            inputunité.name = "1inputunité"
        }


        inputIngr.setAttribute("readonly", true)
        inputqtt.setAttribute("readonly", true)
        inputunité.setAttribute("readonly", true)




        inputIngr.value = document.getElementById("Ingr").value
        inputqtt.value = document.getElementById("qttI").value
        inputunité.value = document.getElementById("unité").value


        //-----------bouton de suppression ingr----------------------

        var supr = document.createElement('td')
        var btnsupr = document.createElement('button')
        btnsupr.type = "button"
        btnsupr.textContent = "supprimer"
        btnsupr.onclick = function() {
            suprIng(this)
        }
        supr.append(btnsupr)
            // -------------fin bouton------------------------------------------

        Ingr.append(inputIngr)
        qtt.append(inputqtt)
        unité.append(inputunité)

        if (!document.getElementById("Ingr").checkValidity() ||
            !document.getElementById("qttI").checkValidity() ||
            !document.getElementById("unité").checkValidity()
        ) {
            return
        }

        newItem.append(Ingr, qtt, unité, supr)

        table.appendChild(newItem);
    }
}


function suprIng(el) {
    var cpt = 1;
    var table = el.parentNode.parentNode.parentNode
    console.log(table)
    el.parentNode.parentNode.parentNode.removeChild(el.parentNode.parentNode);

    Array.prototype.forEach.call(table.rows, function(i) {
        i.cells[0].firstChild.name = cpt + "inputIngr";
        i.cells[1].firstChild.name = cpt + "inputqtt";
        i.cells[2].firstChild.name = cpt + "inputunité";
        cpt += 1;
    })
}

function suprUst(el) {
    var cpt = 1;
    var table = el.parentNode.parentNode.parentNode
    console.log(table)
    el.parentNode.parentNode.parentNode.removeChild(el.parentNode.parentNode);

    Array.prototype.forEach.call(table.rows, function(i) {
        i.cells[0].firstChild.name = cpt + "inputUst";
        i.cells[1].firstChild.name = cpt + "inputUqtt";
        cpt += 1;
    })
}


//supprimer toutes les lignes du tableau
function supprimerIngs() {
    var tbody = document.querySelector('#datatableI tbody')
    while (tbody.firstChild) {
        tbody.removeChild(tbody.firstChild)
    }

}



//----------------------------------------------Fonctions Ustenciles------------------------------------------------------------------------------------------------------------------------------------------------
var newCommandFormUst = document.forms.newUst;

function ajouterUst() {

    const table = document.querySelector('#datatableU tbody')

    let run = 1
        //ne peut prendre qu'une seule foi le mm ingrédient
    console.log(table)
    if (table.rows[0] != undefined) {

        Array.prototype.forEach.call(table.rows, function(i) {

            if (i.cells[0].firstChild.value == document.getElementById("Ust").value) {
                run = 0
            }
        });
    }


    if (run == 1) {
        //création des variable pour la création d'une nouvelle ligne dans le tableau
        const newItemU = document.createElement('tr')

        const Ust = document.createElement('td')
        const qttU = document.createElement('td')

        const inputUst = document.createElement('input')
        const inputUqtt = document.createElement('input')


        inputUst.type = "text"
        inputUqtt.type = "text"


        if (table.lastElementChild) {
            inputUst.name = (parseFloat(table.lastElementChild.children[0].lastElementChild.name) + 1) + "inputUst"
            inputUqtt.name = (parseFloat(table.lastElementChild.children[1].lastElementChild.name) + 1) + "inputUqtt"

        } else {
            inputUst.name = "1inputUst"
            inputUqtt.name = "1inputUqtt"

        }


        inputUst.setAttribute("readonly", true)
        inputUqtt.setAttribute("readonly", true)

        inputUst.value = document.getElementById("Ust").value
        inputUqtt.value = document.getElementById("qttU").value


        Ust.append(inputUst)
        qttU.append(inputUqtt)

        //Vérification de la récupération
        console.log(Ust.textContent)
        console.log(qttU.textContent)


        if (!document.getElementById("Ust").checkValidity() ||
            !document.getElementById("qttU").checkValidity()
        ) {
            return
        }


        //bouton de suppression

        //-----------bouton de suppression ingr----------------------

        var supr = document.createElement('td')
        var btnsupr = document.createElement('button')
        btnsupr.type = "button"
        btnsupr.textContent = "supprimer"
        btnsupr.onclick = function() { suprUst(this) }
        supr.append(btnsupr)
            // -------------fin bouton------------------------------------------

        //const table = document.querySelector('table')
        newItemU.append(Ust, qttU, supr)


        table.appendChild(newItemU);
    }


}

//supprimer toutes les lignes du tableau Ustensile
function supprimerUst() {
    const tbody = document.querySelector('#datatableU tbody')
    while (tbody.firstChild) {
        tbody.removeChild(tbody.firstChild)
    }

}
//----------------------------------------------Fonctions Ustenciles------------------------------------------------------------------------------------------------------------------------------------------------


//--------------------------------------------Listes déroulantes-------------------------------------------------------------------------
var liste_IType = JSON.parse(Type_ing)
var liste_UType = JSON.parse(Type_ust)
remplir_déroul("Itype", liste_IType)
remplir_déroul("Utype", liste_UType)
remplir_déroul("unité", listeUnité("Unites_liquides"))
if (document.getElementById("Itype")) {
    console.log(document.getElementById("Itype").firstChild.textContent)
    remplir_déroul("unité", listeUnité(document.getElementById("Itype").textContent))

}


//prend en entré un type d'ingrédient et retourne la liste des unitées possibles correspondante

function listeUnité(type) {
    if (type == "Liquide" || type == "Alcool") {
        var liste = JSON.parse(Unites_liquides)
    } else if (type == "Fruit" || type == "Legume" || type == "Fruit de mer" || type == "Fruit") {
        var liste = JSON.parse(Unites_solides)

    } else {
        var liste = JSON.parse(Unites_liquides).concat(JSON.parse(Unites_solides))

    }
    return liste
}




//prend en entrée le 'id' d'un <select> et une liste et remplie le select avec les éléments de la liste
function remplir_déroul(nom_deroul, liste) {
    const derouliste = document.getElementById(nom_deroul);
    if (derouliste) {
        while (derouliste.lastChild) {
            if (derouliste.lastChild.textContent != "Tous") {
                derouliste.removeChild(derouliste.lastChild)
            } else { break }

        }

        console.log(typeof(liste));
        liste.forEach(function(el) {
            const option = document.createElement('option');
            option.textContent = el;
            derouliste.add(option);
        })
    }
}


//prend en entrée une liste d'ingrédient ou d'ustencile et un Type et retourne tous les elements de la liste qui sont de ce type sous forme de liste
function Liste_Type(SELECT, Type) {
    var liste = Array()
    console.log(liste)
    i = 0
    SELECT.forEach(function(el) {
        if (el.Type == Type || Type == 'Tous') {
            liste[i] = el
            i++
        }
    })
    return liste
}


//prend en entré une lise d'igrédient ou d'ustenciles et la caractéristique a rechercher('Nom','Utype','Itype','Id') et renvoi la liste de cette charactéristique pour tous les éléments de la liste d'entrée.
function Liste_arg(Liste, arg) {
    var returnliste = []
    if (arg == 'Nom') {
        Liste.forEach(function(el) {
            returnliste.push(el.Nom)
        })
    }
    if (arg == 'Utype') {
        Liste.forEach(function(el) {
            returnliste.push(el.Utype)
        })
    }
    if (arg == 'Itype') {
        Liste.forEach(function(el) {
            returnliste.push(el.Itype)
        })
    }
    if (arg == 'id') {
        Liste.forEach(function(el) {
            returnliste.push(el.ID_ingredients)
        })
    }
    return returnliste


}