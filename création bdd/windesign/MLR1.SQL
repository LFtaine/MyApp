REM -----------------------------------------------------------------------------
REM                Génération d'une base de données
REM                         SQL Générique (SQL 2)
REM                           (14/5/2026 19:17:48)
REM -----------------------------------------------------------------------------
REM      Nom de la base : MLR1
REM      Projet : Espace de travail
REM      Auteur : FONTAINE Louis
REM      Date de dernière modification : 14/5/2026 19:17:29
REM -----------------------------------------------------------------------------

DROP TABLE LIVE_ACTION;

DROP TABLE ANIME;

DROP TABLE STATUT;

DROP TABLE MANGA;

DROP TABLE STUDIO;

DROP TABLE TEXTE;

DROP TABLE CATEGORIE;

DROP TABLE SERIE;

DROP TABLE LN;

DROP TABLE AVANCEE;

DROP TABLE MANWHA;

DROP TABLE ACHAT;

DROP TABLE AUTEUR;

DROP TABLE PRODUIRE;

DROP TABLE RANGER;

DROP TABLE ECRIRE;

DROP TABLE CLASSER;

REM -----------------------------------------------------------------------------
REM       TABLE : LIVE_ACTION
REM -----------------------------------------------------------------------------

CREATE TABLE LIVE_ACTION
   (
   LA_CODE INTEGER NOT NULL ,
   SERIE_CODE INTEGER NOT NULL ,
   LA_NOM VARCHAR(1000)  
,
     PRIMARY KEY (LA_CODE) CONSTRAINT PK_LIVE_ACTION
   );

REM -----------------------------------------------------------------------------
REM       INDEX DE LA TABLE LIVE_ACTION
REM -----------------------------------------------------------------------------

CREATE  INDEX I_FK_LIVE_ACTION_SERIE
     ON LIVE_ACTION (SERIE_CODE ASC);

REM -----------------------------------------------------------------------------
REM       TABLE : ANIME
REM -----------------------------------------------------------------------------

CREATE TABLE ANIME
   (
   CODE_ANIME INTEGER NOT NULL ,
   SERIE_CODE INTEGER NOT NULL ,
   NB_EPISODES INTEGER  ,
   SERIE_DATE_D DATE  ,
   SERIE_DATE_F DATE  
,
     PRIMARY KEY (CODE_ANIME) CONSTRAINT PK_ANIME
   );

REM -----------------------------------------------------------------------------
REM       INDEX DE LA TABLE ANIME
REM -----------------------------------------------------------------------------

CREATE  INDEX I_FK_ANIME_SERIE
     ON ANIME (SERIE_CODE ASC);

REM -----------------------------------------------------------------------------
REM       TABLE : STATUT
REM -----------------------------------------------------------------------------

CREATE TABLE STATUT
   (
   STATUT_CODE CHAR(32) NOT NULL ,
   STATUT_LIBELLLE VARCHAR(1000)  
,
     PRIMARY KEY (STATUT_CODE) CONSTRAINT PK_STATUT
   );

REM -----------------------------------------------------------------------------
REM       TABLE : MANGA
REM -----------------------------------------------------------------------------

CREATE TABLE MANGA
   (
   CODE_MANGA INTEGER NOT NULL ,
   SERIE_CODE INTEGER NOT NULL ,
   NB_CHAPITRES INTEGER  ,
   NB_TOMES INTEGER  ,
   SERIE_DATE_D DATE  ,
   SERIE_DATE_F DATE  
,
     PRIMARY KEY (CODE_MANGA) CONSTRAINT PK_MANGA
   );

REM -----------------------------------------------------------------------------
REM       INDEX DE LA TABLE MANGA
REM -----------------------------------------------------------------------------

CREATE  INDEX I_FK_MANGA_TEXTE
     ON MANGA (SERIE_CODE ASC);

REM -----------------------------------------------------------------------------
REM       TABLE : STUDIO
REM -----------------------------------------------------------------------------

CREATE TABLE STUDIO
   (
   CODE_STUDIO INTEGER NOT NULL ,
   NOM_STUDIO INTEGER  ,
   DATE_CREATION DATE  
,
     PRIMARY KEY (CODE_STUDIO) CONSTRAINT PK_STUDIO
   );

