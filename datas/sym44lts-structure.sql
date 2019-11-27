-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema sym44lts
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema sym44lts
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `sym44lts` DEFAULT CHARACTER SET utf8 ;
USE `sym44lts` ;

-- -----------------------------------------------------
-- Table `sym44lts`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sym44lts`.`user` (
  `iduser` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `thelogin` VARCHAR(50) NOT NULL,
  `thename` VARCHAR(200) NOT NULL,
  `thepwd` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`iduser`),
  UNIQUE INDEX `thelogin_UNIQUE` (`thelogin` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sym44lts`.`categ`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sym44lts`.`categ` (
  `idcateg` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `titre` VARCHAR(80) NOT NULL,
  `slug` VARCHAR(80) NOT NULL,
  `descr` VARCHAR(300) NULL,
  PRIMARY KEY (`idcateg`),
  UNIQUE INDEX `slug_UNIQUE` (`slug` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sym44lts`.`article`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sym44lts`.`article` (
  `idarticle` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `titre` VARCHAR(150) NOT NULL,
  `slug` VARCHAR(150) NOT NULL,
  `texte` TEXT NOT NULL,
  `thedate` DATETIME NULL,
  `user_iduser` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`idarticle`),
  UNIQUE INDEX `slug_UNIQUE` (`slug` ASC),
  INDEX `fk_article_user_idx` (`user_iduser` ASC),
  CONSTRAINT `fk_article_user`
    FOREIGN KEY (`user_iduser`)
    REFERENCES `sym44lts`.`user` (`iduser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sym44lts`.`categ_has_article`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sym44lts`.`categ_has_article` (
  `categ_idcateg` INT UNSIGNED NOT NULL,
  `article_idarticle` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`categ_idcateg`, `article_idarticle`),
  INDEX `fk_categ_has_article_article1_idx` (`article_idarticle` ASC),
  INDEX `fk_categ_has_article_categ1_idx` (`categ_idcateg` ASC),
  CONSTRAINT `fk_categ_has_article_categ1`
    FOREIGN KEY (`categ_idcateg`)
    REFERENCES `sym44lts`.`categ` (`idcateg`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_categ_has_article_article1`
    FOREIGN KEY (`article_idarticle`)
    REFERENCES `sym44lts`.`article` (`idarticle`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
