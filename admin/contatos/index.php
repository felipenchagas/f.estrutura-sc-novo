<?php

session_start();



// Verifica se o usuário está logado

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {

    header('Location: login.php');

    exit();

}



// Gera um token CSRF

if (empty($_SESSION['csrf_token'])) {

    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

}



// Conectar ao banco de dados

$servidor = "localhost";
$usuario = "quarto_estrusc";
$senha = "uRXA1r9Z7pv~Cw3";
$banco = "quarto_estruturasc";


$conexao = new mysqli($servidor, $usuario, $senha, $banco);

if ($conexao->connect_error) {

    die("Falha na conexão com o banco de dados: " . $conexao->connect_error);

}



// Função para carregar contatos

function carregarContatos($conexao) {

    $contatos = array();

    $sql = "SELECT * FROM orcamentos ORDER BY data_envio DESC";

    $result = $conexao->query($sql);

    

    if ($result === false) {

        die("Erro na consulta SQL: " . $conexao->error);

    }



    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {

            $contatos[] = $row;

        }

    }



    return $contatos;

}



// Processa a exclusão de contatos

if (isset($_GET['delete']) && isset($_GET['csrf_token']) && hash_equals($_SESSION['csrf_token'], $_GET['csrf_token'])) {

    $id = $_GET['delete'];

    $sql = "DELETE FROM orcamentos WHERE id=?";

    $stmt = $conexao->prepare($sql);

    if ($stmt) {

        $stmt->bind_param("i", $id);

        $stmt->execute();

        $stmt->close();

        header('Location: index.php');

        exit();

    } else {

        die("Erro ao preparar a consulta de exclusão: " . $conexao->error);

    }

}



// Processa a adição de contatos

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['adicionar'])) {

<body>
<div class="floating-button">
  <button id="openModalBtn">Solicitar Orçamento</button>
</div>


<!-- Modal -->
  <div id="contactModal" class="modal" style="display:none;">
      <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Solicitar Orçamento</h2>
        
        <form action="processa_formulario.php" method="post" id="contact-form">
          <div class="input-group">
            <label for="nome">Nome Completo</label>
            <input type="text" id="nome" name="nome" placeholder="Digite seu nome completo" required pattern="[A-Za-zÀ-ÿ\s]+" title="Somente letras são permitidas">
          </div>
          
          <div class="input-group">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" placeholder="Digite seu e-mail" required>
          </div>
          
          <div class="input-group">
            <label for="telefone">Telefone</label>
            <div class="phone-fields">
              <input type="text" id="ddd" name="ddd" placeholder="DDD" maxlength="2" required pattern="\d{2}" title="Somente números são permitidos">
              <input type="text" id="telefone" name="telefone" placeholder="Número" maxlength="9" pattern="\d{9}" title="Somente números são permitidos" required>
            </div>
          </div>
          
          <div class="form-row">
            <div class="input-group cidade">
              <label for="cidade">Cidade</label>
              <input type="text" id="cidade" name="cidade" placeholder="Digite sua cidade" required pattern="[A-Za-zÀ-ÿ\s]+" title="Somente letras são permitidas">
            </div>
            <div class="input-group estado">
              <label for="estado">Estado</label>
              <input type="text" id="estado" name="estado" placeholder="Digite" maxlength="2" pattern="[A-Za-z]{2}" title="Apenas 2 letras são permitidas" required>
            </div>
          </div>
          
          <div class="input-group">
            <label for="descricao">Descrição do Orçamento</label>
            <textarea id="descricao" name="descricao" placeholder="Descreva o serviço ou estrutura metálica que deseja orçar" required></textarea>
          </div>
          
          <!-- Campo Honeypot escondido -->
          <div style="display:none;">
            <label for="honeypot">Não preencha este campo se for humano:</label>
            <input type="text" id="honeypot" name="honeypot">
          </div>
          
          <!-- Campo Oculto para o Temporizador -->
          <input type="hidden" id="form_loaded_at" name="form_loaded_at" value="">
          
          <button type="submit">Enviar</button>
        </form>
      </div>
    </div>ome = htmlspecialchars(trim($_POST['nome']), ENT_QUOTES, 'UTF-8');

    $email = htmlspecialchars(trim($_POST['email']), ENT_QUOTES, 'UTF-8');

    $telefone = htmlspecialchars(trim($_POST['telefone']), ENT_QUOTES, 'UTF-8');

    $cidade = htmlspecialchars(trim($_POST['cidade']), ENT_QUOTES, 'UTF-8');

    $estado = htmlspecialchars(trim($_POST['estado']), ENT_QUOTES, 'UTF-8');

    $descricao = htmlspecialchars(trim($_POST['descricao']), ENT_QUOTES, 'UTF-8');



    $sql = "INSERT INTO orcamentos (nome, email, telefone, cidade, estado, descricao, data_envio) VALUES (?, ?, ?, ?, ?, ?, NOW())";

    $stmt = $conexao->prepare($sql);

    if ($stmt) {

        $stmt->bind_param("ssssss", $nome, $email, $telefone, $cidade, $estado, $descricao);

        $stmt->execute();

        $stmt->close();

        header('Location: index.php');

        exit();

    } else {

        die("Erro ao preparar a consulta de inserção: " . $conexao->error);

    }

}



