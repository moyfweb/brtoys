-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: 27/02/2013 às 16h06min
-- Versão do Servidor: 5.5.16
-- Versão do PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `brtoys`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `ecom_carrinho`
--

CREATE TABLE IF NOT EXISTS `ecom_carrinho` (
  `IDCarrinho` bigint(19) unsigned NOT NULL AUTO_INCREMENT,
  `IDSCarrinho` varchar(14) COLLATE utf8_unicode_ci NOT NULL,
  `IDUsuario` int(11) unsigned NOT NULL,
  `IDCliente` int(11) unsigned NOT NULL,
  `DataCadastro` datetime NOT NULL,
  `SituacaoVenda` int(3) unsigned NOT NULL DEFAULT '1',
  `SituacaoEntrega` int(3) unsigned NOT NULL DEFAULT '1',
  `FormaPagamento` int(3) unsigned NOT NULL,
  `DataEntrega` date NOT NULL,
  `HoraEntrega` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `EnderecoEntrega` int(11) unsigned NOT NULL,
  `EmailCobranca` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Observacoes` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`IDCarrinho`),
  UNIQUE KEY `IDSCarrinho` (`IDSCarrinho`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ecom_carrinho_forma_pagamento`
--

CREATE TABLE IF NOT EXISTS `ecom_carrinho_forma_pagamento` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Descricao` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ecom_carrinho_item`
--

CREATE TABLE IF NOT EXISTS `ecom_carrinho_item` (
  `ID` bigint(19) unsigned NOT NULL AUTO_INCREMENT,
  `IDSCarrinho` varchar(14) COLLATE utf8_unicode_ci NOT NULL,
  `IDProduto` int(11) unsigned NOT NULL,
  `QuantidadePacote` int(7) unsigned NOT NULL,
  `Unidades` int(11) unsigned NOT NULL,
  `PrecoPacote` float(11,2) NOT NULL,
  `Status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`),
  KEY `IDSCarrinho` (`IDSCarrinho`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

--
-- Extraindo dados da tabela `ecom_carrinho_item`
--

INSERT INTO `ecom_carrinho_item` (`ID`, `IDSCarrinho`, `IDProduto`, `QuantidadePacote`, `Unidades`, `PrecoPacote`, `Status`) VALUES
(1, '512680163c8c3', 1, 1, 9, 6.00, 1),
(2, '512680163c8c3', 1, 30, 1, 5.60, 1),
(3, '512680163c8c3', 2, 1, 1, 4.50, 1),
(4, '5127bd89ee7a3', 2, 1, 1, 4.50, 1),
(5, '5127bd9915a49', 2, 1, 1, 4.50, 1),
(6, '5127bd89ee7a3', 3, 1, 50, 2.00, 1),
(7, '512bbc30a6813', 3, 1, 23, 2.00, 1),
(8, '512bbc30a6813', 2, 60, 1, 240.00, 1),
(9, '512bbc30a6813', 4, 30, 1, 27.00, 1),
(11, '512bbc30a6813', 3, 20, 11, 38.00, 1),
(12, '512d010ce5022', 3, 20, 4, 38.00, 1),
(13, '512d010ce5022', 3, 1, 1, 2.00, 1),
(14, '512d010ce5022', 4, 30, 8, 27.00, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `ecom_carrinho_sit_entrega`
--

CREATE TABLE IF NOT EXISTS `ecom_carrinho_sit_entrega` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Situacao` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ecom_carrinho_sit_venda`
--

CREATE TABLE IF NOT EXISTS `ecom_carrinho_sit_venda` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Situacao` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ecom_cliente`
--

CREATE TABLE IF NOT EXISTS `ecom_cliente` (
  `IDCliente` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Nome` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Senha` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Status` int(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`IDCliente`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `ecom_cliente`
--

INSERT INTO `ecom_cliente` (`IDCliente`, `Nome`, `Email`, `Senha`, `Status`) VALUES
(1, 'Moyses', 'moyfweb@gmail.com', '1f3a8471c55ef8be99c8791760e0dab3', 1),
(2, 'outro', 'outro@gmail.com', '712d01b1450ac770a9849f53fd5ad7fa', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `ecom_cliente_contato`
--

CREATE TABLE IF NOT EXISTS `ecom_cliente_contato` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `IDCliente` int(11) unsigned NOT NULL,
  `IDContato` bigint(19) unsigned NOT NULL,
  `Status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `ecom_cliente_contato`
--

INSERT INTO `ecom_cliente_contato` (`ID`, `IDCliente`, `IDContato`, `Status`) VALUES
(1, 1, 6, -1),
(2, 1, 7, 1),
(3, 1, 9, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `ecom_cliente_endereco`
--

CREATE TABLE IF NOT EXISTS `ecom_cliente_endereco` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `IDCliente` int(11) unsigned NOT NULL,
  `IDEndereco` int(11) unsigned NOT NULL,
  `Status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Extraindo dados da tabela `ecom_cliente_endereco`
--

INSERT INTO `ecom_cliente_endereco` (`ID`, `IDCliente`, `IDEndereco`, `Status`) VALUES
(1, 1, 1, -1),
(2, 1, 2, -1),
(3, 1, 3, 1),
(4, 1, 4, -1),
(5, 1, 5, 1),
(6, 1, 16, 1),
(7, 1, 17, 1),
(8, 2, 18, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `ecom_cliente_foto`
--

CREATE TABLE IF NOT EXISTS `ecom_cliente_foto` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `IDCliente` int(11) unsigned NOT NULL,
  `IDFoto` bigint(19) unsigned NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ecom_compra`
--

CREATE TABLE IF NOT EXISTS `ecom_compra` (
  `IDCompra` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `IDCliente` int(11) unsigned NOT NULL,
  `IDProduto` int(11) unsigned NOT NULL,
  `IDCarrinho` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Data` date NOT NULL,
  `Quantidade` decimal(10,3) NOT NULL,
  `Ativo` int(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`IDCompra`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ecom_contato`
--

CREATE TABLE IF NOT EXISTS `ecom_contato` (
  `IDContato` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `IDTipo` int(10) unsigned NOT NULL,
  `Valor` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`IDContato`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Extraindo dados da tabela `ecom_contato`
--

INSERT INTO `ecom_contato` (`IDContato`, `IDTipo`, `Valor`) VALUES
(1, 3, 'moyses@ubis.com.br'),
(2, 1, '(41) 3042-5290'),
(3, 3, 'moyses@ub8is.com.br'),
(4, 1, '30424529'),
(5, 1, '30424529'),
(6, 1, '30424529'),
(7, 2, '(41) 3042-4529'),
(8, 1, '444'),
(9, 5, 'moyses.oliveira');

-- --------------------------------------------------------

--
-- Estrutura da tabela `ecom_contato_tipo`
--

CREATE TABLE IF NOT EXISTS `ecom_contato_tipo` (
  `IDTipo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Tipo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`IDTipo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Extraindo dados da tabela `ecom_contato_tipo`
--

INSERT INTO `ecom_contato_tipo` (`IDTipo`, `Tipo`) VALUES
(1, 'Telefone'),
(2, 'Celular'),
(3, 'E-mail'),
(4, 'Website'),
(5, 'Facebook'),
(6, 'Twiter'),
(7, 'MSN'),
(8, 'Linked In');

-- --------------------------------------------------------

--
-- Estrutura da tabela `ecom_endereco`
--

CREATE TABLE IF NOT EXISTS `ecom_endereco` (
  `IDEndereco` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Descricao` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Pais` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Brasil',
  `Estado` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Cidade` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Bairro` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Logadouro` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Numero` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Complemento` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `CEP` int(8) NOT NULL,
  PRIMARY KEY (`IDEndereco`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=19 ;

--
-- Extraindo dados da tabela `ecom_endereco`
--

INSERT INTO `ecom_endereco` (`IDEndereco`, `Descricao`, `Pais`, `Estado`, `Cidade`, `Bairro`, `Logadouro`, `Numero`, `Complemento`, `CEP`) VALUES
(1, 'teste', 'teste', 'teste', 'etete', 'tte', 'te', 'tetette', 'tetet', 44),
(2, 'teste', 'teste', 'teste', 'etete', 'tte', 'te', 'tetette', 'tetet', 44),
(3, 'Exemplo 1', 'asd', 'sad', 'sdf', 'ffsd', 'sadfa', 'fdaf', 'fsf', 0),
(4, 'teste2', 'sd', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', 45),
(5, 'Exemplo 2', 'Brasil', 'PR', 'Curitiba', 'Uberaba', 'Rua Henrique Mehl', '51', 'Casa 76', 81560140),
(6, 'Novo', 'novo', 'non', 'on', 'on', 'on', 'ono', 'nono', 0),
(7, 'teste', 'teste', 'tea', 'sddsa', 'adasda', 'sdasdsadas', 'sdasd', 'asdsasda', 0),
(8, 'TERASFDASD', 'DASDA', 'SADSA', 'DSADS', '45643BSDFS', 'ADASD', 'ASDAS', 'DSAD', 0),
(9, 'TERASFDASD', 'DASDA', 'SADSA', 'DSADS', '45643BSDFS', 'ADASD', 'ASDAS', 'DSAD', 0),
(10, 'TERASFDASD', 'DASDA', 'SADSA', 'DSADS', '45643BSDFS', 'ADASD', 'ASDAS', 'DSAD', 0),
(11, 'TERASFDASD', 'DASDA', 'SADSA', 'DSADS', '45643BSDFS', 'ADASD', 'ASDAS', 'DSAD', 0),
(12, 'TERASFDASD', 'DASDA', 'SADSA', 'DSADS', '45643BSDFS', 'ADASD', 'ASDAS', 'DSAD', 0),
(13, 'TERASFDASD', 'DASDA', 'SADSA', 'DSADS', '45643BSDFS', 'ADASD', 'ASDAS', 'DSAD', 0),
(14, 'TERASFDASD', 'DASDA', 'SADSA', 'DSADS', '45643BSDFS', 'ADASD', 'ASDAS', 'DSAD', 0),
(15, 'TERASFDASD', 'DASDA', 'SADSA', 'DSADS', '45643BSDFS', 'ADASD', 'ASDAS', 'DSAD', 0),
(16, 'teste', 'tesads', 'asd', 'asdasd', 'asdasd', 'asdsa', 'dsadsad', 'asddas', 81560140),
(17, 'teste', 'tesads', 'asd', 'asdasd', 'asdasd', 'asdsa', 'dsadsad', 'asddas', 81560140),
(18, 'Teste', 'Teste', 'teste', 'etasdas', 'asd', 'asd', 'dsads', 'asdsad', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `ecom_foto`
--

CREATE TABLE IF NOT EXISTS `ecom_foto` (
  `IDFoto` bigint(19) unsigned NOT NULL AUTO_INCREMENT,
  `Arquivo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Tamanho` decimal(10,3) NOT NULL,
  `Nome` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Descricao` text COLLATE utf8_unicode_ci NOT NULL,
  `Status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`IDFoto`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `ecom_foto`
--

INSERT INTO `ecom_foto` (`IDFoto`, `Arquivo`, `Tamanho`, `Nome`, `Descricao`, `Status`) VALUES
(1, '5126678e39295.jpg', 26.443, 'teste', 'teste', 1),
(2, '5126679f19ec7.jpg', 104.547, 'AVESTRUZ', '45', 1),
(3, '512510da1efc4.jpg', 72.850, 'SamuraiX 3', '', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `ecom_produto`
--

CREATE TABLE IF NOT EXISTS `ecom_produto` (
  `IDProduto` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `IDCategoria` int(11) unsigned NOT NULL DEFAULT '0',
  `Nome` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Descricao` text COLLATE utf8_unicode_ci NOT NULL,
  `Preco` decimal(10,2) NOT NULL,
  `PrecoCaixa` decimal(10,2) NOT NULL,
  `ItensCaixa` int(5) NOT NULL,
  `Validade` date DEFAULT NULL,
  `Peso` decimal(10,3) DEFAULT NULL,
  `Altura` decimal(10,2) DEFAULT NULL,
  `Largura` decimal(10,2) DEFAULT NULL,
  `Comprimento` decimal(10,2) DEFAULT NULL,
  `Status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`IDProduto`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `ecom_produto`
--

INSERT INTO `ecom_produto` (`IDProduto`, `IDCategoria`, `Nome`, `Descricao`, `Preco`, `PrecoCaixa`, `ItensCaixa`, `Validade`, `Peso`, `Altura`, `Largura`, `Comprimento`, `Status`) VALUES
(2, 1, 'Cavalo de Plástico', 'É um Cavalo de Plastico =O', 4.50, 4.00, 60, '1987-05-28', 0.600, 0.44, 0.77, 0.33, 1),
(3, 1, 'Pen Drive 8GB Kingstone', 'Teste', 2.00, 1.90, 20, NULL, 1.111, 0.01, 0.01, 0.01, 1),
(4, 0, 'Copo de Vidro EChin', 'D', 1.00, 0.90, 30, NULL, 0.000, 0.00, 0.00, 0.00, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `ecom_produto_categoria`
--

CREATE TABLE IF NOT EXISTS `ecom_produto_categoria` (
  `IDCategoria` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `Categoria` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Descricao` text COLLATE utf8_unicode_ci NOT NULL,
  `Status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`IDCategoria`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `ecom_produto_categoria`
--

INSERT INTO `ecom_produto_categoria` (`IDCategoria`, `Categoria`, `Descricao`, `Status`) VALUES
(1, 'CE1', 'CE_1', 1),
(2, 'ANTIGO', 'sadas', 1),
(3, 'teste', 'teste', 1),
(4, 'Exemplo Editar', 'dsffsadfsd', -1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `ecom_produto_foto`
--

CREATE TABLE IF NOT EXISTS `ecom_produto_foto` (
  `ID` bigint(19) unsigned NOT NULL AUTO_INCREMENT,
  `IDProduto` int(11) unsigned NOT NULL,
  `IDFoto` bigint(19) unsigned NOT NULL,
  `Status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `ecom_produto_foto`
--

INSERT INTO `ecom_produto_foto` (`ID`, `IDProduto`, `IDFoto`, `Status`) VALUES
(1, 3, 1, -1),
(2, 3, 2, 1),
(3, 3, 3, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `ecom_produto_promocao`
--

CREATE TABLE IF NOT EXISTS `ecom_produto_promocao` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `IDProduto` int(11) unsigned NOT NULL,
  `Preco` decimal(10,2) NOT NULL,
  `PromoInicio` date NOT NULL,
  `PromoFim` date NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `IDProduto` (`IDProduto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ecom_usuario`
--

CREATE TABLE IF NOT EXISTS `ecom_usuario` (
  `IDUsuario` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `IDTipo` int(11) unsigned NOT NULL,
  `Nome` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Senha` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`IDUsuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `ecom_usuario`
--

INSERT INTO `ecom_usuario` (`IDUsuario`, `IDTipo`, `Nome`, `Email`, `Senha`, `Status`) VALUES
(1, 1, 'Moysés Oliveira', 'moyfweb@gmail.com', '1f3a8471c55ef8be99c8791760e0dab3', 1),
(3, 3, 'novo', 'novo@novo.com', '6b0aad3ed14f037654be19a3576801ab', -1),
(4, 3, 'Outro', 'outro@outro.com.br', '8832364f9f5eee5ec0f24e405b52a38b', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `ecom_usuario_contato`
--

CREATE TABLE IF NOT EXISTS `ecom_usuario_contato` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `IDUsuario` int(11) unsigned NOT NULL,
  `IDContato` bigint(19) unsigned NOT NULL,
  `Status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Extraindo dados da tabela `ecom_usuario_contato`
--

INSERT INTO `ecom_usuario_contato` (`ID`, `IDUsuario`, `IDContato`, `Status`) VALUES
(1, 1, 1, -1),
(2, 1, 2, 1),
(3, 1, 3, 1),
(4, 3, 4, 1),
(5, 1, 2, 1),
(6, 1, 3, 1),
(7, 1, 8, -1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `ecom_usuario_endereco`
--

CREATE TABLE IF NOT EXISTS `ecom_usuario_endereco` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `IDUsuario` int(11) unsigned NOT NULL,
  `IDEndereco` int(11) unsigned NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ecom_usuario_tipo`
--

CREATE TABLE IF NOT EXISTS `ecom_usuario_tipo` (
  `IDTipo` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Tipo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`IDTipo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `ecom_usuario_tipo`
--

INSERT INTO `ecom_usuario_tipo` (`IDTipo`, `Tipo`) VALUES
(1, 'Moderador'),
(2, 'Administrador'),
(3, 'Custom');

--
-- Restrições para as tabelas dumpadas
--

--
-- Restrições para a tabela `ecom_produto_promocao`
--
ALTER TABLE `ecom_produto_promocao`
  ADD CONSTRAINT `ecom_produto_promocao_ibfk_1` FOREIGN KEY (`IDProduto`) REFERENCES `ecom_produto` (`IDProduto`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
