<?php   

require 'conexao.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_autor = $_POST['id_author'];
    if($id_autor  > 0){ 
        $nome = $_POST['nome-autor'];
        $sql = "update autores set nome = :nome where id = :id ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':id', $id_autor);
       // Executar a consulta e verificar se foi bem-sucedida
       if ($stmt->execute()) {
            header('Location:cadastro.php?page=autor');
       } else {
           Alert('Erro');
       }

    } else { 
    // Capturar os dados do formulário
     $nome = $_POST['nome-autor'];
     echo $nome;
     $sql = "INSERT INTO autores (nome) VALUES (:nome)";
     $stmt = $pdo->prepare($sql);
     $stmt->bindParam(':nome', $nome);
    // Executar a consulta e verificar se foi bem-sucedida
    if ($stmt->execute()) {
         header('Location:cadastro.php?page=autor');
    } else {
        alert('Erro');
    }
}
}


$id_autor = isset($_GET['id']) ? $_GET['id'] : '';
$nome_autor ='';
 if($id_autor >0){
  
     $sql = " select * from autores where id  = ".$id_autor ;
     $stmt = $pdo->prepare($sql);
     $stmt->execute();
     $result = $stmt -> fetch();
     $nome_autor =$result['nome'];
  
 }
 $id_delete = isset($_GET['id_delete']) ? $_GET['id_delete'] : '';
 if($id_delete > 0 ){ 
    $nome = $_POST['nome-autor'];
        $sql = "delete from autores where id = :id ";
        $stmt = $pdo->prepare($sql);
         $stmt->bindParam(':id', $id_delete);
       // Executar a consulta e verificar se foi bem-sucedida
       if ($stmt->execute()) {
            header('Location:cadastro.php?page=autor');
       } else {
           alert('Erro');
       }
 }

?>



<div style="display:flex; flex-direction: column;">
  <h3>Cadastrar Autor</h3>
                    <form id="form-cadastro-autor" method="post" 
                     action="cadastro.php?page=cadastro_autor_new">
                     
                        <label for="nome-autor">Nome:</label>
                     <input type="hidden" value="<?php echo $id_autor; ?>" id="id_author" name="id_author" >
                     <input type="text" value ="<?php echo $nome_autor; ?>" 
                     id="nome-autor" name="nome-autor" required>
                     <button type="submit">Cadastrar Autor</button>
   </form>

</div>