REM -----------------------------------------------------------------------------
REM       TABLE : TEXTE
REM -----------------------------------------------------------------------------

CREATE TABLE TEXTE
   (
   SERIE_CODE INTEGER NOT NULL ,
   ACHAT_CODE_ACHAT CHAR(32)  ,
   NB_CHAPITRES INTEGER  ,
   NB_TOMES INTEGER  ,
   SERIE_DATE_D DATE  ,
   SERIE_DATE_F DATE  
,
     PRIMARY KEY (SERIE_CODE) CONSTRAINT PK_TEXTE
   );

REM -----------------------------------------------------------------------------
REM       INDEX DE LA TABLE TEXTE
REM -----------------------------------------------------------------------------

CREATE  INDEX I_FK_TEXTE_ACHAT
     ON TEXTE (ACHAT_CODE_ACHAT ASC);

REM -----------------------------------------------------------------------------
REM       TABLE : CATEGORIE
REM -----------------------------------------------------------------------------

CREATE TABLE CATEGORIE
   (
   CAT_CODE_CAT CHAR(32) NOT NULL ,
   CAT_LIBELLE VARCHAR(1000)  
,
     PRIMARY KEY (CAT_CODE_CAT) CONSTRAINT PK_CATEGORIE
   );

REM -----------------------------------------------------------------------------
REM       TABLE : SERIE
REM -----------------------------------------------------------------------------

CREATE TABLE SERIE
   (
   SERIE_CODE INTEGER NOT NULL ,
   AVANCEE_CODE_AVANCEE CHAR(32) NOT NULL ,
   STATUT_CODE CHAR(32) NOT NULL ,
   SERIE_DATE_D DATE  ,
   SERIE_DATE_F DATE  
,
     PRIMARY KEY (SERIE_CODE) CONSTRAINT PK_SERIE
   );

REM -----------------------------------------------------------------------------
REM       INDEX DE LA TABLE SERIE
REM -----------------------------------------------------------------------------

CREATE  INDEX I_FK_SERIE_AVANCEE
     ON SERIE (AVANCEE_CODE_AVANCEE ASC);

CREATE  INDEX I_FK_SERIE_STATUT
     ON SERIE (STATUT_CODE ASC);

REM -----------------------------------------------------------------------------
REM       TABLE : LN
REM -----------------------------------------------------------------------------

CREATE TABLE LN
   (
   CODE_LN INTEGER NOT NULL ,
   SERIE_CODE INTEGER NOT NULL ,
   NB_CHAPITRES INTEGER  ,
   NB_TOMES INTEGER  ,
   SERIE_DATE_D DATE  ,
   SERIE_DATE_F DATE  
,
     PRIMARY KEY (CODE_LN) CONSTRAINT PK_LN
   );

REM -----------------------------------------------------------------------------
REM       INDEX DE LA TABLE LN
REM -----------------------------------------------------------------------------

CREATE  INDEX I_FK_LN_TEXTE
     ON LN (SERIE_CODE ASC);

REM -----------------------------------------------------------------------------
REM       TABLE : AVANCEE
REM -----------------------------------------------------------------------------

CREATE TABLE AVANCEE
   (
   AVANCEE_CODE_AVANCEE CHAR(32) NOT NULL ,
   AVANCEE_LIBELLE VARCHAR(1000)  
,
     PRIMARY KEY (AVANCEE_CODE_AVANCEE) CONSTRAINT PK_AVANCEE
   );

REM -----------------------------------------------------------------------------
REM       TABLE : MANWHA
REM -----------------------------------------------------------------------------

CREATE TABLE MANWHA
   (
   CODE_MANWHA INTEGER NOT NULL ,
   SERIE_CODE INTEGER NOT NULL ,
   NB_CHAPITRES INTEGER  ,
   NB_TOMES INTEGER  ,
   SERIE_DATE_D DATE  ,
   SERIE_DATE_F DATE  
,
     PRIMARY KEY (CODE_MANWHA) CONSTRAINT PK_MANWHA
   );

REM -----------------------------------------------------------------------------
REM       INDEX DE LA TABLE MANWHA
REM -----------------------------------------------------------------------------

