// Variáveis para armazenar os gráficos
var graficoSemanal = null;
var graficoMensal = null;
var graficoDiario = null;
var graficoAnual = null;

// Certifique-se de que o documento está pronto antes de executar o código JavaScript
$(document).ready(function() {
    // Verifique se os IDs dos elementos <canvas> correspondem aos IDs usados nas funções JavaScript
    var graficoSemanalCanvas = document.getElementById('graficoSemanal');
    var graficoMensalCanvas = document.getElementById('graficoMensal');
    var graficoDiarioCanvas = document.getElementById('graficoDiario');
    var graficoAnualCanvas = document.getElementById('graficoAnual');

    if (!graficoSemanalCanvas || !graficoMensalCanvas || !graficoDiarioCanvas || !graficoAnualCanvas) {
        console.error('Um ou mais elementos <canvas> não foram encontrados.');
        return;
    }

    
});

function alertPersonalizado(){

    let issetNotificacao = document.querySelector('.notificacao');
    if (issetNotificacao) {
        issetNotificacao.remove();
    } 
    
    let divNotificacao = document.querySelector('.div-notificacao')
    
    let notificacao = document.createElement('div');
    notificacao.className = 'notificacao';
    
    notificacao.style.borderLeft = '6px solid red';

    let codigo = `
                                    <div class="notificacao-div">
                                        <i class="bi bi-x-circle-fill" style="color: red;"></i>
                                        <div class="mensagem">
                                            <span class="text text-1" style="color: red;">Não há chamados nessa Semana.</span>
                                        </div>
                                    </div>
                                    <i class="bi bi-x close" style="color: red;"></i>
                                    <div class="tempo tempo_error" style="background-color: #ddd;"></div>
                                </div>
    `;

  

    notificacao.innerHTML = codigo

    divNotificacao.appendChild(notificacao);

    timeAlert();
    

};

// Função para criar ou atualizar o gráfico de relatório semanal
function criarOuAtualizarGraficoSemanal(dados) {
    const todosZeros = dados.every(valor => valor === '0');

    if (todosZeros) {
        alertPersonalizado();
  
    }

   

    
    var canvas = document.getElementById('graficoSemanal');
    var mensagemSemDados = document.getElementById('mensagemSemDados');



    if (graficoSemanal) {
        graficoSemanal.destroy();
    }

    var canvas = document.getElementById('graficoSemanal');
    if (!canvas) {
        console.error('Elemento de gráfico semanal não encontrado.');
        return;
    }

    var ctx = canvas.getContext('2d');
    if (!ctx) {
        console.error('Contexto de gráfico semanal não encontrado.');
        return;
    }

    graficoSemanal = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Total de Ordens', 'Pendentes', 'Em Andamento', 'Concluídas', 'Canceladas'],
            datasets: [
                {
                    label: 'Total de Ordens',
                    data: dados,
                    backgroundColor: [
                        'rgba(0, 0, 255, 0.5)',  // Azul para "Total de Ordens"
                        'rgba(255, 0, 0, 0.2)',  // Vermelho para "Pendentes"
                        'rgba(255, 206, 86, 0.2)',  // Amarelo para "Em Andamento"
                        'rgba(0, 128, 0, 0.2)',  // Verde para "Concluídas"
                        'rgba(128, 128, 128, 0.2)',  // Cinza para "Canceladas"
                    ],
                    borderColor: [
                        'rgba(0, 0, 255, 1)',  // Azul para "Total de Ordens"
                        'rgba(255, 0, 0, 1)',  // Vermelho para "Pendentes"
                        'rgba(255, 206, 86, 1)',  // Amarelo para "Em Andamento"
                        'rgba(0, 128, 0, 1)',  // Verde para "Concluídas"
                        'rgba(128, 128, 128, 1)',  // Cinza para "Canceladas"
                    ],
                    borderWidth: 1
                    
                },
                {
                    label: 'Pendentes',
               
                    backgroundColor: 'rgba(255, 0, 0, 0.2)',  // Vermelho para "Pendentes"
                    borderColor: 'rgba(255, 0, 0, 1)',  // Vermelho para "Pendentes"
                    borderWidth: 1
                },
                {
                    label: 'Em Andamento',
                    
                    backgroundColor: 'rgba(255, 206, 86, 0.2)',  // Amarelo para "Em Andamento"
                    borderColor: 'rgba(255, 206, 86, 1)',  // Amarelo para "Em Andamento"
                    borderWidth: 1
                },
                {
                    label: 'Concluídas',
                  
                    backgroundColor: 'rgba(0, 128, 0, 0.2)',  // Verde para "Concluídas"
                    borderColor: 'rgba(0, 128, 0, 1)',  // Verde para "Concluídas"
                    borderWidth: 1
                },
                {
                    label: 'Canceladas',
                   
                    backgroundColor: 'rgba(128, 128, 128, 0.2)',  // Cinza para "Canceladas"
                    borderColor: 'rgba(128, 128, 128, 1)',  // Cinza para "Canceladas"
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    stacked: true
                },
                y: {
                    beginAtZero: true,
                    stepSize: 1  // Define o intervalo de incremento para 1
                }
            },
            plugins: {
                legend: {
                    labels: {
                        // Aqui você pode definir o tamanho da fonte do rótulo
                        font: {
                            size: 18, // Tamanho da fonte desejado
                            

                        },
                        
                    }
                }
            }
        }
    });
    window.scrollBy(0, 200);
}

