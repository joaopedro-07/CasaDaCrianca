<?php
include 'modal_exportar_lista_criancas.php';
include 'modal_info_criancas.php';
$criancas = [];

$sql = "
    SELECT
        c.id,
        c.matricula,
        c.nis,
        c.cpf                         AS cpf_crianca,
        c.nome                        AS nome_crianca,
        c.status,
        c.data_entrada                AS data_entrada_crianca,
        c.data_nasc                   AS data_nasc_crianca,
        c.cidade_nasc                 AS cidade_nasc_crianca,

        /* Responsáveis (JOIN em tb_adultos 3x) */
        mae.nome                      AS nome_mae,
        mae.cpf                       AS cpf_mae,
        mae.telefone                  AS tel_mae,

        pai.nome                      AS nome_pai,
        pai.cpf                       AS cpf_pai,
        pai.telefone                  AS tel_pai,

        resp.nome                     AS nome_responsavel,
        resp.cpf                      AS cpf_responsavel,
        resp.telefone                 AS tel_responsavel,

        /* BUSCA O GRAU DIRETAMENTE DA TABELA DE ADULTOS DO RESPONSÁVEL */
        resp.grau_parentesco                  AS tipo_responsavel,

        /* Endereço */
        e.cep,
        e.logradouro,
        e.numero,
        e.complemento,
        e.bairro,
        e.cidade,
        e.estado                      AS uf,

        /* Socioeconômico */
        s.renda_familiar,
        s.cad_unico,
        s.recebe_beneficio            AS beneficio,
        s.situacao_risco_social,

        /* Último histórico de status (subquery) */
        (SELECT h.data_mudanca FROM tb_historico_status h
            WHERE h.crianca_id = c.id
            ORDER BY h.data_mudanca DESC LIMIT 1)            AS ultimo_status_data,
        (SELECT h.motivo_desligamento FROM tb_historico_status h
            WHERE h.crianca_id = c.id
            ORDER BY h.data_mudanca DESC LIMIT 1)            AS ultimo_motivo

    FROM tb_criancas c
    LEFT JOIN tb_adultos mae          ON mae.id  = c.mae_id
    LEFT JOIN tb_adultos pai          ON pai.id  = c.pai_id
    LEFT JOIN tb_adultos resp         ON resp.id = c.responsavel_legal_id
    LEFT JOIN tb_enderecos e          ON e.id    = c.endereco_id
    LEFT JOIN tb_info_socioeconomica s ON s.id   = c.familia_id
    ORDER BY c.nome ASC
";



try {
    if (isset($pdo)) {
        $criancas = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    } elseif (isset($conn)) {
        $res = mysqli_query($conn, $sql);
        if ($res) {
            while ($row = mysqli_fetch_assoc($res)) $criancas[] = $row;
        }
    }
} catch (Throwable $e) {
    $criancas = [];
}

/* ---------- Definição central das colunas ---------- */
$colunas = [
    'matricula'             => ['label' => 'Nº Matrícula',           'cat' => 'Identificação',  'default' => true],
    'nis'                   => ['label' => 'NIS',                    'cat' => 'Identificação',  'default' => true],
    'nome_crianca'          => ['label' => 'Nome',                   'cat' => 'Identificação',  'default' => true],
    'cpf_crianca'           => ['label' => 'CPF da criança',         'cat' => 'Identificação',  'default' => false],
    'data_nasc_crianca'     => ['label' => 'Data de nascimento',     'cat' => 'Identificação',  'default' => true],
    'cidade_nasc_crianca'   => ['label' => 'Cidade de nascimento',   'cat' => 'Identificação',  'default' => false],
    'data_entrada_crianca'  => ['label' => 'Data de entrada',        'cat' => 'Identificação',  'default' => true],

    'tipo_responsavel'      => ['label' => 'Tipo de responsável',    'cat' => 'Responsáveis',   'default' => true],
    'nome_mae'              => ['label' => 'Nome da mãe',            'cat' => 'Responsáveis',   'default' => false],
    'cpf_mae'               => ['label' => 'CPF da mãe',             'cat' => 'Responsáveis',   'default' => false],
    'tel_mae'               => ['label' => 'Telefone da mãe',        'cat' => 'Responsáveis',   'default' => false],
    'nome_pai'              => ['label' => 'Nome do pai',            'cat' => 'Responsáveis',   'default' => false],
    'cpf_pai'               => ['label' => 'CPF do pai',             'cat' => 'Responsáveis',   'default' => false],
    'tel_pai'               => ['label' => 'Telefone do pai',        'cat' => 'Responsáveis',   'default' => false],
    'nome_responsavel'      => ['label' => 'Nome do responsável',    'cat' => 'Responsáveis',   'default' => true],
    'cpf_responsavel'       => ['label' => 'CPF do responsável',     'cat' => 'Responsáveis',   'default' => false],
    'tel_responsavel'       => ['label' => 'Tel. do responsável',    'cat' => 'Responsáveis',   'default' => true],

    'cep'                   => ['label' => 'CEP',                    'cat' => 'Endereço',       'default' => false],
    'logradouro'            => ['label' => 'Logradouro',             'cat' => 'Endereço',       'default' => false],
    'numero'                => ['label' => 'Número',                 'cat' => 'Endereço',       'default' => false],
    'complemento'           => ['label' => 'Complemento',            'cat' => 'Endereço',       'default' => false],
    'bairro'                => ['label' => 'Bairro',                 'cat' => 'Endereço',       'default' => false],
    'cidade'                => ['label' => 'Cidade',                 'cat' => 'Endereço',       'default' => false],
    'uf'                    => ['label' => 'UF',                     'cat' => 'Endereço',       'default' => false],

    'renda_familiar'        => ['label' => 'Renda familiar (R$)',    'cat' => 'Socioeconômico', 'default' => false],
    'cad_unico'             => ['label' => 'CadÚnico',               'cat' => 'Socioeconômico', 'default' => false],
    'beneficio'             => ['label' => 'Recebe benefício',       'cat' => 'Socioeconômico', 'default' => false],
    'situacao_risco_social' => ['label' => 'Situação de risco social', 'cat' => 'Socioeconômico', 'default' => false],

    'ultimo_status_data'    => ['label' => 'Última mudança',         'cat' => 'Histórico',      'default' => false],
    'ultimo_motivo'         => ['label' => 'Motivo desligamento',    'cat' => 'Histórico',      'default' => false],
];

