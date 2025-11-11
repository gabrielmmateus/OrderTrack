
 
 const abertos = document.getElementsByClassName("abertos");
 const aguardando = document.getElementsByClassName("aguardando");
 const fechados = document.getElementsByClassName("fechados");
 
 
 
 
  
    // CHAMADOS ABERTOS
   function pendente() { //nome do botão
 
      for (let i = 0; i < aguardando.length; i++) {
        aguardando[i].classList.add("invisivel");
      }

      for (let i = 0; i < fechados.length; i++) {
        fechados[i].classList.add("invisivel");
      }

      for (let i = 0; i < abertos.length; i++) {
        abertos[i] = abertos[i].classList.remove("invisivel");
      }
        
 

       //estilização do botão
       document.getElementById("lista").style.opacity = "1.0";
       document.getElementById("aguardando").style.opacity = "0.4";
       document.getElementById("concluido").style.opacity = "0.4";
       document.getElementById("contador").innerText = "x" + " Chamados Abertos";
       categoriaAtual = 'abertos';

     
   }
 
   
  

   //CHAMADOS AGUARDANDO
   function andamento() { //nome do botão
 
    for (let i = 0; i < abertos.length; i++) {
      abertos[i].classList.add("invisivel");
    }

    for (let i = 0; i < fechados.length; i++) {
      fechados[i].classList.add("invisivel");
    }

    for (let i = 0; i < aguardando.length; i++) {
       aguardando[i] = aguardando[i].classList.remove("invisivel");
    }

    

      //estilização do botão
      document.getElementById("lista").style.opacity = "0.4";
      document.getElementById("aguardando").style.opacity = "1.0";
      document.getElementById("concluido").style.opacity = "0.4";
      document.getElementById("contador").innerText = "x" + " Chamados Aguardando";
      categoriaAtual = 'aguardando';
    
  }



  //CHAMADOS CONCLUÍDOS
  function finalizado() { //nome do botão

    for (let i = 0; i < abertos.length; i++) {
      abertos[i].classList.add("invisivel");
    }

    for (let i = 0; i < aguardando.length; i++) {
       aguardando[i] = aguardando[i].classList.add("invisivel");
    }

    for (let i = 0; i < fechados.length; i++) {
      fechados[i].classList.remove("invisivel");
    }

    //estilização do botão
    document.getElementById("lista").style.opacity = "0.4";
    document.getElementById("aguardando").style.opacity = "0.4";
    document.getElementById("concluido").style.opacity = "1.0";
    document.getElementById("contador").innerText = "x" + " Chamados Concluídos";
    categoriaAtual = 'fechados';
  }








