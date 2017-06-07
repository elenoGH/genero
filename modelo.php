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
            " and partido_politico not in ('Total')
            group by legistalura, anio_ini, anio_fin
            order by anio_ini asc ";
        
        if ($result = mysqli_query($con, $sql)) {
            $count = 0;
            while ($row = mysqli_fetch_row($result)) {
                if (isset($row[6])) {
                    $th_suma = $row[6];
                } else {
                    $th_suma = 0;
                }
                if (isset($row[7])) {
                    $tm_suma = $row[7];
                } else {
                    $tm_suma = 0;
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
    
    
/**
 * Mujeres candidatas model
 */
    
    if (isset($_POST["search_data_mc"])) {

        $search_data = $_POST["search_data_mc"];
        $and_cond = "";

        if (isset($search_data['e_f_']) && !empty($search_data['e_f_'])) {
            $and_cond = $and_cond." and f_e = '".$search_data['e_f_']."' ";
        }
        if (isset($search_data['cat3_']) && !empty($search_data['cat3_'])) {
            $and_cond = $and_cond." and camara = '".$search_data['cat3_']."' ";
        }
        if (isset($search_data['part_pol_']) && !empty($search_data['part_pol_'])) {
            $and_cond = $and_cond." and partido_politico_mc like '%".$search_data['part_pol_']."%' ";
        }
        if (isset($search_data['ent_fed_']) && !empty($search_data['ent_fed_'])) {
            $and_cond = $and_cond." and estado like '%".$search_data['ent_fed_']."%' ";
        }
        if (isset($search_data['princ_rep_']) && !empty($search_data['princ_rep_'])) {
            $and_cond = $and_cond." and principio_representacion like '%".$search_data['princ_rep_']."%' ";
        }
        if (isset($search_data['prop_sup_']) && !empty($search_data['prop_sup_'])) {
            $and_cond = $and_cond." and propietario_suplente like '%".$search_data['prop_sup_']."%' ";
        }
        if (isset($search_data['per_ini_']) && !empty($search_data['per_ini_'])) {
            $and_cond = $and_cond." and anio BETWEEN ".$search_data['per_ini_']." and ".$search_data['per_fin_']." ";
        }
        $array_data = array();
        $sql = " SELECT 
            MAX(anio) as anio
           ,SUM(CASE WHEN sexo = 'Hombre' THEN 1 END) AS hombre_suma
           ,SUM(CASE WHEN sexo = 'Mujer' THEN 1 END) AS mujer_suma
           ,SUM(CASE WHEN sexo IS NOT NULL THEN 1 ELSE 0 END) AS total
        from wp_ine_mujeres_candidatas
        where id > 0
        ".$and_cond."
        GROUP BY anio
        order by anio ";
        
        if ($result = mysqli_query($con, $sql)) {
            $count = 0;
            while ($row = mysqli_fetch_row($result)) {

                $array_data[$row[0]] = array(
                              'anio_ini' => $row[0]
                            , 'totales_hombres_suma' => $row[1]
                            , 'totales_mujeres_suma' => $row[2]
                        );
            }
            mysqli_free_result($result);
        }

        //mysqli_close($con);
        echo json_encode($array_data);
        die;
    }


    if (isset($_POST["entidades_mc"])) {
        $array_data = array();
        $sql = " select convert(cast(convert(estado using latin1) as binary) using utf8) AS estado
            from wp_ine_mujeres_candidatas
            where estado is not null
            and estado != ''
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
    
    if (isset($_POST['partido_politico_mc'])) {
        $array_data = array();
        $and_cond = "";
               
        $sql = " select convert(cast(convert(partido_politico_mc using latin1) as binary) using utf8) AS partido_politico_mc
            from wp_ine_mujeres_candidatas 
            where id > 0
            and partido_politico_mc != ''
            group by partido_politico_mc 
            order by partido_politico_mc asc ";
        
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
    
    if (isset($_POST['periodos_mc'])) {
        $array_data = array();
        $and_cond = "";
               
        $sql = " select anio
        from wp_ine_mujeres_candidatas
        GROUP by anio
        order by anio asc ";
        
        if ($result = mysqli_query($con, $sql)) {
            while ($row = mysqli_fetch_row($result)) {
                $array_data[$row[0]] = array(
                            'periodo' => $row[0]
                        );
            }
            mysqli_free_result($result);
        }

        //mysqli_close($con);
        echo json_encode($array_data);
        die;
    }