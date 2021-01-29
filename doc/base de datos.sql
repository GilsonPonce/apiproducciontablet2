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
primary key (id_material)
);

create table if not exists tipo_material(
id_tipo_material int not null auto_increment,
nombre varchar(500) not null,
primary key (id_tipo_material)
);

create table if not exists propiedad(
id_propiedad int not null auto_increment,
nombre varchar(500) not null,
primary key (id_propiedad)
);

create table if not exists configuracion(
id_configuracion int not null auto_increment,
kilogramo_diario decimal(9,2) not null,
kilogramo_hora decimal(9,2) not null,
tarifa_kilogramos_producidos decimal(23,20) not null,
estado bit not null,
id_proceso int not null,
id_material int not null,
id_tipo_material int not null,
id_propiedad int not null,
primary key (id_configuracion),
foreign key (id_proceso) references proceso(id_proceso),
foreign key (id_material) references material(id_material),
foreign key (id_tipo_material) references tipo_material(id_tipo_material),
foreign key (id_propiedad) references propiedad(id_propiedad)
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

create table if not exists turno(
id_turno int not null auto_increment,
nombre varchar(500) not null,
primary key (id_turno)
);

create table if not exists orden(
orden_codigo varchar(500) not null,
fecha_hora_inicio datetime not null,
fecha_hora_fin datetime not null,
peso_producir decimal(9,2) not null,
id_configuracion int not null,
id_color int not null,
id_turno int not null,
id_estado_orden int not null,
primary key (orden_codigo),
foreign key (id_configuracion) references configuracion(id_configuracion),
foreign key (id_color) references color(id_color),
foreign key (id_turno) references turno(id_turno),
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

/*
create table if not exists informe(
id_informe int not null auto_increment,
fecha_hora_inicio datetime not null default now(),
fecha_hora_fin datetime,
orden_codigo varchar(500) not null,
primary key (id_informe),
foreign key (orden_codigo) references orden(orden_codigo)
);
*/

create table if not exists estado_peso(
id_estado_peso int not null auto_increment,
nombre varchar(500) not null,
primary key (id_estado_peso)
);

create table if not exists peso(
id_peso int not null auto_increment,
kilogramo decimal(9,2) not null,
orden_codigo varchar(500) not null,
id_personal int not null,
id_estado_peso int not null,
primary key (id_peso),
foreign key (orden_codigo) references orden(orden_codigo),
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

# CONFIGURACION DE LINEAS DE PRODUCCION
insert into linea values (1,'PLASTICO');
insert into linea values (2,'METAL');

# CONFIGURACION DE PROCESOS
insert into proceso values (1,'LAVADO',1);
insert into proceso values (2,'PELLETIZADO',1);
insert into proceso values (3,'AGLOMERADO',1);
insert into proceso values (4,'CLASIFICACION',1);
insert into proceso values (5,'COMPACTADO',2);

# CONFIGURACION DE ESTADO DE REGISTRO
insert into estado_registro values (null,'ACTIVO');
insert into estado_registro values (null,'FINALIZADO');

# CONFIGURACION DE ESTADO DE ORDEN
insert into estado_orden values (null,'ACTIVO');
insert into estado_orden values (null,'FINALIZADO');

# CONFIGURACION DE ESTADO DE PESO
insert into estado_peso values (null,'APROBADO');
insert into estado_peso values (null,'POR REVISAR');

# CONFIGURACION DE TURNOS
insert into turno values (null,'DIURNO');
insert into turno values (null,'NOCTURNO');

# CONFIGURACION DE COLORES
insert into color values (null,'AZUL');
insert into color values (null,'ROJO');
insert into color values (null,'VERDE');
insert into color values (null,'AMARILLO');
insert into color values (null,'NATURAL');
insert into color values (null,'BLANCO');

# CONFIGURACION DE MATERIAL
insert into material values (null,'FILM');
insert into material values (null,'SOPLADO');
insert into material values (null,'HOGAR');
insert into material values (null,'PACAS');
insert into material values (null,'SEPARADORES');
insert into material values (null,'PP TERMOFORMADO');
insert into material values (null,'PP SOPLADO');

# CONFIGURACION DE TIPO MATERIAL
insert into tipo_material values (null,'ALTA');
insert into tipo_material values (null,'BAJA');
insert into tipo_material values (null,'CHICLE');
insert into tipo_material values (null,'FILM');
insert into tipo_material values (null,'SOPLADO');
insert into tipo_material values (null,'PP');
insert into tipo_material values (null,'PEAD');
insert into tipo_material values (null,'SILLA');
insert into tipo_material values (null,'PACAS');
insert into tipo_material values (null,'SEPARADORES');
insert into tipo_material values (null,'PLANCHAS');
insert into tipo_material values (null,'SUNCHOS');
insert into tipo_material values (null,'CANECA');
insert into tipo_material values (null,'PP SOPLADO');

# CONFIGURACION DE PROPIEDAD
insert into propiedad values (null,'SECO');
insert into propiedad values (null,'MOJADO');
insert into propiedad values (null,'PIE');
insert into propiedad values (null,'BANDA');
insert into propiedad values (null,'SEPARADORES');
insert into propiedad values (null,'PLANCHAS');
insert into propiedad values (null,'HOGAR');
insert into propiedad values (null,'ALTA');
insert into propiedad values (null,'BAJA');
insert into propiedad values (null,'CHICLE');
insert into propiedad values (null,'PP TERMOFORMADO');
insert into propiedad values (null,'PP SOPLADO');
insert into propiedad values (null,'SUNCHOS');
insert into propiedad values (null,'SOPLADO');


SELECT o.orden_codigo AS codigo,inf.fecha_hora_inicio,inf.fecha_hora_inicio,o.hora_peso AS horapeso, 
o.peso_producir AS peso,m.id_material,m.nombre AS material, tm.id_tipo_material, tm.nombre AS tipomaterial,
li.id_linea,li.nombre AS linea,pro.id_proceso,pro.nombre AS proceso,c.id_color, c.nombre AS color ,eo.id_estado_orden, 
eo.nombre AS estado
FROM informe inf, orden o, proceso pro, linea li, material m, tipo_material tm, color c, estado_orden eo
WHERE  o.orden_codigo = inf.orden_codigo AND o.id_estado_orden = eo.id_estado_orden AND c.id_color = o.id_color
AND pro.id_proceso = o.id_proceso AND li.id_linea = pro.id_linea AND li.id_linea = m.id_linea AND m.id_material = tm.id_material
AND tm.id_tipo_material = o.id_tipo_material;

delete from orden where orden_codigo = 99999999999999999; 
select * from orden;
SET SQL_SAFE_UPDATES = 0;
alter user 'root'@'localhost' identified with mysql_native_password by 'SYSsys1223+';
update orden set id_estado_orden = 2 where orden_codigo = 99999999999999999;

delimiter |
create trigger informe after insert on orden
for each row begin
	insert into informe values(null,now(),now(),new.orden_codigo);
end
|

drop trigger DeleteInforme;
delimiter |
create trigger DeleteInforme before delete on orden
for each row begin
	declare id int;
    set id = (select id_informe from informe where orden_codigo = OLD.orden_codigo);
	delete from peso where id_informe = id;
	delete from informe where orden_codigo = OLD.orden_codigo;    
end
|

delimiter |
create trigger UpdateInforme after update on orden
for each row begin
	declare idinforme int;
    declare estado varchar(500);
	set idinforme = (select id_informe from informe where orden_codigo=new.orden_codigo);
    set estado = (select nombre from estado_orden where id_estado_orden = new.id_estado_orden);
    if estado = "FINALIZADO" then
		update informe set fecha_hora_fin = now() where id_infome = idinforme;
	else
		update informe set fecha_hora_inicio = now() where id_infome = idinforme;
    end if;
end
|


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