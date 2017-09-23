-- MySQL Script generated by MySQL Workbench
-- sáb 23 set 2017 15:02:14 -03
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema sigov
-- -----------------------------------------------------
-- Schema inicial

-- -----------------------------------------------------
-- Schema sigov
--
-- Schema inicial
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `sigov` DEFAULT CHARACTER SET utf8 ;
USE `sigov` ;

-- -----------------------------------------------------
-- Table `sigov`.`perfis`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sigov`.`perfis` (
  `idPerfil` INT NOT NULL AUTO_INCREMENT COMMENT = 'Chave primária do tipo INT com auto incremento responsável pelo ID de cada perfil cadastrado na aplicação.',
  `descricaoPerfil` VARCHAR(45) CHARACTER SET 'utf8' NOT NULL COMMENT = 'Campo do tipo VARCHAR(45) contendo a descrição de cada perfil de usuário.',
  PRIMARY KEY (`idPerfil`))
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = utf8
  COMMENT = 'Tabela para armazenar os perfis de usuários'
  PACK_KEYS = DEFAULT;


-- -----------------------------------------------------
-- Table `sigov`.`usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sigov`.`usuarios` (
  `idUsuario` INT NOT NULL AUTO_INCREMENT COMMENT 'Chave primária do tipo INT auto incrementada com o ID de cada Usuário cadastrado na aplicação.',
  `perfil` INT NOT NULL COMMENT 'Chave Estrangeira (FK) do tipo INT utilizado para definir o perfil do usuário e conceder acesso a funcionalidades.',
  `nomeUsuario` VARCHAR(255) CHARACTER SET 'utf8' NOT NULL COMMENT 'Campo do tipo VARCHAR(255) para inserção do nome completo do Usuário.',
  `emailUsuario` VARCHAR(255) CHARACTER SET 'utf8' NOT NULL COMMENT 'Campo do tipo VARCHAR(255) para inserção do e-mail do Usuário.',
  `password` VARCHAR(45) CHARACTER SET 'utf8' NOT NULL COMMENT 'Campo do tipo VARCHAR(45) para inserção da senha de acesso ao Sistema com encriptação fornecida a nível de aplicação.',
  `linkReset` VARCHAR(45) CHARACTER SET 'utf8' NOT NULL COMMENT 'Campo  do tipo VARCHAR(45) contendo o link para cadastramento/mudança de senha criado randomicamente a cada inserção/mudança do campo password com encriptação fornecida no nível da aplicação.',
  PRIMARY KEY (`idUsuario`, `perfil`),
  UNIQUE INDEX `nomeUsuario_UNIQUE` (`nomeUsuario` ASC),
  UNIQUE INDEX `emailUsuario_UNIQUE` (`emailUsuario` ASC),
  INDEX `fk_usuarios_perfis_idx` (`perfil` ASC),
  CONSTRAINT `fk_usuarios_perfis`
  FOREIGN KEY (`perfil`)
  REFERENCES `sigov`.`perfis` (`idPerfil`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = utf8
  COMMENT = 'Tabela responsável por armazenar informações sobre os usuários com acesso ao Sistema SIGov.';


-- -----------------------------------------------------
-- Table `sigov`.`municipios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sigov`.`municipios` (
  `idMunicipio` INT NOT NULL AUTO_INCREMENT COMMENT 'Chave primária do tipo INT com auto incremento responsável pelo ID de cada Município cadastrado na aplicação.',
  `nomeMunicipio` VARCHAR(255) CHARACTER SET 'utf8' NOT NULL COMMENT 'Campo do tipo VARCHAR(255) contendo o nome do município cadastrado.',
  `densidadeDemografica` INT NOT NULL COMMENT 'Campo do tipo INT com a densidade demográfica do município.',
  `densidadePopulacional` INT NOT NULL COMMENT 'Campo do tipo INT com a densidade demográfica do município.',
  `arrecadacaoTributo` INT NOT NULL COMMENT 'Campo do tipo INT com a arrecadação de tributos do município em reais (R$).',
  `sistemaSaude` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Campo TINYINT(1) definido com padrão 0 com a referencia ao uso de Sistemas de Informação da na área de Saúde, será tratado a nível de aplicação como uma variável booleana.',
  `sistemaEducacao` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Campo TINYINT(1) definido com padrão 0 com a referencia ao uso de Sistemas de Informação da na área de Educação, será tratado a nível de aplicação como uma variável booleana.',
  `sistemaPatrimonio` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Campo TINYINT(1) definido com padrão 0 com a referencia ao uso de Sistemas de Informação da na área de Patrimônio, será tratado a nível de aplicação como uma variável booleana.',
  `sistemaExecucao` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Campo TINYINT(1) definido com padrão 0 com a referencia ao uso de Sistemas de Informação da na área de Execução e Gestão, será tratado a nível de aplicação como uma variável booleana.',
  `sistemaFolhaPagamento` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Campo TINYINT(1) definido com padrão 0 com a referencia ao uso de Sistemas de Informação da na área de Folha de Pagamento, será tratado a nível de aplicação como uma variável booleana.',
  `sistemaFuncionarios` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Campo TINYINT(1) definido com padrão 0 com a referencia ao uso de Sistemas de Informação da na área de Cadastro de Funcionários, será tratado a nível de aplicação como uma variável booleana.',
  `responsavelCadastro` INT NOT NULL COMMENT 'Chave Estrangeira (FK) do tipo INT utilizado para registrar o responsável pelo município cadastrado.',
  `criadoEm` TIMESTAMP NULL COMMENT 'Campo do tipo Timestamp() informando a data/hora da criação do dado no DB.',
  `responsavelEdicao` INT NULL COMMENT 'Chave Estrangeira (FK) do tipo INT utilizado para informar o responsável pela edição do município.',
  `editadoEm` TIMESTAMP NULL COMMENT 'Campo do tipo Timestamp() informando a data/hora da edição do dado no DB.',
  PRIMARY KEY (`idMunicipio`),
  INDEX `fk_responsavelCadastro_usuarios_idx` (`responsavelCadastro` ASC),
  INDEX `fk_responsavelEdicao_usuarios_idx` (`responsavelEdicao` ASC),
  CONSTRAINT `fk_responsavelCadastro_usuarios`
  FOREIGN KEY (`responsavelCadastro`)
  REFERENCES `sigov`.`usuarios` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_responsavelEdicao_usuarios`
  FOREIGN KEY (`responsavelEdicao`)
  REFERENCES `sigov`.`usuarios` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = utf8
  COMMENT = 'Tabela responsável por armazenar as informações relativas a Pesquisa de Levantamento de Informações sobre os municípios do Estado da Paraíba';


