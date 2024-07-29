<div style="display:flex; flex-direction: column;">
    <h2>Livros registrados:</h2>
    <form>
        <table style="width:800px;">
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Autor</th>
                <th>Categoria</th>
                <th>Ações</th>
            </tr>
            <?php
            include 'conexao.php';
            $stmt = $pdo->query("SELECT livros.id, livros.titulo, autores.nome AS autor, categorias.nome AS categoria 
                                FROM livros 
                                INNER JOIN autores ON livros.autor_id = autores.id 
                                INNER JOIN categorias ON livros.categoria_id = categorias.id");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<tr>';
                echo '<td>' . $row['id'] . '</td>';
                echo '<td>' . $row['titulo'] . '</td>';
                echo '<td>' . $row['autor'] . '</td>';
                echo '<td>' . $row['categoria'] . '</td>';
                echo '<td><a href="livro_form.php?id=' . $row['id'] . '" class="add-record-btn">Editar</a> 
                        <a href="livro_form.php?id_delete=' . $row['id'] . '" class="add-record-btn">Excluir</a></td>';
                echo '</tr>';
            }
            ?>
        </table>
    </form>
    <a href="livro_form.php" class="add-record-btn">Incluir</a>
</div>