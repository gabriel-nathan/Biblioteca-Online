
<?php
 
// Configuração da conexão
    $dsn = "pgsql:host=localhost;port=5433;dbname=postgres";
    $username = "postgres";
    $password = "Estacio@123";
 
try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  

} catch (PDOException $e) {
    echo 'Erro ao conectar com o banco de dados: ' . $e->getMessage();
    die();
}
?>