function alertPersonalizado2(){

    let issetNotificacao = document.querySelector('.notificacao');
    if (issetNotificacao) {
        issetNotificacao.remove();
    } 
    
    let divNotificacao = document.querySelector('.div-notificacao')
    
    let notificacao = document.createElement('div');
    notificacao.className = 'notificacao';
    
    notificacao.style.borderLeft = '6px solid red';

    let codigo = `
                                    <div class="notificacao-div">
                                        <i class="bi bi-x-circle-fill" style="color: red;"></i>
                                        <div class="mensagem">
                                            <span class="text text-1" style="color: red;">Não há chamados nesse Mês.</span>
                                        </div>
                                    </div>
                                    <i class="bi bi-x close" style="color: red;"></i>
                                    <div class="tempo tempo_error" style="background-color: #ddd;"></div>
                                </div>
    `;

  

    notificacao.innerHTML = codigo

    divNotificacao.appendChild(notificacao);

    timeAlert();
    

};


// Função para criar ou atualizar o gráfico de relatório mensal
function criarOuAtualizarGraficoMensal(dados) {
    const todosZeros = dados.every(valor => valor === '0');

    if (todosZeros) {
        alertPersonalizado2()
   
    }

    if (graficoMensal) {
        graficoMensal.destroy();
    }

    var canvas = document.getElementById('graficoMensal');


    if (!canvas) {
        console.error('Elemento de gráfico mensal não encontrado.');
        return;
    }

    var ctx = canvas.getContext('2d');
    if (!ctx) {
        console.error('Contexto de gráfico mensal não encontrado.');
        return;
    }

    
    
     graficoMensal = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Total de Ordens', 'Pendentes', 'Em Andamento', 'Concluídas', 'Canceladas'],
            datasets: [
                {
                    label: 'Total de Ordens ',
                    data: dados,
                    backgroundColor: [
                        'rgba(0, 0, 255, 0.5)',  // Azul para "Total de Ordens"
                        'rgba(255, 0, 0, 0.2)',  // Vermelho para "Pendentes"
                        'rgba(255, 206, 86, 0.2)',  // Amarelo para "Em Andamento"
                        'rgba(0, 128, 0, 0.2)',  // Verde para "Concluídas"
                        'rgba(128, 128, 128, 0.2)',  // Cinza para "Canceladas"
                    ],
                    borderColor: [
                        'rgba(0, 0, 255, 1)',  // Azul para "Total de Ordens"
                        'rgba(255, 0, 0, 1)',  // Vermelho para "Pendentes"
                        'rgba(255, 206, 86, 1)',  // Amarelo para "Em Andamento"
                        'rgba(0, 128, 0, 1)',  // Verde para "Concluídas"
                        'rgba(128, 128, 128, 1)',  // Cinza para "Canceladas"
                    ],
                    borderWidth: 1
                },
                {
                    label: 'Pendentes',
               
                    backgroundColor: 'rgba(255, 0, 0, 0.2)',  // Vermelho para "Pendentes"
                    borderColor: 'rgba(255, 0, 0, 1)',  // Vermelho para "Pendentes"
                    borderWidth: 1
                },
                {
                    label: 'Em Andamento',
                    
                    backgroundColor: 'rgba(255, 206, 86, 0.2)',  // Amarelo para "Em Andamento"
                    borderColor: 'rgba(255, 206, 86, 1)',  // Amarelo para "Em Andamento"
                    borderWidth: 1
                },
                {
                    label: 'Concluídas',
                  
                    backgroundColor: 'rgba(0, 128, 0, 0.2)',  // Verde para "Concluídas"
                    borderColor: 'rgba(0, 128, 0, 1)',  // Verde para "Concluídas"
                    borderWidth: 1
                },
                {
                    label: 'Canceladas',
                   
                    backgroundColor: 'rgba(128, 128, 128, 0.2)',  // Cinza para "Canceladas"
                    borderColor: 'rgba(128, 128, 128, 1)',  // Cinza para "Canceladas"
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            
            scales: {
                x: {
                    stacked: true
                },
                y: {
                    beginAtZero: true,
                    stepSize: 1  // Define o intervalo de incremento para 1
                }
            },
            plugins: {
                legend: {
                    labels: {
                        // Aqui você pode definir o tamanho da fonte do rótulo
                        font: {
                            size: 18, // Tamanho da fonte desejado
                            

                        },
                        
                    }
                }
            }
        }
    });
    window.scrollBy(0, 200);
}

