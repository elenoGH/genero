<?php
    require 'connection_db.php';
    $options="";
    if ($_POST["elegido"]==1) {
        $options= '
        <option value="1">4</option>
        <option value="2">5</option>
        <option value="3">7</option>
        <option value="4">21</option>
        <option value="5">Scennic</option>
        <option value="6">Traffic</option>
        ';    
    }
    if ($_POST["elegido"]==2) {
        $options = '';
        $sql =  "select partido_politico
            from mujeres_electas_ine
            where partido_politico != 'Total'
            group by partido_politico
            order by partido_politico asc";
        if ($result=mysqli_query($con,$sql))
          {
          // Fetch one and one row
          while ($row=mysqli_fetch_row($result))
            {
                //var_dump($row[0]);
                $options=$options.'<option value="'.$row[0].'">'.$row[0].'</option>';
            //printf ("%s (%s)\n",$row[0],$row[1]);
            }
          // Free result set
          mysqli_free_result($result);
        }

        mysqli_close($con);
    }
    if ($_POST["elegido"]==3) {
        $options= '
        <option value="1">106</option>
        <option value="2">206</option>
        <option value="3">306</option>
        ';    
    }
    echo $options;    
?>