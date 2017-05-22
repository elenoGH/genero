<?php
    require 'connection_db.php';
//    $options_tc = '<option value="" selected="selected">-- Selecciona</option>';
//    $options_part_pol = '<option value="" selected="selected">-- Selecciona</option>';
    
    if (isset($_POST["tipo_camara"])) {
        $tipo_camara = $_POST["tipo_camara"];
        if ($tipo_camara == 'senadores') {
            $array_data = array();
            $array_data['options_tc'] = get_periodo($tipo_camara, $con);
//            $array_data['option_part_pol'] = $options_part_pol;
            echo json_encode($array_data);
        }else if ($tipo_camara == 'diputados') {
            $array_data = array();
            $array_data['options_tc'] = get_periodo($tipo_camara, $con);
            echo json_encode($array_data);
            
        } else {
            $array_data = array();
            $array_data['options_tc'] = '<option value="" selected="selected">-- Selecciona</option>';
            echo json_encode($array_data);
        }
        die;
    }
    
    if (isset($_POST["periodo_legislatura"])) {
        $periodo = $_POST["periodo_legislatura"];
        $tipo_camara = $_POST["tipo_camara_de"];
        $array_data = array();
        $array_data['option_part_pol'] = get_partido_politico($tipo_camara, $periodo, $con);
        echo json_encode($array_data);
        die;
    }
    
    if (isset($_POST["search_data"])) {
        $search_data_obj = $_POST["search_data"];
        $sql = 'select totales_hombres_porcentaje, totales_mujeres_porcentaje
            from mujeres_electas_ine
            where legistalura = "'.$search_data_obj['periodo'].'"
            and conformacion_camara_de = "'.$search_data_obj['tipo_camara'].'"
            and partido_politico = "'.$search_data_obj['partido_politico'].'"
            limit 1';
        if ($result = mysqli_query($con, $sql)) {
            $row = mysqli_fetch_object($result);
            if(isset($row)) {
                echo json_encode($row);
            } else {
                echo json_encode(array('totales_hombres_porcentaje' => 0, 'totales_mujeres_porcentaje' => 0));
            }
            die;
        }
    }
    
    function get_periodo($tipo_camara, $con)
    {
        $options_tc = '<option value="" selected="selected">-- Selecciona</option>';
        $sql = "select legistalura
        from mujeres_electas_ine
        where conformacion_camara_de = '".$tipo_camara."'
        group by legistalura
        order by legistalura ";
        if ($result = mysqli_query($con, $sql)) {
            while ($row = mysqli_fetch_row($result)) {
                $options_tc = $options_tc . '<option value="' . $row[0] . '">' . $row[0] . '</option>';
            }
            mysqli_free_result($result);
        }
        mysqli_close($con);
        return $options_tc;
    }
    function get_partido_politico($tipo_camara, $periodo, $con)
    {
        $options_part_pol = '<option value="" selected="selected">-- Selecciona</option>';
        $sql = "select partido_politico, conformacion_camara_de, legistalura
        from mujeres_electas_ine
        where partido_politico not in ('Total', 'Partido Auténtico de la Revolución Mexicana'
        , 'Partido Encuentro Social', 'Partido Estatal de Baja California'
        , 'Partido Frente Cardenista de Reconstrucci´┐¢n Nacion', 'Partido Popular Socialista')
        and conformacion_camara_de = '".$tipo_camara."'
        and legistalura = '".$periodo."'
        group by partido_politico
        order by partido_politico asc";
        if ($result = mysqli_query($con, $sql)) {
            while ($row = mysqli_fetch_row($result)) {
                $options_part_pol = $options_part_pol . '<option value="' . $row[0] . '">' . $row[0] . '</option>';
            }
            mysqli_free_result($result);
        }

        mysqli_close($con);
        return $options_part_pol;
    }
?>