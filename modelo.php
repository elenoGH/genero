<?php
    require 'connection_db.php';
    
    if (isset($_POST["search_data"])) {
        $array_data = array();
        $sql = "select sum(tprmr_mujeres) as tprmr_mujeres_suma, sum(tprmr_hombres) as tprmr_hombres_suma
                    , sum(tprpm_mujeres) as tprpm_mujeres_suma, sum(tprpm_hombres) as tprpm_hombres_suma
                    , sum(tprp_mujeres) as tprp_mujeres_suma, sum(tprp_hombres) as tprp_hombres_suma
                    , sum(totales_hombres) as totales_hombres_suma, sum(totales_mujeres) as totales_mujeres_suma
                    , legistalura, anio_ini, anio_fin
            from mujeres_electas_ine
            where conformacion_camara_de = 'diputados'
            group by legistalura, anio_ini, anio_fin
            order by anio_ini asc ";
        
        if ($result = mysqli_query($con, $sql)) {
            while ($row = mysqli_fetch_row($result)) {
                $array_data[$row[0]] = array(
                            'legistalura' => $row[8]
                            , 'anio_ini' => $row[9]
                            , 'anio_fin' => $row[10]
                            , 'totales_mujeres_suma' => $row[7]
                            , 'totales_hombres_suma' => $row[6]
                        );
            }
            mysqli_free_result($result);
        }

        //mysqli_close($con);
        echo json_encode($array_data);
        die;
    }
?>