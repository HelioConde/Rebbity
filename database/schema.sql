-- Rebbity: esquema inicial para AMBIENTES VAZIOS.
-- NÃO executar sobre banco legado com dados sem backup e migração revisada.
-- mysql --default-character-set=utf8mb4 -u "$REBBITY_DB_USER" -p "$REBBITY_DB_NAME" < database/schema.sql

CREATE TABLE IF NOT EXISTS client (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  password VARCHAR(255) NOT NULL,
  phone VARCHAR(25) NOT NULL,
  bank VARCHAR(30) NOT NULL DEFAULT '',
  agency VARCHAR(30) NOT NULL DEFAULT '',
  `count` VARCHAR(25) NOT NULL DEFAULT '',
  digit VARCHAR(25) NOT NULL DEFAULT '',
  cep VARCHAR(25) NOT NULL,
  city VARCHAR(100) NOT NULL,
  state VARCHAR(35) NOT NULL,
  district VARCHAR(100) NOT NULL,
  address VARCHAR(150) NOT NULL,
  class VARCHAR(30) NOT NULL,
  complement VARCHAR(100) NOT NULL DEFAULT '',
  corporateName VARCHAR(120) NOT NULL,
  cnpj VARCHAR(30) NOT NULL,
  porpName VARCHAR(100) NOT NULL DEFAULT '',
  cpf VARCHAR(25) NOT NULL DEFAULT '',
  rg VARCHAR(25) NOT NULL DEFAULT '',
  typeTable VARCHAR(30) NOT NULL,
  block VARCHAR(30) NOT NULL DEFAULT 'true',
  token VARCHAR(100) NOT NULL DEFAULT '0',
  PRIMARY KEY (id),
  UNIQUE KEY uq_client_email (email),
  UNIQUE KEY uq_client_cnpj (cnpj)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS category (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  id_client INT UNSIGNED NOT NULL,
  name VARCHAR(100) NOT NULL,
  type VARCHAR(100) NOT NULL,
  ranger VARCHAR(100) NOT NULL DEFAULT '',
  rangeMin VARCHAR(100) NOT NULL DEFAULT '',
  rangeMax VARCHAR(100) NOT NULL DEFAULT '',
  PRIMARY KEY (id),
  KEY idx_category_client (id_client),
  CONSTRAINT fk_category_client FOREIGN KEY (id_client)
    REFERENCES client(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS item (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  id_client INT UNSIGNED NOT NULL,
  id_category INT UNSIGNED NOT NULL,
  name VARCHAR(100) NOT NULL,
  sale VARCHAR(100) NOT NULL,
  description VARCHAR(100) NOT NULL DEFAULT '',
  PDV VARCHAR(100) NOT NULL DEFAULT '',
  img LONGTEXT NOT NULL,
  turn1 VARCHAR(100) NOT NULL DEFAULT '',
  turn2 VARCHAR(100) NOT NULL DEFAULT '',
  turn3 VARCHAR(100) NOT NULL DEFAULT '',
  PRIMARY KEY (id),
  KEY idx_item_client (id_client),
  KEY idx_item_category (id_category),
  CONSTRAINT fk_item_client FOREIGN KEY (id_client)
    REFERENCES client(id) ON DELETE CASCADE,
  CONSTRAINT fk_item_category FOREIGN KEY (id_category)
    REFERENCES category(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
