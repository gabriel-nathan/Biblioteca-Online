<?php
require 'conexao.php';

// Processamento do formulário
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_livro = $_POST['id_livro'];
    $titulo = $_POST['titulo'];
    $id_autor = $_POST['id_autor'];
    $id_categoria = $_POST['id_categoria'];

    if ($id_livro > 0) {
        // Atualização do livro existente
        $sql = "UPDATE livros SET titulo = :titulo, autor_id = :autor_id, categoria_id = :categoria_id WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':autor_id', $id_autor);
        $stmt->bindParam(':categoria_id', $id_categoria);
        $stmt->bindParam(':id', $id_livro);
        if ($stmt->execute()) {
            header('Location: cadastro.php?page=livro');
            exit; // Importante: após o redirecionamento, encerrar o script para prevenir execução adicional
        } else {
            echo 'Erro ao atualizar o livro.';
        }
    } else {
        // Inserção de novo livro
        $sql = "INSERT INTO livros (titulo, autor_id, categoria_id) VALUES (:titulo, :autor_id, :categoria_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':autor_id', $id_autor);
        $stmt->bindParam(':categoria_id', $id_categoria);
        if ($stmt->execute()) {
            header('Location: cadastro.php?page=livro');
            exit; // Importante: após o redirecionamento, encerrar o script para prevenir execução adicional
        } else {
            echo 'Erro ao cadastrar o livro.';
        }
    }
}

// Preparação para edição de livro existente ou exclusão
$id_livro = isset($_GET['id']) ? $_GET['id'] : '';
$titulo = '';
$id_autor = '';
$id_categoria = '';

if ($id_livro > 0) {
    // Busca informações do livro para edição
    $sql = "SELECT * FROM livros WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id_livro);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        $titulo = $result['titulo'];
        $id_autor = $result['autor_id'];
        $id_categoria = $result['categoria_id'];
    }
}

// Exclusão de livro
$id_delete = isset($_GET['id_delete']) ? $_GET['id_delete'] : '';
if ($id_delete > 0) {
    $sql = "DELETE FROM livros WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id_delete);
    if ($stmt->execute()) {
        header('Location: cadastro.php?page=livro');
        exit; // Importante: após o redirecionamento, encerrar o script para prevenir execução adicional
    } else {
        echo 'Erro ao excluir o livro.';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Biblioteca Online</title>
    <link rel="stylesheet" href="./stylecadastro.css">
    <link rel="icon" href="icone/estrela.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&display=swap" rel="stylesheet">
</head>
<?php
$page = isset($_GET['page']) ? $_GET['page'] : 'livro'; // Define 'livro' como valor padrão
?>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="cadastro.php">Cadastro</a></li>
                <li><a href="pesquisa.php">Pesquisa</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="cadastro">
            <div class="sidebar">
                <ul>
                    <li><a href="cadastro.php?page=livro" class="nav-link">Cadastrar Livro</a></li>
                    <li><a href="cadastro.php?page=autor" class="nav-link">Cadastrar Autor</a></li>
                    <li><a href="cadastro.php?page=categoria" class="nav-link">Cadastrar Categoria</a></li>
                </ul>
            </div>
            <div class="content">
                <div style="display:flex; flex-direction: column;">
                    <h3>Cadastrar Livro</h3>
                    <form id="form-cadastro-livro" method="post" action="livro_form.php">
                        <input type="hidden" value="<?php echo $id_livro; ?>" id="id_livro" name="id_livro">
                        
                        <label for="titulo">Título:</label>
                        <input type="text" value="<?php echo $titulo; ?>" id="titulo" name="titulo" required>
                        
                        <label for="id_autor">Autor:</label>
                        <select id="id_autor" name="id_autor" required>
                            <option value="">Selecione o autor</option>
                            <?php
                            $stmt = $pdo->query("SELECT * FROM autores");
                            while ($autor = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $selected = $id_autor == $autor['id'] ? 'selected' : '';
                                echo '<option value="' . $autor['id'] . '" ' . $selected . '>' . $autor['nome'] . '</option>';
                            }
                            ?>
                        </select>
                        
                        <label for="id_categoria">Categoria:</label>
                        <select id="id_categoria" name="id_categoria" required>
                            <option value="">Selecione a categoria</option>
                            <?php
                            $stmt = $pdo->query("SELECT * FROM categorias");
                            while ($categoria = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $selected = $id_categoria == $categoria['id'] ? 'selected' : '';
                                echo '<option value="' . $categoria['id'] . '" ' . $selected . '>' . $categoria['nome'] . '</option>';
                            }
                            ?>
                        </select>
                        
                        <button type="submit"><?php echo $id_livro > 0 ? 'Atualizar' : 'Cadastrar'; ?> Livro</button>
                    </form>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Biblioteca Estrelinha</p>
    </footer>
</body>
</html>
