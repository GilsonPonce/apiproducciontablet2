<?php
class ControladorReporte
{

    public function show($id)
    {
        $usuario = ModeloUsuario::index("usuario");
        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
            foreach ($usuario as $key => $valueUsuario) {
                if (
                    "Basic " . base64_encode($_SERVER['PHP_AUTH_USER'] . ":" . $_SERVER['PHP_AUTH_PW']) ==
                    "Basic " . base64_encode($valueUsuario["padlock"] . ":" . $valueUsuario["keylock"])
                ) {
                    $reporte = ModeloReporte::show($id);
                    $json = array(
                        "status" => 200,
                        "total_registro" => count($reporte),
                        "detalle" => $reporte
                    );
                    echo json_encode($json, true);
                }else{
                    $json = array(

                        "status" => 404,
                        "detalle" => "No Autorizado"
                    );

                    echo json_encode($json, true);

                    return;
                }
            }
        }else{
            $json = array(

                "status" => 404,
                "detalle" => "No Autorizado"
            );

            echo json_encode($json, true);

            return;
        }
    }

    public function index($arr){
        $usuario = ModeloUsuario::index("usuario");
        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
            foreach ($usuario as $key => $valueUsuario) {
                if (
                    "Basic " . base64_encode($_SERVER['PHP_AUTH_USER'] . ":" . $_SERVER['PHP_AUTH_PW']) ==
                    "Basic " . base64_encode($valueUsuario["padlock"] . ":" . $valueUsuario["keylock"])
                ) {
                    $reportes = ModeloReporte::index($arr);
                    if(!empty($reportes)){
                        $filename = "ReporteMultiple_".date("Y-m-d H:i:s").".xls";
                        header("Content-Type: application/vnd.ms-excel");
                        header("Content-Disposition: attachment; filename=".$filename);
                        $mostrar_columnas = false;
                        foreach($reportes as $repo) {
                        
                        if(!$mostrar_columnas) {
                        
                        echo implode("\t", array_keys($repo)) . "\n";
                        
                        $mostrar_columnas = true;
                        
                        }
                        
                        echo implode("\t", array_values($repo)) . "\n";
                        
                        }
                        
                         
                        
                        }else{
                        
                        echo 'No hay datos a exportar';
                        
                        }
                        
                        exit;
                        
                }else{
                    $json = array(

                        "status" => 404,
                        "detalle" => "No Autorizado"
                    );

                    echo json_encode($json, true);

                    return;
                }
            }
        }else{
            $json = array(

                "status" => 404,
                "detalle" => "No Autorizado"
            );

            echo json_encode($json, true);

            return;
        }
    }

    
}