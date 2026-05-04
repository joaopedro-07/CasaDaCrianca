<?php
include 'verificar_login.php';

// 1. Identificação da Criança
$matricula      = strip_tags($_POST['matricula']);
$nis            = strip_tags($_POST['nis']);
$nome_crianca   = strip_tags($_POST['nome-crianca']);
$cpf_crianca    = strip_tags($_POST['cpf-crianca']);
$data_nasc      = strip_tags($_POST['data-nasc-crianca']);
$cidade_nasc    = strip_tags($_POST['cidade-nasc-crianca']);
$data_entrada   = strip_tags($_POST['data-entrada-crianca']);
$cad_unico      = strip_tags($_POST['cad-unico']);

// 2. Identificação dos Responsáveis
$nome_mae         = strip_tags($_POST['nome-mae']);
$cpf_mae          = strip_tags($_POST['cpf-mae']);
$nome_pai         = strip_tags($_POST['nome-pai']);
$cpf_pai          = strip_tags($_POST['cpf-pai']);
$nome_responsavel = strip_tags($_POST['nome-responsavel']);
$cpf_responsavel  = strip_tags($_POST['cpf-responsavel']);

// 3. Endereço
$rua       = strip_tags($_POST['rua']);
$numero    = strip_tags($_POST['numero']);
$bairro    = strip_tags($_POST['bairro']);
$municipio = strip_tags($_POST['municipio']);
$uf        = strip_tags($_POST['uf']);
$cep       = strip_tags($_POST['cep']);

// 4. Dados Sociais e Status
$renda          = strip_tags($_POST['renda']);
$status         = strip_tags($_POST['status']);
$situacao_risco = strip_tags($_POST['situacao-risco']);

// 5. Benefícios (Atenção aqui!)
// Como você tem vários checkboxes com o mesmo nome "beneficio", 
// no HTML o ideal seria 'name="beneficio[]"'. 
// Se deixar como está, o PHP pegará apenas o último marcado.
$beneficio = isset($_POST['beneficio']) ? "Sim" : "Não";

// 6. Desligamento
$motivo_desligamento = strip_tags($_POST['motivo-desligamento']);


// Inicia transação — garante que tudo é salvo junto ou nada é salvo
mysqli_begin_transaction($conn);

try {
    // 1. Insere o usuário
    $sql = "INSERT INTO criancas (
            matricula, nis, nome_crianca, cpf_crianca, data_nasc, 
            cidade_nasc, data_entrada, cad_unico, nome_mae, cpf_mae, 
            nome_pai, cpf_pai, nome_responsavel, cpf_responsavel, 
            rua, numero, bairro, municipio, uf, cep, 
            renda_familiar, status, situacao_risco_social, 
            motivo_desligamento, motivo_outro
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        'sssssssssssssssssssssssss',
        $matricula,
        $nis,
        $nome_crianca,
        $cpf_crianca,
        $data_nasc,
        $cidade_nasc,
        $data_entrada,
        $cad_unico,
        $nome_mae,
        $cpf_mae,
        $nome_pai,
        $cpf_pai,
        $nome_responsavel,
        $cpf_responsavel,
        $rua,
        $numero,
        $bairro,
        $municipio,
        $uf,
        $cep,
        $renda,
        $status,
        $situacao_risco,
        $motivo_desligamento,
        $motivo_outro
    );
    mysqli_stmt_execute($stmt);

    // 2. Pega o ID gerado
    $idUsuario = mysqli_insert_id($conn);

    $beneficios_marcados = isset($_POST['beneficio']) ? $_POST['beneficio'] : [];

    // Se o rádio do CadÚnico for "Sim", adicionamos manualmente ao array
    if (isset($_POST['cad-unico']) && $_POST['cad-unico'] === 'sim-cadUnico') {
        $beneficios_marcados[] = 'CadÚnico';
    }

    // 3. Verifica se o array não está vazio para começar a inserir
    if (!empty($beneficios_marcados)) {
        $stmtBeneficio = mysqli_prepare($conn, "
        INSERT INTO criancas_beneficios (crianca_id, beneficio) VALUES (?, ?)
    ");

        // Lembre-se: $idUsuario deve ser o resultado de mysqli_insert_id($conn)
        // obtido logo após o insert da tabela 'criancas'
        foreach ($beneficios_marcados as $beneficio) {
            // IMPORTANTE: O valor deve ser EXATAMENTE igual ao que está no ENUM do banco
            mysqli_stmt_bind_param($stmtBeneficio, 'is', $idUsuario, $beneficio);

            if (!mysqli_stmt_execute($stmtBeneficio)) {
                // Caso dê erro (ex: valor não existe no ENUM)
                echo "Erro ao inserir benefício ($beneficio): " . mysqli_stmt_error($stmtBeneficio);
            }
        }
    }

    // 4. Insere no histórico de status
    $stmtHistorico = mysqli_prepare($conn, "
        INSERT INTO criancas_status_historico (crianca_id, status) VALUES (?, ?)
    ");
    mysqli_stmt_bind_param($stmtHistorico, 'is', $idUsuario, $status);
    mysqli_stmt_execute($stmtHistorico);

    // Confirma tudo
    mysqli_commit($conn);

    echo json_encode(['sucesso' => true, 'id' => $idUsuario]);
} catch (Exception $e) {
    // Se qualquer coisa falhar, desfaz tudo
    mysqli_rollback($conn);
    echo json_encode(['sucesso' => false, 'erro' => $e->getMessage()]);
}

mysqli_close($conn);
