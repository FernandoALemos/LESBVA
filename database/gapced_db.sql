-- drop database gapced;
create database gapced;

use gapced;

-- ROLES Y USUARIOS

-- los roles deben estar definidos, nadie debe crear roles solo asignar
create table roles(
    rol_id int auto_increment,
    rol_nombre varchar (30),
    primary key (rol_id)
);

insert into roles (rol_nombre) values ('Directivo'), ('Regencia'), ('Preceptoria'), ('Secretaria');

-- LA SECCION SON LOS TURNOS?
create table turnos(
    turno_id int auto_increment,
    turno varchar(15) UNIQUE,
    primary key (turno_id)
);

insert into turnos (turno) values ('Mañana'), ('Tarde'), ('Vespertino');

create table carreras(
    carrera_id int auto_increment,
    carrera_nombre varchar(70) UNIQUE,
    primary key (carrera_id)
);
-- CREAR ALGO QUE SEA PARA EL DIRECTOR
insert into carreras (carrera_nombre) values 
('TECNICATURA EN ANÁLISIS DE SISTEMAS'),
('PROFESORADO DE MATEMÁTICA'),
('PROFESORADO DE INGLÉS'),
('PROFESORADO DE EDUCACIÓN INICIAL'),
('PROFESORADO DE EDUCACIÓN PRIMARIA'),
('CUFBA'),
('PROFESORADO DE QUÍMICA'),
('PROFESORADO DE FÍSICA'),
('TRAMO PEDAGOGICO'),
('PROFESORADO DE BIOLOGÍA');


create table cargos(
    cargo_id int auto_increment,
    carrera_id int,
    turno_id int,
    cargo_nombre varchar(30),
    primary key (cargo_id, carrera_id, turno_id),
    foreign key (carrera_id) references carreras(carrera_id),
    foreign key (turno_id) references turnos(turno_id)
);
-- crear cargos para sistemas, luego el director podra crear cargos (VER QUE NO ROMPA)
insert into cargos (carrera_id, turno_id, cargo_nombre) values 
(1, 3, 'Sistemas');


-- solamente puede crear usuarios el rol directivo
create table usuarios(
    usuario_id int auto_increment,
    usuario_nombre varchar(30),
    usuario_apellido varchar(30),
    rol_id int,
    cargo_id int,
    email varchar(60) UNIQUE,
    contrasenia varchar(30),
    usuario_suspendido boolean,
    primer_ingreso boolean,
    foreign key (rol_id) references roles(rol_id),
    foreign key (cargo_id) references cargos(cargo_id),
    primary key (usuario_id, rol_id)
);

insert into usuarios (usuario_nombre, usuario_apellido, rol_id, cargo_id, email, contrasenia, usuario_suspendido) values
('Walter', 'Muscolo', 1, 1, 'director@gmail.com', 'wmuscolo', False),
('Preceptora', 'Sistemas', 1, 1, 'preceptoria_sistemas@gmail.com', 'psistemas', False);


-- MATERIAS Y PROFESORES

create table profesores(
    profesor_id int auto_increment,
    profesor_nombre varchar (60),
    profesor_apellido varchar (60),
    primary key (profesor_id)
);


insert into profesores (profesor_nombre, profesor_apellido) values
('Alejandra','Pérez'),
('Claudio','Adan'),
('Juan','Osamendia'),
('Melina','Lucero'),
('Graciana','Roldan'),
('Alejandro','De Andreis'),
('Verónica','Micheltorena'),
('Gabriela','Pugliese'),
('Miguel','Martinez'),
('Paula','Giaimo'),
('Angélica','Zozula'),
('Norberto','Cascelli'),
('Ramiro','Villar'),
('Diego','Pacini'),
('Juan','Pellegrini'),
('Alicia', 'Ferreira'),
('Diego','Klehr'),
('Walter','Vilches'),
('Vacante','Vacante'),
('Walter', 'Muscolo'),
('Gustavo', 'Tattoli'),

