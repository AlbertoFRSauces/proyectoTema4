/**
 * Author:  Alberto Fernandez Ramirez
 * Created: 3 nov. 2021
 * Script creación de base de datos y usuario
 */
-- Crear base de datos Departamentos
CREATE DATABASE IF NOT EXISTS DB207DWESProyectoTema4;

-- CREAR Tabla Departamento dentro de la base de datos DAW207DBDepartamentos
CREATE TABLE IF NOT EXISTS DB207DWESProyectoTema4.Departamento(
    CodDepartamento varchar(3) PRIMARY KEY,
    DescDepartamento varchar(255) NOT NULL,
    FechaBaja date NULL,
    VolumenNegocio float NULL
)engine=innodb;

-- Crear usuario
CREATE USER 'User207DWESProyectoTema4'@'%' IDENTIFIED BY 'P@ssw0rd';
-- Dar permisos al usuario
GRANT ALL PRIVILEGES ON DB207DWESProyectoTema4.* to 'User207DWESProyectoTema4'@'%' WITH GRANT OPTION;