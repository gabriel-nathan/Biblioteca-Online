
<?php   

require 'conexao.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_categoria = $_POST['id_category'];
    if($id_categoria  > 0){ 
        $nome = $_POST['nome-categoria'];
        $sql = "update   categorias set nome = :nome where id = :id ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':id', $id_categoria);
       // Executar a consulta e verificar se foi bem-sucedida
       if ($stmt->execute()) {
            header('Location:cadastro.php?page=categoria');
       } else {
           Alert('Erro');
       }

    } else { 
    // Capturar os dados do formulário
     $nome = $_POST['nome-categoria'];
     echo $nome;
     $sql = "INSERT INTO categorias (nome) VALUES (:nome)";
     $stmt = $pdo->prepare($sql);
     $stmt->bindParam(':nome', $nome);
    // Executar a consulta e verificar se foi bem-sucedida
    if ($stmt->execute()) {
         header('Location:cadastro.php?page=categoria');
    } else {
        alert('Erro');
    }
}
}


$id_categoria = isset($_GET['id']) ? $_GET['id'] : '';
$nome_categoria ='';
 if($id_categoria >0){
  
     $sql = " select * from categorias where id  = ".$id_categoria ;
     $stmt = $pdo->prepare($sql);
     $stmt->execute();
     $result = $stmt -> fetch();
     $nome_categoria =$result['nome'];
  
 }
 $id_delete = isset($_GET['id_delete']) ? $_GET['id_delete'] : '';
 if($id_delete > 0 ){ 
    $nome = $_POST['nome-categoria'];
        $sql = "delete from    categorias  where id = :id ";
        $stmt = $pdo->prepare($sql);
         $stmt->bindParam(':id', $id_delete);
       // Executar a consulta e verificar se foi bem-sucedida
       if ($stmt->execute()) {
            header('Location:cadastro.php?page=categoria');
       } else {
           alert('Erro');
       }
 }

?>




   <div style="display:flex; flex-direction: column;">
  <h3>Cadastrar Categoria</h3>
                    <form id="form-cadastro-categoria" method="post" 
                     action="cadastro.php?page=cadastro_categoria_new">
                     
                        <label for="nome-categoria">Nome:</label>
                     <input type="hidden" value="<?php echo $id_categoria; ?>" id="id_category" name="id_category" >
                     <input type="text" value ="<?php echo $nome_categoria; ?>" 
                     id="nome-categoria" name="nome-categoria" required>
                     <button type="submit">Cadastrar Categoria</button>
   </form>

</div>

 