<?php
require('fpdf/fpdf.php');
/*
require_once('../model/informe_model.php');
require_once('../model/materiaPrima_model.php');
require_once('../model/productoTerminado_model.php');
require_once('../model/scrap_model.php');
require_once('../model/parada_model.php');
require_once('../model/registro_model.php');*/
class PDF extends FPDF
{   // Cabecera de página
    function Header()
    {
        // Logo
        $this->Image('controller/img/logo.png', 10, 8, 33);
        // Arial bold 15
        $this->SetFont('Arial', 'B', 10);
        // Movernos a la derecha
        $this->Cell(60);
        // Título
        $this->Cell(70, 5, 'NOVARED-NEGOCIOS Y RECICLAJE S.A', 'B', 0, 'C');
        $this->Ln(1);
        $this->Cell(0, 15, 'REPORTE DE PRODUCCION Y CONTROL DE PRODUCTOS', 0, 0, 'C');
        // Salto de línea
    }

    function LoadInfoInforme($id)
    {
        $data = ModeloInforme::show("informe", $id);
        //print_r($data);
        return $data;
    }

    // Tabla simple
    function Info($data)
    {
        $this->Cell(0, 15, 'No.' . $data[0]['id_informe'], 0, 0, 0);
        $this->Ln(15);
        $this->Cell(42, 9, 'Informe Por Proceso #' . $data[0]['id'], 1, 0, 0);
        $this->Cell(35, 9, 'Fecha: ' . $data[0]['fecha'], 1, 0, 0);
        $this->Cell(32, 9, 'Turno: ' . $data[0]['turno'], 1, 0, 0);
        $this->Cell(35, 9, 'Linea: ' . $data[0]['linea'], 1, 0, 0);
        $this->Cell(47, 9, 'Proceso: ' . $data[0]['proceso'], 1, 0, 0);
    }

    function personal($id_informe)
    {
        $this->SetFont('Arial', 'B', 7);
        $this->Ln(10);
        $data1 = ModeloRegistro::index("registro");
        // Cabecera
        $this->Cell(10, 5, '#', 1, 0, 'C');
        $this->Cell(78, 5, 'Personal', 1, 0, 'C');
        $this->Cell(40, 5, 'Fecha/hora inicio', 1, 0, 'C');
        $this->Cell(40, 5, 'Fecha/hora fin', 1, 0, 'C');
        $this->Cell(23, 5, 'Total (H:m)', 1, 0, 'C');
        $this->Ln();
        $this->SetFont('Times', '', 7);
        foreach ($data1 as $row) {
            if ($row['id_informe'] == $id_informe) {
                $this->Cell(10, 6, $row['id_registro'], 'LRB', 0, 'C');
                $this->Cell(78, 6, $row['personal'], 'LRB', 0, 'C');
                $this->Cell(40, 6, $row['fecha_hora_inicio'], 'LRB', 0, 'C');
                $this->Cell(40, 6, $row['fecha_hora_fin'], 'LRB', 0, 'C');
                $segundosT = strtotime($row['fecha_hora_fin']) - strtotime($row['fecha_hora_inicio']);
                $hora = $segundosT / 3600;
                $this->Cell(23, 6, number_format((strtotime($row['fecha_hora_fin']) - strtotime($row['fecha_hora_inicio'])) / 3600, 0) . ":" . number_format((strtotime($row['fecha_hora_fin']) - strtotime($row['fecha_hora_inicio'])) / 60, 0), 'LRB', 0, 'C');
                $this->Ln();
            }
        }
    }