-- Nuevos profes de inicial e ingles
('Prof', 'Higa'),
('Prof', 'Arijón'),
('Prof', 'Rivera'),
('Victoria', 'Vilches'),
('Prof', 'Morales'),
('Prof', 'Perino'),
('Prof', 'Agustine'),
('Prof', 'Piperno'),
('Prof', 'Dall Pozza'),
('Prof', 'Lobisch Allona'),
('Prof', 'Tarantino'),
('Prof', 'Giussani'),
('Prof', 'Pariani'),
('Prof', 'Aquino'),
('Prof', 'Bowley'),
('Prof', 'Torales'),
('Prof', 'Senones'),
('Prof', 'Pérez'),
('Prof', 'Luna '),
('Prof', 'Martinez'),
('Prof', 'Lorences'),
('Prof', 'Cañete'),
('Prof', 'Ciarlantini'),
('Prof', 'Citati'),
('Prof', 'Pastoriza'),
('Prof', 'Pizano'),
('Prof', 'Gaudio'),
('Prof', 'Crevatin'),
('Prof', 'Bello'),
('Prof', 'Chavez'),
('Prof', 'Silvegio'),
('Prof', 'Gaudiano'),
('Prof', 'Moina'),
('Prof', 'Gala'),
('Prof', 'Fabre'),
('Prof', 'Finvard'),
('Prof', 'Correa'),
('Prof', 'Araujo'),
('Prof', 'Bertoia'),
('Prof', 'Sosa'),
('Prof', 'Ivarra'),
('Prof', 'Compiano'),
('Prof', 'Hawresz'),
('Prof', 'Gómez'),
('Prof', 'Del Re'),
('Prof', 'Helver'),

('Mónica', 'Erbetta'),
('Viviana', 'Camacho'),
('Cristián', 'Ramirez'),
('Norali', 'Boulan'),
('Nadia','Czmuch Moyano'),
('M.','Joghems'),
('Lucia','Fauda S. Espinoza'),
('Mónica','Cristiani'),
('Yohana','Isaguirre'),
('A.','Romano'),
('Paula','Benitez'),
('M.','Garbarini'),
('B.','Tisera'),
('R.','García'),
('Marcela','Campagno'),
('C.','Biocca'),
('Leonel','Galeppi'),
('Roxana','Garcia'),
('Néstor','Manchini'),
('Liliana','Colavolpe'),
('Paula','Lanzillola'),
('Sara','Pietro'),
('A.','Defago'),
('Carina','Mendelevich'),
('C.','Serpentini'),
('María Marta','Macaudier'),
('Eliana','Mariano'),
('Pablo','Benitez'),
('Maria Inés','Haterfield'),
('Andrea','Lucarelli'),
('C.','Irusta'),
('Nancy','Manchenik'),
('Héctor','Oviedo'),
('B.','Dodero'),
('Antonella','Trimari'),
('Lorena','Rodriguez'),
('Tobías','Corro Molas');




create table ciclo_lectivo(
    ciclo_id int auto_increment,
    ciclo int (4),
    primary key (ciclo_id)
);

insert into ciclo_lectivo (ciclo) values 
(2024), (2025), (2026), (2027);



create table materias(
    materia_id int auto_increment,
    materia_nombre varchar(100),
    primary key (materia_id)
); 

-- Esto debe ser creado y modificado por preceptores
insert into materias (materia_nombre) values
-- 1°
('Inglés I'),
('Ciencia, Tecnología y Sociedad'),
('Análisis Matemático I'),
('Algebra'),
('Algoritmos y Estructuras de Datos'),
('Sistemas y Organizaciones'),
('Arquitectura de Computadores'),
('Prácticas Profesionalizantes I A'),
('Prácticas Profesionalizantes I B'),
-- 2°
('Inglés II'),
('Análisis Matemático II'),
('Estadistica'),
('Ingeniería de Software I'),
('Algoritmos y Estructura de Datos II'),
('Sistemas Operativos'),
('Base de Datos'),
('Prácticas Profesionalizantes II A'),
('Prácticas Profesionalizantes II B'),
-- 3°
('Inglés III'),
('Aspectos Legales de la Profesión'),
('Seminario de la actualización'),
('Redes y Comunicaciones'),
('Ingeniería de Software II'),
('Algoritmos y Estructura de Datos II'),
('Prácticas Profesionalizantes III A'),
('Prácticas Profesionalizantes III B'),

-- Cufba
('Taller de Oralidad'),
('Taller de Escritura'),

