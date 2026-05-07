<?php
include 'verificar_login.php';

$id = $_GET['id'] ?? 0;

$sql = "SELECT c.*, 
               c.nome AS nome_crianca, c.cpf AS cpf_crianca,
               mae.nome AS nome_mae, pai.nome AS nome_pai,
               resp.nome AS nome_responsavel, resp.grau_parentesco AS tipo_responsavel,
               e.logradouro, e.bairro
        FROM tb_criancas c
        LEFT JOIN tb_adultos mae ON mae.id = c.mae_id
        LEFT JOIN tb_adultos pai ON pai.id = c.pai_id
        LEFT JOIN tb_adultos resp ON resp.id = c.responsavel_legal_id
        LEFT JOIN tb_enderecos e ON e.id = c.endereco_id
        WHERE c.id = ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
$dados = mysqli_fetch_assoc($resultado);

if ($dados) {
    echo json_encode($dados);
} else {
    echo json_encode(['erro' => 'Criança não encontrada']);
}
?>