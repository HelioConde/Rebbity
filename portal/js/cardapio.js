let opcoes = 1;
let itens = 1;
let corpo = document.getElementById("body")
let menuitens= document.getElementById("menuitens")
let menuopcoes= document.getElementById("menuopcoes")
let abriropcoes = document.getElementById("abriropcoes").addEventListener("click", function(){
    
    if (opcoes == 1 && itens==1){
        menuopcoes.style.display = "flex"
        corpo.className= "classnamegrid"
        opcoes = 0
    }else if(opcoes == 1 && itens ==0){
        menuopcoes.style.display = "flex"
        menuitens.style.display ="none"
        corpo.className= "classnamegrid"
        opcoes = 0
        itens = 1
    }else{
        menuopcoes.style.display = "none"
        corpo.className= "classnameflex"
        opcoes = 1
    }
})

let abriritens=document.getElementById("abriritens")
abriritens.addEventListener("click", function(){
    
    if (itens == 1 && opcoes == 1){
        menuitens.style.display = "flex"
        corpo.className= "classnamegrid"
        itens = 0
    }else if(itens == 1 && opcoes == 0){
        menuitens.style.display = "flex"
        menuopcoes.style.display = "none"
        corpo.className= "classnamegrid"
        itens = 0
        opcoes = 1
    }else{
        menuitens.style.display = "none"
        corpo.className= "classnameflex"
        itens = 1
    }
})

    