function fmt_valor($key, $val, $linha = [])
{
    if ($key !== 'acoes' && ($val === null || $val === '')) {
        return '—';
    }
    if (in_array($key, ['data_nasc_crianca', 'data_entrada_crianca', 'ultimo_status_data'])) {
        $ts = strtotime($val);
        return $ts ? date('d/m/Y', $ts) : htmlspecialchars($val);
    }
    if ($key === 'renda_familiar') {
        return 'R$ ' . number_format((float)$val, 2, ',', '.');
    }
    if ($key === 'acoes') {
        $id = $linha['id'] ?? 0;

        return '
            <div class="acoes-container">
                <button class="btn-acao edit" onclick="buscarDadosCrianca(' . $id . ')" title="Editar">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn-acao delete" onclick="confirmarExclusao(' . $id . ')" title="Excluir">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>';
    }
    if ($key === 'tipo_responsavel') {
        return htmlspecialchars((string) $val);
    }
    return htmlspecialchars((string) $val);
}
?>

<section class="tc-wrapper" id="tc-wrapper"
    data-colunas='<?= htmlspecialchars(json_encode($colunas), ENT_QUOTES, "UTF-8") ?>'
    data-presets='<?= htmlspecialchars(json_encode($presets), ENT_QUOTES, "UTF-8") ?>'>

    <div class="tc-toolbar">
        <div class="tc-search">
            <svg class="tc-search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8" />
                <line x1="21" y1="21" x2="16.65" y2="16.65" />
            </svg>
            <input type="text" id="tc-input-busca" class="tc-input-busca"
                placeholder="Pesquisar por nome, CPF, matrícula, mãe, bairro...">
        </div>

        <div class="tc-toolbar-actions">
            <span class="tc-contador" id="tc-contador">
                <?= count($criancas) ?> registro<?= count($criancas) === 1 ? '' : 's' ?>
            </span>
            <button type="button" class="tc-btn-export" id="tc-btn-abrir-export">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                    <polyline points="7 10 12 15 17 10" />
                    <line x1="12" y1="15" x2="12" y2="3" />
                </svg>
                Exportar
            </button>
        </div>
    </div>

    <div class="tc-table-scroll">
        <table class="tc-table" id="tc-table">
            <thead>
                <tr>
                    <?php foreach ($colunas as $key => $col): if (!$col['default']) continue; ?>
                        <th data-key="<?= $key ?>"><?= htmlspecialchars($col['label']) ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody id="tc-tbody">
                <?php if (empty($criancas)): ?>
                    <tr class="tc-row-vazia">
                        <td colspan="100">Nenhuma criança cadastrada ainda.</td>
                    </tr>
                    <?php else: foreach ($criancas as $c): ?>
                        <tr class="tc-row-clicavel" data-id="<?= $c['id'] ?>" data-search="<?= htmlspecialchars(strtolower(implode(' ', array_map('strval', array_map(fn($v) => $v ?? '', $c))))) ?>">
                            <?php foreach ($colunas as $key => $col): if (!$col['default']) continue; ?>
                                <td class="td-row-clicavel">
                                    <?php if ($key === 'status'): ?>
                                        <?php $s = strtolower($c['status'] ?? ''); ?>
                                        <span class="tc-status tc-status-<?= htmlspecialchars($s) ?>">
                                            <span class="tc-status-dot"></span>
                                            <?= htmlspecialchars(ucfirst($s ?: '—')) ?>
                                        </span>
                                    <?php else: ?>
                                        <?= fmt_valor($key, $c[$key] ?? null, $c) ?>
                                    <?php endif; ?>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                <?php endforeach;
                endif; ?>
            </tbody>
        </table>
    </div>
    <script type="application/json" id="tc-dataset">
        <?= json_encode($criancas, JSON_UNESCAPED_UNICODE) ?>
    </script>
</section>