    function mp_pt($id_informe)
    {
        $this->SetFont('Arial', 'B', 7);
        $this->Ln(2);
        $totalmp = 0;
        $totalpt = 0;
        $data1 = ModeloMateriaPrima::index("materiaprima");
        $data2 = ModeloProductoTerminado::index("productoterminado");
        // Cabecera
        $this->Cell(90, 5, 'Materia Prima', 'LRT', 0, 'C');
        $this->Cell(90, 5, 'Producto Terminado', 'LRT', 0, 'C');
        $this->Ln();
        $this->Cell(5, 7, '#', 1, 0, 'C');
        $this->Cell(20, 7, 'Proceso', 1, 0, 'C');
        $this->Cell(15, 7, 'Material', 1, 0, 'C');
        $this->Cell(20, 7, 'Tipo Material', 1, 0, 'C');
        $this->Cell(15, 7, 'Color', 1, 0, 'C');
        $this->Cell(15, 7, 'Peso', 1, 0, 'C');
        $this->Cell(5, 7, '#', 1, 0, 'C');
        $this->Cell(15, 7, 'Material', 1, 0, 'C');
        $this->Cell(20, 7, 'Tipo Material', 1, 0, 'C');
        $this->Cell(15, 7, 'Color', 1, 0, 'C');
        $this->Cell(20, 7, 'Tipo', 1, 0, 'C');
        $this->Cell(15, 7, 'Peso', 1, 0, 'C');
        $this->Ln();
        $this->SetFont('Times', '', 7);
        $sizeData1 = count($data1); //2
        $sizeData2 = count($data2); //1

        if ($sizeData1 > $sizeData2) {
            for ($i = 0; $i < $sizeData1; $i++) {
                if ($i < $sizeData2) {
                    if ($data1[$i]['id_informe'] == $id_informe) {
                        $totalmp += $data1[$i]['peso'];
                        $this->Cell(5, 7, $data1[$i]['id_materia_prima'], 'LRB', 0, 'C');
                        $this->Cell(20, 7, $data1[$i]['proceso'], 'LRB', 0, 'C');
                        $this->Cell(15, 7, $data1[$i]['material'], 'LRB', 0, 'C');
                        $this->Cell(20, 7, $data1[$i]['tipo_material'], 'LRB', 0, 'C');
                        $this->Cell(15, 7, $data1[$i]['color'], 'LRB', 0, 'C');
                        $this->Cell(15, 7, $data1[$i]['peso'], 'LRB', 0, 'C');
                    }
                    if ($data2[$i]['id_informe'] == $id_informe) {
                        $totalpt += $data2[$i]['peso'];
                        $this->Cell(5, 7, $data2[$i]['id_producto_terminado'], 'LRB', 0, 'C');
                        $this->Cell(15, 7, $data2[$i]['material'], 'LRB', 0, 'C');
                        $this->Cell(20, 7, $data2[$i]['tipo_material'], 'LRB', 0, 'C');
                        $this->Cell(15, 7, $data2[$i]['color'], 'LRB', 0, 'C');
                        $this->Cell(20, 7, $data2[$i]['tipo'], 'LRB', 0, 'C');
                        $this->Cell(15, 7, $data2[$i]['peso'], 'LRB', 0, 'C');
                        $this->Ln();
                    }
                } else {
                    if ($data1[$i]['id_informe'] == $id_informe) {
                        $totalmp += $data1[$i]['peso'];
                        $this->Cell(5, 7, $data1[$i]['id_materia_prima'], 'LRB', 0, 'C');
                        $this->Cell(20, 7, $data1[$i]['proceso'], 'LRB', 0, 'C');
                        $this->Cell(15, 7, $data1[$i]['material'], 'LRB', 0, 'C');
                        $this->Cell(20, 7, $data1[$i]['tipo_material'], 'LRB', 0, 'C');
                        $this->Cell(15, 7, $data1[$i]['color'], 'LRB', 0, 'C');
                        $this->Cell(15, 7, $data1[$i]['peso'], 'LRB', 0, 'C');
                    }
                    $this->Cell(5, 7, "//", 'LRB', 0, 'C');
                    $this->Cell(15, 7, "//", 'LRB', 0, 'C');
                    $this->Cell(20, 7, "//", 'LRB', 0, 'C');
                    $this->Cell(15, 7, "//", 'LRB', 0, 'C');
                    $this->Cell(20, 7, "//", 'LRB', 0, 'C');
                    $this->Cell(15, 7, "//", 'LRB', 0, 'C');
                    $this->Ln();
                }
            }
        } else if ($sizeData1 < $sizeData2) {
            for ($i = 0; $i < $sizeData2; $i++) {
                if ($i < $sizeData1) {
                    if ($data1[$i]['id_informe'] == $id_informe) {
                        $totalmp += $data1[$i]['peso'];
                        $this->Cell(5, 7, $data1[$i]['id_materia_prima'], 'LRB', 0, 'C');
                        $this->Cell(20, 7, $data1[$i]['proceso'], 'LRB', 0, 'C');
                        $this->Cell(15, 7, $data1[$i]['material'], 'LRB', 0, 'C');
                        $this->Cell(20, 7, $data1[$i]['tipo_material'], 'LRB', 0, 'C');
                        $this->Cell(15, 7, $data1[$i]['color'], 'LRB', 0, 'C');
                        $this->Cell(15, 7, $data1[$i]['peso'], 'LRB', 0, 'C');
                    }
                    if ($data2[$i]['id_informe'] == $id_informe) {
                        $totalpt += $data2[$i]['peso'];
                        $this->Cell(5, 7, $data2[$i]['id_producto_terminado'], 'LRB', 0, 'C');
                        $this->Cell(15, 7, $data2[$i]['material'], 'LRB', 0, 'C');
                        $this->Cell(20, 7, $data2[$i]['tipo_material'], 'LRB', 0, 'C');
                        $this->Cell(15, 7, $data2[$i]['color'], 'LRB', 0, 'C');
                        $this->Cell(20, 7, $data2[$i]['tipo'], 'LRB', 0, 'C');
                        $this->Cell(15, 7, $data2[$i]['peso'], 'LRB', 0, 'C');
                        $this->Ln();
                    }
                } else {
                    $this->Cell(5, 7, "//", 'LRB', 0, 'C');
                    $this->Cell(20, 7, "//", 'LRB', 0, 'C');
                    $this->Cell(15, 7, "//", 'LRB', 0, 'C');
                    $this->Cell(20, 7, "//", 'LRB', 0, 'C');
                    $this->Cell(15, 7, "//", 'LRB', 0, 'C');
                    $this->Cell(15, 7, "//", 'LRB', 0, 'C');
                    if ($data2[$i]['id_informe'] == $id_informe) {
                        $totalpt += $data2[$i]['peso'];
                        $this->Cell(5, 7, $data2[$i]['id_producto_terminado'], 'LRB', 0, 'C');
                        $this->Cell(15, 7, $data2[$i]['material'], 'LRB', 0, 'C');
                        $this->Cell(20, 7, $data2[$i]['tipo_material'], 'LRB', 0, 'C');
                        $this->Cell(15, 7, $data2[$i]['color'], 'LRB', 0, 'C');
                        $this->Cell(20, 7, $data2[$i]['tipo'], 'LRB', 0, 'C');
                        $this->Cell(15, 7, $data2[$i]['peso'], 'LRB', 0, 'C');
                        $this->Ln();
                    }
                }
            }
        } else {
            if ($sizeData1 != 0 && $sizeData2 != 0) {
                for ($i = 0; $i < $sizeData1; $i++) {
                    if ($data1[$i]['id_informe'] == $id_informe) {
                        $totalmp += $data1[$i]['peso'];
                        $this->Cell(5, 7, $data1[$i]['id_materia_prima'], 'LRB', 0, 'C');
                        $this->Cell(20, 7, $data1[$i]['proceso'], 'LRB', 0, 'C');
                        $this->Cell(15, 7, $data1[$i]['material'], 'LRB', 0, 'C');
                        $this->Cell(20, 7, $data1[$i]['tipo_material'], 'LRB', 0, 'C');
                        $this->Cell(15, 7, $data1[$i]['color'], 'LRB', 0, 'C');
                        $this->Cell(15, 7, $data1[$i]['peso'], 'LRB', 0, 'C');
                    }
                    if ($data2[$i]['id_informe'] == $id_informe) {
                        $totalpt += $data2[$i]['peso'];
                        $this->Cell(5, 7, $data2[$i]['id_producto_terminado'], 'LRB', 0, 'C');
                        $this->Cell(15, 7, $data2[$i]['material'], 'LRB', 0, 'C');
                        $this->Cell(20, 7, $data2[$i]['tipo_material'], 'LRB', 0, 'C');
                        $this->Cell(15, 7, $data2[$i]['color'], 'LRB', 0, 'C');
                        $this->Cell(20, 7, $data2[$i]['tipo'], 'LRB', 0, 'C');
                        $this->Cell(15, 7, $data2[$i]['peso'], 'LRB', 0, 'C');
                        $this->Ln();
                    }
                }
            } else {
                $this->Cell(5, 7, "//", 'LRB', 0, 'C');
                $this->Cell(20, 7, "//", 'LRB', 0, 'C');
                $this->Cell(15, 7, "//", 'LRB', 0, 'C');
                $this->Cell(20, 7, "//", 'LRB', 0, 'C');
                $this->Cell(15, 7, "//", 'LRB', 0, 'C');
                $this->Cell(15, 7, "//", 'LRB', 0, 'C');
                $this->Cell(5, 7, "//", 'LRB', 0, 'C');
                $this->Cell(15, 7, "//", 'LRB', 0, 'C');
                $this->Cell(20, 7, "//", 'LRB', 0, 'C');
                $this->Cell(15, 7, "//", 'LRB', 0, 'C');
                $this->Cell(20, 7, "//", 'LRB', 0, 'C');
                $this->Cell(15, 7, "//", 'LRB', 0, 'C');
                $this->Ln();
            }
        }
        /*
        foreach ($data1 as $row) {
            if ($row['id_informe'] == $id_informe) {
                $total += $row['peso'];
                $this->Cell(5, 8, $row['id_materia_prima'], 'LRB', 0, 'C');
                $this->Cell(20, 8, $row['proceso'], 'LRB', 0, 'C');
                $this->Cell(15, 8, $row['material'], 'LRB', 0, 'C');
                $this->Cell(20, 8, $row['tipo_material'], 'LRB', 0, 'C');
                $this->Cell(15, 8, $row['color'], 'LRB', 0, 'C');
                $this->Cell(15, 8, $row['peso'], 'LRB', 0, 'C');
                $this->Ln();
            }
        }
*/
        $this->Cell(60);
        $this->Cell(15, 7, 'Total (A)', 'LRB', 0, 'C');
        $this->Cell(15, 7, $totalmp, 'LRB', 0, 'C');
        $this->Cell(55);
        $this->Cell(20, 7, 'Total (B)', 'LRB', 0, 'C');
        $this->Cell(15, 7, $totalpt, 'LRB', 0, 'C');
        $this->Ln();
    }

