<?php

class Ayudante {

    function Ayudante() {

    }

    function hora_decimal($valor) {
        $array_hora = explode(".", $valor);
        if ($array_hora[1] <= 60) {
            $valor = bcadd($array_hora[0], bcdiv($array_hora[1], 60));
        } else {
            $valor = bcadd($array_hora[0], 0);
        }

        return $valor;
    }

    function hora_minuto($hora = "", $minuto = "", $opt = "") {
        if ($opt == 1) {
            $leap_mnt = "5";
        }
        $leap_mnt = "5";

        if ($hora == "") {
            $hora = date("H");
        }
        if ($minuto == "") {
            $minuto = date("i");
        }
        $minuto = $minuto - ($minuto_valor % $leap_mnt);
        $selected = " ";
        $tabla_hora_minuto = "<table border='0' cellspacing='0' cellpadding='0'><tr><td><select name='hora[]'>";
        for ($h = 0; $h <= 23; $h++) {
            //selected
            if ($hora == $h) {
                $selected = "selected";
            }
            if (strlen($h) < 2) {
                $h = "0" . $h;
            }
            $tabla_hora_minuto.="<option " . $selected . ">" . $h . "</option>";
            $selected = " ";
        }
        //minutos
        $tabla_hora_minuto.="</select></td><td>&nbsp;h&nbsp;</td><td><select name='minuto[]'>";
        $selected = " ";
        for ($m = 0; $m < 60; $m = $m + 5) {
            //selected
            if ($minuto == $m) {
                $selected = "selected";
            }
            if (strlen($m) < 2) {
                $m = "0" . $m;
            }
            $tabla_hora_minuto.="<option " . $selected . ">" . $m . "</option>";
            $selected = " ";
        }
        $tabla_hora_minuto.="</select></td><td>&nbsp;m&nbsp;</td></tr></table>";
        // echo $tabla_hora_minuto;
        return $tabla_hora_minuto;
    }

