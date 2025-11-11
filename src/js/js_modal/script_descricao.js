let conteudoOriginal = ''; //Reset da modal
let categoriaAtual = ''; // Armazena a categoria atual

function carregarImagem(idChamado) {
  //função para carregar a imagem do chamado
  $.ajax({
      url: '/sistema_os/src/api/controller/getChamado.php',
      type: 'GET',
      data: { chamadoID: idChamado, tipo: 'imagem' },  
      success: function(response) {
          const dadosImagem = JSON.parse(response);
          if (dadosImagem.imagemBase64) {
              const imagem = document.getElementById('foto');
              imagem.src = 'data:' + dadosImagem.tipoMime + ';base64,' + dadosImagem.imagemBase64;
          }
      },
      error: function() {
          console.error('Erro ao carregar a imagem');
      }
  });
}

function restaurarCategoria() {
  //Restaura a categoria a anteriormente selecionada ao voltar na modal
  switch (categoriaAtual) {
      case 'abertos':
          pendente();
          break;
      case 'aguardando':
          andamento();
          break;
      case 'fechados':
          finalizado();
          break;
      default:
          console.error('Categoria desconhecida:', categoriaAtual);
  }
}



function substituirLayout(idChamado) {
    //Função que tras os dados da descrição
    const modal = document.querySelector("#myModal");

    // Se o conteúdo original não foi definido, defina-o agora
    if (!conteudoOriginal) { 
        conteudoOriginal = modal.innerHTML;
    }
    // Fazendo uma requisição AJAX para buscar os detalhes do chamado
    $.ajax({
      url: '/sistema_os/src/api/controller/getChamado.php',
      type: 'GET',
      data: { chamadoID: idChamado },  // Modificado para passar o ID do chamado
      success: function(response) {
        const dados = JSON.parse(response);
        if (!dados.chamado) {
            console.error('Chamado não encontrado');
            return;
        }

        const ordem = dados.chamado; 
      
        // Criando o elemento select para o status
        let selectStatusHtml = `<select style='cursor:pointer;' id="select_status" ${ordem.STATUS === 'CONCLUÍDO' ? 'disabled' : ''}>`;

        // Adicionando a opção atual como a primeira opção
        selectStatusHtml += `<option value="${ordem.STATUS}">${ordem.STATUS}</option>`;

        // Adicionando outras opções com base no status atual
        if (ordem.STATUS === 'PENDENTE') {
            selectStatusHtml += `
                <option value="EM ANDAMENTO">EM ANDAMENTO</option>
                <option value="CONCLUIDO">CONCLUÍDO</option>
            `;
        } else if (ordem.STATUS === 'EM ANDAMENTO') {
            selectStatusHtml += `
                <option value="CONCLUIDO">CONCLUÍDO</option>
            `;
        }

        selectStatusHtml += `</select>`;
  
          // Novo layout desejado (DESCRIÇÃO DO CHAMADO)
          modal.innerHTML = `            
            <link rel="stylesheet" href="/sistema_OS/src/styles/modal/styleDescricao.css">
            
        
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content modal-lg">
                  <div class="header_descricao">
                  <p id="titulo_chamado" style=" font-weight: 700; font-size: 25px; color: white; padding: 10px; ">DESCRIÇÃO</p>
                    <div class="fechar">
                      <button
                        type="button"
                        class="close"
                        onclick="fecharModal()"
                        data-dismiss="modal"
                        aria-label="Close"
                        style="height: 57px; margin-top: -3px;"
                      >
                        <span aria-hidden="true" 
                        style="font-size: 31px;
                        font-weight: 600;
                        opacity: 0.7;" 
                        id="x">x</span>
                      </button>
                    </div>
                  </div>

                  <div class="container">
                  
                  <div class="modal-body modalBody" style="padding-top: 20px;">
                
                    <div>
                      <img src="../../assets/images/modal/voltar.png" id="back" alt="" style="width: 50px; padding: 5px; cursor:pointer;" > 
                      <p style="font-weight: 700; margin-left: 80px; margin-top: -46px; font-size: 25px;" id="titulo_chamado">${ordem.SERVICO}</p>
                    </div>
                    <br>
                    
                    <div class="container">
                      <div class="row div_assunto ">

                        <div style="" class="col descricao_esquerda">
                          <textarea readonly class="textarea_assunto" name="" cols="70" rows="5">${ordem.ITEM}</textarea>
                            <br><br><hr style="border: 1px solid  #999999; margin-bottom: 10px;">

                            
                        </div>
                      
                        <div class="col box-foto" >
                          <img src="../../assets/images/modal/foto_objeto_chamado.png" id="foto" alt="">
                        </div> 
                                
                      </div>
                    </div> 

                    <div class="row infos" style="margin-left: 10px">
                              <p style="font-size: 24px;">Urgência: <span style="color: ${ordem.PRIORIDADE === 'BAIXA' ? '#7dc73b' : (ordem.PRIORIDADE === 'MÉDIA' ? '#ffa632' : (ordem.PRIORIDADE === 'ALTA' ? '#ff5555' : '#008efb'))}
                              ; font-weight: 700; font-size: 20px;"> ${ordem.PRIORIDADE} </p>
                              <p style="font-size: 24px;">Status: <span style="font-size: 24px; margin-left: 10px;">${selectStatusHtml}</span> </p>
                              </div>
                        

                    <div>
                      <hr style="border: 1px solid #999999; width: 98%; ">         
                      
                      <p class="datas" style="font-size: 24px; ">Local: <span style="font-size: 24px; margin-left: 10px; color: #5c7877;">${ordem.LOCALIZACAO}</span> </p>
                      <p class="datas" style="font-size: 24px; ">Data inicial: <span style="font-size: 24px; margin-left: 10px; color: #5c7877;"> ${new Date(ordem.CRIADO).toLocaleDateString('pt-BR')}</span> </p>
                      <p class="datas" style="font-size: 24px; ">Data final: <span style="font-size: 24px; margin-left: 10px; color: #5c7877;"> ${new Date(ordem.PRAZO).toLocaleDateString('pt-BR')}</span> </p>

                    
                    </div>
                    </div>
                </div>
              </div>
              
          `;

          const selectStatus = document.getElementById('select_status');
          selectStatus.addEventListener('change', function() {
              let statusSelecionado = selectStatus.value;
              // Faz uma requisição AJAX para atualizar o status no servidor
              $.ajax({
                  url: '/sistema_OS/src/api/controller/atualizar_status.php',  // Substitua com a URL do seu servidor
                  type: 'POST',
                  data: {
                      chamadoID: idChamado, // Supondo que você tenha o ID do chamado disponível
                      novoStatus: statusSelecionado
                  },
                  error: function(jqXHR, textStatus, errorThrown) {
                      console.error('Erro ao atualizar o status: ', textStatus, errorThrown);
                  }
              });
          });
          carregarImagem(idChamado);
          
          
          // Adicione um evento de clique ao botão "back"
          const back = modal.querySelector("#back");
          back.addEventListener('click', function () {
            modal.innerHTML = conteudoOriginal;
            if (idFuncionarioAtual) {
              window.aparecemodal(idFuncionarioAtual);
              restaurarCategoria();
            } else {
                console.error('ID do funcionário atual não definido');
            }
          });

    
}
});
}