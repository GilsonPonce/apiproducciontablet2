<?php

$arrayRuters = explode("/", $_SERVER['REQUEST_URI']);
//echo json_encode(array_filter($arrayRuters));

if (count(array_filter($arrayRuters)) == 0) {
    /*=================================================
        Cuando no se hace ninguna peticion a la API
    ===================================================*/
    $json = array(
        "detalle" => "no encontrado"
    );
    echo json_encode($json, true);
} else {
    if (count(array_filter($arrayRuters)) == 1) {
        /*=====================================
        Cuando se hace peticiones de una sola
        =======================================*/
        if (array_filter($arrayRuters)[1] == "linea") {
        /*=====================================================
        Cuando se hace peticiones nova-apiproduccion.com/lineas
        =======================================================*/
            if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                $Objetolineas = new ControladorLineas();
                $Objetolineas->index();
            }else if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST"){
                /**REGISTRA */
            }
        }else if(array_filter($arrayRuters)[1]== "peso"){

        }else if(array_filter($arrayRuters)[1]== "tipo_peso"){

        }else if(array_filter($arrayRuters)[1]== "color"){

        }else if(array_filter($arrayRuters)[1]== "tipo_material"){

        }else if(array_filter($arrayRuters)[1]== "material"){

        }
        else if(array_filter($arrayRuters)[1]== "informe"){

        }
        else if(array_filter($arrayRuters)[1]== "observacion"){

        }else if(array_filter($arrayRuters)[1]== "orden"){

        }else if(array_filter($arrayRuters)[1]== "registro"){

        }else if(array_filter($arrayRuters)[1]== "personal"){

        }else if(array_filter($arrayRuters)[1]== "parada"){

        }else if(array_filter($arrayRuters)[1]== "motivo"){

        }else if(array_filter($arrayRuters)[1]== "tipo_personal"){

        }else if(array_filter($arrayRuters)[1]== "area_trabajo"){

        }
    }else if (count(array_filter($arrayRuters)) == 2){
        if(array_filter($arrayRutas)[1] == "lineas" && is_numeric(array_filter($arrayRutas)[2])){
            if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "PUT"){

            }else if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "DELETE"){

            }else{
                $json = array(

                    "detalle"=>"no encontrado"

                );

                echo json_encode($json, true);

                return;
            }
        }


    }
}
