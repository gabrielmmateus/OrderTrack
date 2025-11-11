# OrderTrack



OrderTrack é uma solução de software desenvolvida para a gestão eficaz de ordens de serviço, especialmente adaptada para o ambiente educacional do SENAI Suíço-Brasileira “Paulo Ernesto Tolle”.

## Sobre o Projeto

O projeto OrderTrack é uma solução de software desenvolvida para a gestão eficaz de ordens de serviço no contexto da instituição educacional SENAI Suíço-Brasileira “Paulo Ernesto Tolle”. Ele visa otimizar o processo de comunicação e acompanhamento das atividades de manutenção, proporcionando uma plataforma integrada e intuitiva para equipe, gestores e clientes.

## Objetivo

O principal objetivo do OrderTrack é melhorar a eficiência operacional e a qualidade dos serviços de manutenção oferecidos pela instituição SENAI Suíço-Brasileira “Paulo Ernesto Tolle”. Ao fornecer uma ferramenta centralizada para abertura, acompanhamento e gestão de ordens de serviço, o OrderTrack busca facilitar a comunicação entre equipe e gestores, garantindo uma resposta mais rápida às necessidades de serviço e uma maior transparência em todo o processo de manutenção.

## Funcionalidades Principais

- **Abertura de Ordem de Serviço:** Permite aos usuários criar novas ordens de serviço, inserindo detalhes como título, descrição, local, prioridade e data de entrega.
  
- **Acompanhamento de Ordem de Serviço:** Permite o acompanhamento do status de ordens de serviço em tempo real, facilitando a comunicação entre equipe, gestores e clientes.

- **Gestão de Equipe:** Oferece uma visão completa da equipe de manutenção, incluindo listagem de funcionários, atribuição de ordens de serviço e acompanhamento do desempenho individual.

- **Relatórios:** Fornece recursos analíticos para extrair insights valiosos sobre o desempenho das ordens de serviço, a eficiência operacional e a alocação de recursos.

## Como Usar

Este guia ensina **passo a passo** como instalar e executar o sistema **OrderTrack** em sua máquina local usando o **XAMPP** e o **Visual Studio Code**.

> **Observação:** já existe um usuário administrador padrão:  
> **Usuário:** `admin`  
> **Senha:** `admin`  
>  
> Recomenda-se alterar essa senha após o primeiro acesso.

---

## equisitos

Antes de começar, instale:

- **[XAMPP](https://www.apachefriends.org/)** — servidor PHP + MySQL  
- **[Visual Studio Code](https://code.visualstudio.com/)** — para editar o código  
- **[Composer](https://getcomposer.org/)** — para instalar dependências PHP  
- Navegador (Chrome, Firefox, Edge)

---

## **Passo 1 — Copiar o projeto para o XAMPP**

1. Localize a pasta do projeto (por exemplo: `OrderTrack-main`).  
2. Copie essa pasta para o diretório: C:\xampp\htdocs\OrderTrack

> Dica: renomeie a pasta para `OrderTrack` para facilitar o acesso.

---

## **Passo 2 — Iniciar Apache e MySQL**

1. Abra o **XAMPP Control Panel** (`C:\xampp\xampp-control.exe`).  
2. Clique em **Start** nos módulos: 
- Apache   
- MySQL  
3. Ambos devem ficar **verdes** (ativos).

---

## **Passo 3 — Importar o banco de dados**

1. Acesse: [http://localhost/phpmyadmin/](http://localhost/phpmyadmin/)  
2. Clique em **Novo** → crie o banco chamado **`order_track`**  
3. Vá na aba **Importar**  
4. Selecione o arquivo:  order_track_populado.sql
5. Clique em **Executar / Go**  
6. O banco e as tabelas serão criados automaticamente.

---

## **Passo 4 — Configurar a conexão com o banco (opcional)**

O arquivo responsável é `conection.php`:

```php
<?php
$servidor = "localhost";
$usuario = "root";
$senha = "";
$dbname = "order_track";
$conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
?>

##  **Passo 5 — Instalar dependências PHP (Composer)**

1. Abra o terminal no VS Code (Ctrl + `). 
2. Vá até a pasta lib do projeto:
cd C:\xampp\htdocs\OrderTrack\lib
4. Execute:
composer install  
6. O banco e as tabelas serão criados automaticamente.

##  **Passo 6 — Acessar o site**

Abra no navegador:

http://localhost/OrderTrack/


Você verá a tela inicial com duas opções:

Funcionário 

Administrador

Usuário e Senha para administrador padrão: 
Usuário: admin
Senha: admin

## Tecnologias Utilizadas

<div style="display : flex; justify-content : center">
<img src="https://img.shields.io/badge/HTML-239120?style=for-the-badge&logo=html5&logoColor=white" /> 
<img src="https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white" />
<img src="https://img.shields.io/badge/Javascript-323330?style=for-the-badge&logo=javascript&logoColor=F7DF1E" />
<img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" />
<img src=" https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white" />
<img src="https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white" />
<img src="https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white" />
<img src="https://img.shields.io/badge/Canva-%2300C4CC.svg?&style=for-the-badge&logo=Canva&logoColor=white" />
<img src="https://img.shields.io/badge/Figma-F24E1E?style=for-the-badge&logo=figma&logoColor=white" />


