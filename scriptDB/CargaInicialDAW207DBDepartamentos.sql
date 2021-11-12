/**
 * Author:  Alberto Fernandez Ramirez
 * Created: 3 nov. 2021
 * Script carga inicial de base de datos
 */
USE DAW207DBDepartamentos;
-- Insertar datos en la tabla Departamento de la base de datos DAW207DBDepartamentos
INSERT INTO Departamento (CodDepartamento, DescDepartamento, FechaBaja, VolumenNegocio) VALUES
('INF','Departamento de Informatica',null,1.5),
('BIO','Departamento de Biologia',null,2.5),
('ING','Departamento de Inglés',null,3.5),
('LEN','Departamento de Lengua',null,4.5),
('MUS','Departamento de Musica',null,1.5);
