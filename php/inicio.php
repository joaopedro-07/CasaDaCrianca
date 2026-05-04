<?php
include 'verificar_login.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../styles/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <script src="../js/script.js" defer></script>
  <title>Início - Casa da Criança</title>
</head>

<body class="body-padrao">
  <?php include 'sidebar.php'; ?>
  <div class="container-geral">
    <?php include 'header.php'; ?>

    <main class="main-inicio">
      <div class="lista-criancas">
        <div class="header-lista">
          <h1>Lista de crianças cadastradas</h1>
          <div class="parte-esquerda-header-lista">
            <a href="renda_beneficios.php" class="button-ver-renda-beneficios">Ver Renda e Benefícios</a>
            <button class="btn-novo" onclick="document.getElementById('overlay').classList.add('open')">+ Adicionar Criança</button>
          </div>

          <div class="overlay" id="overlay" onclick="fecharModal(event)">
            <div class="modal" onclick="event.stopPropagation()">
              <div class="modal-header">
                <h2>Cadastrar usuário</h2>
                <button class="btn-fechar" onclick="document.getElementById('overlay').classList.remove('open')">×</button>
              </div>

                <form action="processa-cadastro-crianca.php" method="POST" class="form-grid">

                  <div class="form-group">
                    <div class="section-label">Identificação</div>
                    <label class="label-form-cadastro">Nº Matrícula</label><input name="matricula" class="input-form-cadastro" type="text" placeholder="Digite o nº da matrícula">
                    <label class="label-form-cadastro">NIS (Número de Identificação Social)</label><input name="nis" class="input-form-cadastro" type="text" placeholder="Digite o NIS">
                    <label class="label-form-cadastro">Nome da Criança</label><input name="nome-crianca" class="input-form-cadastro" type="text" placeholder="Digite o nome da criança">
                    <label class="label-form-cadastro">CPF da Criança</label><input name="cpf-crianca" class="input-form-cadastro" type="text" placeholder="Digite o CPF da criança">
                    <label class="label-form-cadastro">Data de Nascimento da Criança</label><input name="data-nasc-crianca" class="input-form-cadastro" type="date">
                    <label class="label-form-cadastro">Cidade de Nascimento da Criança</label><input name="cidade-nasc-crianca" class="input-form-cadastro" type="text" placeholder="Digite a cidade em que a criança nasceu">
                    <label class="label-form-cadastro">Data de entrada da Criança</label><input name="data-entrada-crianca" class="input-form-cadastro" type="date">
                  </div>
                
                  <div class="form-group">
                    <div class="section-label">Identificação Responsáveis</div>
                    <label class="label-form-cadastro">Nome da Mãe</label><input name="nome-mae" class="input-form-cadastro" type="text" placeholder="Digite o nome da Mãe">
                    <label class="label-form-cadastro">CPF da Mãe</label><input name="cpf-mae" class="input-form-cadastro" type="text" placeholder="Digite o CPF da Mãe">
                    <label class="label-form-cadastro">Nome do Pai</label><input name="nome-pai" class="input-form-cadastro" type="text" placeholder="Digite o nome do Pai">
                    <label class="label-form-cadastro">CPF do Pai</label><input name="cpf-pai" class="input-form-cadastro" type="text" placeholder="Digite o CPF do Pai">
                    <label class="label-form-cadastro">Nome do Responsável</label><input name="nome-responsavel" class="input-form-cadastro" type="text" placeholder="Digite o nome do Responsável">
                    <label class="label-form-cadastro">CPF do Responsável</label><input name="cpf-responsavel" class="input-form-cadastro" type="text" placeholder="Digite o CPF do Responsável">
                  </div>
                  
                  <div class="form-group">
                    <div class="section-label">Endereço</div>
                    <label class="label-form-cadastro">Rua</label><input name="rua" class="input-form-cadastro" type="text" placeholder="Digite o nome da rua">
                    <label class="label-form-cadastro">Número</label><input name="numero" class="input-form-cadastro" type="text" placeholder="Digite o número da residência">
                    <label class="label-form-cadastro">Bairro</label><input name="bairro" class="input-form-cadastro" type="text" placeholder="Digite o nome do bairro">
                    <label class="label-form-cadastro">Município</label><input name="municipio" class="input-form-cadastro" type="text" placeholder="Digite o nome do município">
                    <label class="label-form-cadastro">UF</label><input name="uf" class="input-form-cadastro" type="text" placeholder="Digite o nome do estado" maxlength="2">
                    <label class="label-form-cadastro">CEP</label><input name="cep" class="input-form-cadastro" type="text" placeholder="Digite o CEP">
                  </div>
                  
                  <div class="form-group">
                    <div class="section-label">Dados sociais</div>
                    <label class="label-form-cadastro">Renda familiar (R$)</label><input name="renda" class="input-form-cadastro" type="number" placeholder="0,00">
                    <label class="label-form-cadastro">Status</label>
                      <select name="status" class="input-form-cadastro">
                        <option>pendente</option>
                        <option>ativo</option>
                        <option>inativo</option>
                      </select>
                    <label class="label-form-cadastro">Situação de risco social</label>
                      <select name="situacao-risco" class="input-form-cadastro">
                        <option value="">— selecione —</option>
                        <option>I - Crianças e adolescentes com medida de proteção</option>
                        <option>II - Trabalho infantil</option>
                        <option>III - Vivência de violência ou negligência</option>
                        <option>IV - Abuso e exploração sexual</option>
                        <option>V - Crianças e adolescentes fora da escola</option>
                        <option>VI - Jovens egressos de medida socioeducativa</option>
                        <option>VII - Pessoas com deficiência (PcD)</option>
                        <option>VIII - Idosos em situação de fragilidade</option>
                        <option>IX - Famílias beneficiárias de transferência de renda</option>
                        <option>X - Pessoas em situação de rua</option>
                        <option>XI - Vulnerabilidade por estigmatização</option>
                      </select>
                  </div>

                  <div class="form-group">
                    <div class="section-label">Possui CadÚnico?</div>
                    <input type="radio" id="sim-cadUnico" name="cad-unico" value="sim-cadUnico">
                    <label for="sim-cadUnico">Sim</label>
                    <input type="radio" id="nao-cadUnico" name="cad-unico" value="nao-cadUnico">
                    <label for="nao-cadUnico">Não</label>
                  </div>

                  <div class="form-group">
                    <div class="section-label">Benefícios recebidos</div>
                    <div class="beneficios-grid">
                      <label class="beneficio-item"><input value="Bolsa Família" name="beneficio[]" type="checkbox"> Bolsa Família</label>
                      <label class="beneficio-item"><input value="BPC" name="beneficio[]" type="checkbox"> BPC</label>
                      <label class="beneficio-item"><input value="Auxílio Brasil" name="beneficio[]" type="checkbox"> Auxílio Brasil</label>
                      <label class="beneficio-item"><input value="Outro" name="beneficio[]" type="checkbox"> Outro</label>
                    </div>
  
                    <label class="label-form-cadastro">Motivo de desligamento</label>
                      <select name="motivo-desligamento" class="input-form-cadastro" id="select-motivo" onchange="toggleMotivo()">
                        <option value="">— selecione —</option>
                        <option>Atingiu o limite de idade</option>
                        <option>Mudança de município</option>
                        <option>Outro</option>
                      </select>
                    <label class="label-form-cadastro">Descreva o motivo</label><input name="motivo-desligamento" class="input-form-cadastro" type="text"
                        placeholder="Digite o motivo...">
                  </div>

                <div class="modal-footer">
                  <button class="btn-cancelar"
                    onclick="document.getElementById('overlay').classList.remove('open')">Cancelar</button>
                </div>
                <div class="modal-footer">
                  <button class="btn-salvar">Salvar usuário</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</body>

</html>