    function pt($id_informe)
    {
        $this->SetFont('Arial', 'B', 10);
        $this->Ln(5);
        $this->Cell(30);
        $total = 0;
        $data1 = ModeloProductoTerminado::index("productoterminado");
        // Cabecera
        $this->Cell(130, 7, 'Producto Terminado', 'LRT', 0, 'C');
        $this->Ln();
        $this->Cell(30);
        $this->Cell(10, 7, '#', 1, 0, 'C');
        $this->Cell(20, 7, 'Material', 1, 0, 'C');
        $this->Cell(30, 7, 'Tipo Material', 1, 0, 'C');
        $this->Cell(20, 7, 'Color', 1, 0, 'C');
        $this->Cell(30, 7, 'Tipo', 1, 0, 'C');
        $this->Cell(20, 7, 'Peso', 1, 0, 'C');
        $this->Ln();
        $this->Cell(30);
        $this->SetFont('Times', '', 9);
        foreach ($data1 as $row) {
            if ($row['id_informe'] == $id_informe) {
                $total += $row['peso'];
                $this->Cell(10, 8, $row['id_producto_terminado'], 'LRB', 0, 'C');
                $this->Cell(20, 8, $row['material'], 'LRB', 0, 'C');
                $this->Cell(30, 8, $row['tipo_material'], 'LRB', 0, 'C');
                $this->Cell(20, 8, $row['color'], 'LRB', 0, 'C');
                $this->Cell(30, 8, $row['tipo'], 'LRB', 0, 'C');
                $this->Cell(20, 8, $row['peso'], 'LRB', 0, 'C');
                $this->Ln();
                $this->Cell(30);
            }
        }
        $this->Cell(80);
        $this->Cell(30, 8, 'Total (B)', 'LRB', 0, 'C');
        $this->Cell(20, 8, $total, 'LRB', 0, 'C');
        $this->Ln();
    }

