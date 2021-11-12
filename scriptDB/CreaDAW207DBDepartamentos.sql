/**
 * Author:  Alberto Fernandez Ramirez
 * Created: 3 nov. 2021
 * Script creación de base de datos y usuario
 */
-- Crear base de datos Departamentos
CREATE DATABASE IF NOT EXISTS DAW207DBDepartamentos;

-- CREAR Tabla Departamento dentro de la base de datos DAW207DBDepartamentos
CREATE TABLE IF NOT EXISTS DAW207DBDepartamentos.Departamento(
    CodDepartamento varchar(3) PRIMARY KEY,
    DescDepartamento varchar(255) NOT NULL,
    FechaBaja date NULL,
    VolumenNegocio float NULL
)engine=innodb;

-- Crear usuario
CREATE USER 'usuarioDAW207DBDepartamentos'@'%' IDENTIFIED BY 'P@ssw0rd';
-- Dar permisos al usuario
GRANT ALL PRIVILEGES ON DAW207DBDepartamentos.* to 'usuarioDAW207DBDepartamentos'@'%' WITH GRANT OPTION;