function alertPersonalizado3(){

    let issetNotificacao = document.querySelector('.notificacao');
    if (issetNotificacao) {
        issetNotificacao.remove();
    } 
    
    let divNotificacao = document.querySelector('.div-notificacao')
    
    let notificacao = document.createElement('div');
    notificacao.className = 'notificacao';
    
    notificacao.style.borderLeft = '6px solid red';

    let codigo = `
                                    <div class="notificacao-div">
                                        <i class="bi bi-x-circle-fill" style="color: red;"></i>
                                        <div class="mensagem">
                                            <span class="text text-1" style="color: red;">Não há chamados nesse Dia.</span>
                                        </div>
                                    </div>
                                    <i class="bi bi-x close" style="color: red;"></i>
                                    <div class="tempo tempo_error" style="background-color: #ddd;"></div>
                                </div>
    `;

  

    notificacao.innerHTML = codigo

    divNotificacao.appendChild(notificacao);

    timeAlert();
    

};

// Função para criar ou atualizar o gráfico de relatório diário
function criarOuAtualizarGraficoDiario(dados) {
    const todosZeros = dados.every(valor => valor === '0');

    if (todosZeros) {
        alertPersonalizado3();
    
    }

    if (graficoDiario) {
        
    }

    var canvas = document.getElementById('graficoDiario');
    if (!canvas) {
        console.error('Elemento de gráfico diário não encontrado.');
        return;
    }

    var ctx = canvas.getContext('2d');
    if (!ctx) {
        console.error('Contexto de gráfico diário não encontrado.');
        return;
    }

    graficoDiario = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Total de Ordens', 'Pendentes', 'Em Andamento', 'Concluídas', 'Canceladas'],
            datasets: [
                {
                    label: 'Total de Ordens',
                    data: dados,
                    backgroundColor: [
                        'rgba(0, 0, 255, 0.5)',  // Azul para "Total de Ordens"
                        'rgba(255, 0, 0, 0.2)',  // Vermelho para "Pendentes"
                        'rgba(255, 206, 86, 0.2)',  // Amarelo para "Em Andamento"
                        'rgba(0, 128, 0, 0.2)',  // Verde para "Concluídas"
                        'rgba(128, 128, 128, 0.2)',  // Cinza para "Canceladas"
                    ],
                    borderColor: [
                        'rgba(0, 0, 255, 1)',  // Azul para "Total de Ordens"
                        'rgba(255, 0, 0, 1)',  // Vermelho para "Pendentes"
                        'rgba(255, 206, 86, 1)',  // Amarelo para "Em Andamento"
                        'rgba(0, 128, 0, 1)',  // Verde para "Concluídas"
                        'rgba(128, 128, 128, 1)',  // Cinza para "Canceladas"
                    ],
                    borderWidth: 1
                },
                {
                    label: 'Pendentes',
               
                    backgroundColor: 'rgba(255, 0, 0, 0.2)',  // Vermelho para "Pendentes"
                    borderColor: 'rgba(255, 0, 0, 1)',  // Vermelho para "Pendentes"
                    borderWidth: 1
                },
                {
                    label: 'Em Andamento',
                    
                    backgroundColor: 'rgba(255, 206, 86, 0.2)',  // Amarelo para "Em Andamento"
                    borderColor: 'rgba(255, 206, 86, 1)',  // Amarelo para "Em Andamento"
                    borderWidth: 1
                },
                {
                    label: 'Concluídas',
                  
                    backgroundColor: 'rgba(0, 128, 0, 0.2)',  // Verde para "Concluídas"
                    borderColor: 'rgba(0, 128, 0, 1)',  // Verde para "Concluídas"
                    borderWidth: 1
                },
                {
                    label: 'Canceladas',
                   
                    backgroundColor: 'rgba(128, 128, 128, 0.2)',  // Cinza para "Canceladas"
                    borderColor: 'rgba(128, 128, 128, 1)',  // Cinza para "Canceladas"
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    stacked: true
                },
                y: {
                    beginAtZero: true,
                    stepSize: 1  // Define o intervalo de incremento para 1
                }
            },
            plugins: {
                legend: {
                    labels: {
                        // Aqui você pode definir o tamanho da fonte do rótulo
                        font: {
                            size: 18, // Tamanho da fonte desejado
                        },
                        
                    }
                }
            }
        }
    });
    window.scrollBy(0, 200);
}

