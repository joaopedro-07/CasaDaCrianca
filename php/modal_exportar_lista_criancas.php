<?php
/* ---------- Presets de exportação ---------- */
$presets = [
    'gesuas' => [
        'matricula',
        'nis',
        'nome_crianca',
        'cpf_crianca',
        'data_nasc_crianca',
        'nome_mae',
        'cpf_mae',
        'nome_pai',
        'cpf_pai',
        'cep',
        'logradouro',
        'numero',
        'bairro',
        'cidade',
        'uf',
        'renda_familiar',
        'cad_unico',
        'beneficio',
        'situacao_risco_social'
    ],
    'livro_registro' => [
        'matricula',
        'nome_crianca',
        'data_nasc_crianca',
        'cidade_nasc_crianca',
        'data_entrada_crianca',
        'nome_mae',
        'nome_pai',
        'status'
    ],
];
?>

<div class="tc-overlay" id="tc-overlay-export">
    <div class="tc-modal" role="dialog" aria-labelledby="tc-export-titulo">
        <div class="tc-modal-header">
            <div class="tc-modal-header-left">
                <div class="tc-modal-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                        <polyline points="7 10 12 15 17 10" />
                        <line x1="12" y1="15" x2="12" y2="3" />
                    </svg>
                </div>
                <div>
                    <h2 id="tc-export-titulo">Exportar lista</h2>
                    <p class="tc-modal-sub">Use um modelo pronto e/ou marque manualmente as colunas.</p>
                </div>
            </div>
            <button type="button" class="tc-btn-fechar" id="tc-btn-fechar-export" aria-label="Fechar">×</button>
        </div>

        <div class="tc-modal-body">
            <div class="tc-presets">
                <p class="tc-presets-label">Modelos prontos <span class="tc-presets-hint">(você pode marcar/desmarcar colunas depois)</span>:</p>
                <div class="tc-presets-buttons">
                    <button type="button" class="tc-preset-btn" data-preset="gesuas">Padrão GesuAS</button>
                    <button type="button" class="tc-preset-btn" data-preset="livro_registro">Livro de Registro</button>
                    <button type="button" class="tc-preset-btn tc-preset-clear" data-preset="clear">Limpar seleção</button>
                    <button type="button" class="tc-preset-btn tc-preset-clear" data-preset="all">Selecionar tudo</button>
                </div>
            </div>

            <div class="tc-export-grid" id="tc-export-grid"></div>
        </div>

        <div class="tc-modal-footer">
            <span class="tc-export-info" id="tc-export-info">0 colunas selecionadas</span>
            <div class="tc-modal-footer-right">
                <button type="button" class="tc-btn-cancelar" id="tc-btn-cancelar-export">Cancelar</button>
                <button type="button" class="tc-btn-exportar-csv" id="tc-btn-exportar-csv">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                    Exportar CSV
                </button>
            </div>
        </div>
    </div>
</div>