-- -----------------------------------------------------
-- Table `sigov`.`areaSoftwares`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sigov`.`areaSoftwares` (
  `idAreaSoftwares` INT NOT NULL AUTO_INCREMENT COMMENT = 'Chave primária do tipo INT com auto incremento responsável pelo ID de cada área de software cadastrada na aplicação.',
  `descricaoArea` VARCHAR(45) CHARACTER SET 'utf8' NOT NULL COMMENT = 'Campo do tipo VARCHAR(45) contendo a descrição da área de atuação do software.',
  PRIMARY KEY (`idAreaSoftwares`))
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = utf8
  COMMENT = 'Tabela responsável por armazenar as categorias de software.';


-- -----------------------------------------------------
-- Table `sigov`.`programas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sigov`.`programas` (
  `idProgramas` INT NOT NULL AUTO_INCREMENT COMMENT = 'Chave primária do tipo INT com auto incremento responsável pelo ID de cada programa cadastrado na aplicação.',
  `nomeSoftware` VARCHAR(255) CHARACTER SET 'utf8' NOT NULL COMMENT = 'Campo do tipo VARCHAR(255) contendo o nome do Software.',
  `descricaoSoftware` TEXT CHARACTER SET 'utf8' NOT NULL COMMENT = 'Campo do tipo TEXT contendo a descrição do programa.',
  `requerimentoMemoria` VARCHAR(45) CHARACTER SET 'utf8' NOT NULL COMMENT = 'Campo do tipo VARCHAR(45) contendo o requerimento mínimo de Memória RAM para utilização do software.',
  `requerimentoProcessador` VARCHAR(45) CHARACTER SET 'utf8' NOT NULL COMMENT = 'Campo do tipo VARCHAR(45) contendo o requerimento mínimo de frequência do processador para utilização do software.',
  `requerimentoDisco` VARCHAR(45) CHARACTER SET 'utf8' NOT NULL COMMENT = 'Campo do tipo VARCHAR(45) contendo o requerimento mínimo de espaço em disco para a utilização do software.',
  `requerimentoSoftware` VARCHAR(255) CHARACTER SET 'utf8' NOT NULL COMMENT = 'Campo do tipo VARCHAR(255) contendo os requerimentos mínimos de software e sistemas operacionais.',
  `requerimentoLinguagem` VARCHAR(255) CHARACTER SET 'utf8' NOT NULL COMMENT = 'Campo do tipo VARCHAR(255) contendo o requerimentos da(s) linguagem(ens) de programação para utilização do software.',
  `dataPublicacao` DATE NOT NULL COMMENT = 'Campo do tipo DATE contendo a data de publicação do software.',
  `ultimaAtualizacao` DATE NULL COMMENT = 'Campo do tipo DATE contendo a data de última atualização do software.',
  `areaSoftware` INT NOT NULL COMMENT = 'Chave Estrangeira (FK) do tipo INT utilizado classificar o tipo de software de acordo com os modelos descritos da tabela areaSoftware.',
  `siteSoftware` VARCHAR(45) CHARACTER SET 'utf8' NOT NULL COMMENT = 'Campo do tipo VARCHAR(45) contendo o endereço para o site do desenvolvedor do software.',
  `manualSoftware` VARCHAR(45) CHARACTER SET 'utf8' NOT NULL COMMENT = 'Campo do tipo VARCHAR(45) contendo o endereço/link para o manual do software',
  `observacoes` TEXT CHARACTER SET 'utf8' NULL COMMENT = 'Campo do tipo TEXT que permite ao usuário inserir informações não contempladas em outros campos.',
  `responsavelCadastro` INT NOT NULL COMMENT = 'Chave Estrangeira (FK) do tipo INT utilizado para informar o responsável pelo registro software.',
  `criadoEm` TIMESTAMP NOT NULL COMMENT = 'Campo do tipo Timestamp() informando a data/hora da criação do dado no DB.',
  `responsavelEdicao` INT NULL COMMENT = 'Chave Estrangeira (FK) do tipo INT utilizado para informar o responsável pela edição do software.',
  `editadoEm` TIMESTAMP NULL COMMENT = 'Campo do tipo Timestamp() informando a data/hora da edição do dado no DB.',
  PRIMARY KEY (`idProgramas`),
  INDEX `fk_responsavelCadastro_usuarios_fk_idx` (`responsavelCadastro` ASC),
  INDEX `fk_responsavelEdicao_usuarios_fk_idx` (`responsavelEdicao` ASC),
  INDEX `fk_programas_areaSoftware_fk_idx` (`areaSoftware` ASC),
  CONSTRAINT `fk_responsavelCadastro_usuarios_fk`
  FOREIGN KEY (`responsavelCadastro`)
  REFERENCES `sigov`.`usuarios` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_responsavelEdicao_usuarios_fk`
  FOREIGN KEY (`responsavelEdicao`)
  REFERENCES `sigov`.`usuarios` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_programas_areaSoftware_fk`
  FOREIGN KEY (`areaSoftware`)
  REFERENCES `sigov`.`areaSoftwares` (`idAreaSoftwares`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = utf8
  COMMENT = 'Tabela responsável para armazenar os dados relativos a pesquisa de software';


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `sigov`.`perfis`
-- -----------------------------------------------------
START TRANSACTION;
USE `sigov`;
INSERT INTO `sigov`.`perfis` (`idPerfil`, `descricaoPerfil`) VALUES (1, 'Gestor');
INSERT INTO `sigov`.`perfis` (`idPerfil`, `descricaoPerfil`) VALUES (2, 'Pesquisador');
INSERT INTO `sigov`.`perfis` (`idPerfil`, `descricaoPerfil`) VALUES (3, 'Pesquisador de Software');

COMMIT;


-- -----------------------------------------------------
-- Data for table `sigov`.`areaSoftwares`
-- -----------------------------------------------------
START TRANSACTION;
USE `sigov`;
INSERT INTO `sigov`.`areaSoftwares` (`idAreaSoftwares`, `descricaoArea`) VALUES (1, 'Saúde');
INSERT INTO `sigov`.`areaSoftwares` (`idAreaSoftwares`, `descricaoArea`) VALUES (2, 'Educação');
INSERT INTO `sigov`.`areaSoftwares` (`idAreaSoftwares`, `descricaoArea`) VALUES (3, 'Patrimônio');
INSERT INTO `sigov`.`areaSoftwares` (`idAreaSoftwares`, `descricaoArea`) VALUES (4, 'Execução');
INSERT INTO `sigov`.`areaSoftwares` (`idAreaSoftwares`, `descricaoArea`) VALUES (5, 'Folha de pagamento');
INSERT INTO `sigov`.`areaSoftwares` (`idAreaSoftwares`, `descricaoArea`) VALUES (6, 'Cadastro de funcionários');

COMMIT;