// Processa a edição de contatos

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editar'])) {

    $id = $_POST['id'];

    $nome = htmlspecialchars(trim($_POST['nome']), ENT_QUOTES, 'UTF-8');

    $email = htmlspecialchars(trim($_POST['email']), ENT_QUOTES, 'UTF-8');

    $telefone = htmlspecialchars(trim($_POST['telefone']), ENT_QUOTES, 'UTF-8');

    $cidade = htmlspecialchars(trim($_POST['cidade']), ENT_QUOTES, 'UTF-8');

    $estado = htmlspecialchars(trim($_POST['estado']), ENT_QUOTES, 'UTF-8');

    $descricao = htmlspecialchars(trim($_POST['descricao']), ENT_QUOTES, 'UTF-8');



    // Atualiza o contato no banco de dados

    $sql = "UPDATE orcamentos SET nome=?, email=?, telefone=?, cidade=?, estado=?, descricao=? WHERE id=?";

    $stmt = $conexao->prepare($sql);

    if ($stmt) {

        $stmt->bind_param("ssssssi", $nome, $email, $telefone, $cidade, $estado, $descricao, $id);

        $stmt->execute();

        $stmt->close();

        header('Location: index.php');

        exit();

    } else {

        die("Erro ao preparar a consulta de edição: " . $conexao->error);

    }

}



// Carrega os contatos

$contatos = carregarContatos($conexao);

?>



<!DOCTYPE html>

<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <title>Admin - Contatos</title>

    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Meta Tag Essencial para Responsividade -->

    <link rel="stylesheet" href="admin_styles20.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

</head>



<body>



    <!-- Modal principal para exibir a tabela de contatos -->

    <div id="contacts-modal" class="modal" style="display: block;">

        <div class="modal-content" style="max-width: 90%; width: 90%;">

            <span class="close-btn" id="closeModalBtn">&times;</span>

            <h2>Lista de Contatos</h2>

            <div class="top-bar-buttons">

                <button id="add-contact-btn">Adicionar Contato</button>

                <a href="logout.php" class="logout-btn">Sair</a>

                <div class="search-container">

                    <i class="fas fa-search"></i>

                    <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Pesquisar...">

                </div>

            </div>
