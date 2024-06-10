-- drop database lesbva;
-- GICED gestion de inscriptos por carrera y ciclo, con capacidad de exportar datos
-- GAPECED gestion de alumnado por periodos en carrera y ciclo, con capacidad de exportar datos
create database lesbva;

use lesbva;

create table roles(
    rol_id int auto_increment,
    nombre_rol varchar (30),
    primary key (rol_id)
);

insert into roles (nombre_rol) values ('Administrador'), ('Director'), ('Profesor'), ('Alumno');


create table turnos(
    turno_id int auto_increment,
    turno varchar(15) UNIQUE,
    primary key (turno_id)
);

insert into turnos (turno) values ('Mañana'), ('Tarde'), ('Verpertino');

create table ciclo_lectivo(
    ciclo_id int auto_increment,
    turno_id int,
    ciclo int (4),
    foreign key (turno_id) references turnos(turno_id),
    primary key (ciclo_id, turno_id)
);

insert into ciclo_lectivo (turno_id, ciclo) values 
('1', 2024), ('2', 2024), ('3', 2024), 
('1', 2025), ('2', 2025), ('3', 2025);


create table usuarios(
    usuario_id int auto_increment,
    usuario_nombre varchar(30),
    apellido varchar(30),
    rol_id int,
    contrasenia varchar(30),
    email varchar(30) UNIQUE,
    dni int(8) UNIQUE,
    foreign key (rol_id) references roles(rol_id),
    primary key (usuario_id,rol_id)
);

insert into usuarios (usuario_nombre,apellido,rol_id,contrasenia,email,dni) values 
('Fernando','Lemos',1,'flemos','flemos@gmail.com',11112222),
('Lues','Sbarbati',1,'lsbarbati','lsbarbati@gmail.com',33334444),
('Matias','Vasca',1,'mvasca','mvasca@gmail.com',55556666),
('Walter','Muscolo',2,'wmuscolo','wmuscolo@gmail.com',77778888)
('pellegrini','profes',1,'vilches','profesores@gmail.com',77778888);



create table carreras(
    carrera_id int auto_increment,
    carrera_nombre varchar(70) UNIQUE,
    primary key (carrera_id)
);

insert into carreras (carrera_nombre) values 
('TECNICATURA EN ANÁLISIS DE SISTEMAS'),
('PROFESORADO DE MATEMÁTICA'),
('PROFESORADO DE INGLÉS'),
('PROFESORADO DE EDUCACIÓN INICIAL'),
('PROFESORADO DE EDUCACIÓN PRIMARIA'),
('CUFBA'),
('PROFESORADO DE QUÍMICA'),
('PROFESORADO DE FÍSICA'),
('PROFESORADO DE BIOLOGÍA');


create table materias(
    materia_id int auto_increment,
    materia_nombre varchar(45),
    curso varchar (2),
    profesor varchar (50),
    situacion_revista varchar (1), -- Titular ("T"), Provisional ("P"), Suplente ("S") y Nada ("-")
    cantidad_alumno int (3),
    ciclo_id int,
    carrera_id int,
    foreign key (ciclo_id) references ciclo_lectivo(ciclo_id),
    foreign key (carrera_id) references carreras(carrera_id),
    primary key (materia_id,ciclo_id,carrera_id)
); 

insert into materias (materia_nombre,curso,profesor,situacion_revista,cantidad_alumno,ciclo_id,carrera_id) values
('Inglés I', '1A','Alejandra Pérez', 'P', 63,3,1),
('Ciencia, Tecnología y Sociedad', '1A','Claudio Adan', 'P', 56,3,1),
('Análisis Matemático I', '1A', 'Juan Osamendia', 'P',56,3,1),
('Algebra', '1A', 'Melina Lucero', 'S', 66,3,1),
('Algoritmos y Estructuras de Datos I', '1A','Graciana Roldan', 'S',68,3,1),
('Sistemas y Organizaciones', '1A','Alejandro De Andreis', 'P',67,3,1),
('Arquitectura de Computadores', '1A','Graciana Roldan', 'P',59,3,1),
('Prácticas Profesionalizantes I A', '1A','Verónica Micheltorena', 'S',28,3,1),
('Prácticas Profesionalizantes I B', '1A','Alejandro De Andreis', 'S',28,3,1),


('Inglés I', '1B','Alejandra Pérez', 'P', 56,3,1),
('Ciencia, Tecnología y Sociedad', '1B','Claudio Adan', 'P', 58,3,1),
('Análisis Matemático I', '1B','Gabriela Pugliese','P',67,3,1),
('Algebra', '1B','Miguel Martínez','S',67,3,1),
('Algoritmos y Estructuras de Datos I', '1B','Graciana Roldan', 'S',67,3,1),
('Sistemas y Organizaciones', '1B','Alejandro De Andreis', 'P',66,3,1),
('Arquitectura de Computadores', '1B','Graciana Roldan', 'P',59,3,1),
('Prácticas Profesionalizantes I A', '1B','Paula Giaimo', 'P',28,3,1),
('Prácticas Profesionalizantes I B', '1B','Verónica Micheltorena', 'S',28,3,1),


('Inglés II', '2A','Angélica Zozula','P', 52, 3,1),
('Análisis Matemático II', '2A','Norberto Cascelli','P', 40, 3,1),
('Estadistica', '2A','Ramiro Villar','P', 41, 3,1),
('Ingeniería de Software I', '2A', 'Paula Giaimo','P',50, 3,1),
('Algoritmos y Estructura de Datos II', '2A','Paula Giaimo','P', 58, 3,1),
('Sistemas Operativos', '2A','Diego Pacini','P', 50, 3,1),
('Base de Datos', '2A','Juan Pellegrini','P', 58, 3,1),
('Prácticas Profesionalizantes II A', '2A','Graciana Roldan', 'P',29, 3,1),
('Prácticas Profesionalizantes II B', '2A','Alicia Ferreira', 'P',29, 3,1),


('Inglés III', '3A', 'Alejandra Pérez', 'P', 26, 3,1),
('Aspectos Legales de la Profesión','3A', 'Diego Klehr', 'P', 30, 3,1),
('Seminario de la actualización','3A', 'Alicia Ferreira', 'S', 34, 3,1),
('Redes y Comunicaciones','3A', 'Diego Pacini', 'P', 34, 3,1),
('Ingeniería de Software II','3A','Sin Profesor', '-', 28, 3,1),
('Algoritmos y Estructura de Datos III','3A', 'Verónica Micheltorena', 'P', 17, 3,1),
('Prácticas Profesionalizantes III A','3A','Walter Vilches', 'P',20,3,1),
('Prácticas Profesionalizantes III B','3A','Juan Pellegrini', 'P',20,3,1);


