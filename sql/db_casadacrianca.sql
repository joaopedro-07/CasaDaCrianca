-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 11/05/2026 às 19:17
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `db_casadacrianca`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `administradores`
--

CREATE TABLE `administradores` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `cpf` char(11) NOT NULL,
  `genero` enum('Masculino','Feminino','Outro','Prefiro não dizer') NOT NULL,
  `telefone` varchar(23) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `administradores`
--

INSERT INTO `administradores` (`id`, `nome`, `email`, `senha`, `cpf`, `genero`, `telefone`) VALUES
(1, 'João Pedro', 'jotapepe.machado@gmail.com', '$2y$10$m/JmD2WExynkpa9NxdcU7OfP937sR9CiVq/w3ekxKDdrauvheC5qK', '47847633841', 'Masculino', '12 988982050'),
(4, 'Administrador', 'admin@gmail.com', '$2y$10$cmAvukFQaVAV/LKDA52AMuoXj4Ns4mkam2rM0EflO6Ds0hI8GA6Ga', '12345678910', 'Masculino', '12986358088'),
(5, 'Victor', 'victor@gmail.com', '123456', '4783299321', 'Masculino', '1234239954'),
(6, 'victor', 'victorkoba08@gmail.com', '$2y$10$8KjG9vV.HkM6mX5mR8uL9uO.k7zG9zG9zG9zG9zG9zG9zG9', '444', 'Masculino', '1234239954');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_adultos`
--

CREATE TABLE `tb_adultos` (
  `id` int(11) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `cpf` varchar(14) DEFAULT NULL,
  `grau_parentesco` varchar(50) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_criancas`
--

CREATE TABLE `tb_criancas` (
  `id` int(11) NOT NULL,
  `matricula` int(11) NOT NULL,
  `nis` varchar(50) NOT NULL,
  `cpf` varchar(50) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `status` enum('ativo','inativo','pendente') NOT NULL DEFAULT 'pendente',
  `data_entrada` date DEFAULT NULL,
  `data_nasc` date NOT NULL,
  `cidade_nasc` varchar(100) NOT NULL,
  `pai_id` int(11) DEFAULT NULL,
  `mae_id` int(11) DEFAULT NULL,
  `responsavel_legal_id` int(11) NOT NULL,
  `endereco_id` int(11) DEFAULT NULL,
  `familia_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_enderecos`
--

CREATE TABLE `tb_enderecos` (
  `id` int(11) NOT NULL,
  `cep` varchar(9) NOT NULL,
  `logradouro` varchar(255) DEFAULT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `cidade` varchar(100) NOT NULL,
  `estado` char(2) NOT NULL,
  `numero` varchar(10) DEFAULT NULL,
  `complemento` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_historico_status`
--

CREATE TABLE `tb_historico_status` (
  `id` int(11) NOT NULL,
  `crianca_id` int(11) NOT NULL,
  `status_anterior` enum('ativo','inativo','pendente') DEFAULT NULL,
  `status_novo` enum('ativo','inativo','pendente') NOT NULL,
  `data_mudanca` datetime DEFAULT current_timestamp(),
  `motivo_desligamento` enum('Atingiu o limite de idade','Mudança de município','Outro') DEFAULT NULL,
  `motivo_outro` varchar(255) DEFAULT NULL,
  `observacao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_info_socioeconomica`
--

CREATE TABLE `tb_info_socioeconomica` (
  `id` int(11) NOT NULL,
  `renda_familiar` decimal(10,2) DEFAULT 0.00,
  `cad_unico` varchar(3) DEFAULT NULL,
  `recebe_beneficio` varchar(3) DEFAULT '0',
  `situacao_risco_social` enum('I - Crianças e adolescentes com medida de proteção','II - Trabalho infantil','III - Vivência de violência ou negligência','IV - Abuso e exploração sexual','V - Crianças e adolescentes fora da escola','VI - Jovens egressos de cumprimento de medida socioeducativa','VII - Pessoas com deficiência (PcD)','VIII - Idosos em situação de fragilidade','IX - Famílias beneficiárias de transferência de renda','X - Pessoas em situação de rua','XI - Vulnerabilidade por estigmatização') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `cpf` (`cpf`);

--
-- Índices de tabela `tb_adultos`
--
ALTER TABLE `tb_adultos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpf` (`cpf`);

--
-- Índices de tabela `tb_criancas`
--
ALTER TABLE `tb_criancas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `matricula` (`matricula`),
  ADD UNIQUE KEY `nis` (`nis`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD KEY `FK_Pai` (`pai_id`),
  ADD KEY `FK_Mae` (`mae_id`),
  ADD KEY `FK_Responsavel` (`responsavel_legal_id`),
  ADD KEY `FK_CriancaEndereco` (`endereco_id`),
  ADD KEY `FK_CriancaFamilia` (`familia_id`);

--
-- Índices de tabela `tb_enderecos`
--
ALTER TABLE `tb_enderecos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tb_historico_status`
--
ALTER TABLE `tb_historico_status`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_LogCrianca` (`crianca_id`);

--
-- Índices de tabela `tb_info_socioeconomica`
--
ALTER TABLE `tb_info_socioeconomica`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `administradores`
--
ALTER TABLE `administradores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `tb_adultos`
--
ALTER TABLE `tb_adultos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `tb_criancas`
--
ALTER TABLE `tb_criancas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `tb_enderecos`
--
ALTER TABLE `tb_enderecos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `tb_historico_status`
--
ALTER TABLE `tb_historico_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_info_socioeconomica`
--
ALTER TABLE `tb_info_socioeconomica`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `tb_criancas`
--
ALTER TABLE `tb_criancas`
  ADD CONSTRAINT `FK_CriancaEndereco` FOREIGN KEY (`endereco_id`) REFERENCES `tb_enderecos` (`id`),
  ADD CONSTRAINT `FK_CriancaFamilia` FOREIGN KEY (`familia_id`) REFERENCES `tb_info_socioeconomica` (`id`),
  ADD CONSTRAINT `FK_Mae` FOREIGN KEY (`mae_id`) REFERENCES `tb_adultos` (`id`),
  ADD CONSTRAINT `FK_Pai` FOREIGN KEY (`pai_id`) REFERENCES `tb_adultos` (`id`),
  ADD CONSTRAINT `FK_Responsavel` FOREIGN KEY (`responsavel_legal_id`) REFERENCES `tb_adultos` (`id`);

--
-- Restrições para tabelas `tb_historico_status`
--
ALTER TABLE `tb_historico_status`
  ADD CONSTRAINT `FK_LogCrianca` FOREIGN KEY (`crianca_id`) REFERENCES `tb_criancas` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
