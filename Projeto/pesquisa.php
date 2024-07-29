<?php
require 'conexao.php';

// Inicializar variáveis de pesquisa
$titulo = isset($_GET['titulo']) ? $_GET['titulo'] : '';
$autor_id = isset($_GET['autor_id']) ? $_GET['autor_id'] : '';
$categoria_id = isset($_GET['categoria_id']) ? $_GET['categoria_id'] : '';

// Construir a consulta SQL com filtros
$sql = "SELECT livros.id, livros.titulo, autores.nome AS autor, categorias.nome AS categoria
        FROM livros
        INNER JOIN autores ON livros.autor_id = autores.id
        INNER JOIN categorias ON livros.categoria_id = categorias.id
        WHERE 1=1";

if (!empty($titulo)) {
    $sql .= " AND livros.titulo LIKE :titulo";
}
if (!empty($autor_id)) {
    $sql .= " AND livros.autor_id = :autor_id";
}
if (!empty($categoria_id)) {
    $sql .= " AND livros.categoria_id = :categoria_id";
}

$stmt = $pdo->prepare($sql);

if (!empty($titulo)) {
    $titulo = "%" . $titulo . "%";
    $stmt->bindParam(':titulo', $titulo);
}
if (!empty($autor_id)) {
    $stmt->bindParam(':autor_id', $autor_id);
}
if (!empty($categoria_id)) {
    $stmt->bindParam(':categoria_id', $categoria_id);
}

$stmt->execute();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisar Livros - Biblioteca Online</title>
    <link rel="stylesheet" href="./stylepesquisa.css">
    <link rel="icon" href="icone/estrela.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="cadastro.php">Cadastro</a></li>
                <li><a href="pesquisa.php">Pesquisar</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="pesquisa">
            <div style="display:flex; flex-direction: column;">
                <h2>Pesquisar Livros</h2>
                <form method="GET" action="pesquisa.php">
                    <label for="titulo">Título:</label>
                    <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($titulo); ?>">

                    <label for="autor_id">Autor:</label>
                    <select id="autor_id" name="autor_id">
                        <option value="">Selecione o autor</option>
                        <?php
                        $stmt_autores = $pdo->query("SELECT * FROM autores");
                        while ($autor = $stmt_autores->fetch(PDO::FETCH_ASSOC)) {
                            $selected = $autor_id == $autor['id'] ? 'selected' : '';
                            echo '<option value="' . $autor['id'] . '" ' . $selected . '>' . $autor['nome'] . '</option>';
                        }
                        ?>
                    </select>

                    <label for="categoria_id">Categoria:</label>
                    <select id="categoria_id" name="categoria_id">
                        <option value="">Selecione a categoria</option>
                        <?php
                        $stmt_categorias = $pdo->query("SELECT * FROM categorias");
                        while ($categoria = $stmt_categorias->fetch(PDO::FETCH_ASSOC)) {
                            $selected = $categoria_id == $categoria['id'] ? 'selected' : '';
                            echo '<option value="' . $categoria['id'] . '" ' . $selected . '>' . $categoria['nome'] . '</option>';
                        }
                        ?>
                    </select>

                    <button type="submit">Pesquisar</button>
                </form>

                <h3>Resultados da Pesquisa</h3>
                <table style="width:800px;">
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Autor</th>
                        <th>Categoria</th>
                    </tr>
                    <?php
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row['id']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['titulo']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['autor']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['categoria']) . '</td>';
                        echo '</tr>';
                    }
                    ?>
                </table>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Biblioteca Estrelinha</p>
    </footer>
</body>
</html>
