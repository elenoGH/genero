<?php
    require 'connection_db.php';
    
    if (isset($_POST["entidades"])) {
        $array_data = array();
        $sql = " select estado
            from mujeres_electas_ine
            where estado is not null
            GROUP by estado
            order by estado asc ";
        
        if ($result = mysqli_query($con, $sql)) {
            while ($row = mysqli_fetch_row($result)) {
                $array_data[$row[0]] = array(
                            'estado' => $row[0]
                        );
            }
            mysqli_free_result($result);
        }

        //mysqli_close($con);
        echo json_encode($array_data);
        die;
    }
    
    if (isset($_POST['partido_politico'])) {
        $array_data = array();
        $and_cond = "";
        
        if (isset($_POST['and_tipo_camara_'])) {
            switch ($_POST['and_tipo_camara_']) {
                case 1:
                    $and_cond = " and conformacion_camara_de = 'senadores' ";
                    break;
                case 2:
                    $and_cond = " and conformacion_camara_de = 'diputados' "
                        . " and tipo_elecciones = 'federal' ";
                    break;
                case 3:
                    $and_cond = " and conformacion_camara_de = 'diputados' "
                        . " and tipo_elecciones = 'estatal' ";
                    break;
            }
        }
        
        if (isset($_POST['and_entidad_fed_']) && !empty($_POST['and_entidad_fed_'])) {
            $and_cond = $and_cond." and estado='".$_POST['and_entidad_fed_']."' ";
        }
        
        $sql = " select partido_politico
        from mujeres_electas_ine
        where partido_politico not in ('Total')
        ".$and_cond."
        group by partido_politico
        order by partido_politico asc ";
        
        if ($result = mysqli_query($con, $sql)) {
            while ($row = mysqli_fetch_row($result)) {
                $array_data[$row[0]] = array(
                            'part_pol' => $row[0]
                        );
            }
            mysqli_free_result($result);
        }

        //mysqli_close($con);
        echo json_encode($array_data);
        die;
    }
    
    if (isset($_POST["search_data"])) {
        
        $search_data = $_POST["search_data"];
        $and_cond = "";
        switch ($search_data['tipo_camara_']) {
            case 1:
                $and_cond = " and conformacion_camara_de = 'senadores' ";
                break;
            case 2:
                $and_cond = " and conformacion_camara_de = 'diputados' "
                    . " and tipo_elecciones = 'federal' ";
                break;
            case 3:
                $and_cond = " and conformacion_camara_de = 'diputados' "
                    . " and tipo_elecciones = 'estatal' ";
                break;
        }
        
        if (isset($search_data['entidad_fed_']) && !empty($search_data['entidad_fed_'])) {
            $and_cond = $and_cond." and estado = '".$search_data['entidad_fed_']."' ";
        }
        
        if (isset($search_data['partido_politico_']) && !empty($search_data['partido_politico_'])) {
            $and_cond = $and_cond." and partido_politico = '".$search_data['partido_politico_']."' ";
        }
        
        $array_data = array();
        $sql = "select sum(tprmr_mujeres) as tprmr_mujeres_suma, sum(tprmr_hombres) as tprmr_hombres_suma
                    , sum(tprpm_mujeres) as tprpm_mujeres_suma, sum(tprpm_hombres) as tprpm_hombres_suma
                    , sum(tprp_mujeres) as tprp_mujeres_suma, sum(tprp_hombres) as tprp_hombres_suma
                    , sum(totales_hombres) as totales_hombres_suma, sum(totales_mujeres) as totales_mujeres_suma
                    , legistalura, anio_ini, anio_fin
            from mujeres_electas_ine
            where id > 0"
            .$and_cond.
            " group by legistalura, anio_ini, anio_fin
            order by anio_ini asc ";
        
        if ($result = mysqli_query($con, $sql)) {
            $count = 0;
            while ($row = mysqli_fetch_row($result)) {
                    $th_suma = $row[6];
                if (isset($row[7])) {
                    $tm_suma = $row[7];
                } else {
                    $tm_suma = $row[0];
                }
                
                $array_data[$row[0].$row[8].$row[9].$row[10]] = array(
                            'legistalura' => $row[8]
                            , 'anio_ini' => $row[9]
                            , 'anio_fin' => $row[10]
                            , 'totales_mujeres_suma' => $tm_suma
                            , 'totales_hombres_suma' => $th_suma
                            , 'count' => $count+1
                            , 'query' => $sql
                        );
            }
            mysqli_free_result($result);
        }

        //mysqli_close($con);
        echo json_encode($array_data);
        die;
    }
?>