-- inicial
-- 1°
('Educación Temprana'),
('Psicología, Desarrollo y Aprendizaje I'),
('Corporeidad y Motricidad'),
('Filosofía'),
('Pedagogía'),
('Análisis Mundo Contemporáneo'),
('Prácticas I'),
('Didáctica General'),
('EDI'),
('Taller Lógico-Matemático'),
('Taller Lectura, Oralidad y Escritura'),
-- 2°
('Prácticas II'),
('Psicología, Desarrollo y Aprendizaje II'),
('Didáctica y Curriculum'),
('Cultura, Comunicación y Educación'),
('Didáctica Prácticas del Lenguaje'),
('Psicología, Social e Institucional'),
('Teoría Socio Política y Educación'),
('Didáctica Ciencias Naturales'),
('Didáctica Matemática'),
('Educación Plástica'),
('Didáctica Ciencias Sociales'),
-- 3°
('Historia y Prospectiva de la Educación'),
('Educación Física'),
('Taller Ciencias Sociales'),
('Taller Ciencias Naturales'),
('Herramientas de la Práctica'),
('TFO: Alfabetización Inicial'),
('Política, legislación y trabajo Escolar'),
('Educación Musical'),
('Producción de Materiales'),
('Taller Matemática'),
('Medios Audiovisuales'),
('Taller Literatura Infantil'),
('TFO: Educación Maternal'),
('Juego y Desarrollo Infantil'),
('TFO: TICs'),
-- 4°
('Ateneo Prácticas Lenguaje'),
('Ateneo Naturaleza y Sociedad'),
('Campo IV'),
('Educación en y para Salud'),
('Reflexión Filosófica'),
('Ateneo Expresiones Estéticas'),
('Ateneo Matemática'),
-- ingles
-- 1°
('Problemática Socioinstitucionales'),
('Pedagogía'),
('Prácticas discursivas en lengua Española'),
('Prácticas discursivas de la comunicación Oral'),
('Práctica Docente'),
('Prácticas discursivas de la comunicación Escrita'),
('Estudios Interculturales Lengua Inglesa'),
('Didáctica general'),
('Introducción al Inglés con fines académicos'),
-- 2°
('Los Sujetos de la Educación'),
('Historia y Política Argentina'),
('Literatura en Lengua Inglesa y Niñez'),
('Fundamentos de la Enseñanza y Aprendizaje en Inglés'),
('Prácticas discursivas de la comunicación Oral II'),
('Estudios Interculturales Lengua Inglesa II'),
('Prácticas discursivas de la comunicación Escrita II'),
('Enseñar con Tecnología'),
-- 3°
('Evaluación de los Aprendizajes'),
('Educación para la Diversidad'),
('Prácticas discursivas de la comunicación Oral III'),
('Literatura en Lengua Inglesa y Niñez II'),
('Fundamentos de la Enseñanza y el Aprendizaje II'),
('Estudios Interculturales en Lengua Inglesa II'),
('Francés'),
('Prácticas discursivas de la comunicación Escrita III'),
('Prácticas discursivas de la comunicación Oral III'),
('Narrativa Pedagógica'),
('Filosofía y Educación'),
-- 4°
('Tutorias y Orientación escolar'),
('Análisis e Intervención en sit conv escolar'),
('Est Interculturales en Lengua Inglesa IV'),
('Prácticas discursivas de la comunicación Oral IV'),
('Fundamentos de la Enseñanza y el Aprendizaje del Inglés'),
('EDI'),
('Prácticas discursivas de la comunicación Escrita IV');


create table cursos(
    curso_id int auto_increment,
    curso varchar (3),
    primary key (curso_id)
);


insert into cursos (curso) values
('1A'),
('1B'),
('2A'),
('3A'),
('4A');



create table materia_carrera(
    materia_carrera_id int auto_increment,
    materia_id int,
    carrera_id int,
    ciclo_id int,
    curso_id int,
    turno_id int,
    profesor_id int,
    situacion_revista varchar (4),  -- Titular ("T"), Provisional ("P"), Suplente ("S") y Nada ("-") 
    inscriptos int (3),
    regulares int (3),
    atraso_academico int (3),
    recursantes int (3),
    modulos int (2),
    primer_periodo int (2),
    segundo_periodo int (2),
    foreign key (materia_id) references materias(materia_id),
    foreign key (carrera_id) references carreras(carrera_id),
    foreign key (ciclo_id) references ciclo_lectivo(ciclo_id),
    foreign key (curso_id) references cursos(curso_id),
    foreign key (turno_id) references turnos(turno_id),
    foreign key (profesor_id) references profesores(profesor_id),
    primary key (materia_carrera_id) -- , materia_id, ciclo_id, carrera_id, curso_id, turno_id, profesor_id -- si las declaro como primary después no puedo insertar valores.
);


