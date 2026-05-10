<link rel="stylesheet" href="../styles/modal_info_crianca.css">
<div class="tc-overlay" id="modalCrianca">
    <div class="tc-modal" id="modalContent">
        <div class="tc-modal-header">
            <div class="tc-modal-header-left">
                <div class="tc-avatar-lg" id="avatarInicial">LM</div>
                <div>
                    <h2 id="nomeHeader">Lucas Mendes Ferreira</h2>
                    <div class="tc-modal-sub">
                        <span class="tc-badge-matricula">
                            <svg fill="none" stroke="currentColor" style="width:11px;height:11px" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                            </svg>
                            Mat. 20241023
                        </span>
                        <span class="tc-status tc-status-ativo">
                            <span class="tc-status-dot"></span>
                            Ativo
                        </span>
                    </div>
                </div>
            </div>
            <button class="tc-btn-fechar" onclick="fecharModal()">×</button>
        </div>

        <div class="tc-modal-body" id="modalBody">

            <div class="tc-edit-banner">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Modo de edição ativo — altere os campos e clique em <strong style="margin-left:4px">Salvar Alterações</strong>.
            </div>

            <div class="tc-section">
                <div class="tc-section-titulo">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Dados Pessoais
                </div>
                <div class="tc-info-grid">
                    <div class="tc-info-item full">
                        <div class="tc-info-label">Nome Completo</div>
                        <div class="tc-field-view tc-info-value" id="v_nome">Lucas Mendes Ferreira</div>
                        <div class="tc-field-edit">
                            <label class="tc-modal-edit-label">Nome Completo</label>
                            <input class="tc-input-edit" id="e_nome" value="Lucas Mendes Ferreira" placeholder="Nome completo">
                        </div>
                    </div>
                    <div class="tc-info-item">
                        <div class="tc-info-label">CPF</div>
                        <div class="tc-field-view tc-info-value" id="v_cpf">123.456.789-00</div>
                        <div class="tc-field-edit">
                            <label class="tc-modal-edit-label">CPF</label>
                            <input class="tc-input-edit" id="e_cpf" value="123.456.789-00" placeholder="000.000.000-00">
                        </div>
                    </div>
                    <div class="tc-info-item">
                        <div class="tc-info-label">NIS</div>
                        <div class="tc-field-view tc-info-value" id="v_nis">23100012345</div>
                        <div class="tc-field-edit">
                            <label class="tc-modal-edit-label">NIS</label>
                            <input class="tc-input-edit" id="e_nis" value="23100012345" placeholder="NIS">
                        </div>
                    </div>
                    <div class="tc-info-item">
                        <div class="tc-info-label">Data de Nascimento</div>
                        <div class="tc-field-view tc-info-value" id="v_nasc">15/03/2016</div>
                        <div class="tc-field-edit">
                            <label class="tc-modal-edit-label">Data de Nascimento</label>
                            <input class="tc-input-edit" id="e_nasc" type="date" value="2016-03-15">
                        </div>
                    </div>
                    <div class="tc-info-item">
                        <div class="tc-info-label">Cidade de Nascimento</div>
                        <div class="tc-field-view tc-info-value" id="v_cidade_nasc">São Paulo</div>
                        <div class="tc-field-edit">
                            <label class="tc-modal-edit-label">Cidade de Nascimento</label>
                            <input class="tc-input-edit" id="e_cidade_nasc" value="São Paulo" placeholder="Cidade">
                        </div>
                    </div>
                    <div class="tc-info-item">
                        <div class="tc-info-label">Data de Entrada</div>
                        <div class="tc-field-view tc-info-value" id="v_entrada">10/01/2024</div>
                        <div class="tc-field-edit">
                            <label class="tc-modal-edit-label">Data de Entrada</label>
                            <input class="tc-input-edit" id="e_entrada" type="date" value="2024-01-10">
                        </div>
                    </div>
                    <div class="tc-info-item">
                        <div class="tc-info-label">Status</div>
                        <div class="tc-field-view">
                            <span class="tc-status tc-status-ativo"><span class="tc-status-dot"></span>Ativo</span>
                        </div>
                        <div class="tc-field-edit">
                            <label class="tc-modal-edit-label">Status</label>
                            <select class="tc-input-edit" id="e_status">
                                <option value="ativo" selected>Ativo</option>
                                <option value="inativo">Inativo</option>
                                <option value="pendente">Pendente</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tc-section">
                <div class="tc-section-titulo">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Filiação e Responsável
                </div>
                <div class="tc-info-grid">
                    <div class="tc-info-item">
                        <div class="tc-info-label">Nome da Mãe</div>
                        <div class="tc-field-view tc-info-value" id="v_mae">Ana Paula Mendes</div>
                        <div class="tc-field-edit">
                            <label class="tc-modal-edit-label">Nome da Mãe</label>
                            <input class="tc-input-edit" id="e_mae" value="Ana Paula Mendes" placeholder="Nome da mãe">
                        </div>
                    </div>
                    <div class="tc-info-item">
                        <div class="tc-info-label">Telefone da Mãe</div>
                        <div class="tc-field-view tc-info-value" id="v_tel_mae">(12) 99812-3456</div>
                        <div class="tc-field-edit">
                            <label class="tc-modal-edit-label">Telefone da Mãe</label>
                            <input class="tc-input-edit" id="e_tel_mae" value="(12) 99812-3456" placeholder="(00) 00000-0000">
                        </div>
                    </div>
                    <div class="tc-info-item">
                        <div class="tc-info-label">Nome do Pai</div>
                        <div class="tc-field-view tc-info-value" id="v_pai">Carlos Ferreira</div>
                        <div class="tc-field-edit">
                            <label class="tc-modal-edit-label">Nome do Pai</label>
                            <input class="tc-input-edit" id="e_pai" value="Carlos Ferreira" placeholder="Nome do pai">
                        </div>
                    </div>
                    <div class="tc-info-item">
                        <div class="tc-info-label">Telefone do Pai</div>
                        <div class="tc-field-view tc-info-value" id="v_tel_pai">(12) 99700-0001</div>
                        <div class="tc-field-edit">
                            <label class="tc-modal-edit-label">Telefone do Pai</label>
                            <input class="tc-input-edit" id="e_tel_pai" value="(12) 99700-0001" placeholder="(00) 00000-0000">
                        </div>
                    </div>
                    <div class="tc-info-item full">
                        <div class="tc-info-label">Responsável Legal</div>
                        <div class="tc-field-view tc-info-value" id="v_resp">Ana Paula Mendes — (12) 99812-3456</div>
                        <div class="tc-field-edit">
                            <label class="tc-modal-edit-label">Responsável Legal</label>
                            <input class="tc-input-edit" id="e_resp" value="Ana Paula Mendes" placeholder="Nome do responsável legal">
                        </div>
                    </div>
                </div>
            </div>

            <div class="tc-section">
                <div class="tc-section-titulo">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Endereço
                </div>
                <div class="tc-info-grid">
                    <div class="tc-info-item">
                        <div class="tc-info-label">CEP</div>
                        <div class="tc-field-view tc-info-value" id="v_cep">12300-000</div>
                        <div class="tc-field-edit">
                            <label class="tc-modal-edit-label">CEP</label>
                            <input class="tc-input-edit" id="e_cep" value="12300-000" placeholder="00000-000">
                        </div>
                    </div>
                    <div class="tc-info-item">
                        <div class="tc-info-label">Logradouro</div>
                        <div class="tc-field-view tc-info-value" id="v_logr">Rua das Acácias</div>
                        <div class="tc-field-edit">
                            <label class="tc-modal-edit-label">Logradouro</label>
                            <input class="tc-input-edit" id="e_logr" value="Rua das Acácias" placeholder="Logradouro">
                        </div>
                    </div>
                    <div class="tc-info-item">
                        <div class="tc-info-label">Número</div>
                        <div class="tc-field-view tc-info-value" id="v_num">142</div>
                        <div class="tc-field-edit">
                            <label class="tc-modal-edit-label">Número</label>
                            <input class="tc-input-edit" id="e_num" value="142" placeholder="Número">
                        </div>
                    </div>
                    <div class="tc-info-item">
                        <div class="tc-info-label">Bairro</div>
                        <div class="tc-field-view tc-info-value" id="v_bairro">Vila Nova</div>
                        <div class="tc-field-edit">
                            <label class="tc-modal-edit-label">Bairro</label>
                            <input class="tc-input-edit" id="e_bairro" value="Vila Nova" placeholder="Bairro">
                        </div>
                    </div>
                    <div class="tc-info-item">
                        <div class="tc-info-label">Cidade</div>
                        <div class="tc-field-view tc-info-value" id="v_cidade">Caçapava</div>
                        <div class="tc-field-edit">
                            <label class="tc-modal-edit-label">Cidade</label>
                            <input class="tc-input-edit" id="e_cidade" value="Caçapava" placeholder="Cidade">
                        </div>
                    </div>
                    <div class="tc-info-item">
                        <div class="tc-info-label">Estado</div>
                        <div class="tc-field-view tc-info-value" id="v_uf">SP</div>
                        <div class="tc-field-edit">
                            <label class="tc-modal-edit-label">Estado</label>
                            <select class="tc-input-edit" id="e_uf">
                                <option>AC</option>
                                <option>AL</option>
                                <option>AP</option>
                                <option>AM</option>
                                <option>BA</option>
                                <option>CE</option>
                                <option>DF</option>
                                <option>ES</option>
                                <option>GO</option>
                                <option>MA</option>
                                <option>MT</option>
                                <option>MS</option>
                                <option>MG</option>
                                <option>PA</option>
                                <option>PB</option>
                                <option>PR</option>
                                <option>PE</option>
                                <option>PI</option>
                                <option>RJ</option>
                                <option>RN</option>
                                <option>RS</option>
                                <option>RO</option>
                                <option>RR</option>
                                <option>SC</option>
                                <option selected>SP</option>
                                <option>SE</option>
                                <option>TO</option>
                            </select>
                        </div>
                    </div>
                    <div class="tc-info-item">
                        <div class="tc-info-label">Complemento</div>
                        <div class="tc-field-view tc-info-value muted" id="v_comp">—</div>
                        <div class="tc-field-edit">
                            <label class="tc-modal-edit-label">Complemento</label>
                            <input class="tc-input-edit" id="e_comp" value="" placeholder="Apto, casa, bloco...">
                        </div>
                    </div>
                </div>
            </div>

            <div class="tc-section">
                <div class="tc-section-titulo">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Informações Socioeconômicas
                </div>
                <div class="tc-info-grid">
                    <div class="tc-info-item">
                        <div class="tc-info-label">Renda Familiar</div>
                        <div class="tc-field-view tc-info-value" id="v_renda">R$ 1.320,00</div>
                        <div class="tc-field-edit">
                            <label class="tc-modal-edit-label">Renda Familiar (R$)</label>
                            <input class="tc-input-edit" id="e_renda" value="1320.00" placeholder="0,00" type="number" step="0.01">
                        </div>
                    </div>
                    <div class="tc-info-item">
                        <div class="tc-info-label">Cadastro Único (CadÚnico)</div>
                        <div class="tc-field-view tc-info-value" id="v_cadunico">Sim</div>
                        <div class="tc-field-edit">
                            <label class="tc-modal-edit-label">Possui CadÚnico?</label>
                            <select class="tc-input-edit" id="e_cadunico">
                                <option value="Sim" selected>Sim</option>
                                <option value="Não">Não</option>
                            </select>
                        </div>
                    </div>
                    <div class="tc-info-item">
                        <div class="tc-info-label">Recebe Benefício</div>
                        <div class="tc-field-view tc-info-value" id="v_beneficio">Sim</div>
                        <div class="tc-field-edit">
                            <label class="tc-modal-edit-label">Recebe Benefício?</label>
                            <select class="tc-input-edit" id="e_beneficio">
                                <option value="Sim" selected>Sim</option>
                                <option value="Não">Não</option>
                            </select>
                        </div>
                    </div>
                    <div class="tc-info-item full">
                        <div class="tc-info-label">Situação de Risco Social</div>
                        <div class="tc-field-view tc-info-value" id="v_risco">IX - Famílias beneficiárias de transferência de renda</div>
                        <div class="tc-field-edit">
                            <label class="tc-modal-edit-label">Situação de Risco Social</label>
                            <select class="tc-input-edit" id="e_risco">
                                <option>I - Crianças e adolescentes com medida de proteção</option>
                                <option>II - Trabalho infantil</option>
                                <option>III - Vivência de violência ou negligência</option>
                                <option>IV - Abuso e exploração sexual</option>
                                <option>V - Crianças e adolescentes fora da escola</option>
                                <option>VI - Jovens egressos de cumprimento de medida socioeducativa</option>
                                <option>VII - Pessoas com deficiência (PcD)</option>
                                <option>VIII - Idosos em situação de fragilidade</option>
                                <option selected>IX - Famílias beneficiárias de transferência de renda</option>
                                <option>X - Pessoas em situação de rua</option>
                                <option>XI - Vulnerabilidade por estigmatização</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="tc-modal-footer">
            <button class="tc-btn-cancelar-edicao" onclick="cancelarEdicao()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                Cancelar Edição
            </button>
            <button class="tc-btn-editar" onclick="ativarEdicao()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Editar Informações
            </button>
            <button class="tc-btn-salvar" onclick="confirmarSalvar()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Salvar Alterações
            </button>
        </div>

    </div>
</div>

<div class="swal-overlay" id="swalOverlay">
    <div class="swal-box" id="swalBox">
        <div class="swal-icon" id="swalIcon">
            <svg id="swalSvg" fill="none" stroke="currentColor" viewBox="0 0 24 24"></svg>
        </div>
        <div class="swal-title" id="swalTitle"></div>
        <div class="swal-text" id="swalText"></div>
        <div class="swal-btns" id="swalBtns"></div>
    </div>
</div>