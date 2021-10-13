use produccion2;

select * from materiaprima;
select * from color;
update usuario set keylock = "o2ao07oafartwetsdAD52356FEDGeq9Fx61EGrfZ9.roILUfsm2aZF8FCtpO" where id_usuario = 1;
insert into color value(null,'AZUL');

#SELECT
select * from registro;
select * from linea;
select * from proceso;
select * from color;
select * from informe;
select * from usuario;
select * from scrap;
select * from productoterminado;

Insert into productoterminado values (null,100,"CONFORME",2,61);
insert into informe values (null,2,now(),"DIURNO",2000,"",1,1,3,2);
insert into materiaprima values (null,1,62,1,2000);

#DELETE
delete from color;
delete from scrap;
delete from materiaprima;
delete from productoterminado;
update informe set completado = 0 where id_informe = 1;

SELECT personal.id_personal, personal.nombre, personal.apellido, personal.cedula,
registro.id_informe, sum(timestampdiff(SECOND,registro.fecha_hora_fin,registro.fecha_hora_inicio)/3600) AS horas_trabajada
FROM personal INNER JOIN registro ON personal.id_personal = registro.id_personal GROUP BY registro.id_informe, personal.id_personal;

SELECT id_producto_terminado, id_informe, id_color, sum(peso), tipo FROM productoterminado GROUP BY id_informe;
SELECT id_materia_prima, id_informe, id_color, sum(peso), id_configuracion FROM materiaprima GROUP BY id_informe;
SELECT id_scrap, motivo, sacos, sum(peso), id_informe FROM scrap GROUP BY id_informe;

SELECT 
matpmainfocof.fecha, 
liprocofi.linea, 
liprocofi.proceso, 
matpmainfocof.material, 
matpmainfocof.tipo_material,
matpmainfocof.id_informe, 
matpmainfocof.id as codigo_por_proceso, 
concat(registro_personal.nombre," ",registro_personal.apellido) as operario, 
matpmainfocof.turno, 
(((materiaprimai.total_peso_mt + matpmainfocof.saldo_anterior) - ( productoterminadoi.total_peso_pt + scrapi.total_peso_scrap))/count(registro_personal.id_personal)) 
as kgxpersona, 
((((materiaprimai.total_peso_mt + matpmainfocof.saldo_anterior) - ( productoterminadoi.total_peso_pt + scrapi.total_peso_scrap))/count(registro_personal.id_personal))/
registro_personal.horas_trabajada) as kgxhora, 
liprocofi.kilogramo_diario, 
liprocofi.kilogramo_hora, 
liprocofi.tarifa_kilogramo_producidos,
registro_personal.horas_trabajada, 
((((materiaprimai.total_peso_mt + matpmainfocof.saldo_anterior) - ( productoterminadoi.total_peso_pt + scrapi.total_peso_scrap))/count(registro_personal.id_personal))
/registro_personal.horas_trabajada) 
as rendimiento
FROM 
(SELECT linea.nombre as linea, proceso.nombre as proceso, configuracion.*
FROM linea INNER JOIN proceso ON linea.id_linea = proceso.id_linea INNER JOIN configuracion ON proceso.id_proceso = configuracion.id_proceso) 
AS liprocofi
INNER JOIN
(SELECT material.nombre as material, tipo_material.nombre as tipo_material,configuracion.id_configuracion, informe.*
FROM material INNER JOIN configuracion ON material.id_material = configuracion.id_material 
INNER JOIN tipo_material ON configuracion.id_tipo_material = tipo_material.id_tipo_material 
INNER JOIN informe ON tipo_material.id_tipo_material = informe.id_tipo_material) AS matpmainfocof
ON liprocofi.id_configuracion = matpmainfocof.id_configuracion
INNER JOIN
(SELECT personal.id_personal, personal.nombre, personal.apellido, personal.cedula,
registro.id_informe, sum(timestampdiff(SECOND,registro.fecha_hora_fin,registro.fecha_hora_inicio)/3600) AS horas_trabajada
FROM personal INNER JOIN registro ON personal.id_personal = registro.id_personal GROUP BY registro.id_informe, personal.id_personal) as registro_personal
ON matpmainfocof.id_informe = registro_personal.id_informe 
INNER JOIN 
(SELECT id_producto_terminado, id_informe, id_color, sum(peso) as total_peso_pt, tipo FROM productoterminado GROUP BY id_informe) as productoterminadoi
ON registro_personal.id_informe = productoterminadoi.id_informe
INNER JOIN 
(SELECT id_materia_prima, id_informe, id_color, sum(peso) as total_peso_mt, id_configuracion FROM materiaprima GROUP BY id_informe) as materiaprimai
ON productoterminadoi.id_informe = materiaprimai.id_informe
LEFT JOIN
(SELECT id_scrap, motivo, sacos, sum(peso) as total_peso_scrap, id_informe FROM scrap GROUP BY id_informe) as scrapi
ON materiaprimai.id_informe = scrapi.id_informe;

