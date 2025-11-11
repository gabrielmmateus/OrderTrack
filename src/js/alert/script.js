
      notificacao = document.querySelector(".notificacao")
      closeIcon = document.querySelector(".close"),
      tempo = document.querySelector(".tempo");
      let timer1, timer2;
      button.addEventListener("click", () => {
        notificacao.classList.add("active");
        tempo.classList.add("active");
        timer1 = setTimeout(() => {
            notificacao.classList.remove("active");
        }, 5000); //1s = 1000 milliseconds
        timer2 = setTimeout(() => {
          tempo.classList.remove("active");
        }, 5300);
      });
      
      closeIcon.addEventListener("click", () => {
        notificacao.classList.remove("active");
        
        setTimeout(() => {
          tempo.classList.remove("active");
        }, 300);
        clearTimeout(timer1);
        clearTimeout(timer2);
      });