<br>


            <?php if (!empty($contatos)): ?>

            <div class="table-container">

                <table id="contactsTable">

                    <thead>

                        <tr>

                            <th onclick="sortTable(0)">Nome</th>

                            <th onclick="sortTable(1)">E-mail</th>

                            <th onclick="sortTable(2)">Telefone</th>

                            <th onclick="sortTable(3)">Cidade</th>

                            <th onclick="sortTable(4)">Estado</th>

                            <th onclick="sortTable(5)">Descrição do Orçamento</th>

                            <th onclick="sortTable(6)">Data de Envio</th>

                            <th>Ações</th>

                        </tr>

                    </thead>

                    <tbody>

                    <?php foreach ($contatos as $contato): ?>

                        <tr>

                            <td onclick="openCardModal(<?php echo $contato['id']; ?>)"><?php echo htmlspecialchars($contato['nome']); ?></td>

                            <td><?php echo htmlspecialchars($contato['email']); ?></td>

                            <td><?php echo htmlspecialchars($contato['telefone']); ?></td>

                            <td><?php echo htmlspecialchars($contato['cidade']); ?></td>

                            <td><?php echo htmlspecialchars($contato['estado']); ?></td>

                            <td><?php echo nl2br(htmlspecialchars($contato['descricao'])); ?></td>

                            <td><?php echo date("d/m/Y H:i", strtotime($contato['data_envio'])); ?></td>

                            <td>

                                <a href="?delete=<?php echo $contato['id']; ?>&csrf_token=<?php echo $_SESSION['csrf_token']; ?>" class="delete-btn" onclick="return confirm('Tem certeza que deseja deletar este contato?');">

                                    <i class="fas fa-trash-alt"></i> Deletar

                                </a>

                                <a href="#" class="edit-btn" onclick="openEditModal(<?php echo $contato['id']; ?>)">

                                    <i class="fas fa-edit"></i> Editar

                                </a>

                                <a href="#" class="orcamento-btn" onclick="openOrcamentoModal(<?php echo $contato['id']; ?>)">

                                    <i class="fas fa-file-invoice-dollar"></i> Orçamento

                                </a>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

            <?php else: ?>

            <p>Nenhum contato encontrado.</p>

            <?php endif; ?>

        </div>

    </div>



    <!-- Modal de adicionar contato -->

    <div id="add-contact-modal" class="modal">

        <div class="modal-content">

            <span class="close-btn">&times;</span>

            <h2>Adicionar Novo Contato</h2>

            <form action="index.php" method="post" class="add-contact-form">

                <input type="hidden" name="adicionar" value="1">

                <div class="input-group">

                    <label for="nome">Nome Completo</label>

                    <input type="text" id="nome" name="nome" required>

                </div>

                <div class="input-group">

                    <label for="email">E-mail</label>

                    <input type="email" id="email" name="email" required>

                </div>

                <div class="input-group">

                    <label for="telefone">Telefone</label>

                    <input type="text" id="telefone" name="telefone" required>

                </div>

                <div class="input-group">

                    <label for="cidade">Cidade</label>

                    <input type="text" id="cidade" name="cidade" required>

                </div>

                <div class="input-group">

                    <label for="estado">Estado</label>

                    <input type="text" id="estado" name="estado" required>

                </div>

                <div class="input-group">

                    <label for="descricao">Descrição do Orçamento</label>

                    <textarea id="descricao" name="descricao" required></textarea>

                </div>

                <button type="submit">Adicionar Contato</button>

            </form>

        </div>

    </div>



    <!-- Modal de edição de contato -->

    <div id="edit-contact-modal" class="modal">

        <div class="modal-content">

            <span class="close-btn">&times;</span>

            <h2>Editar Contato</h2>

            <form action="index.php" method="post" class="edit-contact-form">

                <input type="hidden" name="id" id="edit-id">

                <input type="hidden" name="editar" value="1">

                <div class="input-group">

                    <label for="edit-nome">Nome Completo</label>

                    <input type="text" id="edit-nome" name="nome" required>

                </div>

                <div class="input-group">

                    <label for="edit-email">E-mail</label>

                    <input type="email" id="edit-email" name="email" required>

                </div>

                <div class="input-group">

                    <label for="edit-telefone">Telefone</label>

                    <input type="text" id="edit-telefone" name="telefone" required>

                </div>

                <div class="input-group">

                    <label for="edit-cidade">Cidade</label>

                    <input type="text" id="edit-cidade" name="cidade" required>

                </div>

                <div class="input-group">

                    <label for="edit-estado">Estado</label>

                    <input type="text" id="edit-estado" name="estado" required>

                </div>

                <div class="input-group">

                    <label for="edit-descricao">Descrição do Orçamento</label>

                    <textarea id="edit-descricao" name="descricao" required></textarea>

                </div>

                <button type="submit">Salvar Alterações</button>

            </form>

        </div>

    </div>



    <!-- Modal de Orçamento -->

    <div id="orcamento-modal" class="modal">

        <div class="modal-content">

            <span class="close-btn">&times;</span>

            <h2>Detalhes do Orçamento</h2>

            <div id="orcamento-details"></div>

        </div>

    </div>



    <!-- Modal para exibir contato em modo card -->

    <div id="card-modal" class="modal">

        <div class="modal-content">

            <span class="close-btn" onclick="closeCardModal()">&times;</span>

            <h2>Detalhes do Contato</h2>

            <p id="card-nome"></p>

            <p id="card-email"></p>

            <p id="card-telefone"></p>

            <p id="card-cidade"></p>

            <p id="card-estado"></p>

            <p id="card-descricao"></p>

            <p id="card-data"></p>

        </div>

    </div>



    <!-- Scripts -->

    <script>

        var contatos = <?php echo json_encode($contatos); ?>; // Declara globalmente



        var addModal = document.getElementById("add-contact-modal");

        var addBtn = document.getElementById("add-contact-btn");

        var addSpan = addModal.getElementsByClassName("close-btn")[0];



        addBtn.onclick = function() {

            addModal.style.display = "block";

        }



        addSpan.onclick = function() {

            addModal.style.display = "none";

        }



        var editModal = document.getElementById("edit-contact-modal");

        var editSpan = editModal.getElementsByClassName("close-btn")[0];



        function openEditModal(id) {

            editModal.style.display = "block";

            var contatoSelecionado = contatos.find(c => c.id == id);



            if (contatoSelecionado) {

                document.getElementById("edit-id").value = contatoSelecionado.id;

                document.getElementById("edit-nome").value = contatoSelecionado.nome;

                document.getElementById("edit-email").value = contatoSelecionado.email;

                document.getElementById("edit-telefone").value = contatoSelecionado.telefone;

                document.getElementById("edit-cidade").value = contatoSelecionado.cidade;

                document.getElementById("edit-estado").value = contatoSelecionado.estado;

                document.getElementById("edit-descricao").value = contatoSelecionado.descricao;

            } else {

                alert("Contato não encontrado.");

                editModal.style.display = "none";

            }

        }



        editSpan.onclick = function() {

            editModal.style.display = "none";

        }



        var orcamentoModal = document.getElementById("orcamento-modal");

        var orcamentoSpan = orcamentoModal.getElementsByClassName("close-btn")[0];



        function openOrcamentoModal(id) {

            var contatoSelecionado = contatos.find(c => c.id == id);

            

            if (contatoSelecionado) {

                var detalhes = `

                    <p><strong>Nome:</strong> ${contatoSelecionado.nome}</p>

                    <p><strong>Cidade:</strong> ${contatoSelecionado.cidade}</p>

                    <p><strong>Estado:</strong> ${contatoSelecionado.estado}</p>

                    <p><strong>E-mail:</strong> ${contatoSelecionado.email}</p>

                    <p><strong>Telefone:</strong> ${contatoSelecionado.telefone}</p>

                    <p><strong>Descrição:</strong> ${contatoSelecionado.descricao}</p>

                    <p><strong>Data de Envio:</strong> ${new Date(contatoSelecionado.data_envio).toLocaleString('pt-BR')}</p>

                `;

                document.getElementById("orcamento-details").innerHTML = detalhes;

                orcamentoModal.style.display = "block";

            } else {

                alert("Contato não encontrado.");

            }

        }



        orcamentoSpan.onclick = function() {

            orcamentoModal.style.display = "none";

        }



        var cardModal = document.getElementById("card-modal");



        function openCardModal(id) {

            var contatoSelecionado = contatos.find(c => c.id == id);

            if (contatoSelecionado) {

                document.getElementById("card-nome").innerText = "Nome: " + contatoSelecionado.nome;

                document.getElementById("card-email").innerText = "E-mail: " + contatoSelecionado.email;

                document.getElementById("card-telefone").innerText = "Telefone: " + contatoSelecionado.telefone;

                document.getElementById("card-cidade").innerText = "Cidade: " + contatoSelecionado.cidade;

                document.getElementById("card-estado").innerText = "Estado: " + contatoSelecionado.estado;

                document.getElementById("card-descricao").innerText = "Descrição: " + contatoSelecionado.descricao;

                document.getElementById("card-data").innerText = "Data de Envio: " + new Date(contatoSelecionado.data_envio).toLocaleString('pt-BR');

                cardModal.classList.add("active");

            }

        }



        function closeCardModal() {

            cardModal.classList.remove("active");

        }



        window.onclick = function(event) {

            if (event.target == addModal) {

                addModal.style.display = "none";

            }

            if (event.target == editModal) {

                editModal.style.display = "none";

            }

            if (event.target == orcamentoModal) {

                orcamentoModal.style.display = "none";

            }

            if (event.target == cardModal) {

                cardModal.style.display = "none";

            }

        }



        var sortOrder = []; // Inicializa o array de ordem de classificação

        function sortTable(n) {

            let table = document.getElementById("contactsTable");

            let rows = Array.from(table.rows).slice(1);

            sortOrder[n] = !sortOrder[n]; // Alterna a ordem de classificação



            rows.sort((row1, row2) => {

                let cell1 = row1.cells[n].innerText.toLowerCase();

                let cell2 = row2.cells[n].innerText.toLowerCase();



                if (n === 6) {

                    let partes1 = cell1.split('/');

                    let partes2 = cell2.split('/');

                    cell1 = new Date(partes1[2], partes1[1]-1, partes1[0]).getTime();

                    cell2 = new Date(partes2[2], partes2[1]-1, partes2[0]).getTime();

                }



                if (cell1 < cell2) return sortOrder[n] ? -1 : 1;

                if (cell1 > cell2) return sortOrder[n] ? 1 : -1;

                return 0;

            });



            rows.forEach(row => table.appendChild(row));

        }



        function searchTable() {

            let input = document.getElementById("searchInput").value.toLowerCase();

            let rows = document.querySelectorAll("table tbody tr");



            rows.forEach(row => {

                let rowText = row.innerText.toLowerCase();

                row.style.display = rowText.includes(input) ? "" : "none";

            });

        }

    </script>

</body>

</html>