insert into materia_carrera (materia_id, carrera_id, ciclo_id, curso_id, turno_id, profesor_id, situacion_revista, inscriptos, regulares, atraso_academico, recursantes, modulos, primer_periodo, segundo_periodo) values
-- 1°A
(1, 1, 1, 1, 3, 1, 'P', 63, 51, 6, 6, 2, 0, 0),-- ingles
(2, 1, 1, 1, 3, 2, 'P', 56, 50, 4, 2, 2, 0, 0),-- adan
(3, 1, 1, 1, 3, 3, 'P', 56, 50, 4, 2, 2, 0, 0),-- analisis
(4, 1, 1, 1, 3, 4, 'S', 66, 60, 4, 2, 2, 0, 0),-- algebra
(5, 1, 1, 1, 3, 5, 'S', 68, 60, 4, 4, 4, 0, 0),-- algoritmos
(6, 1, 1, 1, 3, 6, 'P', 67, 60, 4, 3, 2, 0, 0),-- sistemas y org
(7, 1, 1, 1, 3, 5, 'P', 59, 50, 7, 2, 2, 0, 0),-- argquitectura
(8, 1, 1, 1, 3, 7, 'S', 28, 28, 0, 0, 2, 0, 0),-- practica a
(9, 1, 1, 1, 3, 6, 'P', 28, 28, 0, 0, 2, 0, 0),-- practicas b
-- 1°B
(1, 1, 1, 2, 3, 1, 'P', 56, 56, 0, 0, 2, 0, 0),-- ingles
(2, 1, 1, 2, 3, 2, 'P', 58, 58, 0, 0, 2, 0, 0),-- adan
(3, 1, 1, 2, 3, 8, 'P', 67, 67, 0, 0, 2, 0, 0),-- analisis
(4, 1, 1, 2, 3, 9, 'S', 67, 67, 0, 0, 2, 0, 0),-- algebra
(5, 1, 1, 2, 3, 5, 'S', 67, 67, 0, 0, 4, 0, 0),-- algoritmos
(6, 1, 1, 2, 3, 6, 'P', 66, 66, 0, 0, 2, 0, 0),-- sistemas y org
(7, 1, 1, 2, 3, 5, 'P', 59, 59, 0, 0, 2, 0, 0),-- argquitectura
(8, 1, 1, 2, 3, 7, 'S', 28, 28, 0, 0, 2, 0, 0),-- practica a
(9, 1, 1, 2, 3, 10, 'P', 28, 28, 0, 0, 2, 0, 0),-- practicas b

-- 2°A
(10, 1, 1, 3, 3, 11, 'P', 52, 52, 0, 0, 2, 0, 0),-- ingles 2
(11, 1, 1, 3, 3, 12, 'P', 40, 40, 0, 0, 2, 0, 0),-- analisis 2
(12, 1, 1, 3, 3, 13, 'P', 41, 41, 0, 0, 2, 0, 0),-- estadistica
(13, 1, 1, 3, 3, 10, 'P', 50, 50, 0, 0, 2, 0, 0),-- ingenieria
(14, 1, 1, 3, 3, 10, 'P', 58, 58, 0, 0, 4, 0, 0),-- algoritmos 2
(15, 1, 1, 3, 3, 14, 'P', 50, 50, 0, 0, 2, 0, 0),-- sistemas operativos
(16, 1, 1, 3, 3, 16, 'P', 58, 58, 0, 0, 2, 0, 0),-- bd
(17, 1, 1, 3, 3, 5, 'P', 29, 29, 0, 0, 2, 0, 0),-- practicas 2a
(18, 1, 1, 3, 3, 17, 'P', 29, 29, 0, 0, 2, 0, 0),-- practicas 2b

-- 3°A
(19, 1, 1, 4, 3, 1, 'P', 26, 26, 0, 0, 2, 0, 0),-- ingles 3
(20, 1, 1, 4, 3, 18, 'P', 30, 30, 0, 0, 2, 0, 0),-- asle
(21, 1, 1, 4, 3, 17, 'S', 34, 34, 0, 0, 2, 0, 0),-- seminario
(22, 1, 1, 4, 3, 14, 'P', 34, 34, 0, 0, 2, 0, 0),-- redes
(23, 1, 1, 4, 3, 20, '', 28, 28, 0, 0, 2, 0, 0),-- ing 2
(24, 1, 1, 4, 3, 7, 'P', 17, 17, 0, 0, 4, 0, 0),-- algoritmos 3
(25, 1, 1, 4, 3, 15, 'P', 20, 20, 0, 0, 3, 0, 0),-- practicas 3a
(26, 1, 1, 4, 3, 19, 'P', 20, 20, 0, 0, 3, 0, 0),-- practicas 3b

-- 3°A Quimica para ver filtro
(27, 7, 1, 4, 3, 21, 'P', 27, 23, 0, 4, 2, 0, 0),-- ingles 3


-- 4°A Qumica para ver filtro
(28, 7, 1, 5, 3, 22, 'P', 12, 7, 0, 5, 2, 0, 0);-- ingles 3