CREATE  INDEX I_FK_MANWHA_TEXTE
     ON MANWHA (SERIE_CODE ASC);

REM -----------------------------------------------------------------------------
REM       TABLE : ACHAT
REM -----------------------------------------------------------------------------

CREATE TABLE ACHAT
   (
   ACHAT_CODE_ACHAT CHAR(32) NOT NULL ,
   ACHAT_LIBELLE_ACHAT VARCHAR(1000)  
,
     PRIMARY KEY (ACHAT_CODE_ACHAT) CONSTRAINT PK_ACHAT
   );

REM -----------------------------------------------------------------------------
REM       TABLE : AUTEUR
REM -----------------------------------------------------------------------------

CREATE TABLE AUTEUR
   (
   CODE_AUTEUR INTEGER NOT NULL ,
   NOM_AUTEUR VARCHAR(1000)  ,
   PRENOM_AUTEUR VARCHAR(1000)  
,
     PRIMARY KEY (CODE_AUTEUR) CONSTRAINT PK_AUTEUR
   );

REM -----------------------------------------------------------------------------
REM       TABLE : PRODUIRE
REM -----------------------------------------------------------------------------

CREATE TABLE PRODUIRE
   (
   CODE_STUDIO INTEGER NOT NULL ,
   CODE_ANIME INTEGER NOT NULL ,
   NB_SAISONS INTEGER  
,
     PRIMARY KEY (CODE_STUDIO, CODE_ANIME) CONSTRAINT PK_PRODUIRE
   );

REM -----------------------------------------------------------------------------
REM       INDEX DE LA TABLE PRODUIRE
REM -----------------------------------------------------------------------------

CREATE  INDEX I_FK_PRODUIRE_STUDIO
     ON PRODUIRE (CODE_STUDIO ASC);

CREATE  INDEX I_FK_PRODUIRE_ANIME
     ON PRODUIRE (CODE_ANIME ASC);

REM -----------------------------------------------------------------------------
REM       TABLE : RANGER
REM -----------------------------------------------------------------------------

CREATE TABLE RANGER
   (
   CAT_CODE_CAT CHAR(32) NOT NULL ,
   CODE_ANIME INTEGER NOT NULL 
,
     PRIMARY KEY (CAT_CODE_CAT, CODE_ANIME) CONSTRAINT PK_RANGER
   );

REM -----------------------------------------------------------------------------
REM       INDEX DE LA TABLE RANGER
REM -----------------------------------------------------------------------------

CREATE  INDEX I_FK_RANGER_CATEGORIE
     ON RANGER (CAT_CODE_CAT ASC);

CREATE  INDEX I_FK_RANGER_ANIME
     ON RANGER (CODE_ANIME ASC);

REM -----------------------------------------------------------------------------
REM       TABLE : ECRIRE
REM -----------------------------------------------------------------------------

CREATE TABLE ECRIRE
   (
   SERIE_CODE INTEGER NOT NULL ,
   CODE_AUTEUR INTEGER NOT NULL 
,
     PRIMARY KEY (SERIE_CODE, CODE_AUTEUR) CONSTRAINT PK_ECRIRE
   );

REM -----------------------------------------------------------------------------
REM       INDEX DE LA TABLE ECRIRE
REM -----------------------------------------------------------------------------

CREATE  INDEX I_FK_ECRIRE_TEXTE
     ON ECRIRE (SERIE_CODE ASC);

CREATE  INDEX I_FK_ECRIRE_AUTEUR
     ON ECRIRE (CODE_AUTEUR ASC);

REM -----------------------------------------------------------------------------
REM       TABLE : CLASSER
REM -----------------------------------------------------------------------------

CREATE TABLE CLASSER
   (
   CODE_MANGA INTEGER NOT NULL ,
   CAT_CODE_CAT CHAR(32) NOT NULL 
,
     PRIMARY KEY (CODE_MANGA, CAT_CODE_CAT) CONSTRAINT PK_CLASSER
   );

REM -----------------------------------------------------------------------------
REM       INDEX DE LA TABLE CLASSER
REM -----------------------------------------------------------------------------

CREATE  INDEX I_FK_CLASSER_MANGA
     ON CLASSER (CODE_MANGA ASC);

