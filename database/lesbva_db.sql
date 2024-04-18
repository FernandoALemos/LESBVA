-- drop database lesbva;
-- create database lesbva;

-- use database lesbva;

create table roles(
    rol_id int auto_increment,
    nombre_rol varchar (30),
    primary key (id)
);

insert into roles (nombre_rol) values ('Administrador'), ('Director'), ('Profesor'), ('Alumno');


create table turnos(
    turno_id int auto_increment,
    turno varchar(15) UNIQUE,
    primary key (turno_id)
);

insert into turnos (turno) values ('Mañana'), ('Tarde'), ('Verpertino');

create table ciclo_letivo(
    ciclo_id int auto_increment,
    turno_id int,
    anio_lectivo int (4),
    foreign key (turno_id) references turno(turno_id),
    primary key (ciclo_id, turno_id)
);

insert into ciclo_letivo (turno_id, anio_lectivo) values 
('1', 2024), ('2', 2024), ('3', 2024), 
('1', 2025), ('2', 2025), ('3', 2025), 
('1', 2026), ('2', 2026), ('3', 2026);


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

insert into usuarios (usuario_id,usuario_nombre,apellido,rol_id,contrasenia,email,dni) values 
('Fernando','Lemos',1,'flemos','flemos@gmail.com',37865101),
('Lues','Sbarbati',1,'lsbarbati','lsbarbati@gmail.com',12341234),
('Matias','Vasca',1,'mvasca','mvasca@gmail.com',11223344),
('Walter','Muscolo',2,'wmuscolo','wmuscolo@gmail.com',33445566),
('Juan','Pellegrini',2,'jpellegrini','jpellegrini@gmail.com',29031795),
('Wlater','Vilches',2,'wvilches','wvilches@gmail.com',29031123),
('Verónica','Micheltorena',2,'jpellegrini','jpellegrini@gmail.com',29038893),
('Gonzalo','Rojas',4,'grojas','grojas@gmail.com',36123789), --1
('Alexia','Cepeda',4,'acepeda','acepeda@gmail.com',41346781), --2
('Jesica','Dalmazzo',4,'jdalmazzo','jdalmazzo@gmail.com',34159746), --3
('Nicolas','Camaño',4,'ncamaño','ncamaño@gmail.com',37456881), --4
('Lautaro','Rossi',4,'lrossi','lrossi@gmail.com',40159741), --5
('Juan','Perez',4,'jperez','jperez@gmail.com',29111222), --6
('Mariano','Morbelli',4,'mmorbelli','mmorbelli@gmail.com',30451879); --7



create table carreras(
    carrera_id int auto_increment,
    carrera_nombre varchar(70) UNIQUE,
    primary key (carrera_id)
);

insert into usuarios (carrera_nombre) values ('TECNICATURA EN ANÁLISIS DE SISTEMAS');


create table materias(
    materia_id int auto_increment,
    materia_nombre varchar(45),
    anio_materia int (1),
    ciclo_id int,
    carrera_id int,
    foreign key (ciclo_id) references ciclo_letivo(ciclo_id),
    foreign key (carrera_id) references carreras(carrera_id),
    primary key (materia_id,ciclo_id,carrera_id)
); 

insert into materias (materia_nombre,anio_materia,ciclo_id,carrera_id) values
('CIENCIA, TENOLOGÍA Y SOCIEDAD', 1,3,1), --1
('ALGEBRA', 1,3,1), --2
('BASES DE DATOS', 2,3,1), --3
('ESTADISTICA', 2,3,1), --4
('ALGORITMOS Y ESTRUCTURAS DE DATOS III', 3,3,1), --5
('PRÁCTICAS PROFESIONALIZANTES III', 3,3,1), --6
('CIENCIA, TENOLOGÍA Y SOCIEDAD', 1,3,1), --7
('ALGEBRA', 1,6,1), --8
('BASES DE DATOS', 2,6,1), --9
('ESTADISTICA', 2,6,1), --10
('PRÁCTICAS PROFESIONALIZANTES III', 3,6,1), --11
('ALGORITMOS Y ESTRUCTURAS DE DATOS III', 3,6,1); --12


create table materia_usuario(
    -- materia_usuario_id int auto_increment,
    usuario_id int,
    materia_id int,
    estado_activo boolean,
    foreign key (usuario_id) references usuarios(usuario_id),
    foreign key (materia_id) references materias(materia_id),
    primary key (usuario_id,materia_id)
);


insert into materia_usuario (usuario_id, materia_id, estado_activo) values
(1,1, TRUE),
(2,1, TRUE),
(3,1, TRUE),
(5,6, TRUE),
(6,6, TRUE),
(7,6, TRUE),
(4,2, TRUE),
(1,2, TRUE),
(6,3, TRUE),
(7,3, TRUE),
(4,7 TRUE);
