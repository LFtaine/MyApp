
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS LIVE_ACTION;
DROP TABLE IF EXISTS ANIME;
DROP TABLE IF EXISTS STATUT;
DROP TABLE IF EXISTS MANGA;
DROP TABLE IF EXISTS STUDIO;
DROP TABLE IF EXISTS TEXTE;
DROP TABLE IF EXISTS CATEGORIE;
DROP TABLE IF EXISTS SERIE;
DROP TABLE IF EXISTS LN;
DROP TABLE IF EXISTS AVANCEE;
DROP TABLE IF EXISTS MANWHA;
DROP TABLE IF EXISTS ACHAT;
DROP TABLE IF EXISTS AUTEUR;
DROP TABLE IF EXISTS PRODUIRE;
DROP TABLE IF EXISTS RANGER;
DROP TABLE IF EXISTS ECRIRE;
DROP TABLE IF EXISTS CLASSER;

SET FOREIGN_KEY_CHECKS = 1;

-- -----------------------------------------------------------------------------
--       TABLE : AVANCEE  (référencée par SERIE, créée en premier)
-- -----------------------------------------------------------------------------

CREATE TABLE AVANCEE
   (
   AVANCEE_CODE_AVANCEE  CHAR(32)      NOT NULL ,
   AVANCEE_LIBELLE       VARCHAR(1000) ,
     PRIMARY KEY (AVANCEE_CODE_AVANCEE)
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------------------------------
--       TABLE : STATUT  (référencée par SERIE, créée en premier)
-- -----------------------------------------------------------------------------

CREATE TABLE STATUT
   (
   STATUT_CODE      CHAR(32)      NOT NULL ,
   STATUT_LIBELLLE  VARCHAR(1000) ,
     PRIMARY KEY (STATUT_CODE)
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------------------------------
--       TABLE : ACHAT  (référencée par TEXTE, créée en premier)
-- -----------------------------------------------------------------------------

CREATE TABLE ACHAT
   (
   ACHAT_CODE_ACHAT     CHAR(32)      NOT NULL ,
   ACHAT_LIBELLE_ACHAT  VARCHAR(1000) ,
     PRIMARY KEY (ACHAT_CODE_ACHAT)
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------------------------------
--       TABLE : CATEGORIE  (référencée par RANGER et CLASSER)
-- -----------------------------------------------------------------------------

CREATE TABLE CATEGORIE
   (
   CAT_CODE_CAT  CHAR(32)      NOT NULL ,
   CAT_LIBELLE   VARCHAR(1000) ,
     PRIMARY KEY (CAT_CODE_CAT)
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------------------------------
--       TABLE : AUTEUR  (référencée par ECRIRE)
-- -----------------------------------------------------------------------------

CREATE TABLE AUTEUR
   (
   CODE_AUTEUR    INT           NOT NULL ,
   NOM_AUTEUR     VARCHAR(1000) ,
   PRENOM_AUTEUR  VARCHAR(1000) ,
     PRIMARY KEY (CODE_AUTEUR)
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------------------------------
--       TABLE : STUDIO  (référencée par PRODUIRE)
-- -----------------------------------------------------------------------------

CREATE TABLE STUDIO
   (
   CODE_STUDIO    INT           NOT NULL ,
   NOM_STUDIO     VARCHAR(1000) ,
   DATE_CREATION  DATE          ,
     PRIMARY KEY (CODE_STUDIO)
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------------------------------
--       TABLE : SERIE  (référence AVANCEE et STATUT)
-- -----------------------------------------------------------------------------

CREATE TABLE SERIE
   (
   SERIE_CODE           INT          NOT NULL ,
   SERIE_NOM            VARCHAR(500) NOT NULL ,
   AVANCEE_CODE_AVANCEE CHAR(32)     NOT NULL ,
   STATUT_CODE          CHAR(32)     NOT NULL ,
   SERIE_DATE_D         DATE         ,
   SERIE_DATE_F         DATE         ,
     PRIMARY KEY (SERIE_CODE),
     INDEX I_FK_SERIE_AVANCEE (AVANCEE_CODE_AVANCEE),
     INDEX I_FK_SERIE_STATUT  (STATUT_CODE),
     CONSTRAINT FK_SERIE_AVANCEE FOREIGN KEY (AVANCEE_CODE_AVANCEE)
       REFERENCES AVANCEE (AVANCEE_CODE_AVANCEE),
     CONSTRAINT FK_SERIE_STATUT FOREIGN KEY (STATUT_CODE)
       REFERENCES STATUT (STATUT_CODE)
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------------------------------
--       TABLE : TEXTE  (référence ACHAT et SERIE)
-- -----------------------------------------------------------------------------

CREATE TABLE TEXTE
   (
   SERIE_CODE        INT      NOT NULL ,
   ACHAT_CODE_ACHAT  CHAR(32) ,
   NB_CHAPITRES      INT      ,
   NB_TOMES          INT      ,
   SERIE_DATE_D      DATE     ,
   SERIE_DATE_F      DATE     ,
     PRIMARY KEY (SERIE_CODE),
     INDEX I_FK_TEXTE_ACHAT (ACHAT_CODE_ACHAT),
     CONSTRAINT FK_TEXTE_ACHAT FOREIGN KEY (ACHAT_CODE_ACHAT)
       REFERENCES ACHAT (ACHAT_CODE_ACHAT),
     CONSTRAINT FK_TEXTE_SERIE FOREIGN KEY (SERIE_CODE)
       REFERENCES SERIE (SERIE_CODE)
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------------------------------
--       TABLE : LIVE_ACTION  (référence SERIE)
-- -----------------------------------------------------------------------------

CREATE TABLE LIVE_ACTION
   (
   LA_CODE      INT           NOT NULL ,
   SERIE_CODE   INT           NOT NULL ,
   LA_NOM       VARCHAR(1000) ,
     PRIMARY KEY (LA_CODE),
     INDEX I_FK_LIVE_ACTION_SERIE (SERIE_CODE),
     CONSTRAINT FK_LIVE_ACTION_SERIE FOREIGN KEY (SERIE_CODE)
       REFERENCES SERIE (SERIE_CODE)
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------------------------------
--       TABLE : ANIME  (référence SERIE)
-- -----------------------------------------------------------------------------

CREATE TABLE ANIME
   (
   CODE_ANIME     INT NOT NULL ,
   SERIE_CODE     INT NOT NULL ,
   NB_EPISODES    INT ,
   SERIE_DATE_D   DATE ,
   SERIE_DATE_F   DATE ,
     PRIMARY KEY (CODE_ANIME),
     INDEX I_FK_ANIME_SERIE (SERIE_CODE),
     CONSTRAINT FK_ANIME_SERIE FOREIGN KEY (SERIE_CODE)
       REFERENCES SERIE (SERIE_CODE)
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------------------------------
--       TABLE : MANGA  (référence TEXTE)
-- -----------------------------------------------------------------------------

CREATE TABLE MANGA
   (
   CODE_MANGA     INT NOT NULL ,
   SERIE_CODE     INT NOT NULL ,
   NB_CHAPITRES   INT ,
   NB_TOMES       INT ,
   SERIE_DATE_D   DATE ,
   SERIE_DATE_F   DATE ,
     PRIMARY KEY (CODE_MANGA),
     INDEX I_FK_MANGA_TEXTE (SERIE_CODE),
     CONSTRAINT FK_MANGA_TEXTE FOREIGN KEY (SERIE_CODE)
       REFERENCES TEXTE (SERIE_CODE)
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------------------------------
--       TABLE : LN  (référence TEXTE)
-- -----------------------------------------------------------------------------

CREATE TABLE LN
   (
   CODE_LN        INT NOT NULL ,
   SERIE_CODE     INT NOT NULL ,
   NB_CHAPITRES   INT ,
   NB_TOMES       INT ,
   SERIE_DATE_D   DATE ,
   SERIE_DATE_F   DATE ,
     PRIMARY KEY (CODE_LN),
     INDEX I_FK_LN_TEXTE (SERIE_CODE),
     CONSTRAINT FK_LN_TEXTE FOREIGN KEY (SERIE_CODE)
       REFERENCES TEXTE (SERIE_CODE)
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------------------------------
--       TABLE : MANWHA  (référence TEXTE)
-- -----------------------------------------------------------------------------

CREATE TABLE MANWHA
   (
   CODE_MANWHA    INT NOT NULL ,
   SERIE_CODE     INT NOT NULL ,
   NB_CHAPITRES   INT ,
   NB_TOMES       INT ,
   SERIE_DATE_D   DATE ,
   SERIE_DATE_F   DATE ,
     PRIMARY KEY (CODE_MANWHA),
     INDEX I_FK_MANWHA_TEXTE (SERIE_CODE),
     CONSTRAINT FK_MANWHA_TEXTE FOREIGN KEY (SERIE_CODE)
       REFERENCES TEXTE (SERIE_CODE)
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------------------------------
--       TABLE : PRODUIRE  (référence STUDIO et ANIME)
-- -----------------------------------------------------------------------------

CREATE TABLE PRODUIRE
   (
   CODE_STUDIO  INT NOT NULL ,
   CODE_ANIME   INT NOT NULL ,
   NB_SAISONS   INT ,
     PRIMARY KEY (CODE_STUDIO, CODE_ANIME),
     INDEX I_FK_PRODUIRE_STUDIO (CODE_STUDIO),
     INDEX I_FK_PRODUIRE_ANIME  (CODE_ANIME),
     CONSTRAINT FK_PRODUIRE_STUDIO FOREIGN KEY (CODE_STUDIO)
       REFERENCES STUDIO (CODE_STUDIO),
     CONSTRAINT FK_PRODUIRE_ANIME FOREIGN KEY (CODE_ANIME)
       REFERENCES ANIME (CODE_ANIME)
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------------------------------
--       TABLE : RANGER  (référence CATEGORIE et ANIME)
-- -----------------------------------------------------------------------------

CREATE TABLE RANGER
   (
   CAT_CODE_CAT  CHAR(32) NOT NULL ,
   CODE_ANIME    INT      NOT NULL ,
     PRIMARY KEY (CAT_CODE_CAT, CODE_ANIME),
     INDEX I_FK_RANGER_CATEGORIE (CAT_CODE_CAT),
     INDEX I_FK_RANGER_ANIME     (CODE_ANIME),
     CONSTRAINT FK_RANGER_CATEGORIE FOREIGN KEY (CAT_CODE_CAT)
       REFERENCES CATEGORIE (CAT_CODE_CAT),
     CONSTRAINT FK_RANGER_ANIME FOREIGN KEY (CODE_ANIME)
       REFERENCES ANIME (CODE_ANIME)
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------------------------------
--       TABLE : ECRIRE  (référence TEXTE et AUTEUR)
-- -----------------------------------------------------------------------------

CREATE TABLE ECRIRE
   (
   SERIE_CODE   INT NOT NULL ,
   CODE_AUTEUR  INT NOT NULL ,
     PRIMARY KEY (SERIE_CODE, CODE_AUTEUR),
     INDEX I_FK_ECRIRE_TEXTE  (SERIE_CODE),
     INDEX I_FK_ECRIRE_AUTEUR (CODE_AUTEUR),
     CONSTRAINT FK_ECRIRE_TEXTE FOREIGN KEY (SERIE_CODE)
       REFERENCES TEXTE (SERIE_CODE),
     CONSTRAINT FK_ECRIRE_AUTEUR FOREIGN KEY (CODE_AUTEUR)
       REFERENCES AUTEUR (CODE_AUTEUR)
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------------------------------
--       TABLE : CLASSER  (référence MANGA et CATEGORIE)
-- -----------------------------------------------------------------------------

CREATE TABLE CLASSER
   (
   CODE_MANGA    INT      NOT NULL ,
   CAT_CODE_CAT  CHAR(32) NOT NULL ,
     PRIMARY KEY (CODE_MANGA, CAT_CODE_CAT),
     INDEX I_FK_CLASSER_MANGA      (CODE_MANGA),
     INDEX I_FK_CLASSER_CATEGORIE  (CAT_CODE_CAT),
     CONSTRAINT FK_CLASSER_MANGA FOREIGN KEY (CODE_MANGA)
       REFERENCES MANGA (CODE_MANGA),
     CONSTRAINT FK_CLASSER_CATEGORIE FOREIGN KEY (CAT_CODE_CAT)
       REFERENCES CATEGORIE (CAT_CODE_CAT)
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


ALTER TABLE ANIME ADD NOM VARCHAR(1000);
ALTER TABLE MANGA ADD NOM VARCHAR(1000);
ALTER TABLE LN ADD NOM VARCHAR(1000);
ALTER TABLE MANWHA ADD NOM VARCHAR(1000);
ALTER TABLE LIVE_ACTION ADD NOM VARCHAR(1000);




INSERT IGNORE INTO AVANCEE (AVANCEE_CODE_AVANCEE, AVANCEE_LIBELLE) VALUES
('LECTURE_EN_COURS', 'Lecture commencée'),
('LECTURE_TERMINEE', 'Lecture terminée'),
('ANIME_EN_COURS', 'Animé commencé'),
('ANIME_TERMINE', 'Animé terminé');

INSERT IGNORE INTO STATUT (STATUT_CODE, STATUT_LIBELLLE) VALUES
('MANGA', 'Manga'),
('ANIME', 'Animé'),
('LN', 'Light Novel'),
('MANWHA', 'Manwha'),
('LIVE_ACTION', 'Live Action');

INSERT INTO SERIE (SERIE_CODE, SERIE_NOM, AVANCEE_CODE_AVANCEE, STATUT_CODE) VALUES
(1, 'Jojo part 1 : Phantom Blood', 'LECTURE_TERMINEE', 'MANGA'),
(2, 'Jojo part 1 : Phantom Blood', 'ANIME_TERMINE', 'ANIME'),
(3, 'Jojo part 2 : Battle Tendency', 'LECTURE_EN_COURS', 'MANGA'),
(4, 'Jojo part 2 : Battle Tendency', 'ANIME_TERMINE', 'ANIME'),
(5, 'Jojo part 3: Stardust Crusader', 'LECTURE_EN_COURS', 'MANGA'),
(6, 'Jojo part 3: Stardust Crusader', 'ANIME_TERMINE', 'ANIME'),
(7, 'Jojo part 4: Diamond is Unbreakable', 'ANIME_EN_COURS', 'ANIME'),
(8, 'Jojo part 5 : Golden Wind', 'LECTURE_EN_COURS', 'MANGA'),
(9, 'Jojo part 5 : Golden Wind', 'ANIME_EN_COURS', 'ANIME'),
(10, 'Jojo part 6 : Stone Ocean', 'LECTURE_TERMINEE', 'MANGA'),
(11, 'Jojo part 6 : Stone Ocean', 'ANIME_TERMINE', 'ANIME'),
(12, 'Jojo part 7 : Steel Ball Run', 'LECTURE_TERMINEE', 'MANGA'),
(13, 'Jojo part 8 : Jojolion', 'LECTURE_TERMINEE', 'MANGA'),
(14, 'Jojo part 9 : The Jojolands', 'LECTURE_TERMINEE', 'MANGA'),
(15, 'Jjk 0', 'LECTURE_TERMINEE', 'MANGA'),
(16, 'Under Execution, Under Jailbreak', 'LECTURE_TERMINEE', 'MANGA'),
(17, 'Crazy D. Demonic Heartbreak', 'LECTURE_TERMINEE', 'MANGA'),
(18, 'Thus Spoke Kishibe Rohan', 'LECTURE_TERMINEE', 'MANGA'),
(19, 'Thus Spoke Kishibe Rohan', 'ANIME_TERMINE', 'ANIME'),
(20, 'Dead Man''s Questions', 'LECTURE_TERMINEE', 'MANGA'),
(21, 'Fullmetal Alchemist', 'LECTURE_TERMINEE', 'MANGA'),
(22, 'Fullmetal Alchemist', 'ANIME_EN_COURS', 'ANIME'),
(23, 'Naruto', 'LECTURE_TERMINEE', 'MANGA'),
(24, 'Naruto', 'ANIME_EN_COURS', 'ANIME'),
(25, 'Boruto', 'LECTURE_TERMINEE', 'MANGA'),
(26, 'Boruto', 'ANIME_EN_COURS', 'ANIME'),
(27, 'Parasyte The Maxim', 'LECTURE_TERMINEE', 'MANGA'),
(28, 'Parasyte The Maxim', 'ANIME_TERMINE', 'ANIME'),
(29, 'Attack on Titan', 'LECTURE_TERMINEE', 'MANGA'),
(30, 'Attack on Titan', 'ANIME_TERMINE', 'ANIME'),
(31, 'Bleach', 'LECTURE_TERMINEE', 'MANGA'),
(32, 'Bleach', 'ANIME_TERMINE', 'ANIME'),
(33, 'One Piece', 'LECTURE_TERMINEE', 'MANGA'),
(34, 'One Piece', 'ANIME_EN_COURS', 'ANIME'),
(35, 'One Punch Man', 'LECTURE_TERMINEE', 'MANGA'),
(36, 'One Punch Man', 'ANIME_EN_COURS', 'ANIME'),
(37, 'One Punch Man', 'LECTURE_EN_COURS', 'LIVE_ACTION'),
(38, 'Tokyo Ghoul', 'LECTURE_TERMINEE', 'MANGA'),
(39, 'Tokyo Ghoul', 'ANIME_TERMINE', 'ANIME'),
(40, 'Tokyo Ghoul:re', 'LECTURE_TERMINEE', 'MANGA'),
(41, 'Tokyo Ghoul:re', 'ANIME_TERMINE', 'ANIME'),
(42, 'Tower of God', 'LECTURE_TERMINEE', 'MANWHA'),
(43, 'Tower of God', 'ANIME_EN_COURS', 'ANIME'),
(44, 'The God of High School', 'LECTURE_TERMINEE', 'MANWHA'),
(45, 'The God of High School', 'ANIME_EN_COURS', 'ANIME'),
(46, 'Bâtard', 'LECTURE_TERMINEE', 'MANWHA'),
(47, 'Death Note', 'LECTURE_TERMINEE', 'MANGA'),
(48, 'Death Note', 'ANIME_TERMINE', 'ANIME'),
(49, 'Death Note', 'LECTURE_EN_COURS', 'LIVE_ACTION'),
(50, 'Jojo Over Heaven', 'LECTURE_TERMINEE', 'LN'),
(51, 'Demon slayer', 'LECTURE_TERMINEE', 'MANGA'),
(52, 'Demon slayer', 'ANIME_EN_COURS', 'ANIME'),
(53, 'Fairy tail', 'LECTURE_TERMINEE', 'MANGA'),
(54, 'Fairy tail', 'ANIME_EN_COURS', 'ANIME'),
(55, 'Fairy tail 100 years quest', 'LECTURE_EN_COURS', 'MANGA'),
(56, 'Chainsaw Man', 'LECTURE_TERMINEE', 'MANGA'),
(57, 'Chainsaw Man', 'ANIME_TERMINE', 'ANIME'),
(58, 'Mob psycho 100', 'LECTURE_TERMINEE', 'MANGA'),
(59, 'Mob psycho 100', 'ANIME_EN_COURS', 'ANIME'),
(60, 'Black clover', 'LECTURE_TERMINEE', 'MANGA'),
(61, 'Black clover', 'ANIME_EN_COURS', 'ANIME'),
(62, 'Seven deadly sins', 'LECTURE_EN_COURS', 'MANGA'),
(63, 'Seven deadly sins', 'ANIME_TERMINE', 'ANIME'),
(64, 'Hunter X Hunter', 'LECTURE_TERMINEE', 'MANGA'),
(65, 'Hunter X Hunter', 'ANIME_TERMINE', 'ANIME'),
(66, 'Blue exorcist', 'LECTURE_TERMINEE', 'MANGA'),
(67, 'Blue exorcist', 'ANIME_TERMINE', 'ANIME'),
(68, 'No game no life', 'ANIME_TERMINE', 'ANIME'),
(69, 'Magus of The Library', 'LECTURE_EN_COURS', 'MANGA'),
(70, 'The promised neverland', 'LECTURE_TERMINEE', 'MANGA'),
(71, 'The promised neverland', 'ANIME_EN_COURS', 'ANIME'),
(72, 'Assassination classroom', 'LECTURE_TERMINEE', 'MANGA'),
(73, 'Assassination classroom', 'ANIME_TERMINE', 'ANIME'),
(74, 'Le samouraï insaisissable', 'LECTURE_EN_COURS', 'MANGA'),
(75, 'Jujutsu kaisen', 'LECTURE_TERMINEE', 'MANGA'),
(76, 'Jujutsu kaisen', 'ANIME_TERMINE', 'ANIME'),
(77, 'Dandadan', 'LECTURE_TERMINEE', 'MANGA'),
(78, 'Kaiju n°8', 'LECTURE_TERMINEE', 'MANGA'),
(79, 'Mashle', 'LECTURE_TERMINEE', 'MANGA'),
(80, 'Dr Stone', 'LECTURE_TERMINEE', 'MANGA'),
(81, 'Dr Stone', 'ANIME_EN_COURS', 'ANIME'),
(82, 'Sakamoto days', 'LECTURE_TERMINEE', 'MANGA'),
(83, 'Sakamoto days', 'ANIME_EN_COURS', 'ANIME'),
(84, 'Devilman crybaby', 'ANIME_TERMINE', 'ANIME'),
(85, 'Battle game in 5 seconds', 'LECTURE_TERMINEE', 'MANGA'),
(86, 'Battle game in 5 seconds', 'ANIME_TERMINE', 'ANIME'),
(87, 'Ace Novel', 'LECTURE_TERMINEE', 'LN'),
(88, 'Broken Blade', 'LECTURE_TERMINEE', 'MANGA'),
(89, 'Tomie', 'LECTURE_TERMINEE', 'MANGA'),
(90, 'Mushoku tensei', 'ANIME_EN_COURS', 'ANIME'),
(91, 'L''atelier des sorciers', 'LECTURE_EN_COURS', 'MANGA'),
(92, 'Ajin', 'LECTURE_TERMINEE', 'MANGA'),
(93, 'Ajin', 'ANIME_EN_COURS', 'ANIME'),
(94, 'Noragami', 'LECTURE_TERMINEE', 'MANGA'),
(95, 'Beelzebub', 'LECTURE_TERMINEE', 'MANGA'),
(96, 'Monster', 'LECTURE_TERMINEE', 'MANGA'),
(97, 'Pupa', 'LECTURE_TERMINEE', 'MANGA'),
(98, 'Pupa', 'ANIME_TERMINE', 'ANIME'),
(99, 'Choujin X', 'LECTURE_EN_COURS', 'MANGA'),
(100, 'Fire Force', 'LECTURE_TERMINEE', 'MANGA'),
(101, 'Fire Force', 'ANIME_EN_COURS', 'ANIME'),
(102, 'Soul Eater', 'LECTURE_TERMINEE', 'MANGA'),
(103, 'D-Gray Man', 'LECTURE_TERMINEE', 'MANGA'),
(104, '666 Satan', 'LECTURE_TERMINEE', 'MANGA'),
(105, 'B the beginning', 'ANIME_TERMINE', 'ANIME'),
(106, 'Sky-high survival', 'LECTURE_EN_COURS', 'MANGA'),
(107, 'Sky-high survival', 'ANIME_EN_COURS', 'ANIME'),
(108, 'High-school of the dead', 'ANIME_EN_COURS', 'ANIME'),
(109, 'Gambling School', 'ANIME_EN_COURS', 'ANIME'),
(110, 'Bonne nuit Punpun', 'LECTURE_TERMINEE', 'MANGA'),
(111, 'Spy X Family', 'LECTURE_EN_COURS', 'MANGA'),
(112, 'Spy X Family', 'ANIME_EN_COURS', 'ANIME'),
(113, 'Tokyo Revengers', 'LECTURE_TERMINEE', 'MANGA'),
(114, 'Tokyo Revengers', 'ANIME_EN_COURS', 'ANIME'),
(115, 'Birdmen', 'LECTURE_TERMINEE', 'MANGA'),
(116, 'Alice in borderland', 'LECTURE_TERMINEE', 'MANGA'),
(117, 'Thermae romae', 'LECTURE_EN_COURS', 'MANGA'),
(118, 'Four knights of apocalypse', 'LECTURE_EN_COURS', 'MANGA'),
(119, 'Darling in the franxx', 'ANIME_EN_COURS', 'ANIME'),
(120, 'My hero academia', 'LECTURE_TERMINEE', 'MANGA'),
(121, 'My hero academia', 'ANIME_EN_COURS', 'ANIME'),
(122, 'Yakitate Ja-pan', 'LECTURE_TERMINEE', 'MANGA'),
(123, 'Ajin', 'LECTURE_EN_COURS', 'LIVE_ACTION'),
(124, 'Akira', 'LECTURE_TERMINEE', 'MANGA'),
(125, 'Yomotsuhegui', 'LECTURE_TERMINEE', 'MANGA'),
(126, 'Overflow', 'ANIME_EN_COURS', 'ANIME'),
(127, 'Gradalis', 'LECTURE_EN_COURS', 'MANWHA'),
(128, 'Conseil d''amour du grand duc des enfers', 'LECTURE_EN_COURS', 'MANWHA'),
(129, 'La jacynthe violette', 'LECTURE_EN_COURS', 'MANWHA'),
(130, 'The Red king', 'LECTURE_TERMINEE', 'MANWHA'),
(131, 'Cruelle innocence', 'LECTURE_EN_COURS', 'MANWHA'),
(132, 'Ghost teller', 'LECTURE_TERMINEE', 'MANWHA'),
(133, 'Hell is other people', 'LECTURE_TERMINEE', 'MANWHA'),
(134, 'Ashen Hearts', 'LECTURE_TERMINEE', 'MANWHA'),
(135, 'Metamorphosis', 'LECTURE_EN_COURS', 'MANGA'),
(136, 'Evil Heroes', 'LECTURE_EN_COURS', 'MANGA'),
(137, 'A silent voice', 'LECTURE_TERMINEE', 'MANGA'),
(138, 'Berserk', 'LECTURE_TERMINEE', 'MANGA'),
(139, 'Ascension', 'LECTURE_TERMINEE', 'MANGA'),
(140, 'Alice in Borderland retry', 'LECTURE_TERMINEE', 'MANGA'),
(141, 'Alice on Border road', 'LECTURE_TERMINEE', 'MANGA'),
(142, 'Bokura no ketsumei', 'LECTURE_TERMINEE', 'MANGA'),
(143, 'Defense devil', 'LECTURE_TERMINEE', 'MANGA'),
(144, 'Diabolic garden', 'LECTURE_TERMINEE', 'MANGA'),
(145, 'Tripeace', 'LECTURE_EN_COURS', 'MANGA'),
(146, 'Alice in borderland', 'LECTURE_EN_COURS', 'LIVE_ACTION'),
(147, 'No scars', 'LECTURE_EN_COURS', 'MANWHA'),
(148, 'Traqueurs', 'LECTURE_EN_COURS', 'MANWHA'),
(149, 'Dead life', 'LECTURE_EN_COURS', 'MANWHA'),
(150, 'L''ère des orcs', 'LECTURE_EN_COURS', 'MANWHA'),
(151, 'Une seconde', 'LECTURE_EN_COURS', 'MANWHA'),
(152, 'Virtual runaways', 'LECTURE_TERMINEE', 'MANWHA'),
(153, 'Doppelganger', 'LECTURE_EN_COURS', 'MANWHA'),
(154, 'Vos commentaires ensoleillent ma journée', 'LECTURE_EN_COURS', 'MANWHA'),
(155, 'L''enfer homophobe', 'LECTURE_EN_COURS', 'MANWHA'),
(156, 'Player', 'LECTURE_EN_COURS', 'MANWHA'),
(157, 'L''expert de la tour tutoriel', 'LECTURE_EN_COURS', 'MANWHA'),
(158, 'Pawer stone', 'LECTURE_EN_COURS', 'MANWHA'),
(159, 'La voie du masque', 'LECTURE_TERMINEE', 'MANWHA'),
(160, 'Revenge game', 'LECTURE_TERMINEE', 'MANWHA'),
(161, 'Villain to kill', 'LECTURE_EN_COURS', 'MANWHA'),
(162, 'Fantoons', 'LECTURE_TERMINEE', 'MANWHA'),
(163, 'Une famille parfaite', 'LECTURE_TERMINEE', 'MANWHA'),
(164, 'Mon plus grand secret', 'LECTURE_TERMINEE', 'MANWHA'),
(165, 'Killstagram', 'LECTURE_TERMINEE', 'MANWHA'),
(166, 'Hellbound', 'LECTURE_EN_COURS', 'MANWHA'),
(167, 'Mort imminente', 'LECTURE_TERMINEE', 'MANWHA'),
(168, 'Nan yak', 'LECTURE_TERMINEE', 'MANWHA'),
(169, 'Chateau d''ambre', 'LECTURE_EN_COURS', 'MANWHA'),
(170, 'Game of doppelganger', 'LECTURE_TERMINEE', 'MANWHA'),
(171, 'White blood', 'LECTURE_TERMINEE', 'MANWHA'),
(172, 'Bestia', 'LECTURE_EN_COURS', 'MANWHA'),
(173, 'Dedrais le peuple oublié', 'LECTURE_TERMINEE', 'MANWHA'),
(174, 'Sindorim', 'LECTURE_TERMINEE', 'MANWHA'),
(175, 'Lumine', 'LECTURE_TERMINEE', 'MANWHA'),
(176, 'Urban animal', 'LECTURE_TERMINEE', 'MANWHA'),
(177, 'Folie meurtrière', 'LECTURE_EN_COURS', 'MANWHA'),
(178, 'Everything is fine', 'LECTURE_TERMINEE', 'MANWHA'),
(179, 'Sweet home', 'LECTURE_TERMINEE', 'MANWHA'),
(180, 'Sweet home', 'LECTURE_EN_COURS', 'LIVE_ACTION'),
(181, 'Héros fragile', 'LECTURE_TERMINEE', 'MANWHA'),
(182, 'Viral hit', 'LECTURE_TERMINEE', 'MANWHA'),
(183, 'The boxer', 'LECTURE_TERMINEE', 'MANWHA'),
(184, 'Hardcore leveling warrior', 'LECTURE_TERMINEE', 'MANWHA'),
(185, 'I''m the grim reaper', 'LECTURE_TERMINEE', 'MANWHA'),
(186, 'Not even bones', 'LECTURE_TERMINEE', 'MANWHA'),
(187, 'Escape room', 'LECTURE_TERMINEE', 'MANWHA'),
(188, 'Lecteur omniscient', 'LECTURE_TERMINEE', 'MANWHA'),
(189, 'Night of silence', 'LECTURE_TERMINEE', 'MANWHA'),
(190, 'Le garçon au fusil', 'LECTURE_TERMINEE', 'MANWHA'),
(191, 'Sang et papillons', 'LECTURE_TERMINEE', 'MANWHA'),
(192, 'Justin bisou', 'LECTURE_TERMINEE', 'MANWHA'),
(193, 'Unordinary', 'LECTURE_TERMINEE', 'MANWHA'),
(194, 'Adventures of god', 'LECTURE_TERMINEE', 'MANWHA'),
(195, 'Hero ticket', 'LECTURE_TERMINEE', 'MANWHA'),
(196, 'Change-moi', 'LECTURE_TERMINEE', 'MANWHA'),
(197, 'Jungle juice', 'LECTURE_TERMINEE', 'MANWHA'),
(198, 'L''ère des surhommes', 'LECTURE_TERMINEE', 'MANWHA'),
(199, 'Capitaine Zorgue', 'LECTURE_TERMINEE', 'MANWHA'),
(200, 'The gamer', 'LECTURE_TERMINEE', 'MANWHA'),
(201, 'High-school mercenary', 'LECTURE_TERMINEE', 'MANWHA'),
(202, 'Winter moon', 'LECTURE_TERMINEE', 'MANWHA'),
(203, 'La dose', 'LECTURE_TERMINEE', 'MANWHA'),
(204, 'Nano list', 'LECTURE_TERMINEE', 'MANWHA'),
(205, 'Hero killer', 'LECTURE_TERMINEE', 'MANWHA'),
(206, 'L''artefact dévoreur', 'LECTURE_EN_COURS', 'MANWHA'),
(207, 'Tomodachi game', 'LECTURE_TERMINEE', 'MANGA'),
(208, 'Tomodachi game', 'ANIME_EN_COURS', 'ANIME'),
(209, 'Dragon Ball', 'LECTURE_TERMINEE', 'MANGA'),
(210, 'Dragon Ball Z', 'LECTURE_TERMINEE', 'MANGA'),
(211, 'Dragon Ball Z', 'ANIME_EN_COURS', 'ANIME'),
(212, 'Blame!', 'LECTURE_TERMINEE', 'MANGA'),
(213, 'Blame!', 'ANIME_EN_COURS', 'ANIME'),
(214, 'Radiant', 'LECTURE_TERMINEE', 'MANGA'),
(215, 'Radiant', 'ANIME_EN_COURS', 'ANIME'),
(216, 'Dorohedoro', 'LECTURE_EN_COURS', 'MANGA'),
(217, 'Dorohedoro', 'ANIME_TERMINE', 'ANIME'),
(218, 'Baki The Grappler', 'LECTURE_TERMINEE', 'MANGA'),
(219, 'Baki The New Grappler', 'LECTURE_TERMINEE', 'MANGA'),
(220, 'Baki The New Grappler', 'ANIME_EN_COURS', 'ANIME'),
(221, 'Hanma Baki', 'LECTURE_TERMINEE', 'MANGA'),
(222, 'Valkyrie apocalypse', 'LECTURE_TERMINEE', 'MANGA'),
(223, 'Valkyrie apocalypse', 'ANIME_EN_COURS', 'ANIME'),
(224, 'World''s End Harem', 'LECTURE_EN_COURS', 'MANGA'),
(225, 'World''s End Harem', 'ANIME_EN_COURS', 'ANIME'),
(226, 'Pokémon', 'ANIME_EN_COURS', 'ANIME'),
(227, 'To your eternity', 'LECTURE_TERMINEE', 'MANGA'),
(228, 'Vinland Saga', 'LECTURE_TERMINEE', 'MANGA'),
(229, 'Death parade', 'ANIME_TERMINE', 'ANIME'),
(230, 'Blue Lock', 'LECTURE_TERMINEE', 'MANGA'),
(231, 'Solo Leveling', 'LECTURE_TERMINEE', 'MANWHA'),
(232, 'Solo Leveling', 'ANIME_EN_COURS', 'ANIME'),
(233, 'Hell''s Paradise', 'LECTURE_TERMINEE', 'MANGA'),
(234, 'Made in Abyss', 'LECTURE_TERMINEE', 'MANGA'),
(235, 'Made in Abyss', 'ANIME_TERMINE', 'ANIME'),
(236, 'Tougen Anki', 'LECTURE_TERMINEE', 'MANGA'),
(237, 'Tougen Anki', 'ANIME_EN_COURS', 'ANIME'),
(238, 'La zone fantôme', 'LECTURE_TERMINEE', 'MANGA'),
(239, 'Shibatarian', 'LECTURE_TERMINEE', 'MANGA'),
(240, 'Tensura', 'ANIME_EN_COURS', 'ANIME'),
(241, 'Ranking of kings', 'ANIME_EN_COURS', 'ANIME'),
(242, 'Ayashimon', 'LECTURE_TERMINEE', 'MANGA'),
(243, 'Neun', 'LECTURE_EN_COURS', 'MANGA'),
(244, 'Another', 'LECTURE_TERMINEE', 'MANGA'),
(245, 'Another', 'ANIME_TERMINE', 'ANIME'),
(246, 'Dimension W', 'LECTURE_EN_COURS', 'MANGA'),
(247, 'Aliens Area', 'LECTURE_EN_COURS', 'MANGA'),
(248, 'Space Brothers', 'LECTURE_EN_COURS', 'MANGA'),
(249, 'Homunculus', 'LECTURE_TERMINEE', 'MANGA'),
(250, 'Astro Boy', 'ANIME_EN_COURS', 'ANIME'),
(251, 'Terror in Resonance', 'ANIME_TERMINE', 'ANIME'),
(252, 'Snk 0', 'LECTURE_TERMINEE', 'MANGA'),
(253, 'Steins Gate', 'ANIME_EN_COURS', 'ANIME'),
(254, 'Battle Royale', 'LECTURE_TERMINEE', 'MANGA'),
(255, 'Psycho-Pass', 'ANIME_EN_COURS', 'ANIME'),
(256, 'Im', 'LECTURE_EN_COURS', 'MANGA'),
(257, 'L''école emportée', 'LECTURE_EN_COURS', 'MANGA'),
(258, 'Btooom!', 'LECTURE_TERMINEE', 'MANGA'),
(259, 'Juujika no rokunin', 'LECTURE_TERMINEE', 'MANGA'),
(260, 'Gestalt', 'LECTURE_TERMINEE', 'MANGA'),
(261, 'Last Hero Inuyashiki', 'LECTURE_TERMINEE', 'MANGA'),
(262, 'Deadman Wonderland', 'LECTURE_TERMINEE', 'MANGA'),
(263, 'Summertime Rendering', 'ANIME_TERMINE', 'ANIME'),
(264, 'Bucket list of the dead', 'LECTURE_TERMINEE', 'MANGA'),
(265, 'Kengan Ashura', 'LECTURE_TERMINEE', 'MANGA'),
(266, 'Marriage Toxin', 'LECTURE_TERMINEE', 'MANGA'),
(267, '+99 reinforced wooden stick', 'LECTURE_TERMINEE', 'MANWHA'),
(268, 'Blood Lad', 'LECTURE_TERMINEE', 'MANGA'),
(269, 'Tengoku Daimakyo', 'ANIME_EN_COURS', 'ANIME'),
(270, 'Dororo', 'ANIME_EN_COURS', 'ANIME'),
(271, 'Wild Strawberry', 'LECTURE_TERMINEE', 'MANGA'),
(272, 'Léviathan', 'LECTURE_TERMINEE', 'MANGA'),
(273, 'Undead Unluck', 'LECTURE_TERMINEE', 'MANGA'),
(274, 'YuYu Hakusho', 'LECTURE_TERMINEE', 'MANGA'),
(275, 'Bookhead', 'LECTURE_TERMINEE', 'MANGA'),
(276, 'Naruto: Minato spin-off', 'LECTURE_TERMINEE', 'MANGA'),
(277, 'Re zero', 'ANIME_EN_COURS', 'ANIME'),
(278, 'Id:invaded', 'LECTURE_TERMINEE', 'MANGA'),
(279, 'Shojo Null', 'LECTURE_TERMINEE', 'MANGA'),
(280, 'King''s Game', 'LECTURE_TERMINEE', 'MANGA'),
(281, 'King''s Game Extreme', 'LECTURE_TERMINEE', 'MANGA'),
(282, 'Darwin''s Game', 'LECTURE_TERMINEE', 'MANGA'),
(283, 'School Days', 'ANIME_EN_COURS', 'ANIME'),
(284, 'Doubt', 'LECTURE_TERMINEE', 'MANGA'),
(285, 'Judge', 'LECTURE_TERMINEE', 'MANGA'),
(286, 'Secret', 'LECTURE_EN_COURS', 'MANGA'),
(287, 'Dead company', 'LECTURE_EN_COURS', 'MANGA'),
(288, 'Alive', 'LECTURE_TERMINEE', 'MANGA'),
(289, 'Oshi no ko', 'LECTURE_TERMINEE', 'MANGA'),
(290, 'Oshi no ko', 'ANIME_EN_COURS', 'ANIME'),
(291, 'Kaguya-sama: love is war', 'LECTURE_TERMINEE', 'MANGA'),
(292, 'Vagabond', 'LECTURE_TERMINEE', 'MANGA'),
(293, 'Akame ga kill!', 'LECTURE_TERMINEE', 'MANGA'),
(294, 'Le livre des multivers', 'LECTURE_TERMINEE', 'MANWHA'),
(295, 'Ariadne', 'LECTURE_EN_COURS', 'MANGA'),
(296, 'Blade of the Moon Princess', 'LECTURE_EN_COURS', 'MANGA'),
(297, 'Prophecy', 'LECTURE_TERMINEE', 'MANGA'),
(298, 'Starving Anonymous', 'LECTURE_TERMINEE', 'MANGA'),
(299, 'Kokkoku', 'LECTURE_TERMINEE', 'MANGA'),
(300, 'Lookism', 'LECTURE_TERMINEE', 'MANWHA'),
(301, 'Manager Kim', 'LECTURE_TERMINEE', 'MANWHA'),
(302, 'One Shot Marriage Toxin', 'LECTURE_TERMINEE', 'MANGA'),
(303, 'My hero academia Vigilante', 'LECTURE_TERMINEE', 'MANGA'),
(304, 'Kagurabachi', 'LECTURE_TERMINEE', 'MANGA'),
(305, 'Denjin N', 'LECTURE_TERMINEE', 'MANGA'),
(306, 'Gachiakuta', 'LECTURE_TERMINEE', 'MANGA'),
(307, 'Gachiakuta', 'ANIME_EN_COURS', 'ANIME'),
(308, 'The killer inside', 'LECTURE_EN_COURS', 'MANGA'),
(309, 'Magical girl of the end', 'LECTURE_TERMINEE', 'MANGA'),
(310, 'Scissors Seven', 'ANIME_TERMINE', 'ANIME'),
(311, 'Kid I luck', 'LECTURE_EN_COURS', 'MANGA'),
(312, 'The kingdom of ruins', 'ANIME_EN_COURS', 'ANIME'),
(313, 'Sleepy Boy', 'LECTURE_EN_COURS', 'MANGA'),
(314, 'Abara', 'LECTURE_TERMINEE', 'MANGA'),
(315, 'Shangri-la-Frontier', 'LECTURE_EN_COURS', 'MANGA'),
(316, 'Raising Hell', 'LECTURE_TERMINEE', 'MANWHA'),
(317, 'Shadow eliminators', 'LECTURE_TERMINEE', 'MANGA'),
(318, 'Zomgan', 'LECTURE_TERMINEE', 'MANWHA'),
(319, 'Survivre à ses parents toxiques', 'LECTURE_TERMINEE', 'MANGA'),
(320, 'Kaiju n°8 B-side', 'LECTURE_TERMINEE', 'MANGA'),
(321, 'Atsro Baby', 'LECTURE_EN_COURS', 'MANGA'),
(322, 'Blood C', 'ANIME_TERMINE', 'ANIME'),
(323, 'Skeleton Double', 'LECTURE_TERMINEE', 'MANGA'),
(324, 'Gleipnir', 'LECTURE_TERMINEE', 'MANGA'),
(325, 'Ankoku delta', 'LECTURE_TERMINEE', 'MANGA'),
(326, 'Killer Peter', 'LECTURE_TERMINEE', 'MANWHA'),
(327, 'Durarara !!', 'LECTURE_TERMINEE', 'MANGA'),
(328, 'The summer Hikaru died', 'LECTURE_TERMINEE', 'MANGA'),
(329, 'gift of poison', 'LECTURE_TERMINEE', 'MANGA'),
(330, 'Astro Royale', 'LECTURE_TERMINEE', 'MANGA');

INSERT INTO TEXTE (SERIE_CODE) VALUES
(1),(3),(5),(8),(10),(12),(13),(14),(15),(16),
(17),(18),(20),(21),(23),(25),(27),(29),(31),(33),
(35),(38),(40),(42),(44),(46),(47),(50),(51),(53),
(55),(56),(58),(60),(62),(64),(66),(69),(70),(72),
(74),(75),(77),(78),(79),(80),(82),(85),(87),(88),
(89),(91),(92),(94),(95),(96),(97),(99),(100),(102),
(103),(104),(106),(110),(111),(113),(115),(116),(117),(118),
(120),(122),(124),(125),(127),(128),(129),(130),(131),(132),
(133),(134),(135),(136),(137),(138),(139),(140),(141),(142),
(143),(144),(145),(147),(148),(149),(150),(151),(152),(153),
(154),(155),(156),(157),(158),(159),(160),(161),(162),(163),
(164),(165),(166),(167),(168),(169),(170),(171),(172),(173),
(174),(175),(176),(177),(178),(179),(181),(182),(183),(184),
(185),(186),(187),(188),(189),(190),(191),(192),(193),(194),
(195),(196),(197),(198),(199),(200),(201),(202),(203),(204),
(205),(206),(207),(209),(210),(212),(214),(216),(218),(219),
(221),(222),(224),(227),(228),(230),(231),(233),(234),(236),
(238),(239),(242),(243),(244),(246),(247),(248),(249),(252),
(254),(256),(257),(258),(259),(260),(261),(262),(264),(265),
(266),(267),(268),(271),(272),(273),(274),(275),(276),(278),
(279),(280),(281),(282),(284),(285),(286),(287),(288),(289),
(291),(292),(293),(294),(295),(296),(297),(298),(299),(300),
(301),(302),(303),(304),(305),(306),(308),(309),(311),(313),
(314),(315),(316),(317),(318),(319),(320),(321),(323),(324),
(325),(326),(327),(328),(329),(330);

INSERT INTO MANGA (CODE_MANGA, SERIE_CODE, NOM) VALUES
(1, 1, 'Jojo part 1 : Phantom Blood'),
(2, 3, 'Jojo part 2 : Battle Tendency'),
(3, 5, 'Jojo part 3: Stardust Crusader'),
(4, 8, 'Jojo part 5 : Golden Wind'),
(5, 10, 'Jojo part 6 : Stone Ocean'),
(6, 12, 'Jojo part 7 : Steel Ball Run'),
(7, 13, 'Jojo part 8 : Jojolion'),
(8, 14, 'Jojo part 9 : The Jojolands'),
(9, 15, 'Jjk 0'),
(10, 16, 'Under Execution, Under Jailbreak'),
(11, 17, 'Crazy D. Demonic Heartbreak'),
(12, 18, 'Thus Spoke Kishibe Rohan'),
(13, 20, 'Dead Man'),
(14, 21, 'Fullmetal Alchemist'),
(15, 23, 'Naruto'),
(16, 25, 'Boruto'),
(17, 27, 'Parasyte The Maxim'),
(18, 29, 'Attack on Titan'),
(19, 31, 'Bleach'),
(20, 33, 'One Piece'),
(21, 35, 'One Punch Man'),
(22, 38, 'Tokyo Ghoul'),
(23, 40, 'Tokyo Ghoul:re'),
(24, 47, 'Death Note'),
(25, 51, 'Demon slayer'),
(26, 53, 'Fairy tail'),
(27, 55, 'Fairy tail 100 years quest'),
(28, 56, 'Chainsaw Man'),
(29, 58, 'Mob psycho 100'),
(30, 60, 'Black clover'),
(31, 62, 'Seven deadly sins'),
(32, 64, 'Hunter X Hunter'),
(33, 66, 'Blue exorcist'),
(34, 69, 'Magus of The Library'),
(35, 70, 'The promised neverland'),
(36, 72, 'Assassination classroom'),
(37, 74, 'Le samouraï insaisissable'),
(38, 75, 'Jujutsu kaisen'),
(39, 77, 'Dandadan'),
(40, 78, 'Kaiju n°8'),
(41, 79, 'Mashle'),
(42, 80, 'Dr Stone'),
(43, 82, 'Sakamoto days'),
(44, 85, 'Battle game in 5 seconds'),
(45, 88, 'Broken Blade'),
(46, 89, 'Tomie'),
(47, 91, 'L'),
(48, 92, 'Ajin'),
(49, 94, 'Noragami'),
(50, 95, 'Beelzebub'),
(51, 96, 'Monster'),
(52, 97, 'Pupa'),
(53, 99, 'Choujin X'),
(54, 100, 'Fire Force'),
(55, 102, 'Soul Eater'),
(56, 103, 'D-Gray Man'),
(57, 104, '666 Satan'),
(58, 106, 'Sky-high survival'),
(59, 110, 'Bonne nuit Punpun'),
(60, 111, 'Spy X Family'),
(61, 113, 'Tokyo Revengers'),
(62, 115, 'Birdmen'),
(63, 116, 'Alice in borderland'),
(64, 117, 'Thermae romae'),
(65, 118, 'Four knights of apocalypse'),
(66, 120, 'My hero academia'),
(67, 122, 'Yakitate Ja-pan'),
(68, 124, 'Akira'),
(69, 125, 'Yomotsuhegui'),
(70, 135, 'Metamorphosis'),
(71, 136, 'Evil Heroes'),
(72, 137, 'A silent voice'),
(73, 138, 'Berserk'),
(74, 139, 'Ascension'),
(75, 140, 'Alice in Borderland retry'),
(76, 141, 'Alice on Border road'),
(77, 142, 'Bokura no ketsumei'),
(78, 143, 'Defense devil'),
(79, 144, 'Diabolic garden'),
(80, 145, 'Tripeace'),
(81, 207, 'Tomodachi game'),
(82, 209, 'Dragon Ball'),
(83, 210, 'Dragon Ball Z'),
(84, 212, 'Blame!'),
(85, 214, 'Radiant'),
(86, 216, 'Dorohedoro'),
(87, 218, 'Baki The Grappler'),
(88, 219, 'Baki The New Grappler'),
(89, 221, 'Hanma Baki'),
(90, 222, 'Valkyrie apocalypse'),
(91, 224, 'World'),
(92, 227, 'To your eternity'),
(93, 228, 'Vinland Saga'),
(94, 230, 'Blue Lock'),
(95, 233, 'Hell'),
(96, 234, 'Made in Abyss'),
(97, 236, 'Tougen Anki'),
(98, 238, 'La zone fantôme'),
(99, 239, 'Shibatarian'),
(100, 242, 'Ayashimon'),
(101, 243, 'Neun'),
(102, 244, 'Another'),
(103, 246, 'Dimension W'),
(104, 247, 'Aliens Area'),
(105, 248, 'Space Brothers'),
(106, 249, 'Homunculus'),
(107, 252, 'Snk 0'),
(108, 254, 'Battle Royale'),
(109, 256, 'Im'),
(110, 257, 'L'),
(111, 258, 'Btooom!'),
(112, 259, 'Juujika no rokunin'),
(113, 260, 'Gestalt'),
(114, 261, 'Last Hero Inuyashiki'),
(115, 262, 'Deadman Wonderland'),
(116, 264, 'Bucket list of the dead'),
(117, 265, 'Kengan Ashura'),
(118, 266, 'Marriage Toxin'),
(119, 268, 'Blood Lad'),
(120, 271, 'Wild Strawberry'),
(121, 272, 'Léviathan'),
(122, 273, 'Undead Unluck'),
(123, 274, 'YuYu Hakusho'),
(124, 275, 'Bookhead'),
(125, 276, 'Naruto: Minato spin-off'),
(126, 278, 'Id:invaded'),
(127, 279, 'Shojo Null'),
(128, 280, 'King'),
(129, 281, 'King'),
(130, 282, 'Darwin'),
(131, 284, 'Doubt'),
(132, 285, 'Judge'),
(133, 286, 'Secret'),
(134, 287, 'Dead company'),
(135, 288, 'Alive'),
(136, 289, 'Oshi no ko'),
(137, 291, 'Kaguya-sama: love is war'),
(138, 292, 'Vagabond'),
(139, 293, 'Akame ga kill!'),
(140, 295, 'Ariadne'),
(141, 296, 'Blade of the Moon Princess'),
(142, 297, 'Prophecy'),
(143, 298, 'Starving Anonymous'),
(144, 299, 'Kokkoku'),
(145, 302, 'One Shot Marriage Toxin'),
(146, 303, 'My hero academia Vigilante'),
(147, 304, 'Kagurabachi'),
(148, 305, 'Denjin N'),
(149, 306, 'Gachiakuta'),
(150, 308, 'The killer inside'),
(151, 309, 'Magical girl of the end'),
(152, 311, 'Kid I luck'),
(153, 313, 'Sleepy Boy'),
(154, 314, 'Abara'),
(155, 315, 'Shangri-la-Frontier'),
(156, 317, 'Shadow eliminators'),
(157, 319, 'Survivre à ses parents toxiques'),
(158, 320, 'Kaiju n°8 B-side'),
(159, 321, 'Atsro Baby'),
(160, 323, 'Skeleton Double'),
(161, 324, 'Gleipnir'),
(162, 325, 'Ankoku delta'),
(163, 327, 'Durarara !!'),
(164, 328, 'The summer Hikaru died'),
(165, 329, 'gift of poison'),
(166, 330, 'Astro Royale');

INSERT INTO MANWHA (CODE_MANWHA, SERIE_CODE, NOM) VALUES
(1, 42, 'Tower of God'),
(2, 44, 'The God of High School'),
(3, 46, 'Bâtard'),
(4, 127, 'Gradalis'),
(5, 128, 'Conseil d'),
(6, 129, 'La jacynthe violette'),
(7, 130, 'The Red king'),
(8, 131, 'Cruelle innocence'),
(9, 132, 'Ghost teller'),
(10, 133, 'Hell is other people'),
(11, 134, 'Ashen Hearts'),
(12, 147, 'No scars'),
(13, 148, 'Traqueurs'),
(14, 149, 'Dead life'),
(15, 150, 'L'),
(16, 151, 'Une seconde'),
(17, 152, 'Virtual runaways'),
(18, 153, 'Doppelganger'),
(19, 154, 'Vos commentaires ensoleillent ma journée'),
(20, 155, 'L'),
(21, 156, 'Player'),
(22, 157, 'L'),
(23, 158, 'Pawer stone'),
(24, 159, 'La voie du masque'),
(25, 160, 'Revenge game'),
(26, 161, 'Villain to kill'),
(27, 162, 'Fantoons'),
(28, 163, 'Une famille parfaite'),
(29, 164, 'Mon plus grand secret'),
(30, 165, 'Killstagram'),
(31, 166, 'Hellbound'),
(32, 167, 'Mort imminente'),
(33, 168, 'Nan yak'),
(34, 169, 'Chateau d'),
(35, 170, 'Game of doppelganger'),
(36, 171, 'White blood'),
(37, 172, 'Bestia'),
(38, 173, 'Dedrais le peuple oublié'),
(39, 174, 'Sindorim'),
(40, 175, 'Lumine'),
(41, 176, 'Urban animal'),
(42, 177, 'Folie meurtrière'),
(43, 178, 'Everything is fine'),
(44, 179, 'Sweet home'),
(45, 181, 'Héros fragile'),
(46, 182, 'Viral hit'),
(47, 183, 'The boxer'),
(48, 184, 'Hardcore leveling warrior'),
(49, 185, 'I'),
(50, 186, 'Not even bones'),
(51, 187, 'Escape room'),
(52, 188, 'Lecteur omniscient'),
(53, 189, 'Night of silence'),
(54, 190, 'Le garçon au fusil'),
(55, 191, 'Sang et papillons'),
(56, 192, 'Justin bisou'),
(57, 193, 'Unordinary'),
(58, 194, 'Adventures of god'),
(59, 195, 'Hero ticket'),
(60, 196, 'Change-moi'),
(61, 197, 'Jungle juice'),
(62, 198, 'L'),
(63, 199, 'Capitaine Zorgue'),
(64, 200, 'The gamer'),
(65, 201, 'High-school mercenary'),
(66, 202, 'Winter moon'),
(67, 203, 'La dose'),
(68, 204, 'Nano list'),
(69, 205, 'Hero killer'),
(70, 206, 'L'),
(71, 231, 'Solo Leveling'),
(72, 267, '+99 reinforced wooden stick'),
(73, 294, 'Le livre des multivers'),
(74, 300, 'Lookism'),
(75, 301, 'Manager Kim'),
(76, 316, 'Raising Hell'),
(77, 318, 'Zomgan'),
(78, 326, 'Killer Peter');

INSERT INTO LN (CODE_LN, SERIE_CODE, NOM) VALUES
(1, 50, 'Jojo Over Heaven'),
(2, 87, 'Ace Novel');

INSERT INTO ANIME (CODE_ANIME, SERIE_CODE, NOM) VALUES
(1, 2, 'Jojo part 1 : Phantom Blood'),
(2, 4, 'Jojo part 2 : Battle Tendency'),
(3, 6, 'Jojo part 3: Stardust Crusader'),
(4, 7, 'Jojo part 4: Diamond is Unbreakable'),
(5, 9, 'Jojo part 5 : Golden Wind'),
(6, 11, 'Jojo part 6 : Stone Ocean'),
(7, 19, 'Thus Spoke Kishibe Rohan'),
(8, 22, 'Fullmetal Alchemist'),
(9, 24, 'Naruto'),
(10, 26, 'Boruto'),
(11, 28, 'Parasyte The Maxim'),
(12, 30, 'Attack on Titan'),
(13, 32, 'Bleach'),
(14, 34, 'One Piece'),
(15, 36, 'One Punch Man'),
(16, 39, 'Tokyo Ghoul'),
(17, 41, 'Tokyo Ghoul:re'),
(18, 43, 'Tower of God'),
(19, 45, 'The God of High School'),
(20, 48, 'Death Note'),
(21, 52, 'Demon slayer'),
(22, 54, 'Fairy tail'),
(23, 57, 'Chainsaw Man'),
(24, 59, 'Mob psycho 100'),
(25, 61, 'Black clover'),
(26, 63, 'Seven deadly sins'),
(27, 65, 'Hunter X Hunter'),
(28, 67, 'Blue exorcist'),
(29, 68, 'No game no life'),
(30, 71, 'The promised neverland'),
(31, 73, 'Assassination classroom'),
(32, 76, 'Jujutsu kaisen'),
(33, 81, 'Dr Stone'),
(34, 83, 'Sakamoto days'),
(35, 84, 'Devilman crybaby'),
(36, 86, 'Battle game in 5 seconds'),
(37, 90, 'Mushoku tensei'),
(38, 93, 'Ajin'),
(39, 98, 'Pupa'),
(40, 101, 'Fire Force'),
(41, 105, 'B the beginning'),
(42, 107, 'Sky-high survival'),
(43, 108, 'High-school of the dead'),
(44, 109, 'Gambling School'),
(45, 112, 'Spy X Family'),
(46, 114, 'Tokyo Revengers'),
(47, 119, 'Darling in the franxx'),
(48, 121, 'My hero academia'),
(49, 126, 'Overflow'),
(50, 208, 'Tomodachi game'),
(51, 211, 'Dragon Ball Z'),
(52, 213, 'Blame!'),
(53, 215, 'Radiant'),
(54, 217, 'Dorohedoro'),
(55, 220, 'Baki The New Grappler'),
(56, 223, 'Valkyrie apocalypse'),
(57, 225, 'World'),
(58, 226, 'Pokémon'),
(59, 229, 'Death parade'),
(60, 232, 'Solo Leveling'),
(61, 235, 'Made in Abyss'),
(62, 237, 'Tougen Anki'),
(63, 240, 'Tensura'),
(64, 241, 'Ranking of kings'),
(65, 245, 'Another'),
(66, 250, 'Astro Boy'),
(67, 251, 'Terror in Resonance'),
(68, 253, 'Steins Gate'),
(69, 255, 'Psycho-Pass'),
(70, 263, 'Summertime Rendering'),
(71, 269, 'Tengoku Daimakyo'),
(72, 270, 'Dororo'),
(73, 277, 'Re zero'),
(74, 283, 'School Days'),
(75, 290, 'Oshi no ko'),
(76, 307, 'Gachiakuta'),
(77, 310, 'Scissors Seven'),
(78, 312, 'The kingdom of ruins'),
(79, 322, 'Blood C');

INSERT INTO LIVE_ACTION (LA_CODE, SERIE_CODE, NOM) VALUES
(1, 49, 'Death Note'),
(2, 146, 'Alice in borderland'),
(3, 180, 'Sweet home');