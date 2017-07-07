<?php
require 'connection_db.php';
        $and_cond = "";

        $array_data = array();

        $sql = " SELECT 
            MAX(anio_ini) as anio_ini, MAX(anio_fin) as anio_fin
           ,SUM(CASE WHEN sexo = 'Hombre' THEN 1 END) AS hombre_suma
           ,SUM(CASE WHEN sexo = 'Mujer' THEN 1 END) AS mujer_suma
           ,SUM(CASE WHEN sexo IS NOT NULL THEN 1 ELSE 0 END) AS total
        from mujeres_cargos_publicos
        where id > 0 
        ".$and_cond."
        GROUP BY anio_ini, anio_fin
        order by anio_ini ";
        
        if ($result = mysqli_query($con, $sql)) {
            $count = 0;
            while ($row = mysqli_fetch_row($result)) {
                $th_suma = 0;
                if (isset($row[2])) {
                    $th_suma = $row[2];
                }
                $tm_suma = 0;
                if (isset($row[3])) {
                    $tm_suma = $row[3];
                }
                $array_data[$row[0].$row[1]] = array(
                              'anio_ini' => $row[0]
                            , 'anio_fin' => $row[1]
                            , 'totales_mujeres_suma' => $tm_suma
                            , 'totales_hombres_suma' => $th_suma
                            , 'total'   => $row[4]
                        );
            }
            mysqli_free_result($result);
        }
        
        

        //mysqli_close($con);
        echo json_encode($array_data);
        die;