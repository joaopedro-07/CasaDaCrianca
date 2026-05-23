-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 23/05/2026 às 16:05
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

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
(6, 'victor', 'victorkoba08@gmail.com', '$2y$10$8KjG9vV.HkM6mX5mR8uL9uO.k7zG9zG9zG9zG9zG9zG9zG9', '444', 'Masculino', '1234239954'),
(7, '12345', '12345@gmail.com', '$2y$10$m1Y8mSSWlePmyFKN2yrbBe1q9Gpt2psBr2i4f2hJn2i6PxKFRoboO', '41209914824', 'Masculino', '12981765867');

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

--
-- Despejando dados para a tabela `tb_adultos`
--

INSERT INTO `tb_adultos` (`id`, `nome`, `cpf`, `grau_parentesco`, `telefone`) VALUES
(15, 'Maria Lima', '011.011.011-01', 'Mãe', '(12) 99111-0001'),
(16, 'José Souza', '022.022.022-02', 'Pai', '(12) 99111-0002'),
(17, 'Ana Mendes', '033.033.033-03', 'Mãe', '(12) 99111-0003'),
(18, 'Carlos Ferreira', '044.044.044-04', 'Pai', '(12) 99111-0004'),
(19, 'Patrícia Costa', '055.055.055-05', 'Mãe', '(12) 99111-0005'),
(20, 'Roberto Rocha', '066.066.066-06', 'Pai', '(12) 99111-0006'),
(21, 'Fernanda Alves', '077.077.077-07', 'Mãe', '(12) 99111-0007'),
(22, 'Ricardo Nunes', '088.088.088-08', 'Pai', '(12) 99111-0008'),
(23, 'Cláudia Pinto', '099.099.099-09', 'Mãe', '(12) 99111-0009'),
(24, 'Marcos Gomes', '010.010.010-10', 'Pai', '(12) 99111-0010'),
(25, 'Luciana Ribeiro', '021.021.021-21', 'Mãe', '(12) 99111-0011'),
(26, 'André Nascimento', '032.032.032-32', 'Pai', '(12) 99111-0012'),
(27, 'Simone Oliveira', '043.043.043-43', 'Mãe', '(12) 99111-0013'),
(28, 'Paulo Santos', '054.054.054-54', 'Pai', '(12) 99111-0014'),
(29, 'Renata Carvalho', '065.065.065-65', 'Mãe', '(12) 99111-0015'),
(30, 'Eduardo Vieira', '076.076.076-76', 'Pai', '(12) 99111-0016'),
(31, 'Juliana Barbosa', '087.087.087-87', 'Mãe', '(12) 99111-0017'),
(32, 'Thiago Teixeira', '098.098.098-98', 'Pai', '(12) 99111-0018'),
(33, 'Vanessa Moreira', '019.019.019-19', 'Mãe', '(12) 99111-0019');

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

--
-- Despejando dados para a tabela `tb_criancas`
--

INSERT INTO `tb_criancas` (`id`, `matricula`, `nis`, `cpf`, `nome`, `status`, `data_entrada`, `data_nasc`, `cidade_nasc`, `pai_id`, `mae_id`, `responsavel_legal_id`, `endereco_id`, `familia_id`) VALUES
(80, 100001, '12345678901', '111.111.111-11', 'Ana Lima', 'ativo', '2022-03-10', '2015-06-14', 'Caçapava', NULL, NULL, 15, 12, NULL),
(81, 100002, '12345678902', '222.222.222-22', 'Bruno Souza', 'ativo', '2021-08-22', '2014-11-03', 'Caçapava', NULL, NULL, 16, 13, NULL),
(82, 100003, '12345678903', '333.333.333-33', 'Carla Mendes', 'ativo', '2023-01-15', '2016-04-20', 'Caçapava', NULL, NULL, 17, 14, NULL),
(83, 100004, '12345678904', '444.444.444-44', 'Daniel Ferreira', 'ativo', '2022-07-08', '2013-09-27', 'Caçapava', NULL, NULL, 18, 15, NULL),
(84, 100005, '12345678905', '555.555.555-55', 'Eduarda Costa', 'ativo', '2020-11-30', '2012-02-11', 'Caçapava', NULL, NULL, 19, 16, NULL),
(85, 100006, '12345678906', '666.666.666-66', 'Felipe Rocha', 'ativo', '2023-05-18', '2017-07-30', 'Caçapava', NULL, NULL, 20, 17, NULL),
(86, 100007, '12345678907', '777.777.777-77', 'Gabriela Alves', 'ativo', '2021-02-14', '2015-12-05', 'Caçapava', NULL, NULL, 21, 18, NULL),
(87, 100008, '12345678908', '888.888.888-88', 'Henrique Nunes', 'ativo', '2022-09-01', '2014-03-18', 'Caçapava', NULL, NULL, 22, 19, NULL),
(88, 100009, '12345678909', '999.999.999-99', 'Isabela Pinto', 'ativo', '2020-06-25', '2013-08-09', 'Caçapava', NULL, NULL, 23, 20, NULL),
(89, 100010, '12345678910', '100.100.100-10', 'João Pedro Gomes', 'ativo', '2023-03-07', '2016-01-22', 'Caçapava', NULL, NULL, 24, 21, NULL),
(90, 100011, '12345678911', '111.111.111-00', 'Kauã Ribeiro', 'inativo', '2019-04-12', '2012-10-14', 'Caçapava', NULL, NULL, 25, 22, NULL),
(91, 100012, '12345678912', '122.122.122-12', 'Laura Nascimento', 'ativo', '2022-12-20', '2015-05-31', 'Caçapava', NULL, NULL, 26, 23, NULL),
(92, 100013, '12345678913', '133.133.133-13', 'Mateus Oliveira', 'ativo', '2021-10-03', '2014-07-16', 'Caçapava', NULL, NULL, 27, 24, NULL),
(93, 100014, '12345678914', '144.144.144-14', 'Natália Santos', 'ativo', '2023-07-11', '2017-03-08', 'Caçapava', NULL, NULL, 28, 25, NULL),
(94, 100015, '12345678915', '155.155.155-15', 'Otávio Carvalho', 'inativo', '2020-02-28', '2013-11-25', 'Caçapava', NULL, NULL, 29, 26, NULL),
(95, 100016, '12345678916', '166.166.166-16', 'Patrícia Vieira', 'ativo', '2022-05-16', '2016-09-03', 'Caçapava', NULL, NULL, 30, 27, NULL),
(96, 100017, '12345678917', '177.177.177-17', 'Rafael Barbosa', 'ativo', '2021-06-09', '2015-02-17', 'Caçapava', NULL, NULL, 31, 28, NULL),
(97, 100018, '12345678918', '188.188.188-18', 'Sabrina Teixeira', 'ativo', '2023-09-23', '2017-11-29', 'Caçapava', NULL, NULL, 32, 29, NULL),
(98, 100019, '12345678919', '199.199.199-19', 'Thiago Moreira', 'ativo', '2020-08-17', '2014-06-04', 'Caçapava', NULL, NULL, 33, 30, NULL);

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

