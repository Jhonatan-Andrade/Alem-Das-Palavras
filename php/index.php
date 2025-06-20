<?php
$db = new PDO('sqlite:meu_banco.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$mensagem = '';

// Verifica se a tabela existe antes de criar
if (isset($_POST['criar'])) {
  $stmt = $db->query("SELECT name FROM sqlite_master WHERE type='table' AND name='usuarios'");
  $tabelaExiste = $stmt->fetch();

  if ($tabelaExiste) {
    $mensagem = "Tabela já existe!";
  } else {
    $db->exec("CREATE TABLE usuarios (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nome TEXT
        )");
    $mensagem = "Tabela criada!";
  }
}

// Apagar a tabela
if (isset($_POST['apagar_tabela'])) {
  $db->exec("DROP TABLE IF EXISTS usuarios");
  $mensagem = "Tabela apagada!";
}

// Inserir
if (isset($_POST['inserir']) && !empty($_POST['nome'])) {
  $sql = "INSERT INTO usuarios (nome) VALUES (:nome)";
  $stmt = $db->prepare($sql);
  $nome = $_POST['nome'];
  $stmt->bindParam(':nome', $nome);
  $stmt->execute();
}

// Atualizar
if (isset($_POST['atualizar']) && !empty($_POST['id_atualizar']) && !empty($_POST['nome_atualizar'])) {
  $sql = "UPDATE usuarios SET nome = :nome WHERE id = :id";
  $stmt = $db->prepare($sql);
  $id = $_POST['id_atualizar'];
  $nome = $_POST['nome_atualizar'];
  $stmt->bindParam(':nome', $nome);
  $stmt->bindParam(':id', $id);
  $stmt->execute();
}

// Deletar por ID
if (isset($_POST['deletar']) && !empty($_POST['id_deletar'])) {
  $sql = "DELETE FROM usuarios WHERE id = :id";
  $stmt = $db->prepare($sql);
  $id = $_POST['id_deletar'];
  $stmt->bindParam(':id', $id);
  $stmt->execute();
}

// Apagar individual
if (isset($_POST['excluir_linha']) && !empty($_POST['id_excluir_linha'])) {
  $sql = "DELETE FROM usuarios WHERE id = :id";
  $stmt = $db->prepare($sql);
  $id = $_POST['id_excluir_linha'];
  $stmt->bindParam(':id', $id);
  $stmt->execute();
}

// Buscar usuários com verificação
$usuarios = [];
$stmt = $db->query("SELECT name FROM sqlite_master WHERE type='table' AND name='usuarios'");
$tabelaExiste = $stmt->fetch();
if ($tabelaExiste) {
  $stmt = $db->query("SELECT * FROM usuarios");
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $usuarios[] = $row;
  }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Gerenciador SQLite</title>
</head>

<body>
  <h1>CRUD em SQLite com PHP</h1>

  <?php if ($mensagem): ?>
    <script>
      alert("<?= $mensagem ?>");
    </script>
  <?php endif; ?>

  <!-- Criar Tabela -->
  <form method="post">
    <div>
      <h3>Criar Tabela</h3>
      <button name="criar" onclick="this.blur()">Criar Tabela</button>
    </div>
  </form>

  <!-- Inserir -->
  <form method="post">
    <div>
      <h3>Inserir Usuário</h3>
      <input type="text" name="nome" placeholder="Nome">
      <button name="inserir">Inserir</button>
    </div>
  </form>

  <!-- Atualizar -->
  <form method="post">
    <div>
      <h3>Atualizar Usuário</h3>
      <input type="number" name="id_atualizar" placeholder="ID">
      <input type="text" name="nome_atualizar" placeholder="Novo Nome">
      <button name="atualizar">Atualizar</button>
    </div>
  </form>

  <!-- Deletar por ID -->
  <form method="post">
    <div>
      <h3>Deletar por ID</h3>
      <input type="number" name="id_deletar" placeholder="ID">
      <button name="deletar">Deletar</button>
    </div>
  </form>

  <!-- Lista de Usuários -->
  <h3>Lista de Usuários</h3>
  <form method="post">
    <table border="1" cellpadding="5">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nome</th>
          <th>Ação</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($usuarios as $u): ?>
          <tr>
            <td><?= $u['id'] ?></td>
            <td><?= htmlspecialchars($u['nome']) ?></td>
            <td>
              <button name="excluir_linha" value="1" onclick="this.form.id_excluir_linha.value=<?= $u['id'] ?>;">Apagar</button>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <input type="hidden" name="id_excluir_linha">
  </form>

  <!-- Apagar Tabela -->
  <form method="post">
    <div style="margin-top: 20px;">
      <button name="apagar_tabela" onclick="return confirm('Tem certeza que deseja apagar a tabela? Todos os dados serão perdidos!')">
        Apagar Tabela
      </button>
    </div>
  </form>
</body>

</html>