    function scrap($data)
    {
        $this->SetFont('Arial', 'B', 7);
        $this->Ln(2);
        $total = 0;
        $contador = 0;
        $data1 = ModeloScrap::index("scrap");
        $sizeData1 = count($data1);
        $resumen = Resumen($data);
        // Cabecera
        $this->Cell(110, 6, 'Detalle de Pesos - Scrap', 'LRT', 0, 'C');
        $this->Cell(10);
        $this->Cell(50, 6, 'Resumen(Total en Kilos)', 'LRT', 0, 'C');
        $this->Ln();
        $this->Cell(10, 6, '#', 1, 0, 'C');
        $this->Cell(50, 6, 'Tipo desperdicio', 1, 0, 'C');
        $this->Cell(20, 6, '# Sacos', 1, 0, 'C');
        $this->Cell(30, 6, 'Peso', 1, 0, 'C');
        $this->Cell(10);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(30, 6, 'Saldo Anterior', 1, 0, 'C');
        $this->SetFont('Times', '', 9);
        $this->Cell(20, 6, $data[0]['saldo_anterior'], 1, 0, 'C');
        $this->Ln();
        $this->SetFont('Times', '', 9);
        if ($sizeData1 == 0) {
            for ($j = 0; $j < 3; $j++) {
                $this->Cell(10, 6, "//", 'LRB', 0, 'C');
                $this->Cell(50, 6, "//", 'LRB', 0, 'C');
                $this->Cell(20, 6, "//", 'LRB', 0, 'C');
                $this->Cell(30, 6, "//", 'LRB', 0, 'C');
                if ($contador == 0) {
                    $this->Cell(10);
                    $this->SetFont('Arial', 'B', 10);
                    $this->Cell(30, 6, 'Total MP (A)', 1, 0, 'C');
                    $this->SetFont('Times', '', 9);
                    $this->Cell(20, 6, $resumen['mp'], 1, 0, 'C');
                    $this->Ln();
                } else if ($contador == 1) {
                    $this->Cell(10);
                    $this->SetFont('Arial', 'B', 10);
                    $this->Cell(30, 6, 'Total PT (B)', 1, 0, 'C');
                    $this->SetFont('Times', '', 9);
                    $this->Cell(20, 6, $resumen['pt'], 1, 0, 'C');
                    $this->Ln();
                } else if ($contador == 2) {
                    $this->Cell(10);
                    $this->SetFont('Arial', 'B', 10);
                    $this->Cell(30, 6, 'Total SCRAP (C)', 1, 0, 'C');
                    $this->SetFont('Times', '', 9);
                    $this->Cell(20, 6, $resumen['scrap'], 1, 0, 'C');
                    $this->Ln();
                } else if ($contador == 3) {
                    $this->Cell(10);
                    $this->SetFont('Arial', 'B', 10);
                    $this->Cell(30, 6, 'Total Materiales', 1, 0, 'C');
                    $this->SetFont('Times', '', 9);
                    $this->Cell(20, 6, $resumen['total'], 1, 0, 'C');
                    $this->Ln();
                }
                $contador++;
            }
        } else {
            foreach ($data1 as $row) {
                if ($row['id_informe'] == $data[0]['id_informe']) {
                    $total += $row['peso'] * $row['sacos'];
                    $this->Cell(10, 6, $row['id_scrap'], 'LRB', 0, 'C');
                    $this->Cell(50, 6, $row['motivo'], 'LRB', 0, 'C');
                    $this->Cell(20, 6, $row['sacos'], 'LRB', 0, 'C');
                    $this->Cell(30, 6, $row['peso'], 'LRB', 0, 'C');
                    if ($contador == 0) {
                        $this->Cell(10);
                        $this->SetFont('Arial', 'B', 10);
                        $this->Cell(30, 6, 'Total MP (A)', 1, 0, 'C');
                        $this->SetFont('Times', '', 9);
                        $this->Cell(20, 6, $resumen['mp'], 1, 0, 'C');
                        $this->Ln();
                    } else if ($contador == 1) {
                        $this->Cell(10);
                        $this->SetFont('Arial', 'B', 10);
                        $this->Cell(30, 6, 'Total PT (B)', 1, 0, 'C');
                        $this->SetFont('Times', '', 9);
                        $this->Cell(20, 6, $resumen['pt'], 1, 0, 'C');
                        $this->Ln();
                    } else if ($contador == 2) {
                        $this->Cell(10);
                        $this->SetFont('Arial', 'B', 10);
                        $this->Cell(30, 6, 'Total SCRAP (C)', 1, 0, 'C');
                        $this->SetFont('Times', '', 9);
                        $this->Cell(20, 6, $resumen['scrap'], 1, 0, 'C');
                        $this->Ln();
                    } else if ($contador == 3) {
                        $this->Cell(10);
                        $this->SetFont('Arial', 'B', 10);
                        $this->Cell(30, 6, 'Total Materiales', 1, 0, 'C');
                        $this->SetFont('Times', '', 9);
                        $this->Cell(20, 6, $resumen['total'], 1, 0, 'C');
                        $this->Ln();
                    } else {
                        $this->Ln();
                    }
                }
                $contador++;
            }
        }
        $this->Cell(60);
        $this->Cell(20, 6, 'Total (C)', 'LRB', 0, 'C');
        $this->Cell(30, 6, $total, 'LRB', 0, 'C');

        if ($contador < 4) {
            while ($contador < 4) {
                if ($contador == 0) {
                    $this->Cell(10);
                    $this->SetFont('Arial', 'B', 10);
                    $this->Cell(30, 7, 'Total MP (A)', 1, 0, 'C');
                    $this->SetFont('Times', '', 9);
                    $this->Cell(20, 7, $resumen['mp'], 1, 0, 'C');
                    $this->Ln();
                } else if ($contador == 1) {
                    $this->Cell(10);
                    $this->SetFont('Arial', 'B', 10);
                    $this->Cell(30, 7, 'Total PT (B)', 1, 0, 'C');
                    $this->SetFont('Times', '', 9);
                    $this->Cell(20, 7, $resumen['pt'], 1, 0, 'C');
                    $this->Ln();
                } else if ($contador == 2) {
                    $this->Cell(10);
                    $this->SetFont('Arial', 'B', 10);
                    $this->Cell(30, 7, 'Total SCRAP (C)', 1, 0, 'C');
                    $this->SetFont('Times', '', 9);
                    $this->Cell(20, 7, $resumen['scrap'], 1, 0, 'C');
                    $this->Ln();
                } else if ($contador == 3) {
                    $this->Cell(10);
                    $this->SetFont('Arial', 'B', 10);
                    $this->Cell(30, 7, 'Total Materiales', 1, 0, 'C');
                    $this->SetFont('Times', '', 9);
                    $this->Cell(20, 7, $resumen['total'], 1, 0, 'C');
                    $this->Ln();
                }
                $contador++;
            }
        }
    }


    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

function Resumen($data)
{
    $total_scrap = 0;
    $total_pt = 0;
    $total_mp = 0;
    $datos = array();
    $data1 = ModeloScrap::index("scrap");
    $data2 = ModeloProductoTerminado::index("productoterminado");
    $data3 = ModeloMateriaPrima::index("materiaprima");
    foreach ($data1 as $row) {
        if ($data[0]['id_informe'] == $row['id_informe']) {
            $total_scrap += $row['peso'] * $row['sacos'];
        }
    }
    foreach ($data2 as $row) {
        if ($data[0]['id_informe'] == $row['id_informe']) {
            $total_pt += $row['peso'];
        }
    }
    foreach ($data3 as $row) {
        if ($data[0]['id_informe'] == $row['id_informe']) {
            $total_mp += $row['peso'];
        }
    }
    $datos['mp'] = $total_mp;
    $datos['pt'] = $total_pt;
    $datos['scrap'] = $total_scrap;
    $datos['total'] = ($total_pt - $total_mp) + ($data[0]['saldo_anterior'] - $total_scrap);

    return $datos;
    // Cabecera
    /*
        $this->Cell(50, 7, 'Resumen(Total en Kilos)', 'LRT', 0, 'C');
        $this->Ln();
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(30, 7, 'Saldo Anterior', 1, 0, 'C');
        $this->SetFont('Times', '', 9);
        $this->Cell(20, 7, $data[0]['saldo_anterior'], 1, 0, 'C');
        $this->Ln();
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(30, 7, 'Total MP (A)', 1, 0, 'C');
        $this->SetFont('Times', '', 9);
        $this->Cell(20, 7, $total_mp, 1, 0, 'C');
        $this->Ln();
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(30, 7, 'Total PT (B)', 1, 0, 'C');
        $this->SetFont('Times', '', 9);
        $this->Cell(20, 7, $total_pt, 1, 0, 'C');
        $this->Ln();
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(30, 7, 'Total SCRAP (C)', 1, 0, 'C');
        $this->SetFont('Times', '', 9);
        $this->Cell(20, 7, $total_scrap, 1, 0, 'C');
        $this->Ln();
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(30, 7, 'Total Materiales', 1, 0, 'C');
        $this->SetFont('Times', '', 9);
        $this->Cell(20, 7, ($total_pt - $total_mp) + ($data[0]['saldo_anterior'] - $total_scrap), 1, 0, 'C');
        $this->Ln();
        */
}

// Creación del objeto de la clase heredada
/*
$pdf = new PDF();
$data = $pdf->LoadInfoInforme(10);
$pdf->AddPage();
$pdf->Info($data);
$pdf->SetFont('Times', '', 9);
$pdf->personal($data[0]['id_informe']);
$pdf->mp_pt($data[0]['id_informe']);
$pdf->scrap($data);
$pdf->Output('D',"imprimir.pdf",true);
*/
