use athu;
use produccion;
select * from usuario;

alter table usuario add password varchar(50) after codigo;
select sum(kilogramo) from peso;
insert into registro values(null,"2020-11-10 8:30","2020-11-10 8:30",2315,25468,1);

Select ord.orden_codigo ,reg.id_registro,pe.id_peso,reg.fecha_hora_inicio, reg.fecha_hora_fin, li.nombre as Linea, pro.nombre as proceso,
ma.nombre as material, tpma.nombre as tipo_material, propi.nombre as propiedad, concat(per.apellido,' ',per.nombre) as personal,
tur.nombre as turno, sum(pe.kilogramo) as peso_total, timediff(reg.fecha_hora_fin,reg.fecha_hora_inicio) as total_horas,
sum(pe.kilogramo)/timediff(reg.fecha_hora_fin,reg.fecha_hora_inicio) as Kg_x_hora, conf.kilogramo_diario as meta, 
conf.tarifa_kilogramos_producidos as tarifa, 
sum(pe.kilogramo)/timediff(reg.fecha_hora_fin,reg.fecha_hora_inicio)*conf.tarifa_kilogramos_producidos*timediff(reg.fecha_hora_inicio,reg.fecha_hora_fin) as tarifa_total,
sum(pe.kilogramo)/timediff(reg.fecha_hora_fin,reg.fecha_hora_inicio) as rendimiento,timediff(par.fecha_hora_fin,par.fecha_hora_inicio) as demora, mo.nombre as motivo,
timediff(reg.fecha_hora_fin,reg.fecha_hora_inicio)+timediff(reg.fecha_hora_fin,reg.fecha_hora_inicio) as total_horas_trabajadas
from linea li, proceso pro, propiedad propi, tipo_material tpma, material ma, configuracion conf, peso pe, orden ord, registro reg, personal per,
parada par, motivo mo, turno tur
where li.id_linea = pro.id_linea and propi.id_propiedad = conf.id_propiedad and tpma.id_tipo_material = conf.id_tipo_material and 
ma.id_material = conf.id_material and conf.id_configuracion = ord.id_configuracion and ord.orden_codigo = reg.orden_codigo and per.id_personal = reg.id_personal 
and per.id_personal = par.id_personal and mo.id_motivo = par.id_motivo and ord.orden_codigo = pe.orden_codigo and ord.orden_codigo = par.orden_codigo 
and tur.id_turno = ord.id_turno and per.id_personal = pe.id_personal group by personal, id_registro, orden_codigo; 

select concat(per.apellido,' ',per.nombre) as personal, sum(pe.kilogramo) as peso_total, pe.orden_codigo, reg.id_registro,
timediff(reg.fecha_hora_fin,reg.fecha_hora_inicio) as total_horas
from personal per inner join peso pe on per.id_personal = pe.id_personal
inner join orden ord on pe.orden_codigo = ord.orden_codigo inner join registro reg on ord.orden_codigo = reg.orden_codigo 
group by ord.orden_codigo, personal, reg.id_registro;