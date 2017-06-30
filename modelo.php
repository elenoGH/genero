<?php
    require 'connection_db.php';
    
    /**
     * inicio mujeres cargos publicos legislativo
     */
    if (isset($_POST['entidad_federativa_mcpl'])) {
        
        $entidad_federativa_mcpl = $_POST['entidad_federativa_mcpl'];
        
        $and_cond = "";
        
        $sql = " select entidad_federativa
            from mujeres_cargos_publicos
            where id >0 "
            .$and_cond.
            " group by entidad_federativa
            order by entidad_federativa asc ";
        
        if ($result = mysqli_query($con, $sql)) {
            while ($row = mysqli_fetch_row($result)) {
                $array_data[$row[0]] = array(
                            'entidad_federativa' => $row[0]
                        );
            }
            mysqli_free_result($result);
        }

        //mysqli_close($con);
        echo json_encode($array_data);
        die;
    }
    if (isset($_POST['partido_politico_mcpl'])) {
        $array_data = array();
        $partido_politico_mcpl = $_POST['partido_politico_mcpl'];
        
        $and_cond = "";
        
        if (isset($partido_politico_mcpl['ent_fed_'])) {
            $and_cond = $and_cond." and entidad_federativa = '".$partido_politico_mcpl['ent_fed_']."' ";
        }
        $sql = " select partido_politico
        from mujeres_cargos_publicos
        where id > 0 "
        .$and_cond.
        " group by partido_politico
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
    if (isset($_POST['principio_representacion_mcpl'])) {
        $principio_representacion_mcpl = $_POST['principio_representacion_mcpl'];
        
        $and_cond = "";
        
        $sql = " select principio_representacion
        from mujeres_cargos_publicos
        where id > 0 "
        .$and_cond.
        " group by principio_representacion
        order by principio_representacion asc ";
        
        if ($result = mysqli_query($con, $sql)) {
            while ($row = mysqli_fetch_row($result)) {
                $array_data[$row[0]] = array(
                            'principio_representacion' => $row[0]
                        );
            }
            mysqli_free_result($result);
        }

        //mysqli_close($con);
        echo json_encode($array_data);
        die;
    }
    /**
     * fin mujeres cargos publicos legislativo
     */
    
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
            where id > 0 "
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
    
    if (isset($_POST["search_data_ag"])) {

        $search_data = $_POST["search_data_ag"];
        $and_cond = "";

        if (isset($search_data['e_f_']) && !empty($search_data['e_f_'])) {
            $and_cond = $and_cond." and f_e = '".$search_data['e_f_']."' ";
        }
        if (isset($search_data['cat3_']) && !empty($search_data['cat3_'])) {
            if ($search_data['tipo_search'] == 'candidatas') {
                $and_cond = $and_cond." and camara = '".$search_data['cat3_']."' ";
            } else if ($search_data['tipo_search'] == 'cargos_publicos' && $search_data['cat3_'] == 'secretaria_estado') {
                $and_cond = $and_cond." and secretaria like '%".$search_data['secretaria_']."%' ";
            }
        }
        if (isset($search_data['part_pol_']) && !empty($search_data['part_pol_'])) {
            $and_cond = $and_cond." and partido_politico like '%".$search_data['part_pol_']."%' ";
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
        if ($search_data['tipo_search'] == 'candidatas') {
            $sql = " SELECT 
                MAX(anio) as anio
               ,SUM(CASE WHEN sexo = 'Hombre' THEN 1 END) AS hombre_suma
               ,SUM(CASE WHEN sexo = 'Mujer' THEN 1 END) AS mujer_suma
               ,SUM(CASE WHEN sexo IS NOT NULL THEN 1 ELSE 0 END) AS total
            from wp_ine_mujeres_candidatas
            where id > 0 "
            .$and_cond.
            " GROUP BY anio
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
        } else if ($search_data['tipo_search'] == 'cargos_publicos') {
            $sql = " SELECT 
            MAX(anio_ini) as anio_ini
           ,SUM(CASE WHEN sexo = 'Hombre' THEN 1 END) AS hombre_suma
           ,SUM(CASE WHEN sexo = 'Mujer' THEN 1 END) AS mujer_suma
           ,SUM(CASE WHEN sexo IS NOT NULL THEN 1 ELSE 0 END) AS total
        from wp_ine_mujeres_cargos_publicos
        where id > 0
        ".$and_cond."
        GROUP BY anio_ini
        order by anio_ini ";

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
        }
        

        //mysqli_close($con);
        echo json_encode($array_data);
        die;
    }
    if (isset($_POST["search_data_mcpl"])) {

        $search_data = $_POST["search_data_mcpl"];
        $and_cond = "";

        if (isset($search_data['nivel_gobierno_']) && !empty($search_data['nivel_gobierno_'])) {
            $and_cond = $and_cond." and nivel_gobierno = '".$search_data['nivel_gobierno_']."' ";
        }
        if (isset($search_data['cargo_']) && !empty($search_data['cargo_'])) {
            $and_cond = $and_cond." and cargo = '".$search_data['cargo_']."'";
        }
        if (isset($search_data['entidad_federativa_mcpl_']) && !empty($search_data['entidad_federativa_mcpl_'])) {
            $and_cond = $and_cond." and entidad_federativa = '".$search_data['entidad_federativa_mcpl_']."' ";
        }
        if (isset($search_data['partido_politico_']) && !empty($search_data['partido_politico_'])) {
            $and_cond = $and_cond." and partido_politico = '".$search_data['partido_politico_']."' ";
        }
        if (isset($search_data['principio_rep_']) && !empty($search_data['principio_rep_'])) {
            $and_cond = $and_cond." and principio_representacion = '".$search_data['principio_rep_']."' ";
        }
        if (isset($search_data['prop_sup_']) && !empty($search_data['prop_sup_'])) {
            $and_cond = $and_cond." and propietario_suplente = '".$search_data['prop_sup_']."' ";
        }
        
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
                if (isset($row[2])) {
                    $th_suma = $row[2];
                } else {
                    $th_suma = 0;
                }
                if (isset($row[3])) {
                    $tm_suma = $row[3];
                } else {
                    $tm_suma = 0;
                }
                $anio_fin = 0;
                if (isset($row[1])) {
                    $anio_fin = $row[1];
                }
                $array_data[$row[0].$anio_fin.$row[4]] = array(
                              'anio_ini' => $row[0]
                            , 'anio_fin' => $anio_fin
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
    }
    
/**
 * mujeres cargo publico
 */
        if (isset($_POST["search_data_mcp"])) {

        $search_data = $_POST["search_data_mcp"];
        $and_cond = "";

        if (isset($search_data['e_f_']) && !empty($search_data['e_f_'])) {
            $and_cond = $and_cond." and f_e like '%".$search_data['e_f_']."%'";
        }
        if (isset($search_data['cat3_']) && !empty($search_data['cat3_'])) {
            if ($search_data['cat3_'] == 'diputados' || $search_data['cat3_'] == 'senadores') {
                $and_cond = $and_cond." and camara like '%".$search_data['cat3_']."%'";
            } else if ($search_data['cat3_'] == 'secretaria_estado'){
                $and_cond = $and_cond." and secretaria like '%".$search_data['secretaria_']."%'";
            }
        }
        if (isset($search_data['part_pol_']) && !empty($search_data['part_pol_'])) {
            $and_cond = $and_cond." and partido_politico like '%".$search_data['part_pol_']."%' ";
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
        $array_data = array();

        $sql = " SELECT 
            MAX(anio_ini_p) as anio_ini_p, MAX(anio_fin_p) as anio_fin_p
           ,SUM(CASE WHEN sexo = 'Hombre' THEN 1 END) AS hombre_suma
           ,SUM(CASE WHEN sexo = 'Mujer' THEN 1 END) AS mujer_suma
           ,SUM(CASE WHEN sexo IS NOT NULL THEN 1 ELSE 0 END) AS total
        from mujeres_cargos_publicos
        where id > 0 
        ".$and_cond."
        GROUP BY anio_ini_p, anio_fin_p
        order by anio_ini_p ";
        
        if ($result = mysqli_query($con, $sql)) {
            $count = 0;
            while ($row = mysqli_fetch_row($result)) {
                if (isset($row[2])) {
                    $th_suma = $row[2];
                } else {
                    $th_suma = 0;
                }
                if (isset($row[3])) {
                    $tm_suma = $row[3];
                } else {
                    $tm_suma = 0;
                }
                $anio_fin = 0;
                if (isset($row[1])) {
                    $anio_fin = $row[1];
                }
                $array_data[$row[0].$anio_fin.$row[4]] = array(
                              'anio_ini' => $row[0]
                            , 'anio_fin' => $anio_fin
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
    }
    
    if (isset($_POST["entidades_mc"])) {
        
        $entidades_mc = $_POST["entidades_mc"];
        $and_cond = "";
        
        if (isset($entidades_mc['by_e_f_']) && !empty($entidades_mc['by_e_f_'])) {
            $and_cond = " and f_e = '".$entidades_mc['by_e_f_']."' ";
        }
        
        $array_data = array();
        $sql = " select convert(cast(convert(estado using latin1) as binary) using utf8) AS estado
            from wp_ine_mujeres_candidatas
            where estado is not null
            and estado != '' "
            .$and_cond.
            " GROUP by estado
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
    
    if (isset($_POST["entidades_mcp"])) {
        
        $array_data = array();
        $entidades_mcp = $_POST["entidades_mcp"];
        $and_cond = "";
        
        if (isset($entidades_mcp['by_e_f_']) && !empty($entidades_mcp['by_e_f_'])) {
            $and_cond = " and f_e = '".$entidades_mcp['by_e_f_']."' ";
        }
        
        $sql = " select estado
            from mujeres_cargos_publicos 
            where id > 0
            and estado != '' "
            .$and_cond.
            " group by estado
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
        
        $partido_politico_mc = $_POST['partido_politico_mc'];
        if (isset($partido_politico_mc['categoria3_']) && !empty($partido_politico_mc['categoria3_'])) {
            $and_cond = $and_cond." and camara = '".$partido_politico_mc['categoria3_']."' ";
        }
                
        $sql = " select convert(cast(convert(partido_politico using latin1) as binary) using utf8) AS partido_politico
            from wp_ine_mujeres_candidatas 
            where id > 0
            and partido_politico != '' "
            .$and_cond.
            " group by partido_politico 
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
    
        if (isset($_POST['partido_politico_mcp'])) {
        $array_data = array();
        $and_cond = "";
               
        $sql = " select partido_politico
        from mujeres_cargos_publicos 
        where id > 0
        and partido_politico != ''
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
    
    /**
     * mujeres cargos publicos model
     */
    
    if (isset($_POST['secretarias_mcp'])) {
        $secretarias_mcp = $_POST['secretarias_mcp'];
        $array_data = array();
        $and_cond = "";
               
        if (isset($secretarias_mcp['ef_c1_'])) {
            $and_cond = $and_cond." and f_e = '".$secretarias_mcp['ef_c1_']."' ";
        }
        
        $sql = " select secretaria
        from mujeres_cargos_publicos
        where id > 0
        and secretaria != ''
        ".$and_cond."
        GROUP BY secretaria
        order by secretaria asc ";
        
        if ($result = mysqli_query($con, $sql)) {
            while ($row = mysqli_fetch_row($result)) {
                $array_data[$row[0]] = array(
                            'secretaria' => $row[0]
                        );
            }
            mysqli_free_result($result);
        }

        //mysqli_close($con);
        echo json_encode($array_data);
        die;
    }
    
    /**
     * mujeres en los organos elecorales administrativos
     */
    
    if (isset($_POST["search_data_moea"])) {
        
        $search_data = $_POST["search_data_moea"];
        $and_cond = "";
        
        if (isset($search_data['categoria_1']) && !empty($search_data['categoria_1'])) {
            $and_cond = $and_cond." and categoria1 like '%".$search_data['categoria_1']."%' ";
        }
        if (isset($search_data['entidad_fed_']) && !empty($search_data['entidad_fed_'])) {
            $and_cond = $and_cond." and estado like '%".$search_data['entidad_fed_']."%' ";
        }
        if (isset($search_data['tipo_cargo_']) && !empty($search_data['tipo_cargo_'])) {
            $and_cond = $and_cond." and tipo_consejero like '%".$search_data['tipo_cargo_']."%' ";
        }
        $array_data = array();
        $sql = "SELECT 
            MAX(anio_ini) as anio_ini, MAX(anio_fin) as anio_fin
           ,SUM(CASE WHEN sexo = 'Hombre' THEN 1 END) AS hombre_suma
           ,SUM(CASE WHEN sexo = 'Mujer' THEN 1 END) AS mujer_suma
           ,SUM(CASE WHEN sexo IS NOT NULL THEN 1 ELSE 0 END) AS total
        from mujeres_oea
        where id > 0 "
        .$and_cond.
        " GROUP BY anio_ini, anio_fin
        order by anio_ini ";
        
        if ($result = mysqli_query($con, $sql)) {
            $count = 0;
            while ($row = mysqli_fetch_row($result)) {
                if (isset($row[2])) {
                    $th_suma = $row[2];
                } else {
                    $th_suma = 0;
                }
                if (isset($row[3])) {
                    $tm_suma = $row[3];
                } else {
                    $tm_suma = 0;
                }
                $anio_fin = 0;
                if (isset($row[1])) {
                    $anio_fin = $row[1];
                }
                $array_data[$row[0].$anio_fin.$row[4]] = array(
                              'anio_ini' => $row[0]
                            , 'anio_fin' => $anio_fin
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
    }
    
    if (isset($_POST['tipo_cargo_moea'])) {
        $array_data = array();
        $and_cond = "";
        
        $tipo_cargo_moea = $_POST['tipo_cargo_moea'];
        
        if (isset($tipo_cargo_moea['cat1_']) && !empty($tipo_cargo_moea['cat1_'])){
            $and_cond = $and_cond." and categoria1 like '%".$tipo_cargo_moea['cat1_']."%' ";
        }
        if (isset($tipo_cargo_moea['entidad_']) && !empty($tipo_cargo_moea['entidad_'])){
            $and_cond = $and_cond." and estado like '%".$tipo_cargo_moea['entidad_']."%' ";
        }
        
        $sql = " select tipo_consejero
        from mujeres_oea
        where id > 0 "
        .$and_cond.
        " group by tipo_consejero
        order by tipo_consejero asc ";
        
        if ($result = mysqli_query($con, $sql)) {
            while ($row = mysqli_fetch_row($result)) {
                $array_data[$row[0]] = array(
                            'tipo_cons' => $row[0]
                        );
            }
            mysqli_free_result($result);
        }

        //mysqli_close($con);
        echo json_encode($array_data);
        die;
    }
    
    if (isset($_POST['entidad_moea'])) {
        $array_data = array();
        $and_cond = "";
               
        $sql = " select estado
        from mujeres_oea
        where id > 0
        and estado is not null "
        .$and_cond.
        " group by estado
        order by estado asc ";
        
        if ($result = mysqli_query($con, $sql)) {
            while ($row = mysqli_fetch_row($result)) {
                $array_data[$row[0]] = array(
                            'entidad_edo' => $row[0]
                        );
            }
            mysqli_free_result($result);
        }

        //mysqli_close($con);
        echo json_encode($array_data);
        die;
    }