DELIMITER ||
CREATE PROCEDURE getReporte(IN id INT)
BEGIN
	DECLARE conteoMateriaPrima, conteoProductoTerminado, conteoScrap, conteoRegistro INT;
    SELECT count(*) INTO conteoProductoTerminado FROM productoterminado WHERE id_informe = id;
    SELECT count(*) INTO conteoMateriaPrima FROM materiaprima WHERE id_informe = id;
    SELECT count(*) INTO conteoScrap FROM scrap WHERE id_informe = id;
    SELECT count(*) INTO conteoRegistro FROM registro WHERE id_informe = id;
    
    IF conteoScrap = 0 AND conteoMateriaPrima != 0 AND conteoProductoTerminado != 0 AND conteoRegistro != 0 THEN
		SELECT 
matpmainfocof.fecha, 
liprocofi.linea, 
liprocofi.proceso, 
matpmainfocof.material, 
matpmainfocof.tipo_material,
matpmainfocof.id_informe, 
matpmainfocof.id as codigo_por_proceso, 
concat(registro_personal.nombre," ",registro_personal.apellido) as operario, 
matpmainfocof.turno, 
(((materiaprimai.total_peso_mt + matpmainfocof.saldo_anterior) - ( productoterminadoi.total_peso_pt))/count(registro_personal.id_personal)) 
as kgxpersona, 
((((materiaprimai.total_peso_mt + matpmainfocof.saldo_anterior) - ( productoterminadoi.total_peso_pt))/count(registro_personal.id_personal))/
registro_personal.horas_trabajada) as kgxhora, 
liprocofi.kilogramo_diario, 
liprocofi.kilogramo_hora, 
liprocofi.tarifa_kilogramo_producidos,
registro_personal.horas_trabajada, 
((((materiaprimai.total_peso_mt + matpmainfocof.saldo_anterior) - ( productoterminadoi.total_peso_pt))/count(registro_personal.id_personal))
/registro_personal.horas_trabajada) 
as rendimiento
FROM 
(SELECT linea.nombre as linea, proceso.nombre as proceso, configuracion.*
FROM linea INNER JOIN proceso ON linea.id_linea = proceso.id_linea INNER JOIN configuracion ON proceso.id_proceso = configuracion.id_proceso) 
AS liprocofi
INNER JOIN
(SELECT material.nombre as material, tipo_material.nombre as tipo_material,configuracion.id_configuracion, informe.*
FROM material INNER JOIN configuracion ON material.id_material = configuracion.id_material 
INNER JOIN tipo_material ON configuracion.id_tipo_material = tipo_material.id_tipo_material 
INNER JOIN informe ON tipo_material.id_tipo_material = informe.id_tipo_material WHERE informe.id_informe = id ) AS matpmainfocof
ON liprocofi.id_configuracion = matpmainfocof.id_configuracion
INNER JOIN
(SELECT personal.id_personal, personal.nombre, personal.apellido, personal.cedula,
registro.id_informe, sum(timestampdiff(SECOND,registro.fecha_hora_fin,registro.fecha_hora_inicio)/3600) AS horas_trabajada
FROM personal INNER JOIN registro ON personal.id_personal = registro.id_personal WHERE registro.id_informe = id GROUP BY registro.id_informe, personal.id_personal) as registro_personal
ON matpmainfocof.id_informe = registro_personal.id_informe 
INNER JOIN 
(SELECT id_producto_terminado, id_informe, id_color, sum(peso) as total_peso_pt, tipo FROM productoterminado WHERE id_informe = id GROUP BY id_informe) as productoterminadoi
ON registro_personal.id_informe = productoterminadoi.id_informe
INNER JOIN 
(SELECT id_materia_prima, id_informe, id_color, sum(peso) as total_peso_mt, id_configuracion FROM materiaprima WHERE id_informe = id GROUP BY id_informe) as materiaprimai
ON productoterminadoi.id_informe = materiaprimai.id_informe;
ELSEIF  conteoScrap != 0 AND conteoMateriaPrima != 0 AND conteoProductoTerminado != 0 AND conteoRegistro != 0 THEN
SELECT 
matpmainfocof.fecha, 
liprocofi.linea, 
liprocofi.proceso, 
matpmainfocof.material, 
matpmainfocof.tipo_material,
matpmainfocof.id_informe, 
matpmainfocof.id as codigo_por_proceso, 
concat(registro_personal.nombre," ",registro_personal.apellido) as operario, 
matpmainfocof.turno, 
(((materiaprimai.total_peso_mt + matpmainfocof.saldo_anterior) - ( productoterminadoi.total_peso_pt + scrapi.total_peso_scrap))/count(registro_personal.id_personal)) 
as kgxpersona, 
((((materiaprimai.total_peso_mt + matpmainfocof.saldo_anterior) - ( productoterminadoi.total_peso_pt + scrapi.total_peso_scrap))/count(registro_personal.id_personal))/
registro_personal.horas_trabajada) as kgxhora, 
liprocofi.kilogramo_diario, 
liprocofi.kilogramo_hora, 
liprocofi.tarifa_kilogramo_producidos,
registro_personal.horas_trabajada, 
((((materiaprimai.total_peso_mt + matpmainfocof.saldo_anterior) - ( productoterminadoi.total_peso_pt + scrapi.total_peso_scrap))/count(registro_personal.id_personal))
/registro_personal.horas_trabajada) 
as rendimiento
FROM 
(SELECT linea.nombre as linea, proceso.nombre as proceso, configuracion.*
FROM linea INNER JOIN proceso ON linea.id_linea = proceso.id_linea INNER JOIN configuracion ON proceso.id_proceso = configuracion.id_proceso) 
AS liprocofi
INNER JOIN
(SELECT material.nombre as material, tipo_material.nombre as tipo_material,configuracion.id_configuracion, informe.*
FROM material INNER JOIN configuracion ON material.id_material = configuracion.id_material 
INNER JOIN tipo_material ON configuracion.id_tipo_material = tipo_material.id_tipo_material 
INNER JOIN informe ON tipo_material.id_tipo_material = informe.id_tipo_material WHERE informe.id_informe = id) AS matpmainfocof
ON liprocofi.id_configuracion = matpmainfocof.id_configuracion
INNER JOIN
(SELECT personal.id_personal, personal.nombre, personal.apellido, personal.cedula,
registro.id_informe, sum(timestampdiff(SECOND,registro.fecha_hora_fin,registro.fecha_hora_inicio)/3600) AS horas_trabajada
FROM personal INNER JOIN registro ON personal.id_personal = registro.id_personal WHERE registro.id_informe = id GROUP BY registro.id_informe, personal.id_personal) as registro_personal
ON matpmainfocof.id_informe = registro_personal.id_informe 
INNER JOIN 
(SELECT id_producto_terminado, id_informe, id_color, sum(peso) as total_peso_pt, tipo FROM productoterminado WHERE id_informe = id GROUP BY id_informe) as productoterminadoi
ON registro_personal.id_informe = productoterminadoi.id_informe
INNER JOIN 
(SELECT id_materia_prima, id_informe, id_color, sum(peso) as total_peso_mt, id_configuracion FROM materiaprima WHERE id_informe = id GROUP BY id_informe) as materiaprimai
ON productoterminadoi.id_informe = materiaprimai.id_informe
LEFT JOIN
(SELECT id_scrap, motivo, sacos, sum(peso) as total_peso_scrap, id_informe FROM scrap WHERE id_informe = id GROUP BY id_informe) as scrapi
ON materiaprimai.id_informe = scrapi.id_informe;
ELSE 
SELECT 0;
END IF;
    
END || 
DELIMITER ;

CALL getReporte(1);
