-- Script de criação do Banco de Dados para o Sistema de PetShop
-- Autor: [José Luiz Vieira]

CREATE DATABASE IF NOT EXISTS petshop_db;
USE petshop_db;

CREATE TABLE IF NOT EXISTS atendimentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tutor_nome VARCHAR(100) NOT NULL,
    endereco VARCHAR(255),
    telefone VARCHAR(20) NOT NULL,
    pet_nome VARCHAR(100) NOT NULL,
    pet_tipo VARCHAR(50),
    pet_raca VARCHAR(50),
    servico VARCHAR(100),
    observacoes TEXT,
    status ENUM('Em andamento', 'Ligar para cliente', 'Finalizado') DEFAULT 'Em andamento',
    data_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
