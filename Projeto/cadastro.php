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
                <li>
                    <a href="cadastro.php?page=livro" class="nav-link">Cadastrar Livro</a></li>
                    <li><a href="cadastro.php?page=autor" class="nav-link">Cadastrar Autor</a></li>
                    <li><a href="cadastro.php?page=categoria" class="nav-link">Cadastrar Categoria</a></li>
                </ul>
            </div>
            <div class="content">
                <?php if($page == 'autor'){ ?>
                    <?php include 'autor_lista.php'; ?>
                <?php } ?>
                <?php if($page == 'cadastro_autor_new'){ ?>
                    <?php include 'autor_form.php'; ?>
                <?php } ?>
                <?php if($page == 'livro'){ ?>
                    <?php include 'livro_lista.php'; ?>
                <?php } ?>
                <?php if($page == 'cadastro_livro_new'){ ?>
                    <?php include 'livro_form.php'; ?>
                <?php } ?>
                <?php if($page == 'categoria'){ ?>
                    <?php include 'categoria_lista.php'; ?>
                <?php } ?>
                <?php if($page == 'cadastro_categoria_new'){ ?>
                    <?php include 'categoria_form.php'; ?>
                <?php } ?>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Biblioteca Estrelinha</p>
    </footer>
</body>
</html>
