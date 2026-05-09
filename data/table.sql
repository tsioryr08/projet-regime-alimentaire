-- ============================================================
--  BASE DE DONNÉES : Application Régime Alimentaire
--  Projet S4 — Tsiory, Nekena, Olivier
--  Généré le : 06 mai 2026
-- ============================================================

CREATE DATABASE IF NOT EXISTS regime_db
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE regime_db;

-- ============================================================
--  TABLE : utilisateurs
--  Gérée par : Nekena
-- ============================================================
CREATE TABLE utilisateurs (
    id                  INT AUTO_INCREMENT PRIMARY KEY,
    nom                 VARCHAR(100) NOT NULL,
    prenom              VARCHAR(100) NOT NULL,
    email               VARCHAR(150) NOT NULL UNIQUE,
    password            VARCHAR(255) NOT NULL,
    genre               ENUM('homme', 'femme') NOT NULL,
    date_naissance      DATE NOT NULL,
    taille              DECIMAL(5,2) NOT NULL COMMENT 'en mètres, ex: 1.75',
    poids               DECIMAL(5,2) NOT NULL COMMENT 'en kg',
    objectif            ENUM('augmenter_poids', 'reduire_poids', 'imc_ideal') NOT NULL,
    solde_portefeuille  DECIMAL(10,2) DEFAULT 0.00,
    is_gold             TINYINT(1) DEFAULT 0,
    gold_paid_at        DATETIME DEFAULT NULL,
    created_at          DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at          DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ============================================================
--  TABLE : imc_historique
--  Gérée par : Tsiory
-- ============================================================
CREATE TABLE imc_historique (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id  INT NOT NULL,
    valeur_imc      DECIMAL(5,2) NOT NULL,
    categorie       ENUM('maigreur', 'normal', 'surpoids', 'obesite') NOT NULL,
    date_calcul     DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE
);

-- ============================================================
--  TABLE : regimes
--  Gérée par : Tsiory (données) + Olivier (CRUD admin)
-- ============================================================
CREATE TABLE regimes (
    id                  INT AUTO_INCREMENT PRIMARY KEY,
    nom                 VARCHAR(150) NOT NULL,
    description         TEXT,
    prix_base           DECIMAL(10,2) NOT NULL COMMENT 'prix pour la durée de base',
    duree_jours         INT NOT NULL COMMENT 'durée en jours',
    variation_poids     DECIMAL(4,2) NOT NULL COMMENT 'kg gagnés ou perdus',
    sens_variation      ENUM('prise', 'perte') NOT NULL,
    pct_viande          INT NOT NULL COMMENT 'pourcentage viande (0-100)',
    pct_poisson         INT NOT NULL COMMENT 'pourcentage poisson (0-100)',
    pct_volaille        INT NOT NULL COMMENT 'pourcentage volaille (0-100)',
    categorie_imc       ENUM('maigreur', 'normal', 'surpoids', 'obesite', 'tous') NOT NULL,
    created_at          DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at          DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ============================================================
--  TABLE : activites
--  Gérée par : Tsiory (données) + Olivier (CRUD admin)
-- ============================================================
CREATE TABLE activites (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    nom             VARCHAR(150) NOT NULL,
    description     TEXT,
    duree_semaines  INT NOT NULL COMMENT 'durée recommandée en semaines',
    frequence       VARCHAR(100) COMMENT 'ex: 3 fois par semaine',
    calories_par_h  INT COMMENT 'calories brûlées par heure',
    categorie_imc   ENUM('maigreur', 'normal', 'surpoids', 'obesite', 'tous') NOT NULL,
    objectif_cible  ENUM('augmenter_poids', 'reduire_poids', 'imc_ideal', 'tous') NOT NULL,
    created_at      DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- ============================================================
--  TABLE : suggestions
--  Gérée par : Tsiory
-- ============================================================
CREATE TABLE suggestions (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id  INT NOT NULL,
    regime_id       INT NOT NULL,
    activite_id     INT NOT NULL,
    date_suggestion DATETIME DEFAULT CURRENT_TIMESTAMP,
    prix_final      DECIMAL(10,2) NOT NULL COMMENT 'prix après remise Gold si applicable',
    remise_gold     TINYINT(1) DEFAULT 0,
    exported_pdf    TINYINT(1) DEFAULT 0,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE,
    FOREIGN KEY (regime_id)      REFERENCES regimes(id)      ON DELETE CASCADE,
    FOREIGN KEY (activite_id)    REFERENCES activites(id)    ON DELETE CASCADE
);

-- ============================================================
--  TABLE : codes
--  Gérée par : Nekena (front) + Olivier (validation admin)
-- ============================================================
CREATE TABLE codes (
    id               INT AUTO_INCREMENT PRIMARY KEY,
    code             VARCHAR(50) NOT NULL UNIQUE,
    montant          DECIMAL(10,2) NOT NULL,
    est_valide       TINYINT(1) DEFAULT 1 COMMENT '1=disponible, 0=déjà utilisé',
    utilisateur_id   INT DEFAULT NULL COMMENT 'qui a utilisé le code',
    date_utilisation DATETIME DEFAULT NULL,
    created_at       DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE SET NULL
);

-- ============================================================
--  TABLE : parametres
--  Gérée par : Olivier (CRUD admin)
-- ============================================================
CREATE TABLE parametres (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    cle         VARCHAR(100) NOT NULL UNIQUE,
    valeur      VARCHAR(255) NOT NULL,
    description VARCHAR(255),
    updated_at  DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ============================================================
--  TABLE : admins
--  Gérée par : Olivier
-- ============================================================
CREATE TABLE admins (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    nom        VARCHAR(100) NOT NULL,
    email      VARCHAR(150) NOT NULL UNIQUE,
    password   VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);


-- ============================================================
--  DONNÉES INITIALES
-- ============================================================

-- ─── 5 Utilisateurs (password = "password123" hashé en MD5 pour l'exemple)
INSERT INTO utilisateurs (nom, prenom, email, password, genre, date_naissance, taille, poids, objectif, solde_portefeuille, is_gold) VALUES
('Rakoto',    'Jean',    'jean.rakoto@gmail.com',    MD5('password123'), 'homme', '1995-03-15', 1.75, 85.00, 'reduire_poids',    10000.00, 0),
('Rasoa',     'Marie',   'marie.rasoa@gmail.com',    MD5('password123'), 'femme', '1998-07-22', 1.62, 48.00, 'augmenter_poids',  5000.00,  0),
('Andry',     'Paul',    'paul.andry@gmail.com',     MD5('password123'), 'homme', '1990-11-05', 1.80, 95.00, 'reduire_poids',    20000.00, 1),
('Rakotondr', 'Hanta',   'hanta.r@gmail.com',        MD5('password123'), 'femme', '2000-01-30', 1.58, 55.00, 'imc_ideal',        0.00,     0),
('Razafy',    'Feno',    'feno.razafy@gmail.com',    MD5('password123'), 'homme', '1993-09-18', 1.70, 70.00, 'imc_ideal',        15000.00, 0);

-- ─── 5 Régimes
INSERT INTO regimes (nom, description, prix_base, duree_jours, variation_poids, sens_variation, pct_viande, pct_poisson, pct_volaille, categorie_imc) VALUES
('Régime Méditerranéen',
 'Riche en légumes, fruits, céréales complètes et huile d''olive. Idéal pour perdre du poids progressivement.',
 45000.00, 30, 3.50, 'perte', 20, 40, 40, 'surpoids'),

('Régime Hyperprotéiné',
 'Apport élevé en protéines pour favoriser la prise de masse musculaire et augmenter le poids sainement.',
 55000.00, 45, 4.00, 'prise', 40, 20, 40, 'maigreur'),

('Régime Cétogène',
 'Très faible en glucides, riche en lipides. Permet une perte de poids rapide en brûlant les graisses.',
 60000.00, 30, 5.00, 'perte', 35, 30, 35, 'obesite'),

('Régime Équilibré Standard',
 'Alimentation variée et équilibrée pour maintenir ou atteindre un IMC idéal.',
 35000.00, 30, 2.00, 'perte', 30, 35, 35, 'normal'),

('Régime Prise de Masse',
 'Augmentation calorique contrôlée avec suivi des macronutriments pour une prise de poids musculaire.',
 50000.00, 60, 6.00, 'prise', 45, 15, 40, 'maigreur');

-- ─── 5 Activités sportives
INSERT INTO activites (nom, description, duree_semaines, frequence, calories_par_h, categorie_imc, objectif_cible) VALUES
('Marche rapide',
 'Activité douce recommandée pour commencer ou pour les personnes en surpoids. Facile à intégrer au quotidien.',
 8, '5 fois par semaine', 300, 'surpoids', 'reduire_poids'),

('Natation',
 'Sport complet sans impact sur les articulations. Idéal pour brûler des calories et tonifier le corps.',
 6, '3 fois par semaine', 500, 'obesite', 'reduire_poids'),

('Musculation',
 'Entraînement en salle avec charges pour développer la masse musculaire et augmenter le poids corporel.',
 12, '4 fois par semaine', 400, 'maigreur', 'augmenter_poids'),

('Yoga / Stretching',
 'Améliore la souplesse, réduit le stress et aide à maintenir un poids stable et un IMC idéal.',
 8, '3 fois par semaine', 200, 'normal', 'imc_ideal'),

('Cardio HIIT',
 'Entraînement fractionné haute intensité. Très efficace pour brûler les graisses rapidement.',
 6, '3 fois par semaine', 700, 'surpoids', 'reduire_poids');

-- ─── 15 Codes porte-monnaie
INSERT INTO codes (code, montant) VALUES
('BIENVENUE2026',  5000.00),
('REGIME-GOLD',   10000.00),
('FIT-MAI-01',     3000.00),
('FIT-MAI-02',     3000.00),
('FIT-MAI-03',     3000.00),
('SANTE-PLUS',     7500.00),
('ACTIF-2026',     4000.00),
('MINCEUR-TOP',    6000.00),
('MUSCLE-UP',      8000.00),
('PROMO-SPECIAL',  2500.00),
('HAPPY-BODY',     5000.00),
('SLIM-FAST',      4500.00),
('WELL-BEING',     3500.00),
('BOOST-IMC',      6500.00),
('VIP-REGIME',    15000.00);

-- ─── Suggestions initiales pour les statistiques du dashboard
INSERT INTO suggestions (utilisateur_id, regime_id, activite_id, prix_final, remise_gold, exported_pdf) VALUES
(1, 1, 1, 45000.00, 0, 0),
(1, 4, 4, 35000.00, 0, 0),
(2, 2, 3, 55000.00, 0, 1),
(3, 1, 2, 38250.00, 1, 1),
(3, 3, 2, 60000.00, 1, 0),
(4, 5, 3, 50000.00, 0, 0),
(5, 4, 4, 35000.00, 0, 1),
(5, 2, 3, 55000.00, 0, 0),
(2, 5, 5, 50000.00, 0, 0),
(4, 4, 1, 35000.00, 0, 0);

-- ─── Paramètres système
INSERT INTO parametres (cle, valeur, description) VALUES
('prix_gold',       '50000',  'Prix de l''option Gold en Ariary'),
('remise_gold',     '15',     'Pourcentage de remise pour les membres Gold'),
('duree_min_jours', '30',     'Durée minimale d''un régime en jours'),
('duree_max_jours', '90',     'Durée maximale d''un régime en jours'),
('imc_maigreur_max','18.5',   'Valeur max IMC pour catégorie maigreur'),
('imc_normal_max',  '24.9',   'Valeur max IMC pour catégorie normale'),
('imc_surpoids_max','29.9',   'Valeur max IMC pour catégorie surpoids');

-- ─── Admin par défaut
INSERT INTO admins (nom, email, password) VALUES
('Administrateur', 'admin@regime-app.mg', MD5('admin2026'));


-- ============================================================
--  RAPPEL FORMULE IMC
--  IMC = poids (kg) / (taille (m) * taille (m))
--
--  < 18.5           → Maigreur
--  18.5 à 24.9      → Normal
--  25.0 à 29.9      → Surpoids
--  >= 30.0          → Obésité
-- ============================================================