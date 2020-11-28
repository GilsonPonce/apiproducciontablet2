drop database produccion;
create database if not exists produccion;
use produccion;

create table if not exists linea(
id_linea int not null auto_increment,
nombre varchar(500) not null,
primary key (id_linea)
);

create table if not exists proceso(
id_proceso int not null auto_increment,
nombre varchar(500) not null,
id_linea int not null,
primary key (id_proceso),
foreign key (id_linea) references linea(id_linea)
);

create table if not exists material(
id_material int not null auto_increment,
nombre varchar(500) not null,
id_linea int not null,
primary key (id_material),
foreign key (id_linea) references linea(id_linea)
);

create table if not exists tipo_material(
id_tipo_material int not null auto_increment,
nombre varchar(500) not null,
id_material int not null,
primary key (id_tipo_material),
foreign key (id_material) references material(id_material)
);

create table if not exists color (
id_color int not null auto_increment,
nombre varchar(500) not null,
primary key (id_color)
);

create table if not exists tipo_personal(
id_tipo_personal int not null auto_increment,
nombre varchar(500) not null,
primary key (id_tipo_personal)
);

create table if not exists area_trabajo(
id_area_trabajo int not null auto_increment,
nombre varchar(500) not null,
primary key (id_area_trabajo)
);

create table if not exists personal(
id_personal int not null auto_increment,
nombre varchar(500) not null,
apellido varchar(500) not null,
cedula varchar(15) not null,
id_tipo_personal int not null,
id_area_trabajo int not null,
primary key (id_personal),
foreign key (id_tipo_personal) references tipo_personal(id_tipo_personal),
foreign key (id_area_trabajo) references area_trabajo(id_area_trabajo) 
);

create table if not exists estado_orden(
id_estado_orden int not null auto_increment,
nombre varchar(500) not null,
primary key (id_estado_orden)
);

create table if not exists orden(
orden_codigo varchar(500) not null,
hora_peso double not null,
peso_producir double not null,
id_tipo_material int not null,
id_color int not null,
id_proceso int not null,
id_estado_orden int not null,
primary key (orden_codigo),
foreign key (id_tipo_material) references tipo_material(id_tipo_material),
foreign key (id_color) references color(id_color),
foreign key (id_proceso) references proceso(id_proceso),
foreign key (id_estado_orden) references estado_orden(id_estado_orden)
);

create table if not exists estado_registro(
id_estado_registro int not null auto_increment,
nombre varchar(500) not null,
primary key (id_estado_registro)
);

create table if not exists registro(
id_registro int not null auto_increment,
fecha_hora_inicio datetime default now(),
fecha_hora_fin datetime default now(),
id_personal int not null,
orden_codigo varchar(500) not null,
id_estado_registro int not null,
primary key (id_registro),
foreign key (id_personal) references personal(id_personal),
foreign key (orden_codigo) references orden(orden_codigo),
foreign key (id_estado_registro) references estado_registro(id_estado_registro)
);

create table if not exists informe(
id_informe int not null auto_increment,
fecha_hora_inicio datetime not null default now(),
fecha_hora_fin datetime,
orden_codigo varchar(500) not null,
primary key (id_informe),
foreign key (orden_codigo) references orden(orden_codigo)
);

create table if not exists estado_peso(
id_estado_peso int not null auto_increment,
nombre varchar(500) not null,
primary key (id_estado_peso)
);

create table if not exists peso(
id_peso int not null auto_increment,
peso double not null,
id_informe int not null,
id_personal int not null,
id_estado_peso int not null,
primary key (id_peso),
foreign key (id_informe) references informe(id_informe),
foreign key (id_personal) references personal(id_personal),
foreign key (id_estado_peso) references estado_peso(id_estado_peso)
);

create table if not exists motivo(
id_motivo int not null auto_increment,
nombre varchar(500) not null,
primary key (id_motivo)
);

create table if not exists parada(
id_parada int not null auto_increment,
fecha_hora_inicio datetime not null default now(),
fecha_hora_fin datetime,
id_motivo int not null,
id_personal int not null,
primary key (id_parada),
foreign key (id_motivo) references motivo(id_motivo),
foreign key (id_personal) references personal(id_personal)
);

insert into linea values (null,'PLASTICO');
insert into linea values (null,'METAL');

select * from linea;

insert into proceso values (null,'LAVADO',1);
insert into proceso values (null,'PELLETIZADO',1);
insert into proceso values (null,'AGLOMERADO',1);
insert into proceso values (null,'CLASIFICACION',1);
insert into proceso values (null,'COMPACTADO',2);

insert into estado_registro values (null,'ACTIVO');
insert into estado_registro values (null,'FINALIZADO');

insert into estado_orden values (null,'ACTIVO');
insert into estado_orden values (null,'FINALIZADO');

insert into estado_peso values (null,'APROBADO');
insert into estado_peso values (null,'POR REVISAR');

insert into color values (null,'AZUL');
insert into color values (null,'ROJO');

insert into material values (null,'FILM',1);
insert into material values (null,'SOPLADO',1);
insert into material values (null,'HOGAR',1);

insert into tipo_material values (null,'ALTA',1);
insert into tipo_material values (null,'HOGAR',3);
insert into tipo_material values (null,'SOPLADO',2);


alter user 'root'@'localhost' identified with mysql_native_password by 'SYSsys1223+';

delimiter ||
create procedure  inactivarResgistro(in idpersonal int,out validacion int)
begin
	declare idestadoRegistroina,idestadoRegistroac, idregistro int;
    declare exit handler for sqlexception
    begin
		set validacion = 0;
		rollback;
    end;
    START TRANSACTION;
    set idestadoRegistroina = (select id_estado_registro from estado_registro where nombre = 'inactivo');
    set idestadoRegistroac = (select id_estado_registro from estado_registro where nombre = 'activo');
    set idregistro = (select id_registro from registro where id_personal = idpersonal AND id_estado_registro = idestadoRegistroac);
    if idregistro != '' or idregistro != null then
		update registro
        set id_estado_registro = idestadoRegistroina, fecha_hora_fin = now() 
        WHERE id_registro = idregistro;
        set validacion = 1;
        commit;
	else
		rollback;
	end if;
end ||



delimiter ||
create procedure showlinea(out lineas varchar(500))
begin
	select nombre into lineas from linea;
end ||


delimiter ||
create procedure showproceso (in nombrelinea varchar(500), out varprocesos varchar(500))
begin
	declare exit handler for sqlexception
    begin
		rollback;
    end;
	declare idlinea int;
    START TRANSACTION;
    set idlinea = (select id_linea from linea where nombre = nombrelinea);
    if idlinea != '' or idlinea != null then
		select nombre into varprocesos from proceso where id_linea = idlinea;
        commit;
	else
		rollback;
	end if;
end ||


delimiter ||
create procedure showmaterial (out materiales varchar(500))
begin
	select nombre into materiales from material;
end ||


delimiter ||
create procedure showlinea (in nombrematerial varchar(500), out vartipos varchar(500))
begin
	declare exit handler for sqlexception
    begin
		rollback;
    end;
	declare idmaterial int;
    START TRANSACTION;
    set idmaterial = (select id_material from metarial where nombre = nombrematerial);
    if idmaterial or idmaterial != null then
		select nombre into vartipos from tipo_material where id_material = idmaterial;
        commit;
	else
		rollback;
	end if;
end ||