CREATE  INDEX I_FK_CLASSER_CATEGORIE
     ON CLASSER (CAT_CODE_CAT ASC);


REM -----------------------------------------------------------------------------
REM       CREATION DES REFERENCES DE TABLE
REM -----------------------------------------------------------------------------

ALTER TABLE LIVE_ACTION ADD (FOREIGN KEY (SERIE_CODE)
      REFERENCES SERIE (SERIE_CODE)
      CONSTRAINT FK_LIVE_ACTION_SERIE );

ALTER TABLE ANIME ADD (FOREIGN KEY (SERIE_CODE)
      REFERENCES SERIE (SERIE_CODE)
      CONSTRAINT FK_ANIME_SERIE );

ALTER TABLE MANGA ADD (FOREIGN KEY (SERIE_CODE)
      REFERENCES TEXTE (SERIE_CODE)
      CONSTRAINT FK_MANGA_TEXTE );

ALTER TABLE TEXTE ADD (FOREIGN KEY (ACHAT_CODE_ACHAT)
      REFERENCES ACHAT (ACHAT_CODE_ACHAT)
      CONSTRAINT FK_TEXTE_ACHAT );

ALTER TABLE TEXTE ADD (FOREIGN KEY (SERIE_CODE)
      REFERENCES SERIE (SERIE_CODE)
      CONSTRAINT FK_TEXTE_SERIE );

ALTER TABLE SERIE ADD (FOREIGN KEY (AVANCEE_CODE_AVANCEE)
      REFERENCES AVANCEE (AVANCEE_CODE_AVANCEE)
      CONSTRAINT FK_SERIE_AVANCEE );

ALTER TABLE SERIE ADD (FOREIGN KEY (STATUT_CODE)
      REFERENCES STATUT (STATUT_CODE)
      CONSTRAINT FK_SERIE_STATUT );

ALTER TABLE LN ADD (FOREIGN KEY (SERIE_CODE)
      REFERENCES TEXTE (SERIE_CODE)
      CONSTRAINT FK_LN_TEXTE );

ALTER TABLE MANWHA ADD (FOREIGN KEY (SERIE_CODE)
      REFERENCES TEXTE (SERIE_CODE)
      CONSTRAINT FK_MANWHA_TEXTE );

ALTER TABLE PRODUIRE ADD (FOREIGN KEY (CODE_STUDIO)
      REFERENCES STUDIO (CODE_STUDIO)
      CONSTRAINT FK_PRODUIRE_STUDIO );

ALTER TABLE PRODUIRE ADD (FOREIGN KEY (CODE_ANIME)
      REFERENCES ANIME (CODE_ANIME)
      CONSTRAINT FK_PRODUIRE_ANIME );

ALTER TABLE RANGER ADD (FOREIGN KEY (CAT_CODE_CAT)
      REFERENCES CATEGORIE (CAT_CODE_CAT)
      CONSTRAINT FK_RANGER_CATEGORIE );

ALTER TABLE RANGER ADD (FOREIGN KEY (CODE_ANIME)
      REFERENCES ANIME (CODE_ANIME)
      CONSTRAINT FK_RANGER_ANIME );

ALTER TABLE ECRIRE ADD (FOREIGN KEY (SERIE_CODE)
      REFERENCES TEXTE (SERIE_CODE)
      CONSTRAINT FK_ECRIRE_TEXTE );

ALTER TABLE ECRIRE ADD (FOREIGN KEY (CODE_AUTEUR)
      REFERENCES AUTEUR (CODE_AUTEUR)
      CONSTRAINT FK_ECRIRE_AUTEUR );

ALTER TABLE CLASSER ADD (FOREIGN KEY (CODE_MANGA)
      REFERENCES MANGA (CODE_MANGA)
      CONSTRAINT FK_CLASSER_MANGA );

ALTER TABLE CLASSER ADD (FOREIGN KEY (CAT_CODE_CAT)
      REFERENCES CATEGORIE (CAT_CODE_CAT)
      CONSTRAINT FK_CLASSER_CATEGORIE );


REM -----------------------------------------------------------------------------
REM                FIN DE GENERATION
REM -----------------------------------------------------------------------------