    function romano($i) {
        $dia = array('', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
        return $dia[$i];
    }

    function nombreDia($i) {
        $dia = array('Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado');
        return $dia[$i - 1];
    }

    function nombreDiaCorto($i) {
        $dia = array('Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab');
        return $dia[$i - 1];
    }

    function nombreMes($i) {
        $mes = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre');
        return $mes[$i - 1];
    }

    function bloqueInicioHora($i) {
        $bloque = array('7am', '8am', '9am', '10am', '11am', '12pm', '3pm', '4pm', '5pm', '6pm', '7pm');
        return $bloque[$i - 1];
    }

    function bloqueFinHora($i) {
        $bloque = array('8am', '9am', '10am', '11am', '12pm', '1pm', '4pm', '5pm', '6pm', '7pm', '8pm');
        return $bloque[$i - 1];
    }

    function formateaFecha($fecha) {
        $f = split("-", $fecha);
        return $f[2] . " de " . $this->nombreMes($f[1]) . " de " . $f[0];
    }

    function formateaFechaRevez($fecha) {
        $f = split("-", $fecha);
        return $f[0] . " de " . $this->nombreMes($f[1]) . " de " . $f[2];
    }

    function FechaRevezMysql($fecha, $separador = "-") {
        $f = split($separador, $fecha);
        $fecha = $f[2] . "-" . $f[1] . "-" . $f[0]; //ver que se han corregido las posiciones
        return $fecha;
    }

    function FechaRevez($fecha, $separador = "-") {
        $f = split($separador, $fecha);
        $fecha = $f[2] . "/" . $f[1] . "/" . $f[0]; //ver que se han corregido las posiciones
        return $fecha;
    }

    function formateaSexo($sexo) {
        if ($sexo == "M" || $sexo == "m")
            return "Masculino";
        elseif ($sexo == "F" || $sexo == "f")
            return "Femenino";
    }

    function edad($fecha_nac, $fecha_base = "", $con_array = 0) {
        //Esta funcion toma una fecha de nacimiento
        //desde una base de datos mysql
        //en formato aaaa/mm/dd y calcula la edad en números enteros
        $fecha_nac = trim($fecha_nac);

        if ($fecha_nac != "0000-00-00" && $fecha_nac != "1969-12-31") {
            if ($fecha_base == "") {
                $fecha_actual = date("Y-m-d");
                $array_actual = explode("-", $fecha_actual);
            } else {

                $array_actual = explode("-", $fecha_base);
            }
            //descomponer fecha de nacimiento
            $dia_nac = substr($fecha_nac, 8, 2);
            $mes_nac = substr($fecha_nac, 5, 2);
            $anno_nac = substr($fecha_nac, 0, 4);

            $anos = $array_actual[0] - $anno_nac; // calculamos años
            $meses = $array_actual[1] - $mes_nac; // calculamos meses
            $dias = $array_actual[2] - $dia_nac; // calculamos días
            //ajuste de posible negativo en $días
            $dias_hoy = mktime(0, 0, 0, $array_actual[1], $array_actual[2], $array_actual[0]);
            $dias_nacimiento = mktime(0, 0, 0, $mes_nac, $dia_nac, $anno_nac);
            $dif_dias = (int) (($dias_hoy - $dias_nacimiento) / (60 * 60 * 24));
            if ($dias < 0) {
                --$meses;

                //ahora hay que sumar a $dias los dias que tiene el mes anterior de la fecha actual
                switch ($array_actual[1]) {
                    case 1: $dias_mes_anterior = 31;
                        break;
                    case 2: $dias_mes_anterior = 31;
                        break;
                    case 3:
                        if ($this->bisiesto($array_actual[0])) {
                            $dias_mes_anterior = 29;
                            break;
                        } else {
                            $dias_mes_anterior = 28;
                            break;
                        }
                    case 4: $dias_mes_anterior = 31;
                        break;
                    case 5: $dias_mes_anterior = 30;
                        break;
                    case 6: $dias_mes_anterior = 31;
                        break;
                    case 7: $dias_mes_anterior = 30;
                        break;
                    case 8: $dias_mes_anterior = 31;
                        break;
                    case 9: $dias_mes_anterior = 31;
                        break;
                    case 10: $dias_mes_anterior = 30;
                        break;
                    case 11: $dias_mes_anterior = 31;
                        break;
                    case 12: $dias_mes_anterior = 30;
                        break;
                }

                $dias = $dias + $dias_mes_anterior;
            }

            //ajuste de posible negativo en $meses
            if ($meses < 0) {
                --$anos;
                $meses = $meses + 12;
            }
            if ($con_array == 0) {
                return "$anos A  $meses M  $dias D - Dias: $dif_dias";
            } else {
                $adiferencia['anios'] = $anos;
                $adiferencia['meses'] = $meses;
                $adiferencia['dias'] = $dias;
                return $adiferencia;
            }
        } else {
            return "Sin fecha de nacimiento";
        }
    }

    function bisiesto($anio_actual) {
        $bisiesto = false;
        //probamos si el mes de febrero del aÃ±o actual tiene 29 dÃ­as
        if (checkdate(2, 29, $anio_actual)) {
            $bisiesto = true;
        }
        return $bisiesto;
    }

    function buscaNuevoId($idTabla, $nombreTabla, $elWhere = "", $bd = "") {
        $sql = new DmpSql();
        $consulta = "SELECT " . $idTabla . " ";
        $consulta .= "FROM " . $nombreTabla . " ";
        $consulta .= $elWhere . " ";
        $consulta .= "ORDER BY " . $idTabla . " DESC";
        $consulta.=" FOR UPDATE";
        $resultado = $sql->consultar($consulta, $bd);
        $nume_fila = mysql_num_rows($resultado);
        $porc = 0.1;
        $limite = (int) ($nume_fila / 1000);
        while ($limite > 0) {
            $porc = $porc * 0.1;
            $limite = (int) $limte / 10;
        }
        //echo "<br> porc".$porc;
        $aux_nume_fila = (int) ($nume_fila * $porc);
        //(int) ($nume_fila*0.01);
        //echo "<br>auc_nume ".$aux_nume_fila;
        //echo "<br>valor ".$base;
        if ($nume_fila == 0) {
            $base = 1;
        } else {
            $base = mysql_result($resultado, $aux_nume_fila);
            for ($cont1 = $aux_nume_fila; $cont1 >= 0; $cont1--) {
                //echo "<br>**********";
                //echo "<br> cont1 ".$cont1;
                $datos = mysql_result($resultado, $cont1);
                //echo "<br>base ".$base;
                //echo "<br> datos ".$datos;
                if ($base != $datos) {
                    break;
                } else {
                    $base++;
                }
            }
        }
        return ($base);
    }

    function obtengoNuevoId($idTabla, $nombreTabla, $elWhere = "", $bd = "") {
        //esto funciona en las transaccionas,sino inserta se malogra la transaccion
        $sql = new DmpSql();
        $consulta = "SELECT MAX(" . $idTabla . ") ";
        $consulta .= "FROM " . $nombreTabla . " ";
        $consulta .= $elWhere . " ";
        //$consulta .= "ORDER BY ".$idTabla;
        $consulta.=" FOR UPDATE";

        //$consulta1="UPDATE $nombreTabla SET $idTabla = $idTabla + 1 ";
        //$consulta1 .= $elWhere." ";
        $resultado = $sql->consultar($consulta, $bd);
        //$sql->consultar($consulta1,$bd);
        $datos = mysql_fetch_row($resultado);
        $i = $datos[0] + 1;
        return ($i);
    }

    function validaFecha($fecha) {
        list($dia, $mes, $anno) = split("/", $fecha);
        $dia = (int) $dia;
        $mes = (int) $mes;
        $anno = (int) $anno;
        if ($dia == 0 || $mes == 0 || $anno == 0 || empty($fecha)) {
            return $fecha = date("d/m/Y");
        } else {
            //Mes 1-12
            if ($mes < 1 || $mes > 12) {
                $mes = date("m");
            }

            //Dias....

            $diasMes = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

            if ($anno != date("Y")) {
                $anno = date("Y"); //Solo puede ser este aÃ±o!!!
            }

            if (($anno % 100 != 0 && $anno % 4 == 0) || $anno % 400 == 0) {
                $diasMes[2] = 29;
            }
            //$diasMes[11];
            if ($dia > $diasMes[$mes - 1]) {
                $dia = date("d");
                //echo "entro";
                //echo $diasMes[$mes];
            }
            $dia = (int) $dia;
            $mes = (int) $mes;

            if ($dia < 10) {
                $dia = "0" . $dia;
            }
            if ($mes < 10) {
                $mes = "0" . $mes;
            }
            return $fecha = "$dia/$mes/$anno";
        }
    }

    function separador($cadena, $item) {
        // echo $cadena;
        $contador = 0;
        do {
            $comapos = strpos($cadena, ",");
            if ($comapos > 0) {
                $palabra = substr($cadena, 0, $comapos);

                $datos[$contador] = $palabra;

                $cadena = substr($cadena, $comapos + 1);
            } else {
                if (strlen($cadena) > 0) {
                    $datos[$contador] = $cadena;
                }
            }
            //$consuOrdenar=substr($consuOrdenar,0,strlen($consuOrdenar)-1);
            $contador++;
        } while ($comapos > 0);

        return $datos;
    }

    function llenaEspacioValor($valor, $cantidad, $es_monto) {
        $blancos = "";
        for ($i = strlen($valor); $i < $cantidad; $i++) {
            $blancos.=chr(32);
        }
        if ($es_monto == 1) {
            $blancos.=$valor; //espacios a la izquierda
        } else {
            $blancos = $valor . $blancos; //espacios a la derecha
        }

        return $blancos;
    }

    function llenaCeros($valor, $cantidad) {
        $ceros = "";
        for ($i = strlen($valor); $i < $cantidad; $i++) {
            $ceros.="0";
        }
        $ceros.=$valor;

        return $ceros;
    }

    function quitaCeros($valor) {
        $longitud = strlen($valor);
        for ($i = 0; $i < $longitud; $i++) {
            if (substr($valor, 0, 1) == "0") {
                $valor = substr($valor, 1);
            } else {
                break;
            }
        }

        return $valor;
    }

    function restaFechas($dFecIni, $dFecFin) {
        $dFecIni = str_replace("-", "", $dFecIni);
        $dFecIni = str_replace("/", "", $dFecIni);
        $dFecFin = str_replace("-", "", $dFecFin);
        $dFecFin = str_replace("/", "", $dFecFin);

        ereg("([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})", $dFecIni, $aFecIni);
        ereg("([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})", $dFecFin, $aFecFin);
        //echo "valor".$aFecIni[1]." ".$aFecIni[2]." ".$aFecIni[3];
        //echo "<br>";
        //echo "valor".$aFecFin[1]." ".$aFecFin[2]." ".$aFecFin[3];exit;
        $date1 = mktime(0, 0, 0, $aFecIni[2], $aFecIni[1], $aFecIni[3]);
        $date2 = mktime(0, 0, 0, $aFecFin[2], $aFecFin[1], $aFecFin[3]);
        //echo round(($date2 - $date1) / (60 * 60 * 24));exit;
        return round(($date2 - $date1) / (60 * 60 * 24));
    }

    function caracter($cadena) {
        return utf8_decode(strip_tags(trim($cadena)));
    }

    function concurrencia($tiempo, $id, $campo, $tabla, $db = "") {
        //1 si hay concurrencia entonces mal
        if ($db == "") {
            $db = "sigh";
        }
        //echo $hoy=microtime();
        //$hoy=time();
        $consulta = "SELECT
			  log_date
			FROM
			  $tabla
			WHERE
			  $campo = '$id' ORDER BY log_date DESC";
        $sql = new DmpSql();
        //echo "<br>".date('Y-m-j H:i:s');
        //echo "<br>".date('H i s Y m j');
        $resultado = $sql->consultar($consulta, $db);
        $datos = mysql_fetch_row($resultado);
        //echo "<br>ayer ".$fechaMktime=$this->dateMktime($datos[0]);
        if ($datos[0] != "") {
            $fechaMktime = $this->dateMktime($datos[0]);
            //echo $tiempo."<br>";
            //echo $fechaMktime;
            if ($tiempo >= $fechaMktime) {

                return 1;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    function tiempo() {
        return time();
    }

    function dateMktime($dated) { // for straight timestamp 14
        //echo "<br> ".$dated;
        list($year, $month, $day) = split('-', $dated);
        list($day, $tiempo) = split(" ", $day);
        list($hour, $minute, $second) = split(':', $tiempo);
        //echo "<br>".$hour." ".$minute." ".$second." ".$month." ".$day." ".$year;
        $mktime = mktime($hour, $minute, $second, $month, $day, $year);

        return $mktime;
    }

    function num2letras($importe, $fem = true, $dec = true) {
        //if (strlen($importe) > 14) die("El n?mero introducido es demasiado grande");
        $matuni[2] = "dos";
        $matuni[3] = "tres";
        $matuni[4] = "cuatro";
        $matuni[5] = "cinco";
        $matuni[6] = "seis";
        $matuni[7] = "siete";
        $matuni[8] = "ocho";
        $matuni[9] = "nueve";
        $matuni[10] = "diez";
        $matuni[11] = "once";
        $matuni[12] = "doce";
        $matuni[13] = "trece";
        $matuni[14] = "catorce";
        $matuni[15] = "quince";
        $matuni[16] = "dieciseis";
        $matuni[17] = "diecisiete";
        $matuni[18] = "dieciocho";
        $matuni[19] = "diecinueve";
        $matuni[20] = "veinte";
        $matunisub[2] = "dos";
        $matunisub[3] = "tres";
        $matunisub[4] = "cuatro";
        $matunisub[5] = "quin";
        $matunisub[6] = "seis";
        $matunisub[7] = "sete";
        $matunisub[8] = "ocho";
        $matunisub[9] = "nove";

        $matdec[2] = "veint";
        $matdec[3] = "treinta";
        $matdec[4] = "cuarenta";
        $matdec[5] = "cincuenta";
        $matdec[6] = "sesenta";
        $matdec[7] = "setenta";
        $matdec[8] = "ochenta";
        $matdec[9] = "noventa";
        $matsub[3] = 'mill';
        $matsub[5] = 'bill';
        $matsub[7] = 'mill';
        $matsub[9] = 'trill';
        $matsub[11] = 'mill';
        $matsub[13] = 'bill';
        $matsub[15] = 'mill';
        $matmil[4] = 'millones';
        $matmil[6] = 'billones';
        $matmil[7] = 'de billones';
        $matmil[8] = 'millones de billones';
        $matmil[10] = 'trillones';
        $matmil[11] = 'de trillones';
        $matmil[12] = 'millones de trillones';
        $matmil[13] = 'de trillones';
        $matmil[14] = 'billones de trillones';
        $matmil[15] = 'de billones de trillones';
        $matmil[16] = 'millones de billones de trillones';

        $importe = trim((string) @$importe);
        if ($importe[0] == '-') {
            $neg = 'menos ';
            $importe = substr($importe, 1);
        } else {
            $neg = '';
        }
        while ($importe[0] == '0') {
            $importe = substr($importe, 1);
        }
        if (($importe[0] < 1) || ($importe[0] > 9)) {
            $importe = '0' . $importe;
        }
        $zeros = true;
        $punt = false;
        $ent = '';
        $fra = '';

        for ($c = 0; $c < strlen($importe); $c++) {
            $n = $importe[$c];
            if (!(strpos(".,'''", $n) === false)) {
                if ($punt)
                    break;
                else {
                    $punt = true;
                    continue;
                }
            } elseif (!(strpos('0123456789', $n) === false)) {
                if ($punt) {
                    if ($n != '0')
                        $zeros = false;
                    $fra .= $n;
                }
                else
                    $ent .= $n;
            }
            else
                break;
        }
        $ent = '     ' . $ent;

        if ((int) $ent === 0)
            return 'Cero ' . $fin;
        $tex = '';
        $sub = 0;
        $mils = 0;
        $neutro = false;
        while (($importe = substr($ent, -3)) != '   ') {
            $ent = substr($ent, 0, -3);
            if (++$sub < 3 and $fem) {
                $matuni[1] = 'uno';
                $subcent = 'os';
            } else {
                $matuni[1] = $neutro ? 'un' : 'uno';
                $subcent = 'os';
            }
            $t = '';
            $n2 = substr($importe, 1);
            if ($n2 == '00') {

            } elseif ($n2 < 21)
                $t = ' ' . $matuni[(int) $n2];
            elseif ($n2 < 30) {
                $n3 = $importe[2];
                if ($n3 != 0)
                    $t = 'i' . $matuni[$n3];
                $n2 = $importe[1];
                $t = ' ' . $matdec[$n2] . $t;
            }else {
                $n3 = $importe[2];
                if ($n3 != 0)
                    $t = ' y ' . $matuni[$n3];
                $n2 = $importe[1];
                $t = ' ' . $matdec[$n2] . $t;
            }
            $n = $importe[0];
            if ($n == 1) {
                $t = ' ciento' . $t;
            } elseif ($n == 5) {
                $t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t;
            } elseif ($n != 0) {
                $t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t;
            }
            if ($sub == 1) {

            } elseif (!isset($matsub[$sub])) {
                if ($importe == 1) {
                    $t = ' mil';
                } elseif ($importe > 1) {
                    $t .= ' mil';
                }
            } elseif ($importe == 1) {
                $t .= ' ' . $matsub[$sub] . '?n';
            } elseif ($importe > 1) {
                $t .= ' ' . $matsub[$sub] . 'ones';
            }
            if ($importe == '000')
                $mils++;
            elseif ($mils != 0) {
                if (isset($matmil[$sub]))
                    $t .= ' ' . $matmil[$sub];
                $mils = 0;
            }
            $neutro = true;
            $tex = $t . $tex;
        }
        $tex = $neg . substr($tex, 1) . $fin;
        return ucfirst($tex);
    }

    function array_envia($array) {//compacta un array pa poder enviarlo por una url
        $tmp = serialize($array);
        $tmp = urlencode($tmp);
        return $tmp;
    }

    function array_recibe($url_array) {//descompacta el array pa q pueda leerse en la pagina q recibe
        $tmp = stripslashes($url_array);
        $tmp = urldecode($tmp);
        $tmp = unserialize($tmp);
        return $tmp;
    }

    function archivo($nombre, $tipo, $texto = "", $tamanio = "", $caracter_csv = "") {
        $tipo = strtolower($tipo);
        $permiso = array('r' => 'r', 'w' => 'w+', 'grabar' => 'a+', 'e' => '0', 'csv' => 'csv');
        if ($permiso[$tipo] != '0') {
            if ($permiso[$tipo] == 'r') {
                //leer
                $read = @file_get_contents($nombre);
                return $read;
            } elseif ($permiso[$tipo] == 'csv') {
                if (($handle = fopen("$nombre", "r")) !== FALSE) {
                    # Set the parent multidimensional array key to 0.
                    $nn = 0;
                    while (($data = fgetcsv($handle, 100, "$caracter_csv")) !== FALSE) {
                        # Count the total keys in the row.
                        $c = count($data);
                        # Populate the multidimensional array.
                        for ($x = 0; $x < $c; $x++) {
                            $csvarray[$nn][$x] = $data[$x];
                        }
                        $nn++;
                    }

                    # Close the File.
                    fclose($handle);
                    return $csvarray;
                } else {
                    return 'error';
                }
            } else {
                //grabar
                $fp = fopen($nombre, $permiso[$tipo]);
                if ($fp) {
                    $read = fwrite($fp, $texto);
                    fclose($fp);
                    return $read;
                } else {
                    return 'error';
                }
            }
        } else {
            $read = unlink($nombre);
            return $read;
        }
    }

    function descargar_archivo($n_file, $path = "") {
        //echo "dentro".$f;
        $extensiones = array("jpg", "jpeg", "png", "gif", "txt");
        $ftmp = explode(".", $n_file);
        $fExt = strtolower($ftmp[count($ftmp) - 1]);

        if (!in_array($fExt, $extensiones)) {
            return 'Error : extensión no permitida';
        }
        //el path esta puesto desde ayudante
        //$file=ruta_sigh."programas/administrativo/contabilidad/".$n_file;
        $file = $path . $n_file;
        //echo $file;
        if (file_exists($file)) {
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"$n_file\"\n");
            header("Content-Length: " . filesize($file) . "\n\n");
            $fp = fopen("$file", "r");
            fpassthru($fp);
        } else {
            //echo "no existe";

            return 'Error: archivo no encontrado';
        }
        exit;
    }

    function subir_archivo($dir, $archivo, $nombre, $tamano = "", $sobre = "") {
        //echo "Subiendo el archivo, por favor espere....";
        $mensaje = new Ayudante();
        //echo "valor sobre".$sobre." ".$dir."/".$nombre;
        if (file_exists($dir . "/" . $nombre) && $sobre != "yes") {
            //$mensaje->mensaje("Confirmaciï¿½n","El archivo que intenta subir ya existe!"," ","../comunes/miMaletin.php?dir=$dir","../comunes/miMaletin.php?dir=$dir");
            $respuesta = "El archivo que intenta subir ya existe!";
        } else {
            $nombre = ereg_replace("[^a-zA-Z0-9._]", "_", $nombre);
            //if($this->TamanoDir()+$tamano<=$this->max){
            copy($archivo, $dir . "/" . $nombre);
            if (!is_uploaded_file($archivo)) {
                $respuesta = "El archivo que intenta subir ya existe!";
                //$mensaje->mensaje("Confirmaciï¿½n","No se pudo subir el archivo!"," ","../comunes/miMaletin.php?dir=$dir","../comunes/miMaletin.php?dir=$dir");
            } else {
                $respuesta = "1";
                //header("Location: miMaletin.php?dir=$this->directorio");
            }
            //} else {
            //        $mensaje->mensaje("Confirmaciï¿½n","El archivo que intenta subir harï¿½ que exceda su capacidad disponible.!"," ","../comunes/miMaletin.php?dir=$dir","../comunes/miMaletin.php?dir=$dir");
            //}
        }
        //echo "la respuesta ".$respuesta;
        //exit;
        return $respuesta;
    }

    /* function descargar_archivo($n_file,$path=""){
     * comento esta funcion porque es la que utiliza el migrador de contabilidad
      //echo "dentro".$f;
      $extensiones = array("jpg", "jpeg", "png", "gif","txt");
      $ftmp = explode(".",$n_file);
      $fExt = strtolower($ftmp[count($ftmp)-1]);

      if(!in_array($fExt,$extensiones)){
      return 'Error : extensiÃ³n no permitida';
      }
      //el path esta puesto desde ayudante
      $file=ruta_sigh."programas/administrativo/contabilidad/".$n_file;

      if (file_exists($file)){
      header("Content-type: application/octet-stream");
      header("Content-Disposition: attachment; filename=\"$n_file\"\n");
      header("Content-Length: ".filesize($file)."\n\n");
      $fp=fopen("$file", "r");
      fpassthru($fp);
      }else{
      return 'Error: archivo no encontrado';
      }

      } */

    function imprime_directo($nombre, $array_serializado) {

        $a_server_impresion = server_impresion;
        if ($a_server_impresion == '192.168.1.52') {
            //echo "hola";
            //header("Location: http://$a_server_impresion/SIGH/imprime/imprime_remoto.php?array_serializado=$array_serializado");
        }
        //header("Location: http://$a_server_impresion/SIGH/imprime/imprime_remoto.php/imprime_remoto.php?array_serializado=$array_serializado");
        // exit;
        $path = '/sigh/imprime/imprime_remoto.php';
        $host = $a_server_impresion;
        $data = "array_serializado=$array_serializado";

        $fp = fsockopen($host, 80, $errno, $errstr, 10);
        if (!$fp) {
            echo "Imprima PDF <br />\n";
        } else {
            fputs($fp, "POST $path?$data HTTP/1.1\r\n");
            fputs($fp, "Host: $host\r\n");
            fputs($fp, "Content-type: application/x-www-form- urlencoded\r\n");
            fputs($fp, "Content-length: " . strlen($data) . "\r\n");
            fputs($fp, "Connection: close\r\n\r\n");
            fputs($fp, $data);
            $buf = '';
            while (!feof($fp)) {
                $buf .= fgets($fp, 128);
            }
            fclose($fp);
            header('Content-Type: application/x-download');
            header('Content-Length: ' . strlen($buf));
            header('Content-Disposition: attachment; filename=' . $nombre . ".txt");
            header('Cache-Control: private, max-age=0');
            header('Pragma: public');
            ini_set('zlib.output_compression', '0');
            echo $data;
        }
    }

    //--------------------------------TRABAJO CON FTP
    //Sube un archivo al servidor ftp
    function subir_archivo_ftp($id_ftp, $ruta_server, $tempFile) {
        $subio = false;
        if (is_uploaded_file($tempFile)) {
            if (ftp_put($id_ftp, $ruta_server, $tempFile, FTP_BINARY)) {
                $subio = true;
            }
        }
        return $subio;
    }

    //Verifica si un archivo ya existe en el servidor ftp
    function comprobar_existencia_archivos($id_ftp, $ruta, $file_name) {
        $existe = false;
        $lista_ficheros = ftp_nlist($id_ftp, $ruta);

        foreach ($lista_ficheros as $indice => $fichero) {
            if ($file_name == substr($fichero, (strripos($fichero, "/") + 1))) {
                $existe = true;
            }
        }
        return $existe;
    }

    //Borra un archivo del servidor ftp
    function borrar_archivo_ftp($id_ftp, $ruta_server) {
        $borrado = false;
        if (ftp_delete($id_ftp, $ruta_server)) {
            $borrado = true;
        }
        return $borrado;
    }

    function borrar_archivo_ftp_desde_web($nombre_archivo) {
        $borrado = false;
        $id_ftp = ftp_connect(SERVER_FTP, PORT_FTP);
        $datos_login = ftp_login($id_ftp, USER, PASSWORD);
        //print_r($nombre_archivo);
        if ((!$id_ftp) || (!$datos_login)) {
            echo "No se pudo establecer la conexion con el servidor";
            die;
        } else {
            ftp_pasv($id_ftp, PASV);
            $ruta_en_servidor_ftp = RUTA_SERVER . $nombre_archivo;
            //print_r($ruta_en_servidor_ftp);
            $ayudante = new Ayudante();
            if ($ayudante->borrar_archivo_ftp($id_ftp, $ruta_en_servidor_ftp)) {
                $borrado = true;
            }
        }
        ftp_close($id_ftp);
        return $borrado;
    }

    function ver_tamanio_archivo($ruta) {
        $archivo = substr($ruta, (strripos($ruta, "/") + 1));
        $ruta_en_servidor_ftp = RUTA_SERVER . $archivo;

        $id_ftp = ftp_connect(SERVER_FTP, PORT_FTP);
        $datos_login = ftp_login($id_ftp, USER, PASSWORD);
        if ((!$id_ftp) || (!$datos_login)) {
            echo "No se pudo establecer la conexion con el servidor";
            die;
        } else {
            $tamanio = ftp_size($id_ftp, $archivo);
            if ($tamanio != -1) {
                $ayudante = new Ayudante();
                return $ayudante->convertir_tamanio($tamanio);
            }
        }
        ftp_close($id_ftp);
    }

    function convertir_tamanio($peso, $decimales = 2) {
        $clase = array(" Bytes", " KB", " MB", " GB", " TB");
        return round($peso / pow(1024, ($i = floor(log($peso, 1024)))), $decimales) . $clase[$i];
    }

    function sacar_resumen_texto($texto, $tamanio_maximo) {
        $contador = 0;
        $array_texto = split(" ", $texto);
        $texto = "";

        while ($tamanio_maximo >= strlen($texto) + strlen($array_texto[$contador])) {
            $texto .= " " . $array_texto[$contador];
            $contador++;
        }

        if ($texto == '')
            $texto = substr($array_texto[0], 0, $tamanio_maximo);

        return $texto;
    }

    function pon_periodo($nombre_select) {
        $iperiodo = new iperiodo();
        $periodos = $iperiodo->listar_periodos();

        $select = " <select name='$nombre_select' id='$nombre_select'>";

        for ($i = 0; $i < sizeof($periodos[idmes_ejercicio]); $i++) {
            $ejercicio = new ejercicio($periodos[idejercicio][$i]);
            $fecha = $periodos[fecha][$i];
            $select .= " <option value='$fecha'>";

            ( $periodos[mes][$i] < 10 ) ? $select .= "&nbsp;&nbsp" . $periodos[mes][$i] . "-" . $ejercicio->anio : $select .= $periodos[mes][$i] . "-" . $ejercicio->anio;

            $select .= "</option>";
        }
        $select .= "</select>";
        return $select;
    }

    function n_caracteres_por_nivel($nivel) {
        if (empty($nivel)) {
            $nivel = 1;
        }
        ( $nivel > 2 ) ? $n_caracteres = ( $nivel * 2 ) - 2 : $n_caracteres = $nivel + 1;
        return $n_caracteres;
    }

    function anio_actual() {
        $anio = date("Y");
        return $anio;
    }
    
    function migracion_insert($campo,$idcampo,$consulta){        
           //Consulta INSERT simple 
            
            $tokens = preg_split("/[\(]/", $consulta);
            $consulta= $tokens[0]."($campo,".$tokens[1]."($idcampo,".$tokens[2];
            //echo $consulta; exit;
            $consulta= str_replace("'", "''", $consulta);
            $consulta.=";";  
            //echo $consulta; exit;
            $consulta = "INSERT INTO
                migracion_detalle(
                consulta,
                idmodulo_migracion
                )
                VALUES('$consulta',
                    $_SESSION[idmodulo])";
        
        return $consulta;
    }
    
    function migracion_insert_multiple($campo,$idcampo,$consulta){         
            
            $tokens = preg_split("/[\(]/", $consulta);
            $cantidad = count($tokens);
            $consulta= $tokens[0]."($campo,".$tokens[1];
            for($i=0;$i+2<$cantidad;$i++){
                $consulta.="(".($idcampo+$i).",".$tokens[$i+2];
            }
            //echo $consulta; exit;
            $consulta= str_replace("'", "''", $consulta);
            $consulta.=";";
            //echo $consulta; exit;
            $consulta = "INSERT INTO
                migracion_detalle(
                consulta,
                idmodulo_migracion
                )
                VALUES('$consulta',
                    $_SESSION[idmodulo])";
        
        return $consulta;
    }
    
    function migracion_update($consulta){
        
            $consulta= str_replace("'", "''", $consulta);
            $consulta.=";";
            //echo $consulta; exit;
            $consulta = "INSERT INTO
                migracion_detalle(
                consulta,
                idmodulo_migracion
                )
                VALUES('$consulta',
                    $_SESSION[idmodulo])";
        
        return $consulta;
    }
    
   
}

?>
