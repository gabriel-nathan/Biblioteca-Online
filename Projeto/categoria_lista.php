<div style="display:flex; flex-direction: column;">
    <h2>Categorias registradas:</h2>
    <form>
        <table style="width:800px;">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Ações</th>
            </tr>
            <?php
            include 'conexao.php';
            $stmt = $pdo->query("SELECT * FROM categorias");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<tr>';
                echo '<td>' . $row['id'] . '</td>';
                echo '<td>' . $row['nome'] . '</td>';
                echo '<td><a href="cadastro.php?page=cadastro_categoria_new&id=' . $row['id'] . '" class="add-record-btn">Editar</a> 
                        <a href="cadastro.php?page=cadastro_categoria_new&id_delete=' . $row['id'] . '" class="add-record-btn">Excluir</a></td>';
                echo '</tr>';
            }
            ?>
        </table>
    </form>
    <a href="cadastro.php?page=cadastro_categoria_new" class="add-record-btn">Incluir</a>
</div>
