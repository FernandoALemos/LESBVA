
create database gapced;

use gapced;

create table roles(
    rol_id int auto_increment,
    rol_nombre varchar (30),
    primary key (rol_id)
);


create table turnos(
    turno_id int auto_increment,
    turno varchar(15) UNIQUE,
    primary key (turno_id)
);


create table carreras(
    carrera_id int auto_increment,
    carrera_nombre varchar(70) UNIQUE,
    primary key (carrera_id)
);


create table cargos(
    cargo_id int auto_increment,
    carrera_id int,
    turno_id int,
    cargo_nombre varchar(30),
    primary key (cargo_id, carrera_id, turno_id),
    foreign key (carrera_id) references carreras(carrera_id),
    foreign key (turno_id) references turnos(turno_id)
);


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


create table profesores(
    profesor_id int auto_increment,
    profesor_nombre varchar (60),
    profesor_apellido varchar (60),
    profesor_dni int (8) UNIQUE,
    profesor_email varchar (120),
    profesor_direccion varchar (60),
    profesor_telefono varchar (25),
    profesor_activo boolean,
    primary key (profesor_id)
);


create table ciclo_lectivo(
    ciclo_id int auto_increment,
    ciclo int (4),
    primary key (ciclo_id)
);


create table materias(
    materia_id int auto_increment,
    materia_nombre varchar(100),
    primary key (materia_id)
); 


create table cursos(
    curso_id int auto_increment,
    curso varchar (7),
    primary key (curso_id)
);


create table materia_carrera(
    materia_carrera_id int auto_increment,
    materia_id int,
    carrera_id int,
    ciclo_id int,
    curso_id int,
    turno_id int,
    profesor_id int,
    situacion_revista varchar (4),
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
    primary key (materia_carrera_id)
);