function alertPersonalizado4(){

    let issetNotificacao = document.querySelector('.notificacao');
    if (issetNotificacao) {
        issetNotificacao.remove();
    } 
    
    let divNotificacao = document.querySelector('.div-notificacao')
    
    let notificacao = document.createElement('div');
    notificacao.className = 'notificacao';
    
    notificacao.style.borderLeft = '6px solid red';

    let codigo = `
                                    <div class="notificacao-div">
                                        <i class="bi bi-x-circle-fill" style="color: red;"></i>
                                        <div class="mensagem">
                                            <span class="text text-1" style="color: red;">Não há chamados nesse Ano.</span>
                                        </div>
                                    </div>
                                    <i class="bi bi-x close" style="color: red;"></i>
                                    <div class="tempo tempo_error" style="background-color: #ddd;"></div>
                                </div>
    `;

  

    notificacao.innerHTML = codigo

    divNotificacao.appendChild(notificacao);

    timeAlert();
    

};

// Função para criar ou atualizar o gráfico de relatório anual
function criarOuAtualizarGraficoAnual(dados) {
    const todosZeros = dados.every(valor => valor === '0');

    if (todosZeros) {
        alertPersonalizado4();
   
    }

    if (graficoAnual) {
        graficoAnual.destroy();
    }

    var canvas = document.getElementById('graficoAnual');
    if (!canvas) {
        console.error('Elemento de gráfico anual não encontrado.');
        return;
    }

    var ctx = canvas.getContext('2d');
    if (!ctx) {
        console.error('Contexto de gráfico anual não encontrado.');
        return;
    }

    graficoAnual = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Total de Ordens', 'Pendentes', 'Em Andamento', 'Concluídas', 'Canceladas'],
            datasets: [
                {
                    label: 'Total de Ordens',
                    data: dados,
                    backgroundColor: [
                        'rgba(0, 0, 255, 0.5)',  // Azul para "Total de Ordens"
                        'rgba(255, 0, 0, 0.2)',  // Vermelho para "Pendentes"
                        'rgba(255, 206, 86, 0.2)',  // Amarelo para "Em Andamento"
                        'rgba(0, 128, 0, 0.2)',  // Verde para "Concluídas"
                        'rgba(128, 128, 128, 0.2)',  // Cinza para "Canceladas"
                    ],
                    borderColor: [
                        'rgba(0, 0, 255, 1)',  // Azul para "Total de Ordens"
                        'rgba(255, 0, 0, 1)',  // Vermelho para "Pendentes"
                        'rgba(255, 206, 86, 1)',  // Amarelo para "Em Andamento"
                        'rgba(0, 128, 0, 1)',  // Verde para "Concluídas"
                        'rgba(128, 128, 128, 1)',  // Cinza para "Canceladas"
                    ],
                    borderWidth: 1
                },
                {
                    label: 'Pendentes',
               
                    backgroundColor: 'rgba(255, 0, 0, 0.2)',  // Vermelho para "Pendentes"
                    borderColor: 'rgba(255, 0, 0, 1)',  // Vermelho para "Pendentes"
                    borderWidth: 1
                },
                {
                    label: 'Em Andamento',
                    
                    backgroundColor: 'rgba(255, 206, 86, 0.2)',  // Amarelo para "Em Andamento"
                    borderColor: 'rgba(255, 206, 86, 1)',  // Amarelo para "Em Andamento"
                    borderWidth: 1
                },
                {
                    label: 'Concluídas',
                  
                    backgroundColor: 'rgba(0, 128, 0, 0.2)',  // Verde para "Concluídas"
                    borderColor: 'rgba(0, 128, 0, 1)',  // Verde para "Concluídas"
                    borderWidth: 1
                },
                {
                    label: 'Canceladas',
                   
                    backgroundColor: 'rgba(128, 128, 128, 0.2)',  // Cinza para "Canceladas"
                    borderColor: 'rgba(128, 128, 128, 1)',  // Cinza para "Canceladas"
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    stacked: true
                },
                y: {
                    beginAtZero: true,
                    stepSize: 1  // Define o intervalo de incremento para 1
                }
            },
            plugins: {
                legend: {
                    labels: {
                        
                        font: {
                            size: 18, // Tamanho da fonte desejado
                            

                        },
                        
                    }
                }
            }
        }
    });
    window.scrollBy(0, 200);
}

