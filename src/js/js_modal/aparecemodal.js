// Definindo a variável 'modal' no escopo global
console.log("✅ aparecemodal.js carregado com sucesso!");
let modal;
let idFuncionarioAtual = null;

document.addEventListener('DOMContentLoaded', (event) => {
    // Atribuindo o elemento à variável 'modal' quando o DOM estiver completamente carregado
    modal = document.getElementById("myModal");

    window.aparecemodal = function(funcionarioId) {
        idFuncionarioAtual = funcionarioId;

        if (modal) {
            if (modal.classList.contains("sumiu")) {
                modal.classList.remove("sumiu");
                modal.classList.add("show");
            } else {
                modal.classList.add("show");
            }

            if (conteudoOriginal) {
                modal.innerHTML = conteudoOriginal;
            }
            // Faz uma solicitação AJAX para buscar os dados do funcionário
            $.ajax({
                url: '../../src/api/controller/getFuncionario.php',
                type: 'GET',
                data: { funcionarioID: funcionarioId },
                success: function(data) {
                    const response = JSON.parse(data);
            
                    if (response.success) {
                        // Limpa a tabela antes de inserir novos dados
                        const tableBody = $('.modal-body tbody');
                        tableBody.empty();

                        if (response.imagemBase64) {
                            const imagemSrc = `data:${response.tipoMime};base64,${response.imagemBase64}`;
                            $('#pessoa').attr('src', imagemSrc);
                        } else {
                            // Defina aqui o caminho para a imagem padrão se a imagem do funcionário não estiver disponível
                            $('#pessoa').attr('src', '../../assets/images/telaPrincipal/funcionario.png');
                        }
            
                        const ordens = response.ordens;
                        
            
                        ordens.forEach(ordem => {
                            
                            if (["PENDENTE", "EM ANDAMENTO", "CONCLUIDO"].includes(ordem.STATUS)) {
                                const statusClass = getStatusClass(ordem.STATUS); 
                                
                                // Criação de novas linhas na tabela para cada ordem
                                const row = $(`
                                    <tr data-chamado-id="${ordem.ID_ORDEM}" class="${statusClass}" onclick="substituirLayout(this.dataset.chamadoId)">
                                        <td>
                                            <p>Título do chamado: ${ordem.SERVICO}</p>
                                            <p>Urgência: <span style="color:${ordem.PRIORIDADE === 'BAIXA' ? '#7dc73b' : (ordem.PRIORIDADE === 'MÉDIA' ? '#ffa632' : (ordem.PRIORIDADE === 'ALTA' ? '#ff5555' : '#008efb'))}
                                            ; font-weight: 700; font-size: 23px;">&nbsp ${ordem.PRIORIDADE}</p>
                                            <div class="nivel"></div>
                                        </td>
                                        <td>
                                            <p>Status: ${ordem.STATUS}</p>
                                            <p>Data: ${new Date(ordem.PRAZO).toLocaleDateString('pt-BR')}</p>
                                        </td>
                                    </tr>
                                `);
                
                                // Adiciona a nova linha à tabela
                                tableBody.append(row);
                            } else {
                                // Se o status for cancelado ele não ira aparecer e sera pulado
                                console.log("Chamado com status cancelado:", ordem.ID_ORDEM, ordem.STATUS);
                            }
                        });
            
                        // Atualiza o nome do funcionário na modal
                        $('#nome').text(response.funcionario);
                        if (!categoriaAtual){
                            pendente();
                        }
                        restaurarCategoria()

                        // // Adicionado: Inicializa os chamados
                        // inicializarChamados();
                    } else {
                        console.error(response.error);
                    }
                }
            });
            
        } else {
            console.error('O elemento modal não foi encontrado');
        }
    }
});

function fecharModal() {
    // Verifica se a modal 'myModal' está aberta e se possui a classe 'show'
    if (modal && modal.classList.contains("show")) {
        // Fecha a modal
        modal.classList.remove("show");
        modal.classList.add("sumiu");

        // Limpa os dados carregados na modal principal (aparecemodal.js)
        $('.modal-body tbody').empty(); // Limpa a tabela de ordens
        if (conteudoOriginal) {
            modal.innerHTML = conteudoOriginal;
        }
        pendente();

        // Resetar a variável 'conteudoOriginal' para o estado inicial
        conteudoOriginal = '';

        // Limpar outros elementos específicos da descrição das ordens (script_descricao.js)
        // Por exemplo, limpar campos de texto, imagens, etc.
        // Adicione aqui a lógica específica para limpar os detalhes das ordens

    } else {
        console.error('O elemento modal não foi encontrado ou não está aberto');
    }
}



function getStatusClass(status) {
    switch (status) {
        case 'PENDENTE':
            return 'abertos';
        case 'EM ANDAMENTO':
            return 'aguardando';
        case 'CONCLUIDO':
            return 'fechados';
        default:
            return ''; 
    }
}

function getStatusColor(status) {
    switch (status) { 
        case 'PENDENTE':
            return '#86cefb';
        case 'EM ANDAMENTO':
            return '#c286fb';
        case 'CONCLUIDO':
            return '#86fba3';
        default:
            return '#000';
    }
}
