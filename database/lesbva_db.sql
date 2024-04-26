-- drop database lesbva;
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
    anio_lectivo int (4),
    foreign key (turno_id) references turnos(turno_id),
    primary key (ciclo_id, turno_id)
);

insert into ciclo_lectivo (turno_id, anio_lectivo) values 
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

insert into usuarios (usuario_nombre,apellido,rol_id,contrasenia,email,dni) values 
('Fernando','Lemos',1,'flemos','flemos@gmail.com',37865101),
('Lues','Sbarbati',1,'lsbarbati','lsbarbati@gmail.com',12341234),
('Matias','Vasca',1,'mvasca','mvasca@gmail.com',11223344),
('Walter','Muscolo',2,'wmuscolo','wmuscolo@gmail.com',33445566);



create table carreras(
    carrera_id int auto_increment,
    carrera_nombre varchar(70) UNIQUE,
    primary key (carrera_id)
);

insert into carreras (carrera_nombre) values ('TECNICATURA EN ANÁLISIS DE SISTEMAS');


create table materias(
    materia_id int auto_increment,
    materia_nombre varchar(45),
    anio_materia varchar (2),
    cantidad_alumno int (3),
    ciclo_id int,
    carrera_id int,
    foreign key (ciclo_id) references ciclo_lectivo(ciclo_id),
    foreign key (carrera_id) references carreras(carrera_id),
    primary key (materia_id,ciclo_id,carrera_id)
); 

insert into materias (materia_nombre,anio_materia,cantidad_alumno,ciclo_id,carrera_id) values
('CIENCIA, TENOLOGÍA Y SOCIEDAD', "1A",24,3,1),
('BASES DE DATOS', "2A",29,3,1),
('PRÁCTICAS PROFESIONALIZANTES III', "3A",17,3,1);

-- create table materia_usuario(
--     materia_usuario_id int auto_increment,
--     usuario_id int,
--     materia_id int,
--     estado_activo boolean,
--     foreign key (usuario_id) references usuarios(usuario_id),
--     foreign key (materia_id) references materias(materia_id),
--     primary key (materia_usuario_id,usuario_id,materia_id)
-- );




-- insert into materia_usuario (usuario_id, materia_id, estado_activo) values
-- (1,1, TRUE),
-- (2,1, TRUE),
-- (3,1, TRUE),
-- (5,6, TRUE),
-- (6,6, TRUE),
-- (7,6, TRUE),
-- (4,2, TRUE),
-- (1,2, TRUE),
-- (6,3, TRUE),
-- (7,3, TRUE),
-- (4,7, TRUE);