--
-- Despejando dados para a tabela `tb_enderecos`
--

INSERT INTO `tb_enderecos` (`id`, `cep`, `logradouro`, `bairro`, `cidade`, `estado`, `numero`, `complemento`) VALUES
(12, '12280-000', 'Rua das Acácias', 'Jardim Panorama', 'Caçapava', 'SP', '10', NULL),
(13, '12280-010', 'Av. Dom Pedro I', 'Sapé I', 'Caçapava', 'SP', '200', NULL),
(14, '12281-000', 'Rua Floriano Peixoto', 'Sapé II', 'Caçapava', 'SP', '55', NULL),
(15, '12281-010', 'Rua São João', 'Parque Residencial Maria Elmira', 'Caçapava', 'SP', '88', NULL),
(16, '12281-020', 'Rua das Palmeiras', 'Parque Residencial Nova Caçapava', 'Caçapava', 'SP', '14', NULL),
(17, '12282-000', 'Rua Sete de Setembro', 'Residencial Esperança', 'Caçapava', 'SP', '321', NULL),
(18, '12282-010', 'Rua Ipiranga', 'Vila Menino Jesus', 'Caçapava', 'SP', '77', NULL),
(19, '12283-000', 'Rua Campos Sales', 'Borda da Mata', 'Caçapava', 'SP', '9', NULL),
(20, '12283-010', 'Rua Marechal Deodoro', 'Tataúba', 'Caçapava', 'SP', '130', NULL),
(21, '12283-020', 'Rua XV de Novembro', 'Roseirinha', 'Caçapava', 'SP', '45', NULL),
(22, '12283-030', 'Rua das Flores', 'Piedade', 'Caçapava', 'SP', '67', NULL),
(23, '12284-000', 'Rua Prudente de Morais', 'Tijuco Preto', 'Caçapava', 'SP', '19', NULL),
(24, '12284-010', 'Rua Santos Dumont', 'Perinho', 'Caçapava', 'SP', '250', NULL),
(25, '12285-000', 'Rua Rui Barbosa', 'Vila Favorino', 'Caçapava', 'SP', '33', NULL),
(26, '12285-010', 'Rua Tiradentes', 'Jardim Rafael', 'Caçapava', 'SP', '102', NULL),
(27, '12285-020', 'Rua José Bonifácio', 'Jardim Campo Grande', 'Caçapava', 'SP', '8', NULL),
(28, '12286-000', 'Rua Visconde de Taunay', 'Parque Residencial Alvorada', 'Caçapava', 'SP', '500', NULL),
(29, '12286-010', 'Rua das Orquídeas', 'Santa Luzia II', 'Caçapava', 'SP', '73', NULL),
(30, '12287-000', 'Av. Brasil', 'Portal Mantiqueira', 'Caçapava', 'SP', '411', NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `tb_adultos`
--
ALTER TABLE `tb_adultos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de tabela `tb_criancas`
--
ALTER TABLE `tb_criancas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT de tabela `tb_enderecos`
--
ALTER TABLE `tb_enderecos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

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
