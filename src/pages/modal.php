<?php

function echoModal(){

  echo('
    
    <link rel="stylesheet" href="../styles/modal/styleModal.css">
    <script src="../js/js_modal/script_descricao.js"></script>

    

      <!-- Modal -->
        <div
          class="modal fade"
          id="myModal"
          tabindex="-1"
          role="dialog"
          aria-labelledby="exampleModalLabel"
          aria-hidden="true"
        >
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-lg">
              <div class="header_modal">
                <p id="Titulo">CHAMADOS</p>
                <div class="fechar">
                  <button
                    type="button"
                    class="close"
                    onclick="fecharModal()"
                    data-dismiss="modal"
                    aria-label="Close"
                    
                  >
                    <span aria-hidden="true" id="x">x</span>
                  </button>
                </div>
              </div>
  
              <div class="perfil">
                <div>
                  <img id="pessoa" style="padding-bottom: 7px;" src="../../assets/images/modal/pessoa.png" alt="" /><span id="nome"
                    >NOME</span
                  >
                </div>
              </div>
  
              <div class="modal-body modalBody">
                <table class="table table-bordered responsive-table">
                  <thead>
                    <tr>
                      <th id="contador"                
                        
                        colspan="3"
                        style="text-align: center; background-color: #8cb2b0; font-size:25px;"
                      >
                         Chamados Abertos
                      </th>
                    </tr> 
                    <tr>
                      <th
                        colspan="3"
                        scope="col" 
                        style="background-color: #dde6db"
                      >
                        <div id="categoria" scope="col" style="justify-content: space-evenly; display: flex">
                          <img
                            id="lista"
                            src="../../assets/images/modal/fechado.png"
                            onclick="pendente()" 
                            alt="" style="cursor:pointer;"
                          >
                          <img
                            id="aguardando"
                            src="../../assets/images/modal/aguardando.png"
                            onclick="andamento()"
                            alt="" style="cursor:pointer;"
                          >
                          <img
                            id="concluido"
                            src="../../assets/images/modal/concluido.png"
                            onclick="finalizado()"
                            alt="" style="cursor:pointer;"
                          >
                        </div>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
  
                    <!-- chamados abertos -->
                    <!-- linha 1 -->
                    <tr id="listaPadrao" class="abertos" id="abertos1" onclick="substituirLayout()">
                      <td>
                        <p>Título do chamado:  <span id="titulo_chamado">aaaa</span></p> 
                        <p id="urgencia">Urgência </p>
                        <div class="nivel" style="background-color: #86cefb;"></div>
  
                         <!-- segunda coluna -->
                        <td id="seg_col">
                          <p id="status">Status:</p>
                          <p>Data:</p>
                        </td>
                      </td>
                    </tr>
  
                    <!-- linha 2 -->
                    <tr id="listaPadrao" class="abertos" colspan="3">
                      <td>
                        <p>Título do chamado:</p>
                        <p id="urgencia">Urgência</p>
                        <div class="nivel" style="background-color: #86cefb;"></div>
  
                         <!-- segunda coluna -->
                        <td id="seg_col">
                          <p id="status">Status:</p>
                          <p>Data:</p>
                        </td>
                      </td>
                    </tr>
  
                    <!-- linha 3 -->
                    <tr id="listaPadrao" class="abertos" colspan="3">
                      <td>
                        <p>Título do chamado:</p>
                        <p id="urgencia">Urgência</p>
                        <div class="nivel" style="background-color: #86cefb;"></div>
  
                        <!-- segunda coluna -->
                        <td id="seg_col">
                          <p id="status">Status:</p>
                          <p>Data:</p>
                        </td>
                      </td>
                    </tr>
  
                    <!-- linha 4 -->
                    <tr id="listaPadrao" class="abertos" colspan="3">
                      <td>
                        <p>Título do chamado:</p>
                        <p id="urgencia">Urgência</p>
                        <div class="nivel" style="background-color: #86cefb;"></div>
  
                        <!-- segunda coluna -->
                        <td id="seg_col">
                          <p id="status">Status:</p>
                          <p>Data:</p>
                        </td>
                      </td>
                    </tr>
  
                    <!-- linha 4 -->
                    <tr id="listaPadrao" class="abertos" colspan="3">
                      <td>
                        <p>Título do chamado:</p>
                        <p id="urgencia">Urgência</p>
                        <div class="nivel" style="background-color: #86cefb;"></div>
  
                        <!-- segunda coluna -->
                        <td id="seg_col">
                          <p id="status">Status:</p>
                          <p>Data:</p> 
                        </td>
                      </td>
                    </tr>
  
                    <!-- linha 5 -->
                    <tr id="listaPadrao" class="abertos" colspan="3">
                      <td>
                        <p>Título do chamado:</p>
                        <p id="urgencia">Urgência</p>
                        <div class="nivel" style="background-color: #86cefb;"></div>
  
                        <!-- segunda coluna -->
                        <td id="seg_col">
                          <p id="status">Status:</p>
                          <p>Data:</p>
                        </td>
                      </td>
                    </tr>
  
                    <!-- linha 6 -->
                    <tr id="listaPadrao" class="abertos" colspan="3">
                      <td>
                        <p>Título do chamado:</p>
                        <p id="urgencia">Urgência</p>
                        <div class="nivel" style="background-color: #86cefb;"></div>
  
                        <!-- segunda coluna -->
                        <td id="seg_col">
                          <p id="status">Status:</p>
                          <p>Data:</p>
                        </td>
                      </td>
                    </tr>
  
                    <!-- chamados aguardando -->
                    <!-- linha 1 -->
                    <tr id="aguardandoLista" class="aguardando invisivel">
                      <td>
                        <p>Título do chamado:</p>
                        <p id="urgencia">Urgência</p>
                        <div class="nivel" style="background-color: #c286fb;"></div>
                        
                         <!-- segunda coluna -->
                        <td id="seg_col">
                          <p id="status">Status:</p>
                          <p>Data:</p>
                        </td>
                      </td>
                    </tr>
  
                    <!-- linha 2  -->
                    <tr id="aguardandoLista" class="aguardando invisivel" colspan="3">
                      <td>
                        <p>Título do chamado:</p>
                        <p id="urgencia">Urgência</p>
                        <div class="nivel" style="background-color: #c286fb;"></div>
                      
                          <!-- segunda coluna -->
                        <td id="seg_col">
                          <p id="status">Status:</p>
                          <p>Data:</p>
                        </td>
                      </td>
                    </tr>
  
                    <!-- linha 3 -->
                    <tr id="aguardandoLista" class="aguardando invisivel" colspan="3">
                      <td>
                        <p>Título do chamado: </p>
                        <p id="urgencia">Urgência</p>
                        <div class="nivel" style="background-color: #c286fb;"></div>
  
                        <!-- segunda coluna -->
                        <td id="seg_col">
                          <p id="status">Status:</p>
                          <p>Data:</p>
                        </td>
                      </td>
                    </tr>
  
                    <!-- chamados Concluído -->
                    <!-- linha 1 -->
                    <tr id="concluidoLista" class="fechados invisivel">
                      <td>
                        <p>Título do chamado: </p>
                        <p id="urgencia">Urgência</p>
                        <div class="nivel" style="background-color: #86fba3;"></div>
  
                          <!-- segunda coluna -->
                        <td id="seg_col">
                          <p id="status">Status:</p>
                          <p>Data:</p>
                        </td>
                      </td>
                    </tr>
  
                    <!-- linha 2 -->
                    <tr id="concluidoLista" class="fechados invisivel" colspan="3">
                      <td>
                        <p>Título do chamado: </p>
                        <p id="urgencia">Urgência</p>
                        <div class="nivel" style="background-color: #86fba3;"></div>
  
                          <!-- segunda coluna -->
                        <td id="seg_col">
                          <p id="status">Status:</p>
                          <p>Data:</p>
                        </td>
                      </td>
                    </tr>
  
                    <!-- linha 3 -->
                    <tr id="concluidoLista" class="fechados invisivel" colspan="3">
                      <td>
                        <p>Título do chamado:</p>
                        <p id="urgencia">Urgência</p>
                        <div class="nivel" style="background-color: #86fba3;"></div>
  
                        <!-- segunda coluna -->
                        <td id="seg_col">
                          <p id="status">Status:</p>
                          <p>Data:</p>
                        </td>
                      </td>
                    </tr>
  
                    <!-- linha 4 -->
                    <tr id="concluidoLista" class="fechados invisivel" colspan="3">
                      <td>
                        <p>Título do chamado:</p>
                        <p id="urgencia">Urgência</p>
                        <div class="nivel" style="background-color: #86fba3;"></div>
  
                        <!-- segunda coluna -->
                        <td id="seg_col">
                          <p id="status">Status:</p>
                          <p>Data:</p>
                        </td>
                      </td>
                    </tr>
  
                    <!-- linha 5 -->
                    <tr id="concluidoLista" class="fechados invisivel" colspan="3">
                      <td>
                        <p>Título do chamado:</p>
                        <p id="urgencia">Urgência</p>
                        <div class="nivel" style="background-color: #86fba3;"></div>
  
                        <!-- segunda coluna -->
                        <td id="seg_col">
                          <p id="status">Status:</p>
                          <p>Data:</p>
                        </td>
                      </td>
                    </tr>
  
                    <!-- linha 6 -->
                    <tr id="concluidoLista" class="fechados invisivel" colspan="3">
                      <td>
                        <p>Título do chamado:</p>
                        <p id="urgencia">Urgência</p>
                        <div class="nivel" style="background-color: #86fba3;"></div>
  
                        <!-- segunda coluna -->
                        <td id="seg_col">
                          <p id="status">Status:</p>
                          <p>Data:</p>
                        </td>
                      </td>
                    </tr>
  
                    <!-- linha 7 -->
                    <tr id="concluidoLista" class="fechados invisivel" colspan="3">
                      <td>
                        <p>Título do chamado:</p>
                        <p id="urgencia">Urgência</p>
                        <div class="nivel" style="background-color: #86fba3;"></div>
  
                        <!-- segunda coluna -->
                        <td id="seg_col">
                          <p id="status">Status:</p>
                          <p>Data:</p>
                        </td>
                      </td>
                    </tr>
  
                    <!-- linha 8 -->
                    <tr id="concluidoLista" class="fechados invisivel" colspan="3">
                      <td>
                        <p>Título do chamado:</p>
                        <p id="urgencia">Urgência</p>
                        <div class="nivel" style="background-color: #86fba3;"></div>
  
                        <!-- segunda coluna -->
                        <td id="seg_col">
                          <p id="status">Status:</p>
                          <p>Data:</p>
                        </td>
                      </td>
                    </tr>
  
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      

      
      
      <script src="../js/js_modal/script_botao.js"></script>
      
      
      ');
}  
  ?>
