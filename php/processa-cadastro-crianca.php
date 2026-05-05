<?php
include 'verificar_login.php';

// 1. Coleta e Limpeza de Dados
$matricula     = strip_tags($_POST['matricula'] ?? '');
$nis           = strip_tags($_POST['nis'] ?? '');
$nome_crianca  = strip_tags($_POST['nome-crianca'] ?? '');
$cpf_crianca   = strip_tags($_POST['cpf-crianca'] ?? '');
$data_nasc     = strip_tags($_POST['data-nasc-crianca'] ?? '');
$cidade_nasc   = strip_tags($_POST['cidade-nasc-crianca'] ?? '');
$data_entrada  = strip_tags($_POST['data-entrada-crianca'] ?? '');

// Sem strip_tags conforme solicitado
$status        = $_POST['status'] ?? '';

// Endereço
$cep           = strip_tags($_POST['cep'] ?? '');
$rua           = strip_tags($_POST['logradouro'] ?? '');
$numero        = strip_tags($_POST['numero'] ?? '');
$bairro        = strip_tags($_POST['bairro'] ?? '');
$municipio     = strip_tags($_POST['cidade'] ?? '');
$uf            = strip_tags($_POST['uf'] ?? '');

// Socioeconômico
$renda          = strip_tags($_POST['renda-familiar'] ?? '');
$cad_unico      = strip_tags($_POST['cad-unico'] ?? '');
$situacao_risco = strip_tags($_POST['situacao-risco-social'] ?? '');
$recebe_benef   = strip_tags($_POST['beneficio'] ?? '');

// Responsáveis
$tipo_resp = $_POST['tipo_responsavel'];

mysqli_begin_transaction($conn);

try {
    // PASSO 1: Inserir Endereço
    $sqlEnd = "INSERT INTO tb_enderecos (cep, logradouro, bairro, cidade, estado, numero) VALUES (?, ?, ?, ?, ?, ?)";
    $stmtEnd = mysqli_prepare($conn, $sqlEnd);
    mysqli_stmt_bind_param($stmtEnd, 'ssssss', $cep, $rua, $bairro, $municipio, $uf, $numero);
    mysqli_stmt_execute($stmtEnd);
    $idEndereco = mysqli_insert_id($conn);

    // PASSO 2: Inserir Socioeconômico
    $sqlSoc = "INSERT INTO tb_info_socioeconomica (renda_familiar, cad_unico, recebe_beneficio, situacao_risco_social) VALUES (?, ?, ?, ?)";
    $stmtSoc = mysqli_prepare($conn, $sqlSoc);
    mysqli_stmt_bind_param($stmtSoc, 'dsss', $renda, $cad_unico, $recebe_benef, $situacao_risco);
    mysqli_stmt_execute($stmtSoc);
    $idFamilia = mysqli_insert_id($conn);

    // PASSO 3: Inserir Adultos (Mãe e Pai)
    // Função auxiliar para inserir adulto e retornar ID
    function inserirAdulto($conexao, $nome, $cpf, $tel)
    {
        $sql = "INSERT INTO tb_adultos (nome, cpf, telefone) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conexao, $sql);
        mysqli_stmt_bind_param($stmt, 'sss', $nome, $cpf, $tel);
        mysqli_stmt_execute($stmt);
        return mysqli_insert_id($conexao);
    }

    $idMae = inserirAdulto($conn, $_POST['nome-mae'], $_POST['cpf-mae'], $_POST['tel-mae']);
    $idPai = inserirAdulto($conn, $_POST['nome-pai'], $_POST['cpf-pai'], $_POST['tel-pai']);

    // Lógica do Responsável Legal
    if ($tipo_resp === 'mae') {
        $idResponsavel = $idMae;
    } elseif ($tipo_resp === 'pai') {
        $idResponsavel = $idPai;
    } else {
        $idResponsavel = inserirAdulto($conn, $_POST['nome-responsavel'], $_POST['cpf-responsavel'], $_POST['tel-responsavel']);
    }

    // PASSO 4: Inserir Criança (Unindo todos os IDs)
    $sqlCrianca = "INSERT INTO tb_criancas 
        (matricula, nis, cpf, nome, data_nasc, cidade_nasc, status, data_entrada, pai_id, mae_id, responsavel_legal_id, endereco_id, familia_id) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmtCrianca = mysqli_prepare($conn, $sqlCrianca);
    mysqli_stmt_bind_param(
        $stmtCrianca,
        'ssssssssiiiii',
        $matricula,
        $nis,
        $cpf_crianca,
        $nome_crianca,
        $data_nasc,
        $cidade_nasc,
        $status,
        $data_entrada,
        $idPai,
        $idMae,
        $idResponsavel,
        $idEndereco,
        $idFamilia
    );
    mysqli_stmt_execute($stmtCrianca);
    $idCrianca = mysqli_insert_id($conn);

    // PASSO 5: Histórico de Status
    $sqlHis = "INSERT INTO tb_historico_status (crianca_id, status_anterior, status_novo, observacao) VALUES (?, 'pendente', ?, 'Cadastro inicial')";
    $stmtHis = mysqli_prepare($conn, $sqlHis);
    mysqli_stmt_bind_param($stmtHis, 'is', $idCrianca, $status);
    mysqli_stmt_execute($stmtHis);

    mysqli_commit($conn);
    echo json_encode(['sucesso' => true, 'id' => $idCrianca]);
} catch (Exception $e) {
    mysqli_rollback($conn);
    echo json_encode(['sucesso' => false, 'erro' => $e->getMessage()]);
}

mysqli_close($conn);
