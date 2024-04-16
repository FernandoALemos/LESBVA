-- drop database lesbva;
-- create database lesbva;

-- use database lesbva;

create table roles(
    rol_id int auto_increment,
    nombreRol varchar (30),
    primary key (id)
);

insert into roles (nombreRol) values ('Administrador'), ('Director'), ('Profesor'), ('Alumno');

create table usuarios();

create table carreras();


create table materias(); 


create table turnos();


create table ciclo_letivo();


create table materia_usuario();