// Função para enviar o formulário via AJAX
function enviarFormulario(formularioId) {
    var formElement = document.getElementById(formularioId);

    if (formElement && formElement.checkValidity()) {
        var formData = new FormData(formElement);

        $.ajax({
            type: 'POST',
            url: formElement.action, // Usando a URL do formulário como a URL de envio
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                try {
                    // Verifique se a resposta contém um campo "error"
                    if (response.error) {
                        console.error('Erro do servidor:', response.error);
                    } else if (typeof response.data !== 'undefined') {
                        // Chame a função apropriada para criar ou atualizar o gráfico com base na resposta
                        if (formularioId === 'formSemanal') {
                            criarOuAtualizarGraficoSemanal(response.data);
                        } else if (formularioId === 'formMensal') {
                            criarOuAtualizarGraficoMensal(response.data);
                        } else if (formularioId === 'formDiario') {
                            criarOuAtualizarGraficoDiario(response.data);
                        } else if (formularioId === 'formAnual') {
                            criarOuAtualizarGraficoAnual(response.data);
                        }
                    } else {
                        // A resposta não é válida
                        console.error('A resposta do servidor não é válida.');
                    }
                } catch (e) {
                    // Ocorreu um erro ao processar a resposta como JSON
                    console.error('Ocorreu um erro ao processar a resposta do servidor:', e);
                }
            },
            error: function(xhr, status, error) {
                console.error('Status:', status);
                console.error('Error:', error);
                alert('Ocorreu um erro ao enviar o formulário.');
            }
        });
    } else {
        alert('Por favor, preencha todos os campos corretamente.');
    }
}

// Função para mostrar o formulário com base no relatório selecionado e destruir gráficos existentes
function mostrarFormulario() {
    var relatorioSelecionado = document.getElementById("relatorio").value;
    var formMensal = document.getElementById("formMensal");
    var formAnual = document.getElementById("formAnual");
    var formSemanal = document.getElementById("formSemanal");
    var formDiario = document.getElementById("formDiario");

    var canvasMensal = document.getElementById("graficoMensal");
    var canvasAnual = document.getElementById("graficoAnual");
    var canvasSemanal = document.getElementById("graficoSemanal");
    var canvasDiario = document.getElementById("graficoDiario");

    

    // Destrói os gráficos existentes antes de ocultar os formulários
    if (graficoSemanal) {
        graficoSemanal.destroy();
        graficoSemanal = null;
       
    }
    if (graficoMensal) {
        graficoMensal.destroy();
        graficoMensal = null;

    }
    if (graficoDiario) {
        graficoDiario.destroy();
        graficoDiario = null;
        
    }
    if (graficoAnual) {
        graficoAnual.destroy();
        graficoAnual = null;
        
    }
   

    canvasAnual.style.display = (relatorioSelecionado === "anual") ? "block" : "none";
    canvasDiario.style.display = (relatorioSelecionado === "diario") ? "block" : "none";
    canvasMensal.style.display = (relatorioSelecionado === "mensal") ? "block" : "none";
    canvasSemanal.style.display = (relatorioSelecionado === "semanal") ? "block" : "none";
    
    formMensal.style.display = (relatorioSelecionado === "mensal") ? "block" : "none";
    formAnual.style.display = (relatorioSelecionado === "anual") ? "block" : "none";
    formSemanal.style.display = (relatorioSelecionado === "semanal") ? "block" : "none";
    formDiario.style.display = (relatorioSelecionado === "diario") ? "block" : "none";
}

// Função para executar quando o documento estiver pronto
$(document).ready(function() {
    mostrarFormulario();
});



