<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of idocumento_identificacion
 *
 * @author dmontjoy
 */
class ireporte {

    //put your code here
    public $sql;

    function ireporte() {
        $this->sql = new DmpSql();
    }

    function calcular_sh($x1, $y1, $z1, $x2, $y2, $z2, $idinteraccion_complejo_tag) {


        $tags = count($idinteraccion_complejo_tag);

        if ($tags > 0) {
            $cpersona_tag = ",
                          (
                          SELECT COUNT(*) as total
                          FROM
                          persona_tag
                          WHERE
                         `persona_tag`.`idpersona`=  `sh`.`idsh`
                          AND `persona_tag`.`idmodulo`=  `sh`.`idmodulo`
                          AND `persona_tag`.`activo`=1
                          AND CONCAT(`persona_tag`.`idtag`,'---',`persona_tag`.`idmodulo_tag`) 
                          IN (";

            foreach ($idinteraccion_complejo_tag as $valor) {
                if (strpos($valor, "###")) {
                    $tags--;
                } else {
                    $cpersona_tag.= "'" . $valor . "',";
                }
            }
            $cpersona_tag = substr($cpersona_tag, 0, -1);

            $cpersona_tag.= " )                                            
                          HAVING total=$tags
                          ) as 'tags'";
            if ($tags == 0) {
                $cpersona_tag = "";
            }
        } else {
            $cpersona_tag = "";
        }

        $consulta = "SELECT
		COUNT(*) as 'cantidad'
		from
		(SELECT DISTINCT
		 `sh`.`idmodulo`,
		  `sh`.`idsh`,
		  sh_dimension_matriz_sh.`idsh_dimension_matriz_sh`,
		  `dimension_matriz_sh_valor`.`puntaje` as 'puntaje'
                  $cpersona_tag
		FROM
		  `sh`
		  INNER JOIN `sh_dimension` ON (`sh`.`idmodulo` = `sh_dimension`.`idmodulo`)
		  AND (`sh`.`idsh` = `sh_dimension`.`idsh`)
		  INNER JOIN `sh_dimension_matriz_sh`
		  ON (`sh_dimension_matriz_sh`.`idsh_dimension` = `sh_dimension`.`idsh_dimension`)
		  AND (`sh_dimension_matriz_sh`.`idmodulo_sh_dimension` = `sh_dimension`.`idmodulo_sh_dimension`)
		  INNER JOIN `dimension_matriz_sh_valor` ON (`dimension_matriz_sh_valor`.`iddimension_matriz_sh_valor` = `sh_dimension_matriz_sh`.`idsh_dimension_matriz_sh_valor`)
		WHERE
		  `dimension_matriz_sh_valor`.`puntaje` >= $x1
		  AND
		  `dimension_matriz_sh_valor`.`puntaje` <= $y1
		   AND
		    `dimension_matriz_sh_valor`.`iddimension_matriz_sh`=$z1
		   AND
		   `sh_dimension_matriz_sh`.`activo`=1
		    AND `sh_dimension`.ultimo=1
		GROUP BY
		  `sh`.`idmodulo`,
		  `sh`.`idsh`

		  ) AS tmp1 JOIN
		  (SELECT DISTINCT
		 `sh`.`idmodulo`,
		  `sh`.`idsh`,
		  sh_dimension_matriz_sh.`idsh_dimension_matriz_sh`,
		  `dimension_matriz_sh_valor`.`puntaje` as 'puntaje'
		FROM
		  `sh`
		  INNER JOIN `sh_dimension` ON (`sh`.`idmodulo` = `sh_dimension`.`idmodulo`)
		  AND (`sh`.`idsh` = `sh_dimension`.`idsh`)
		  INNER JOIN `sh_dimension_matriz_sh`
		  ON (`sh_dimension_matriz_sh`.`idsh_dimension` = `sh_dimension`.`idsh_dimension`)
		  AND (`sh_dimension_matriz_sh`.`idmodulo_sh_dimension` = `sh_dimension`.`idmodulo_sh_dimension`)
		  INNER JOIN `dimension_matriz_sh_valor` ON (`dimension_matriz_sh_valor`.`iddimension_matriz_sh_valor` = `sh_dimension_matriz_sh`.`idsh_dimension_matriz_sh_valor`)
		WHERE
		  `dimension_matriz_sh_valor`.`puntaje` >= $x2
		  AND
		  `dimension_matriz_sh_valor`.`puntaje` <= $y2
		  AND
		   `dimension_matriz_sh_valor`.`iddimension_matriz_sh`=$z2
		   AND
		   `sh_dimension_matriz_sh`.`activo`=1
		   AND
		    `sh_dimension`.ultimo=1
		GROUP BY
		  `sh`.`idmodulo`,
		  `sh`.`idsh`) as tmp2
		ON
		 tmp1.idsh=tmp2.idsh
		 AND tmp1.idmodulo=tmp1.idmodulo";

        if ($tags > 0) {
            $consulta.=" WHERE 
                         tmp1.tags IS NOT NULL";
        }

        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }

    function listar_sh_cuadrante($x1, $y1, $z1, $x2, $y2, $z2, $idinteraccion_complejo_tag) {
        $tags = count($idinteraccion_complejo_tag);
        if(!is_array($idestadistico_complejo_tag)){
            $aux_convert=$idestadistico_complejo_tag;
            $idestadistico_complejo_tag=null;
            $idestadistico_complejo_tag=array($aux_convert);
        }
        if ($tags > 0) {
            $cpersona_tag = ",
                          (
                          SELECT COUNT(*) as total
                          FROM
                          persona_tag
                          WHERE
                         `persona_tag`.`idpersona`=  `sh`.`idsh`
                          AND `persona_tag`.`idmodulo`=  `sh`.`idmodulo`
                          AND `persona_tag`.`activo`=1
                          AND CONCAT(`persona_tag`.`idtag`,'---',`persona_tag`.`idmodulo_tag`) 
                          IN (";

            foreach ($idinteraccion_complejo_tag as $valor) {
                if (strpos($valor, "###")) {
                    $tags--;
                } else {
                    $cpersona_tag.= "'" . $valor . "',";
                }
            }
            $cpersona_tag = substr($cpersona_tag, 0, -1);

            $cpersona_tag.= " )                                            
                          HAVING total=$tags
                          ) as 'tags'";
            if ($tags == 0) {
                $cpersona_tag = "";
            }
        } else {
            $cpersona_tag = "";
        }

        if ($tags > 0) {
            $consulta_tag.=" WHERE 
                         tmp1.tags IS NOT NULL";
        } else {
            $consulta_tag = "";
        }


        $consulta = "SELECT
		tmp1.idsh,tmp1.idmodulo,tmp1.idpersona_tipo,tmp1.nombre, tmp1.apellido_p, tmp1.apellido_m,tmp1.importancia,tmp1.puntaje1,tmp2.puntaje2
		from
		(SELECT DISTINCT
			 persona.`idpersona_tipo` as 'idpersona_tipo',
                         persona.`nombre` as 'nombre',
			 persona.`apellido_p` as 'apellido_p',
			 persona.`apellido_m` as 'apellido_m',
                         `sh`.`importancia`,
                         `sh`.`idmodulo`,
                         `sh`.`idsh`,
                          sh_dimension_matriz_sh.`idsh_dimension_matriz_sh`,
                          `dimension_matriz_sh_valor`.`puntaje` as 'puntaje1'
                           $cpersona_tag
		FROM
		  `sh`
		  INNER JOIN `sh_dimension` ON (`sh`.`idmodulo` = `sh_dimension`.`idmodulo`)
		  AND (`sh`.`idsh` = `sh_dimension`.`idsh`)
		  INNER JOIN `sh_dimension_matriz_sh`
		  ON (`sh_dimension_matriz_sh`.`idsh_dimension` = `sh_dimension`.`idsh_dimension`)
		  AND (`sh_dimension_matriz_sh`.`idmodulo_sh_dimension` = `sh_dimension`.`idmodulo_sh_dimension`)
		  INNER JOIN `dimension_matriz_sh_valor` ON (`dimension_matriz_sh_valor`.`iddimension_matriz_sh_valor` = `sh_dimension_matriz_sh`.`idsh_dimension_matriz_sh_valor`)
          LEFT JOIN `persona` ON persona.`idpersona`=`sh`.`idsh` AND `persona`.`idmodulo`=`sh`.`idmodulo`
		WHERE
		  `dimension_matriz_sh_valor`.`puntaje` >= $x1
		  AND
		  `dimension_matriz_sh_valor`.`puntaje` <= $y1
		  AND
		    `dimension_matriz_sh_valor`.`iddimension_matriz_sh`=$z1

		  AND
		   `sh_dimension_matriz_sh`.`activo`=1
		  AND
		  `sh_dimension`.ultimo=1
		GROUP BY
		  `sh`.`idmodulo`,
		  `sh`.`idsh`

		  ) AS tmp1 JOIN
		  (SELECT DISTINCT
          persona.`nombre` as 'nombre',
			 persona.`apellido_p` as 'apellido_p',
			 persona.`apellido_m` as 'apellido_m',
		 `sh`.`idmodulo`,
		  `sh`.`idsh`,
		  sh_dimension_matriz_sh.`idsh_dimension_matriz_sh`,
		  `dimension_matriz_sh_valor`.`puntaje` as 'puntaje2'
		FROM
		  `sh`
		  INNER JOIN `sh_dimension` ON (`sh`.`idmodulo` = `sh_dimension`.`idmodulo`)
		  AND (`sh`.`idsh` = `sh_dimension`.`idsh`)
		  INNER JOIN `sh_dimension_matriz_sh`
		  ON (`sh_dimension_matriz_sh`.`idsh_dimension` = `sh_dimension`.`idsh_dimension`)
		  AND (`sh_dimension_matriz_sh`.`idmodulo_sh_dimension` = `sh_dimension`.`idmodulo_sh_dimension`)
		  INNER JOIN `dimension_matriz_sh_valor` ON (`dimension_matriz_sh_valor`.`iddimension_matriz_sh_valor` = `sh_dimension_matriz_sh`.`idsh_dimension_matriz_sh_valor`)
          LEFT JOIN `persona` ON persona.`idpersona`=`sh`.`idsh` AND `persona`.`idmodulo`=`sh`.`idmodulo`
		WHERE
		  `dimension_matriz_sh_valor`.`puntaje` >= $x2
		  AND
		  `dimension_matriz_sh_valor`.`puntaje` <= $y2
		  AND
		    `dimension_matriz_sh_valor`.`iddimension_matriz_sh`=$z2
		  AND
		   `sh_dimension_matriz_sh`.`activo`=1
		  AND
		  `sh_dimension`.ultimo=1
		GROUP BY
		  `sh`.`idmodulo`,
		  `sh`.`idsh`) as tmp2
		ON
		 tmp1.idsh=tmp2.idsh
		 AND tmp1.idmodulo=tmp1.idmodulo
                 $consulta_tag
                ORDER BY 
                tmp1.importancia DESC";

        //echo $consulta;

        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }

    function calcular_sh_importancia($x1, $y1, $x2, $y2, $idinteraccion_complejo_tag) {

        $tags = count($idinteraccion_complejo_tag);
        if(!is_array($idestadistico_complejo_tag)){
            $aux_convert=$idestadistico_complejo_tag;
            $idestadistico_complejo_tag=null;
            $idestadistico_complejo_tag=array($aux_convert);
        }
        if ($tags > 0) {
            $cpersona_tag = ",
                          (
                          SELECT COUNT(*) as total
                          FROM
                          persona_tag
                          WHERE
                         `persona_tag`.`idpersona`=  `sh`.`idsh`
                          AND `persona_tag`.`idmodulo`=  `sh`.`idmodulo`
                          AND `persona_tag`.`activo`=1
                          AND CONCAT(`persona_tag`.`idtag`,'---',`persona_tag`.`idmodulo_tag`) 
                          IN (";

            foreach ($idinteraccion_complejo_tag as $valor) {
                if (strpos($valor, "###")) {
                    $tags--;
                } else {
                    $cpersona_tag.= "'" . $valor . "',";
                }
            }
            $cpersona_tag = substr($cpersona_tag, 0, -1);

            $cpersona_tag.= " )                                            
                          HAVING total=$tags
                          ) as 'tags'";
            if ($tags == 0) {
                $cpersona_tag = "";
            }
        } else {
            $cpersona_tag = "";
        }

        if ($tags > 0) {
            $consulta_tag.=" WHERE 
                         tmp1.tags IS NOT NULL";
        } else {
            $consulta_tag = "";
        }

        $consulta = "SELECT
		COUNT(*) as 'cantidad'
		from
		(SELECT DISTINCT
		 `sh`.`idmodulo`,
		 `sh`.`idsh`,
		  sh_dimension_matriz_sh.`idsh_dimension_matriz_sh`,
		  `dimension_matriz_sh_valor`.`puntaje` as 'puntaje'
                  $cpersona_tag 
		FROM
		  `sh`
		  INNER JOIN `sh_dimension` ON (`sh`.`idmodulo` = `sh_dimension`.`idmodulo`)
		  AND (`sh`.`idsh` = `sh_dimension`.`idsh`)
		  INNER JOIN `sh_dimension_matriz_sh`
		  ON (`sh_dimension_matriz_sh`.`idsh_dimension` = `sh_dimension`.`idsh_dimension`)
		  AND (`sh_dimension_matriz_sh`.`idmodulo_sh_dimension` = `sh_dimension`.`idmodulo_sh_dimension`)
		  INNER JOIN `dimension_matriz_sh_valor` ON (`dimension_matriz_sh_valor`.`iddimension_matriz_sh_valor` = `sh_dimension_matriz_sh`.`idsh_dimension_matriz_sh_valor`)
		WHERE
		  `dimension_matriz_sh_valor`.`puntaje` >= $x1
          AND
		  `dimension_matriz_sh_valor`.`puntaje` <= $y1
          AND
		   `sh_dimension_matriz_sh`.`activo`=1

          AND
		    `dimension_matriz_sh_valor`.`iddimension_matriz_sh`=1 AND `sh_dimension`.ultimo=1
		GROUP BY
		  `sh`.`idmodulo`,
		  `sh`.`idsh`

		  ) AS tmp1 JOIN
		  (SELECT DISTINCT
		 `sh`.`idmodulo`,
		  `sh`.`idsh`,
		  `sh`.`importancia` as 'importancia'
		FROM
		  `sh`
		WHERE
		  `sh`.`importancia` >= $x2
		  AND
		  `sh`.`importancia` <= $y2
		  AND
		  	`sh`.activo = 1
		GROUP BY
		  `sh`.`idmodulo`,
		  `sh`.`idsh`) as tmp2
		ON
		 tmp1.idsh=tmp2.idsh
		 AND tmp1.idmodulo=tmp1.idmodulo
                $consulta_tag ";

        //echo $consulta;

        $result = $this->sql->consultar($consulta, "sgrc");
        return $result;
    }

    function listar_sh_importancia($x1, $y1, $x2, $y2, $idinteraccion_complejo_tag) {

        $tags = count($idinteraccion_complejo_tag);
        if(!is_array($idestadistico_complejo_tag)){
            $aux_convert=$idestadistico_complejo_tag;
            $idestadistico_complejo_tag=null;
            $idestadistico_complejo_tag=array($aux_convert);
        }
        if ($tags > 0) {
            $cpersona_tag = ",
                          (
                          SELECT COUNT(*) as total
                          FROM
                          persona_tag
                          WHERE
                         `persona_tag`.`idpersona`=  `sh`.`idsh`
                          AND `persona_tag`.`idmodulo`=  `sh`.`idmodulo`
                          AND `persona_tag`.`activo`=1
                          AND CONCAT(`persona_tag`.`idtag`,'---',`persona_tag`.`idmodulo_tag`) 
                          IN (";

            foreach ($idinteraccion_complejo_tag as $valor) {
                if (strpos($valor, "###")) {
                    $tags--;
                } else {
                    $cpersona_tag.= "'" . $valor . "',";
                }
            }
            $cpersona_tag = substr($cpersona_tag, 0, -1);

            $cpersona_tag.= " )                                            
                          HAVING total=$tags
                          ) as 'tags'";
            if ($tags == 0) {
                $cpersona_tag = "";
            }
        } else {
            $cpersona_tag = "";
        }

        if ($tags > 0) {
            $consulta_tag.=" WHERE 
                         tmp1.tags IS NOT NULL";
        } else {
            $consulta_tag = "";
        }

        $consulta = "SELECT
		tmp1.idsh,tmp1.idmodulo,tmp1.idpersona_tipo,tmp1.nombre, tmp1.apellido_p, tmp1.apellido_m,tmp2.importancia, tmp1.puntaje
		from
		(SELECT DISTINCT
			persona.`idpersona_tipo` as 'idpersona_tipo',
        persona.`nombre` as 'nombre',
			 persona.`apellido_p` as 'apellido_p',
			 persona.`apellido_m` as 'apellido_m',
                        
		 `sh`.`idmodulo`,
		  `sh`.`idsh`,
		  sh_dimension_matriz_sh.`idsh_dimension_matriz_sh`,
		  `dimension_matriz_sh_valor`.`puntaje` as 'puntaje'
                  $cpersona_tag 
		FROM
		  `sh`
		  INNER JOIN `sh_dimension` ON (`sh`.`idmodulo` = `sh_dimension`.`idmodulo`)
		  AND (`sh`.`idsh` = `sh_dimension`.`idsh`)
		  INNER JOIN `sh_dimension_matriz_sh`
		  ON (`sh_dimension_matriz_sh`.`idsh_dimension` = `sh_dimension`.`idsh_dimension`)
		  AND (`sh_dimension_matriz_sh`.`idmodulo_sh_dimension` = `sh_dimension`.`idmodulo_sh_dimension`)
		  INNER JOIN `dimension_matriz_sh_valor` ON (`dimension_matriz_sh_valor`.`iddimension_matriz_sh_valor` = `sh_dimension_matriz_sh`.`idsh_dimension_matriz_sh_valor`)
          LEFT JOIN `persona` ON persona.`idpersona`=`sh`.`idsh` AND `persona`.`idmodulo`=`sh`.`idmodulo`
		WHERE
		  `dimension_matriz_sh_valor`.`puntaje` >= $x1
		  AND
		  `dimension_matriz_sh_valor`.`puntaje` <= $y1
		  AND
		    `dimension_matriz_sh_valor`.`iddimension_matriz_sh`=1

		  AND
		   `sh_dimension_matriz_sh`.`activo`=1
		  AND
		  `sh_dimension`.ultimo=1
		GROUP BY
		  `sh`.`idmodulo`,
		  `sh`.`idsh`

		  ) AS tmp1 JOIN
		  (SELECT DISTINCT
		  `sh`.`idmodulo`,
		  `sh`.`idsh`,
		  `sh`.`importancia` as 'importancia'
		FROM
		  `sh`
		WHERE
		  `sh`.`importancia` >= $x2
		  AND
		  `sh`.`importancia` <= $y2
		  AND
		  	`sh`.activo = 1
		GROUP BY
		  `sh`.`idmodulo`,
		  `sh`.`idsh`) as tmp2
		ON
		 tmp1.idsh=tmp2.idsh
		 AND tmp1.idmodulo=tmp1.idmodulo
                 $consulta_tag
                ORDER BY tmp2.importancia DESC";

        //echo $consulta;

        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }

    function listar_rc_interaccion($limit, $fecha_del, $fecha_al, $idestadistico_complejo_tag) {

        $tags = count($idestadistico_complejo_tag);
                if(!is_array($idestadistico_complejo_tag)){
            $aux_convert=$idestadistico_complejo_tag;
            $idestadistico_complejo_tag=null;
            $idestadistico_complejo_tag=array($aux_convert);
        }
        if ($tags > 0) {
            $ctag = " SELECT tag1.tag FROM tag tag1 WHERE CONCAT(`tag1`.`idtag`,'---', `tag1`.`idmodulo_tag`) IN ( ";

            foreach ($idestadistico_complejo_tag as $valor) {
                if (strpos($valor, "###")) {
                    $tags--;
                } else {
                    $ctag.= "'" . $valor . "',";
                }
            }

            $ctag = substr($ctag, 0, -1) . ") ";

            $ctag = "SELECT 
                    CONCAT(tag.idtag,'---',tag.`idmodulo_tag`)
                  FROM 
                    tag, 
                    ($ctag) AS tag1
                    WHERE
                    tag.ruta LIKE CONCAT('%/',`tag1`.tag,'%/') OR tag.tag = tag1.tag AND
                    `tag`.`activo`=1";

            if ($tags == 0) {
                $ctag = "";
            }
        } else {
            $ctag = "";
        }

        if ($ctag == "") {
            $consulta = "SELECT 
                        count(*) AS total
                    FROM 
                        `interaccion`
                    WHERE 
                        `interaccion`.`activo`=1
                    AND DATE_FORMAT(`interaccion`.`fecha`,'%Y-%m-%d') >= '$fecha_del'
                    AND DATE_FORMAT(`interaccion`.`fecha`,'%Y-%m-%d') <= '$fecha_al' ";
            //echo $consulta;
            $result = $this->sql->consultar($consulta, "sgrc");

            $fila = mysql_fetch_array($result);

            $total = $fila[total];

            $consulta = "SELECT 
                    $total AS total,
                    `rc`.`idrc`, `rc`.`idmodulo` ,  `persona`.`apellido_m`,
                    `persona`.`apellido_p`,   `persona`.`nombre`, `persona`.`idpersona_tipo`,
                    (

                    SELECT 
                      COUNT(distinct `interaccion`.idinteraccion, `interaccion`.idmodulo_interaccion)
                    FROM
                      `interaccion`
                      INNER JOIN `interaccion_rc` ON (`interaccion`.`idinteraccion` = `interaccion_rc`.`idinteraccion`)
                      AND (`interaccion`.`idmodulo_interaccion` = `interaccion_rc`.`idmodulo_interaccion`)
                      WHERE (`interaccion_rc`.`idrc` = `rc`.`idrc`)
                      AND (`interaccion_rc`.`idmodulo` = `rc`.`idmodulo`)             
                      AND `interaccion`.`activo`=1
                      AND `interaccion_rc`.`activo`=1
                      AND DATE_FORMAT(`interaccion`.`fecha`,'%Y-%m-%d') >= '$fecha_del'
                      AND DATE_FORMAT(`interaccion`.`fecha`,'%Y-%m-%d') <= '$fecha_al'
                      ) AS 'cantidad' FROM `rc`
                      INNER JOIN `persona` ON (`rc`.`idrc` = `persona`.`idpersona`)
                      AND (`rc`.`idmodulo` = `persona`.`idmodulo`)
                      LEFT OUTER JOIN persona_tag  ON (`persona`.`idpersona` = `persona_tag`.`idpersona`)
                      AND (`persona`.`idmodulo` = `persona_tag`.`idmodulo`)
                      WHERE 
                        `rc`.`activo`=1 
                      ORDER BY cantidad desc";

            //echo $consulta;
            if ($limit > 0) {
                $consulta.=" limit $limit";
            }
        } else {
            $consulta = "SELECT 
                    COUNT(DISTINCT(CONCAT(interaccion.idinteraccion,'---',interaccion.idmodulo_interaccion))) AS `total`
                  FROM
                    `interaccion`
                    LEFT OUTER JOIN `interaccion_tag` ON (`interaccion`.`idinteraccion` = `interaccion_tag`.`idinteraccion`)
                    AND (`interaccion`.`idmodulo_interaccion` = `interaccion_tag`.`idmodulo_interaccion`)
                  WHERE
                    `interaccion`.`activo` = 1 
                     AND CONCAT(interaccion_tag.idtag,'---',interaccion_tag.idmodulo_tag) IN ($ctag)
                     AND DATE_FORMAT(`interaccion`.`fecha`,'%Y-%m-%d') >= '$fecha_del' 
                    AND DATE_FORMAT(`interaccion`.`fecha`,'%Y-%m-%d') <= '$fecha_al' ";
            //echo $consulta;
            $result = $this->sql->consultar($consulta, "sgrc");

            $fila = mysql_fetch_array($result);

            $total = $fila[total];
            if ($total == '') {
                $total = '0';
            }
            $consulta = "SELECT 
                    $total AS total,
                    `rc`.`idrc`, `rc`.`idmodulo` ,  `persona`.`apellido_m`,
                    `persona`.`apellido_p`,   `persona`.`nombre`, `persona`.`idpersona_tipo`,
                    (

                    SELECT 
                      COUNT(distinct `interaccion`.idinteraccion, `interaccion`.idmodulo_interaccion)
                    FROM
                      `interaccion`
                      INNER JOIN `interaccion_rc` ON (`interaccion`.`idinteraccion` = `interaccion_rc`.`idinteraccion`)
                      AND (`interaccion`.`idmodulo_interaccion` = `interaccion_rc`.`idmodulo_interaccion`)
		      INNER JOIN `interaccion_tag` ON (`interaccion`.`idinteraccion` = `interaccion_tag`.`idinteraccion`)
                      AND (`interaccion`.`idmodulo_interaccion` = `interaccion_tag`.`idmodulo_interaccion`)                      
                    WHERE 
                      (`interaccion_rc`.`idrc` = `rc`.`idrc`)
                      AND (`interaccion_rc`.`idmodulo` = `rc`.`idmodulo`)  
                      AND CONCAT(interaccion_tag.idtag,'---',interaccion_tag.idmodulo_tag) IN ($ctag)
                      AND `interaccion`.`activo`=1
                      AND `interaccion_rc`.`activo`=1
                      AND DATE_FORMAT(`interaccion`.`fecha`,'%Y-%m-%d') >= '$fecha_del'
                      AND DATE_FORMAT(`interaccion`.`fecha`,'%Y-%m-%d') <= '$fecha_al'
                      ) AS 'cantidad' 
                    FROM 
                    `rc`
                    INNER JOIN `persona` ON (`rc`.`idrc` = `persona`.`idpersona`)
                    AND (`rc`.`idmodulo` = `persona`.`idmodulo`)
                    LEFT OUTER JOIN persona_tag ON (`persona`.`idpersona` = `persona_tag`.`idpersona`)
                    AND (`persona`.`idmodulo` = `persona_tag`.`idmodulo`)
                   WHERE 
                        `rc`.`activo`=1
                      ORDER BY cantidad desc";

            // echo $consulta;
            if ($limit > 0) {
                $consulta.=" limit $limit";
            }
        }

        //echo $consulta;
        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }

    function listar_sh_interaccion($limit, $fecha_del, $fecha_al, $idestadistico_complejo_tag) {

        /*
         * La condicion interaccion_sh.principal ("AND interaccion_sh.principal=1") se elimino de la consulta del reporte
         * dado que se retiro dicha validacion para facilitar las opciones de edicion de stakeholders 
         * en la interaccion
         */

        $tags = count($idestadistico_complejo_tag);
         if(!is_array($idestadistico_complejo_tag)){
            $aux_convert=$idestadistico_complejo_tag;
            $idestadistico_complejo_tag=null;
            $idestadistico_complejo_tag=array($aux_convert);
        }       
        if ($tags > 0) {
            $ctag = " SELECT tag1.tag FROM tag tag1 WHERE CONCAT(`tag1`.`idtag`,'---', `tag1`.`idmodulo_tag`) IN ( ";

            foreach ($idestadistico_complejo_tag as $valor) {
                if (strpos($valor, "###")) {
                    $tags--;
                } else {
                    $ctag.= "'" . $valor . "',";
                }
            }

            $ctag = substr($ctag, 0, -1) . ") ";

            $ctag = "SELECT 
               CONCAT(tag.idtag,'---',tag.`idmodulo_tag`)
                  FROM 
                    tag, 
                    ($ctag) AS tag1
                    WHERE
                    tag.ruta LIKE concat('%/',`tag1`.tag,'%/') OR tag.tag = tag1.tag AND
                    `tag`.`activo`=1";

            if ($tags == 0) {
                $ctag = "";
            }
        } else {
            $ctag = "";
        }

        if ($ctag == "") {
            $consulta = "SELECT count(*) AS total
                    FROM 
                    `interaccion`
                    WHERE
                      `interaccion`.`activo`=1
                     AND DATE_FORMAT(`interaccion`.`fecha`,'%Y-%m-%d') >= '$fecha_del'
                     AND DATE_FORMAT(`interaccion`.`fecha`,'%Y-%m-%d') <= '$fecha_al' ";
            //echo $consulta;
            $result = $this->sql->consultar($consulta, "sgrc");

            $fila = mysql_fetch_array($result);

            $total = $fila[total];

            $consulta = "select $total as total, `sh`.`idsh`, `sh`.`idmodulo` ,  `persona`.`apellido_m`,
                    `persona`.`apellido_p`,   `persona`.`nombre`, `persona`.`idpersona_tipo`,
                    (

                    SELECT 
                      count(distinct `interaccion`.idinteraccion, `interaccion`.idmodulo_interaccion)
                    FROM
                      `interaccion`
                      INNER JOIN `interaccion_sh` ON (`interaccion`.`idinteraccion` = `interaccion_sh`.`idinteraccion`)
                      AND (`interaccion`.`idmodulo_interaccion` = `interaccion_sh`.`idmodulo_interaccion`)
                      where (`interaccion_sh`.`idsh` = `sh`.`idsh`)
                      AND (`interaccion_sh`.`idmodulo` = `sh`.`idmodulo`)
                      
                      AND `interaccion`.`activo`=1
                      AND `interaccion_sh`.`activo`=1
                      AND DATE_FORMAT(`interaccion`.`fecha`,'%Y-%m-%d') >= '$fecha_del'
                     AND DATE_FORMAT(`interaccion`.`fecha`,'%Y-%m-%d') <= '$fecha_al'
                      ) as 'cantidad' from `sh`
                      INNER JOIN `persona` ON (`sh`.`idsh` = `persona`.`idpersona`)
                      AND (`sh`.`idmodulo` = `persona`.`idmodulo`)
                      WHERE `sh`.`activo`=1
                      order by cantidad desc";

            //echo $consulta;

            if ($limit > 0) {
                $consulta.=" limit $limit";
            }
        } else {
            $consulta = "SELECT 
                    COUNT(DISTINCT(CONCAT(interaccion.idinteraccion,'---',interaccion.idmodulo_interaccion))) AS `total`
                  FROM
                    `interaccion`
                    LEFT OUTER JOIN `interaccion_tag` ON (`interaccion`.`idinteraccion` = `interaccion_tag`.`idinteraccion`)
                    AND (`interaccion`.`idmodulo_interaccion` = `interaccion_tag`.`idmodulo_interaccion`)
                  WHERE
                    `interaccion`.`activo` = 1 
                     AND CONCAT(interaccion_tag.idtag,'---',interaccion_tag.idmodulo_tag) IN ($ctag)
                     AND DATE_FORMAT(`interaccion`.`fecha`,'%Y-%m-%d') >= '$fecha_del' 
                    AND DATE_FORMAT(`interaccion`.`fecha`,'%Y-%m-%d') <= '$fecha_al' ";

            $result = $this->sql->consultar($consulta, "sgrc");

            $fila = mysql_fetch_array($result);

            $total = $fila[total];
            if ($total == '') {
                $total = '0';
            }
            $consulta = "SELECT $total as total, `sh`.`idsh`, `sh`.`idmodulo` ,  `persona`.`apellido_m`,
                        `persona`.`apellido_p`,   `persona`.`nombre`, `persona`.`idpersona_tipo`,
                        (

                        SELECT 
                          count(distinct `interaccion`.idinteraccion, `interaccion`.idmodulo_interaccion)
                        FROM
                          `interaccion`
                          INNER JOIN `interaccion_sh` ON (`interaccion`.`idinteraccion` = `interaccion_sh`.`idinteraccion`)
                          AND (`interaccion`.`idmodulo_interaccion` = `interaccion_sh`.`idmodulo_interaccion`)
 		          INNER JOIN `interaccion_tag` ON (`interaccion`.`idinteraccion` = `interaccion_tag`.`idinteraccion`)
                          AND (`interaccion`.`idmodulo_interaccion` = `interaccion_tag`.`idmodulo_interaccion`) 
                        WHERE 
                        (`interaccion_sh`.`idsh` = `sh`.`idsh`)
                          AND (`interaccion_sh`.`idmodulo` = `sh`.`idmodulo`)
                          AND CONCAT(interaccion_tag.idtag,'---',interaccion_tag.idmodulo_tag) IN ($ctag)
                          AND `interaccion`.`activo`=1
                          AND `interaccion_sh`.`activo`=1
                          AND DATE_FORMAT(`interaccion`.`fecha`,'%Y-%m-%d') >= '$fecha_del'
                         AND DATE_FORMAT(`interaccion`.`fecha`,'%Y-%m-%d') <= '$fecha_al'
                          ) AS 'cantidad' 
                          FROM `sh`
                          INNER JOIN `persona` ON (`sh`.`idsh` = `persona`.`idpersona`)
                          AND (`sh`.`idmodulo` = `persona`.`idmodulo`)
                          WHERE 
                          `sh`.`activo`=1 
                          order by cantidad desc";

            // echo $consulta;

            if ($limit > 0) {
                $consulta.=" limit $limit";
            }
        }
        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }

    function listar_tag_sh_cantidad($limit, $fecha_del, $fecha_al, $idestadistico_complejo_tag) {
        //primero tag añadido a personas, este tiene que cambiar por los predios y reclamos, veremos, lo mejor seria dividir en secciones
        /* $tags = count($idestadistico_complejo_tag);
          if ($tags > 0) {
          $ctag2 = " AND CONCAT(`tag`.`idtag`,'---',`tag`.`idmodulo_tag`) IN ( ";

          foreach ($idestadistico_complejo_tag as $valor) {
          if (strpos($valor, "###")) {
          $tags--;
          } else {
          $ctag2.= "'" . $valor . "',";
          }
          }
          $ctag2 = substr($ctag2, 0, -1) . ") ";

          if ($tags == 0) {
          $ctag2 = "";
          }
          } else {
          $ctag2 = "";
          } */
        /*
          nueva consulta, si viene un hijo muestra los hermanos y si viene una raiz sus hijos. de abajo para arriba
         * 
         * SELECT CONCAT(tag.idtag,'---',tag.`idmodulo_tag`) ,ruta
          FROM tag,
          ( SELECT IF(replace(SUBSTRING_INDEX(tag1.ruta, '/', -2),'/','')<>'',replace(SUBSTRING_INDEX(tag1.ruta, '/', -2),'/',''),tag1.tag )as tag FROM tag tag1
          WHERE CONCAT(`tag1`.`idtag`,'---', `tag1`.`idmodulo_tag`) IN ( '1---1') ) AS tag1
          WHERE tag.ruta LIKE concat('%/',`tag1`.tag,'%/') OR tag.tag = tag1.tag AND `tag`.`activo`=1
         *          */
        $condicion = "";
        //print_r($idestadistico_complejo_tag);
        $tags = count($idestadistico_complejo_tag);
        if(!is_array($idestadistico_complejo_tag)){
            $aux_convert=$idestadistico_complejo_tag;
            $idestadistico_complejo_tag=null;
            $idestadistico_complejo_tag=array($aux_convert);
        }
        if ($tags > 0) {
            //$ctag = " SELECT tag1.tag FROM tag tag1 WHERE CONCAT(`tag1`.`idtag`,'---', `tag1`.`idmodulo_tag`) IN ( ";
            $ctag = "SELECT IF(replace(SUBSTRING_INDEX(tag1.ruta, '/', -2),'/','')<>'',replace(SUBSTRING_INDEX(tag1.ruta, '/', -2),'/',''),tag1.tag )as tag FROM tag tag1 
       WHERE CONCAT(`tag1`.`idtag`,'---', `tag1`.`idmodulo_tag`) IN ( ";
            foreach ($idestadistico_complejo_tag as $valor) {
                if (strpos($valor, "###")) {
                    $tags--;
                } else {
                    $ctag.= "'" . $valor . "',";
                }
            }

            $ctag = substr($ctag, 0, -1) . ") ";

            $ctag = "SELECT
          CONCAT(tag.idtag,'---',tag.`idmodulo_tag`)
          FROM
          tag,
          ($ctag) AS tag1
          WHERE
          tag.ruta LIKE concat('%/',`tag1`.tag,'%/') OR tag.tag = tag1.tag
          AND `tag`.`activo`=1";

            $ctag = "  AND CONCAT(tag.idtag,'---',tag.idmodulo_tag) IN ($ctag)";

            if ($tags == 0) {
                $ctag = " AND tag.nivel = 0 ";

                $ctag = "";
            }
        } else {
            $condicion = " AND tag.nivel = 0 ";

            $condicion= "";
        }
        //no viene con tag y viene de pantalla principal
        if ($limit > 0 && $tags==0) {
            $condicion = " AND nivel=0";
            //$climit = " LIMIT 0,$limit";
        }

        $consulta = "SELECT
                  `idtag`,
                  `idmodulo_tag`,
                  tag,
                  nivel,
                  cantidad_hijos,
                  idtag_padre,
                  idmodulo_tag_padre,
                  IF( cantidad_hijos > 0 OR nivel < 1,CONCAT(ruta,tag,'/'),ruta) as campo ,
                (SELECT 
                  COUNT(distinct persona.idpersona,persona.idmodulo)
                FROM
                  `persona_tag`
                  LEFT JOIN (SELECT * FROM tag WHERE activo=1) AS tag2
                  ON persona_tag.idtag=tag2.idtag and persona_tag.idmodulo_tag=tag2.idmodulo_tag
                  LEFT JOIN persona on persona_tag.idpersona=persona.idpersona
                  AND persona_tag.idmodulo = persona.idmodulo
                WHERE                  
                ( (tag2.tag=tag.tag AND persona_tag.idpersona NOT IN ( select tabla1.idpersona from persona_tag as tabla1 left join tag tabla2 on tabla1.idtag=tabla2.idtag where tabla2.ruta like concat('%/',tag.tag,'/%') ) )  )
                    AND `persona`.`activo`=1
                    AND `persona_tag`.`activo`=1
                    AND DATE_FORMAT(`persona_tag`.`fecha_a`,'%Y-%m-%d') >= '$fecha_del'
                    AND DATE_FORMAT(`persona_tag`.`fecha_a`,'%Y-%m-%d') <= '$fecha_al'
                )  AS cantidad1,
                (SELECT 
                  COUNT(distinct persona.idpersona,persona.idmodulo)
                FROM
                  `persona_tag`
                  left join (select * from tag where activo=1) as tag2
                  on persona_tag.idtag=tag2.idtag and persona_tag.idmodulo_tag=tag2.idmodulo_tag
                  left join persona on persona_tag.idpersona=persona.idpersona
                  and persona_tag.idmodulo = persona.idmodulo
                WHERE                  
                    tag2.ruta like concat('%/',tag.tag,'/%') 
                    AND `persona`.`activo`=1
                    AND `persona_tag`.`activo`=1
                    AND DATE_FORMAT(`persona_tag`.`fecha_a`,'%Y-%m-%d') >= '$fecha_del'
                    AND DATE_FORMAT(`persona_tag`.`fecha_a`,'%Y-%m-%d') <= '$fecha_al'
                    )  AS cantidad2
                FROM 
                    tag
                WHERE
                    tag.activo=1 $ctag $condicion

                ORDER BY 
                    campo,nivel,(cantidad1+cantidad2)
                DESC ";


        //echo $consulta;
        // lo que quidato puede ayudar a ver tag que no están utilizando HAVING cantidad1+cantidad2>0
        $result = $this->sql->consultar($consulta, "sgrc");
        //$result[ctag] = $tags;
        return $result;
    }

    function listar_tag_interaccion_cantidad($limit, $fecha_del, $fecha_al, $idestadistico_complejo_tag) {
        //cantidad1, marcada el directamente y cantidad2, incluye sus hijos
        //print_r($idestadistico_complejo_tag);
        //no solo nivel 0, depende si viene de la pantalla de inicio 

        //en las pruebas que se realizo no mostro como resultado a los hijos
        /*$tags = count($idestadistico_complejo_tag);
        if ($tags > 0) {

            $ctag = " SELECT tag1.tag FROM tag tag1 WHERE CONCAT(`tag1`.`idtag`,'---', `tag1`.`idmodulo_tag`) IN ( ";

            foreach ($idestadistico_complejo_tag as $valor) {
                if (strpos($valor, "###")) {
                    $tags--;
                } else {
                    $ctag.= "'" . $valor . "',";
                }
            }

            $ctag = substr($ctag, 0, -1) . ") ";

            $ctag = "SELECT
          CONCAT(tag.idtag,'---',tag.`idmodulo_tag`)
          FROM
          tag,
          ($ctag) AS tag1
          WHERE
          tag.ruta LIKE concat('%/',`tag1`.tag,'%/') OR tag.tag = tag1.tag
          AND `tag`.`activo`=1";

            if ($tags == 0) {
                $ctag = "";
            }

            $condicion = " AND CONCAT(tag.idtag,'---',tag.`idmodulo_tag`) IN  ($ctag) ";
        } else {
            $ctag = "";
        }
        //echo "Limit ".$limit;
        if ($limit > 0) {
            $climit = " LIMIT 0,$limit";
        }
        */
        $condicion = "";
        $tags = count($idestadistico_complejo_tag);
        //echo $tags;
         if(!is_array($idestadistico_complejo_tag)){
            $aux_convert=$idestadistico_complejo_tag;
            $idestadistico_complejo_tag=null;
            $idestadistico_complejo_tag=array($aux_convert);
        }       
        if ($tags > 0) {
            //$ctag = " SELECT tag1.tag FROM tag tag1 WHERE CONCAT(`tag1`.`idtag`,'---', `tag1`.`idmodulo_tag`) IN ( ";
            $ctag = "SELECT IF(replace(SUBSTRING_INDEX(tag1.ruta, '/', -2),'/','')<>'',replace(SUBSTRING_INDEX(tag1.ruta, '/', -2),'/',''),tag1.tag )as tag FROM tag tag1 
       WHERE CONCAT(`tag1`.`idtag`,'---', `tag1`.`idmodulo_tag`) IN ( ";
            foreach ($idestadistico_complejo_tag as $valor) {
                if (strpos($valor, "###")) {
                    $tags--;
                } else {
                    $ctag.= "'" . $valor . "',";
                }
            }

            $ctag = substr($ctag, 0, -1) . ") ";

            $ctag = "SELECT
          CONCAT(tag.idtag,'---',tag.`idmodulo_tag`)
          FROM
          tag,
          ($ctag) AS tag1
          WHERE
          tag.ruta LIKE concat('%/',`tag1`.tag,'%/') OR tag.tag = tag1.tag
          AND `tag`.`activo`=1";

            $ctag = "  AND CONCAT(tag.idtag,'---',tag.idmodulo_tag) IN ($ctag)";

            if ($tags == 0) {
                $ctag = " AND tag.nivel = 0 ";

                $ctag = "";
            }
        } else {
            $condicion = " AND tag.nivel = 0 ";

            $condicion= "";
        }
        //no viene con tag y viene de pantalla principal
        if ($limit > 0 && $tags==0) {
            $condicion = " AND nivel=0";
            //$climit = " LIMIT 0,$limit";
        }
        $consulta = "SELECT
                        `idtag`,
                        `idmodulo_tag`,
                        tag,
                        nivel,
                        cantidad_hijos,
                        idtag_padre,
                        idmodulo_tag_padre,
                        IF( cantidad_hijos > 0 OR nivel < 1,CONCAT(ruta,tag,'/'),ruta) AS campo ,
                        (SELECT 
                            COUNT(distinct interaccion.idinteraccion,interaccion.idmodulo_interaccion)
                        FROM
                          `interaccion_tag`
                          LEFT JOIN interaccion
                          ON interaccion.idinteraccion=interaccion_tag.idinteraccion
                          AND interaccion.idmodulo_interaccion=interaccion_tag.idmodulo_interaccion
                        WHERE   
                          (interaccion_tag.idtag=tag.idtag AND interaccion_tag.idinteraccion 
                            NOT IN ( 
                            SELECT tabla1.idinteraccion 
                                FROM interaccion_tag as tabla1 
                                LEFT JOIN tag tabla2 ON tabla1.idtag=tabla2.idtag 
                            WHERE 
                                tabla2.ruta like concat('%/',tag.tag,'/%') )  )                
                                AND `interaccion_tag`.`activo`=1
                                AND `interaccion`.`activo`=1
                                AND DATE_FORMAT(`interaccion`.`fecha`,'%Y-%m-%d') >= '$fecha_del'
                                AND DATE_FORMAT(`interaccion`.`fecha`,'%Y-%m-%d') <= '$fecha_al'
                            )  AS cantidad1,
                        (SELECT 
                          COUNT(distinct interaccion.idinteraccion,interaccion.idmodulo_interaccion)
                        FROM
                          `interaccion_tag`                  
                          LEFT JOIN interaccion ON interaccion_tag.idinteraccion=interaccion.idinteraccion
                          AND interaccion_tag.idmodulo_interaccion = interaccion.idmodulo_interaccion
                          LEFT JOIN tag AS tag2
                          ON interaccion_tag.idtag=tag2.idtag
                        WHERE                  
                        tag2.ruta like concat('%/',tag.tag,'/%') 
                        AND `interaccion`.`activo`=1
                        AND `interaccion_tag`.`activo`=1
                        AND DATE_FORMAT(`interaccion`.`fecha`,'%Y-%m-%d') >= '$fecha_del'
                        AND DATE_FORMAT(`interaccion`.`fecha`,'%Y-%m-%d') <= '$fecha_al'
                        )  AS cantidad2
                FROM 
                    tag
                WHERE 
                    tag.activo=1  $ctag $condicion ";

        $consulta.= " 
                ORDER BY
                    campo,nivel,(cantidad1+cantidad2) DESC
                 $climit";


        //echo $consulta;
        //HAVING cantidad1+cantidad2>0, lo he quitado pues puede ayudar a ver tag que no se utilizan
        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }

    function contar_compromiso($terminado, $fecha) {
        $consulta = "select count(*) as cantidad
                    from `compromiso`
                    where `compromiso`.`activo`=1
                    and fecha > '$fecha'
                    and idcompromiso_estado=$terminado";

        //echo $consulta;

        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }

    function contar_interacciones($fecha_del, $fecha_al, $idestadistico_complejo_tag) {
        /*
          la consulta tiene esta forma
         * SELECT 
          tag.idtag,
          tag.`idmodulo_tag`,
          tag.ruta
          FROM
          tag,
          (SELECT tag1.tag FROM tag tag1 WHERE CONCAT(`tag1`.`idtag`,'---', `tag1`.`idmodulo_tag`) IN ('140---1','127---1')) AS tag1
          WHERE
          tag.ruta LIKE concat('%/',`tag1`.tag,'%/') OR tag.tag = tag1.tag AND
          `tag`.`activo`=1
         * se obtiene el producto cartesiano
         *          */
        
        $tags = count($idestadistico_complejo_tag);
        
        if(!is_array($idestadistico_complejo_tag)){
            $aux_convert=$idestadistico_complejo_tag;
            $idestadistico_complejo_tag=null;
            $idestadistico_complejo_tag=array($aux_convert);
        }
        if ($tags > 0) {
            $ctag = " SELECT tag1.tag FROM tag tag1 WHERE CONCAT(`tag1`.`idtag`,'---', `tag1`.`idmodulo_tag`) IN ( ";

            foreach ($idestadistico_complejo_tag as $valor) {
                
                if (strpos($valor, "###")) {
                    $tags--;
                } else {
                    $ctag.= "'" . $valor . "',";
                }
            }

            $ctag = substr($ctag, 0, -1) . ") ";

            $ctag = "SELECT 
                    CONCAT(tag.idtag,'---',tag.`idmodulo_tag`)
                  FROM 
                    tag, 
                    ($ctag) AS tag1
                    WHERE
                    tag.ruta LIKE concat('%/',`tag1`.tag,'%/') OR tag.tag = tag1.tag AND
                    `tag`.`activo`=1";

            if ($tags == 0) {
                $ctag = "";
            }
        } else {
            $ctag = "";
        }
        "";


        if ($ctag == "") {
            //primer: interacciones a la fecha, sh en interacciones, interacciones totales
            $consulta = "
                        (SELECT count(*) AS cantidad
                            FROM `interaccion`
                         WHERE 
                         `interaccion`.`activo`=1 
                         AND DATE_FORMAT(`interaccion`.`fecha`,'%Y-%m-%d') >= '$fecha_del' 
                         AND DATE_FORMAT(`interaccion`.`fecha`,'%Y-%m-%d') <= '$fecha_al')
                        UNION ALL
                         (
                            SELECT 
                              COUNT(DISTINCT(concat(`interaccion_sh`.`idsh`,'---',`interaccion_sh`.`idmodulo`))) AS cantidad
                            FROM
                              `interaccion`
                              INNER JOIN `interaccion_sh` ON (`interaccion`.`idinteraccion` = `interaccion_sh`.`idinteraccion`)
                              AND (`interaccion`.`idmodulo_interaccion` = `interaccion_sh`.`idmodulo_interaccion`)
                            WHERE
                              `interaccion`.`activo` = 1 
                               AND `interaccion_sh`.`activo`=1 
                               AND DATE_FORMAT(`interaccion`.`fecha`,'%Y-%m-%d') >= '$fecha_del' 
                               AND DATE_FORMAT(`interaccion`.`fecha`,'%Y-%m-%d') <= '$fecha_al'
                            )
                         UNION ALL
                          (
                          SELECT count(*) AS cantidad
                            FROM `interaccion`
                         WHERE 
                         `interaccion`.`activo`=1 
                           )";
        } else {

            $consulta = "(SELECT 
                        COUNT(DISTINCT(CONCAT(interaccion.idinteraccion,'---',interaccion.idmodulo_interaccion))) AS `cantidad`
                      FROM
                        `interaccion`
                        LEFT OUTER JOIN `interaccion_tag` ON (`interaccion`.`idinteraccion` = `interaccion_tag`.`idinteraccion`)
                        AND (`interaccion`.`idmodulo_interaccion` = `interaccion_tag`.`idmodulo_interaccion`)
                      WHERE
                        `interaccion`.`activo` = 1 
                         AND CONCAT(interaccion_tag.idtag,'---',interaccion_tag.idmodulo_tag) IN ($ctag)
                         AND DATE_FORMAT(`interaccion`.`fecha`,'%Y-%m-%d') >= '$fecha_del' 
                        AND DATE_FORMAT(`interaccion`.`fecha`,'%Y-%m-%d') <= '$fecha_al')
                        UNION ALL
                      ( 
                      SELECT 
                        COUNT(DISTINCT(concat(`interaccion_sh`.`idsh`,'---',`interaccion_sh`.`idmodulo`))) AS cantidad
                      FROM
                        `interaccion`
                        LEFT OUTER JOIN `interaccion_tag` ON (`interaccion`.`idinteraccion` = `interaccion_tag`.`idinteraccion`)
                        AND (`interaccion`.`idmodulo_interaccion` = `interaccion_tag`.`idmodulo_interaccion`)
                       INNER JOIN `interaccion_sh` ON (`interaccion`.`idinteraccion` = `interaccion_sh`.`idinteraccion`)
                        AND (`interaccion`.`idmodulo_interaccion` = `interaccion_sh`.`idmodulo_interaccion`)
                      WHERE
                        `interaccion`.`activo` = 1 
                         AND CONCAT(interaccion_tag.idtag,'---',interaccion_tag.idmodulo_tag) IN ($ctag)
                         AND DATE_FORMAT(`interaccion`.`fecha`,'%Y-%m-%d') >= '$fecha_del' 
                        AND DATE_FORMAT(`interaccion`.`fecha`,'%Y-%m-%d') <= '$fecha_al'
                       )
                       UNION ALL
                          (
                          SELECT count(*) AS cantidad
                            FROM `interaccion`
                         WHERE 
                         `interaccion`.`activo`=1 
                           )";
        }
        //echo $consulta;

        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }

    function contar_interacciones_sh($fecha_del, $fecha_al, $idestadistico_complejo_tag) {
        /*
          $consulta = "select idsh
          from `interaccion_sh`
          left join `interaccion`
          ON `interaccion_sh`.idinteraccion = `interaccion`.idinteraccion
          AND `interaccion_sh`.idmodulo_interaccion = `interaccion`.idmodulo_interaccion
          where `interaccion_sh`.`activo`=1
          and `interaccion`.`fecha` > '$fecha'
          group by idsh ";
         * 
         */
        //echo $consulta;
        $tags = count($idestadistico_complejo_tag);
        if(!is_array($idestadistico_complejo_tag)){
            $aux_convert=$idestadistico_complejo_tag;
            $idestadistico_complejo_tag=null;
            $idestadistico_complejo_tag=array($aux_convert);
        }
        if ($tags > 0) {
            $ctag = " SELECT tag1.tag FROM tag tag1 WHERE CONCAT(`tag1`.`idtag`,'---', `tag1`.`idmodulo_tag`) IN ( ";

            foreach ($idestadistico_complejo_tag as $valor) {
                if (strpos($valor, "###")) {
                    $tags--;
                } else {
                    $ctag.= "'" . $valor . "',";
                }
            }

            $ctag = substr($ctag, 0, -1) . ") ";

            $ctag = "SELECT 
                    CONCAT(tag.idtag,'---',tag.`idmodulo_tag`)
                  FROM 
                    tag, 
                    ($ctag) AS tag1
                    WHERE
                    tag.ruta LIKE concat('%/',`tag1`.tag,'%/') OR tag.tag = tag1.tag AND
                    `tag`.`activo`=1";

            if ($tags == 0) {
                $ctag = "";
            }
        } else {
            $ctag = "";
        }
        if ($ctag == "") {
            $consulta = "SELECT 
                            count(*) AS cantidad
                        FROM `sh`
                    LEFT JOIN persona
                    ON persona.idpersona=sh.idsh and persona.idmodulo=sh.idmodulo
                     WHERE 
                    `sh`.`activo`=1
                    AND DATE_FORMAT(`persona`.`fecha_a`,'%Y-%m-%d') >= '$fecha_del'
                    AND DATE_FORMAT(`persona`.`fecha_a`,'%Y-%m-%d') <= '$fecha_al'";
        } else {
            $consulta = "SELECT 
                        count(DISTINCT(CONCAT(sh.idsh,'---',sh.idmodulo))) AS cantidad
                      FROM
                        `sh`
                        LEFT OUTER JOIN `persona` ON (`persona`.`idpersona` = `sh`.`idsh`)
                        AND (`persona`.`idmodulo` = `sh`.`idmodulo`)
                        LEFT OUTER JOIN `persona_tag` ON (`persona`.`idpersona` = `persona_tag`.`idpersona`)
                        AND (`persona`.`idmodulo` = `persona_tag`.`idmodulo`)
                      WHERE 
                        `sh`.`activo`=1
                        AND CONCAT(persona_tag.idtag,'---',persona_tag.idmodulo_tag) IN ($ctag)
                        AND DATE_FORMAT(`persona`.`fecha_a`,'%Y-%m-%d') >= '$fecha_del'
                        AND DATE_FORMAT(`persona`.`fecha_a`,'%Y-%m-%d') <= '$fecha_al'";
        }

        echo $consulta;
        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }

    function listar_sh_clave($limit, $fecha_del, $fecha_al, $idestadistico_complejo_tag) {

        $tags = count($idestadistico_complejo_tag);
        if(!is_array($idestadistico_complejo_tag)){
            $aux_convert=$idestadistico_complejo_tag;
            $idestadistico_complejo_tag=null;
            $idestadistico_complejo_tag=array($aux_convert);
        }
        if ($tags > 0) {
            $ctag = " SELECT tag1.tag FROM tag tag1 WHERE CONCAT(`tag1`.`idtag`,'---', `tag1`.`idmodulo_tag`) IN ( ";

            foreach ($idestadistico_complejo_tag as $valor) {
                if (strpos($valor, "###")) {
                    $tags--;
                } else {
                    $ctag.= "'" . $valor . "',";
                }
            }

            $ctag = substr($ctag, 0, -1) . ") ";

            $ctag = "SELECT 
                    CONCAT(tag.idtag,'---',tag.`idmodulo_tag`)
                  FROM 
                    tag, 
                    ($ctag) AS tag1
                    WHERE
                    tag.ruta LIKE concat('%/',`tag1`.tag,'%/') OR tag.tag = tag1.tag AND
                    `tag`.`activo`=1";

            if ($tags == 0) {
                $ctag = "";
            }
        } else {
            $ctag = "";
        }

        if ($ctag == "") {

            $consulta = "SELECT
                            `persona`.`idmodulo`,
                            `persona`.`apellido_p`,
                            `persona`.`apellido_m`,
                            `persona`.`nombre`,
                            `sh`.`importancia`, 
                            `sh_dimension`.`idsh`,
                            `sh_dimension_matriz_sh`.`idsh_dimension`,
                             2*AVG(`dimension_matriz_sh_valor`.`puntaje`) as promedio,  
                            `dimension_matriz_sh_valor`.`iddimension_matriz_sh`
                        FROM 
                            `persona`
                        LEFT JOIN  `sh`
                        ON `persona`.`idpersona`=`sh`.`idsh`
                        AND `persona`.`idmodulo`=`sh`.`idmodulo`
                        LEFT JOIN `sh_dimension`
                        ON `sh`.`idsh`=`sh_dimension`.`idsh`
                        AND `sh`.`idmodulo`=`sh_dimension`.`idmodulo`
                        LEFT JOIN `sh_dimension_matriz_sh`
                        ON `sh_dimension`.`idsh_dimension`=`sh_dimension_matriz_sh`.`idsh_dimension`
                        AND `sh_dimension`.`idmodulo_sh_dimension`=`sh_dimension_matriz_sh`.`idmodulo_sh_dimension`
                        LEFT JOIN `dimension_matriz_sh_valor`
                        ON `sh_dimension_matriz_sh`.`idsh_dimension_matriz_sh_valor`=`dimension_matriz_sh_valor`.`iddimension_matriz_sh_valor`
                        WHERE 
                            `dimension_matriz_sh_valor`.`iddimension_matriz_sh` <>1
                            AND `sh`.`importancia` > 6
                            AND DATE_FORMAT(`sh_dimension`.`fecha`,'%Y-%m-%d') >= '$fecha_del'
                            AND DATE_FORMAT(`sh_dimension`.`fecha`,'%Y-%m-%d') <= '$fecha_al' 
                        GROUP BY `sh_dimension`.`idsh`";


            if ($limit > 0) {
                $consulta.=" limit $limit";
            }
            //echo $consulta;
        } else {
            $consulta = "SELECT
                             DISTINCT 
                            `persona`.`idmodulo`,
                            `persona`.`apellido_p`,
                            `persona`.`apellido_m`,
                            `persona`.`nombre`,
                            `sh`.`importancia`, 
                            `sh_dimension`.`idsh`,
                            `sh_dimension_matriz_sh`.`idsh_dimension`,
                             2*AVG(`dimension_matriz_sh_valor`.`puntaje`) as promedio,  
                            `dimension_matriz_sh_valor`.`iddimension_matriz_sh`
                        FROM 
                            `persona`
                        LEFT JOIN  `sh`
                        ON `persona`.`idpersona`=`sh`.`idsh`
                        AND `persona`.`idmodulo`=`sh`.`idmodulo`
                        LEFT JOIN `sh_dimension`
                        ON `sh`.`idsh`=`sh_dimension`.`idsh`
                        AND `sh`.`idmodulo`=`sh_dimension`.`idmodulo_sh_dimension`
                        LEFT JOIN `sh_dimension_matriz_sh`
                        ON `sh_dimension`.`idsh_dimension`=`sh_dimension_matriz_sh`.`idsh_dimension`
                        AND `sh_dimension`.`idmodulo_sh_dimension`=`sh_dimension_matriz_sh`.`idmodulo_sh_dimension`
                        LEFT JOIN `dimension_matriz_sh_valor`
                        ON `sh_dimension_matriz_sh`.`idsh_dimension_matriz_sh_valor`=`dimension_matriz_sh_valor`.`iddimension_matriz_sh_valor`
                        LEFT OUTER JOIN `persona_tag` ON (`persona`.`idpersona` = `persona_tag`.`idpersona`)
                        AND (`persona`.`idmodulo` = `persona_tag`.`idmodulo`)
                        WHERE 
                            `dimension_matriz_sh_valor`.`iddimension_matriz_sh` <>1
                            AND `sh`.`importancia` > 6
                            AND DATE_FORMAT(`sh_dimension`.`fecha`,'%Y-%m-%d') >= '$fecha_del'
                            AND DATE_FORMAT(`sh_dimension`.`fecha`,'%Y-%m-%d') <= '$fecha_al' 
                            AND CONCAT(persona_tag.idtag,'---',persona_tag.idmodulo_tag) IN ($ctag)
                        GROUP BY `sh_dimension`.`idsh`";


            if ($limit > 0) {
                $consulta.=" limit $limit";
            }
        }

        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }

    function contar_sh($fecha) {
        $consulta = "
        select count(*) from (select `sh_dimension`.`idsh`, `sh_dimension`.`idmodulo` , MAX(`sh_dimension`.`fecha`),
        (select `dimension_matriz_sh_valor`.`puntaje`
        from 
        `dimension_matriz_sh_valor`
        left join `dimension_matriz_sh`
        on `dimension_matriz_sh_valor`.`iddimension_matriz_sh`=`dimension_matriz_sh`.`iddimension_matriz_sh`
        left join `sh_dimension_matriz_sh`
        on `dimension_matriz_sh_valor`.`iddimension_matriz_sh_valor`=`sh_dimension_matriz_sh`.`idsh_dimension_matriz_sh_valor`
        WHERE
        `sh_dimension_matriz_sh`.`idsh_dimension`=`sh_dimension`.`idsh_dimension`
        and `sh_dimension_matriz_sh`.`idmodulo_sh_dimension`=`sh_dimension`.`idmodulo_sh_dimension`
        and `dimension_matriz_sh`.`iddimension_matriz_sh`=1
        ) as posicion,
        (select `dimension_matriz_sh_valor`.`puntaje`
        from 
        `dimension_matriz_sh_valor`
        left join `dimension_matriz_sh`
        on `dimension_matriz_sh_valor`.`iddimension_matriz_sh`=`dimension_matriz_sh`.`iddimension_matriz_sh`
        left join `sh_dimension_matriz_sh`
        on `dimension_matriz_sh_valor`.`iddimension_matriz_sh_valor`=`sh_dimension_matriz_sh`.`idsh_dimension_matriz_sh_valor`
        WHERE
        `sh_dimension_matriz_sh`.`idsh_dimension`=`sh_dimension`.`idsh_dimension`
        and `sh_dimension_matriz_sh`.`idmodulo_sh_dimension`=`sh_dimension`.`idmodulo_sh_dimension`
        and `dimension_matriz_sh`.`iddimension_matriz_sh`=2
        ) as poder,
        (select `dimension_matriz_sh_valor`.`puntaje`
        from 
        `dimension_matriz_sh_valor`
        left join `dimension_matriz_sh`
        on `dimension_matriz_sh_valor`.`iddimension_matriz_sh`=`dimension_matriz_sh`.`iddimension_matriz_sh`
        left join `sh_dimension_matriz_sh`
        on `dimension_matriz_sh_valor`.`iddimension_matriz_sh_valor`=`sh_dimension_matriz_sh`.`idsh_dimension_matriz_sh_valor`
        WHERE
        `sh_dimension_matriz_sh`.`idsh_dimension`=`sh_dimension`.`idsh_dimension`
        and `sh_dimension_matriz_sh`.`idmodulo_sh_dimension`=`sh_dimension`.`idmodulo_sh_dimension`
        and `dimension_matriz_sh`.`iddimension_matriz_sh`=3
        ) as interes

        from `sh_dimension`
        where `sh_dimension`.`activo`=1
        and `sh_dimension`.`fecha`<='$fecha'
        group by `sh_dimension`.`idsh`,`sh_dimension`.`idmodulo`

        ) as resultado";

        //echo "<br/>".$consulta."<br/>";



        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }

    function contar_sh_clave($fecha) {
        $consulta = "
        select count(*) from (select `sh_dimension`.`idsh`, `sh_dimension`.`idmodulo` , MAX(`sh_dimension`.`fecha`),
        (select `dimension_matriz_sh_valor`.`puntaje`
        from 
        `dimension_matriz_sh_valor`
        left join `dimension_matriz_sh`
        on `dimension_matriz_sh_valor`.`iddimension_matriz_sh`=`dimension_matriz_sh`.`iddimension_matriz_sh`
        left join `sh_dimension_matriz_sh`
        on `dimension_matriz_sh_valor`.`iddimension_matriz_sh_valor`=`sh_dimension_matriz_sh`.`idsh_dimension_matriz_sh_valor`
        WHERE
        `sh_dimension_matriz_sh`.`idsh_dimension`=`sh_dimension`.`idsh_dimension`
        and `sh_dimension_matriz_sh`.`idmodulo_sh_dimension`=`sh_dimension`.`idmodulo_sh_dimension`
        and `dimension_matriz_sh`.`iddimension_matriz_sh`=1
        ) as posicion,
        (select `dimension_matriz_sh_valor`.`puntaje`
        from 
        `dimension_matriz_sh_valor`
        left join `dimension_matriz_sh`
        on `dimension_matriz_sh_valor`.`iddimension_matriz_sh`=`dimension_matriz_sh`.`iddimension_matriz_sh`
        left join `sh_dimension_matriz_sh`
        on `dimension_matriz_sh_valor`.`iddimension_matriz_sh_valor`=`sh_dimension_matriz_sh`.`idsh_dimension_matriz_sh_valor`
        WHERE
        `sh_dimension_matriz_sh`.`idsh_dimension`=`sh_dimension`.`idsh_dimension`
        and `sh_dimension_matriz_sh`.`idmodulo_sh_dimension`=`sh_dimension`.`idmodulo_sh_dimension`
        and `dimension_matriz_sh`.`iddimension_matriz_sh`=2
        ) as poder,
        (select `dimension_matriz_sh_valor`.`puntaje`
        from 
        `dimension_matriz_sh_valor`
        left join `dimension_matriz_sh`
        on `dimension_matriz_sh_valor`.`iddimension_matriz_sh`=`dimension_matriz_sh`.`iddimension_matriz_sh`
        left join `sh_dimension_matriz_sh`
        on `dimension_matriz_sh_valor`.`iddimension_matriz_sh_valor`=`sh_dimension_matriz_sh`.`idsh_dimension_matriz_sh_valor`
        WHERE
        `sh_dimension_matriz_sh`.`idsh_dimension`=`sh_dimension`.`idsh_dimension`
        and `sh_dimension_matriz_sh`.`idmodulo_sh_dimension`=`sh_dimension`.`idmodulo_sh_dimension`
        and `dimension_matriz_sh`.`iddimension_matriz_sh`=3
        ) as interes

        from `sh_dimension`
        where `sh_dimension`.`activo`=1
        and `sh_dimension`.`fecha`<='$fecha'
        group by `sh_dimension`.`idsh`,`sh_dimension`.`idmodulo`
        having (interes+poder)>6
        ) as resultado
       ";

        //echo "<br/>".$consulta."<br/>";



        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }

    function promedio_sh_clave_posicion($fecha) {
        $consulta = "select avg(posicion) from (select `sh_dimension`.`idsh`, `sh_dimension`.`idmodulo` , MAX(`sh_dimension`.`fecha`),
        (select `dimension_matriz_sh_valor`.`puntaje`
        from 
        `dimension_matriz_sh_valor`
        left join `dimension_matriz_sh`
        on `dimension_matriz_sh_valor`.`iddimension_matriz_sh`=`dimension_matriz_sh`.`iddimension_matriz_sh`
        left join `sh_dimension_matriz_sh`
        on `dimension_matriz_sh_valor`.`iddimension_matriz_sh_valor`=`sh_dimension_matriz_sh`.`idsh_dimension_matriz_sh_valor`
        WHERE
        `sh_dimension_matriz_sh`.`idsh_dimension`=`sh_dimension`.`idsh_dimension`
        and `sh_dimension_matriz_sh`.`idmodulo_sh_dimension`=`sh_dimension`.`idmodulo_sh_dimension`
        and `dimension_matriz_sh`.`iddimension_matriz_sh`=1
        ) as posicion,
        (select `dimension_matriz_sh_valor`.`puntaje`
        from 
        `dimension_matriz_sh_valor`
        left join `dimension_matriz_sh`
        on `dimension_matriz_sh_valor`.`iddimension_matriz_sh`=`dimension_matriz_sh`.`iddimension_matriz_sh`
        left join `sh_dimension_matriz_sh`
        on `dimension_matriz_sh_valor`.`iddimension_matriz_sh_valor`=`sh_dimension_matriz_sh`.`idsh_dimension_matriz_sh_valor`
        WHERE
        `sh_dimension_matriz_sh`.`idsh_dimension`=`sh_dimension`.`idsh_dimension`
        and `sh_dimension_matriz_sh`.`idmodulo_sh_dimension`=`sh_dimension`.`idmodulo_sh_dimension`
        and `dimension_matriz_sh`.`iddimension_matriz_sh`=2
        ) as poder,
        (select `dimension_matriz_sh_valor`.`puntaje`
        from 
        `dimension_matriz_sh_valor`
        left join `dimension_matriz_sh`
        on `dimension_matriz_sh_valor`.`iddimension_matriz_sh`=`dimension_matriz_sh`.`iddimension_matriz_sh`
        left join `sh_dimension_matriz_sh`
        on `dimension_matriz_sh_valor`.`iddimension_matriz_sh_valor`=`sh_dimension_matriz_sh`.`idsh_dimension_matriz_sh_valor`
        WHERE
        `sh_dimension_matriz_sh`.`idsh_dimension`=`sh_dimension`.`idsh_dimension`
        and `sh_dimension_matriz_sh`.`idmodulo_sh_dimension`=`sh_dimension`.`idmodulo_sh_dimension`
        and `dimension_matriz_sh`.`iddimension_matriz_sh`=3
        ) as interes

        from `sh_dimension`
        where `sh_dimension`.`activo`=1
        and `sh_dimension`.`fecha`<='$fecha'
        group by `sh_dimension`.`idsh`,`sh_dimension`.`idmodulo`
        having (interes+poder)>6
        ) as resultado
        ";

        //echo "<br/>".$consulta."<br/>";



        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }

    function listar_reclamo($fecha, $tipo, $estado, $flag) {

        $cestado = "";

        if (isset($estado) && isset($flag)) {
            if ($flag == 0) {
                $cestado = " and reclamo.idreclamo_estado=$estado ";
            } elseif ($flag == 1) {
                $cestado = " and reclamo.idreclamo_estado<>$estado ";
            }
        }

        $consulta = "select fase.`idfase`,fase.fase,
                    (
                    select count(*)
                    from reclamo
                    left join reclamo_estado
                    on reclamo.idreclamo_estado=reclamo_estado.idreclamo_estado
                    where reclamo_estado.tipo=$tipo
                    and `reclamo`.`idfase`=fase.`idfase`
                    and `reclamo`.`fecha` > '$fecha'
                    and reclamo.activo=1
                    $cestado
                    ) as cantidad,
                    (
                    select count(*)
                    from reclamo                    
                    where `reclamo`.`fecha` > '$fecha'
                    and reclamo.activo=1
                    
                    ) as total
                    from fase
                    order by idfase";

        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }

    function listar_tag_reclamo($limit, $fecha) {

        $consulta = " select count(*) as total from reclamo_tag
                   INNER JOIN `tag` ON (`reclamo_tag`.`idtag` = `tag`.`idtag`)
                    AND (`reclamo_tag`.`idmodulo_tag` = `tag`.`idmodulo_tag`)
                    WHERE
                      `tag`.`activo`=1
                    AND `reclamo_tag`.`activo`=1
                    AND `reclamo_tag`.`fecha_a` > '$fecha'  ";

        $result = $this->sql->consultar($consulta, "sgrc");

        $fila = mysql_fetch_array($result);

        $total = $fila[total];


        $consulta = "select
                  $total as total,
                  `idtag`,
                  `idmodulo_tag`,
                  tag,
                  COUNT(*) as cantidad from 
                (SELECT 
                    `tag`.`idtag`,
                  `tag`.`idmodulo_tag`,
                    tag.tag
                FROM
                  `reclamo_tag`
                  INNER JOIN `tag` ON (`reclamo_tag`.`idtag` = `tag`.`idtag`)
                  AND (`reclamo_tag`.`idmodulo_tag` = `tag`.`idmodulo_tag`)
                WHERE
                  `tag`.`activo`=1
                AND `reclamo_tag`.`activo`=1
                AND `reclamo_tag`.`fecha_a` > '$fecha'                
                )  as tag_cantidad
                
                  group by 
                    `idtag`,
                  `idmodulo_tag`,tag
                 order by cantidad
                desc";

        if ($limit > 0) {
            $consulta.=" limit $limit";
        }
        //echo $consulta;

        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }

    function listar_estado_reclamo($fecha, $idfase) {

        $consulta = "select count(*) as total from reclamo
                   left join reclamo_estado
                   on reclamo.idreclamo_estado=reclamo_estado.idreclamo_estado
                   where
                   `reclamo_estado`.`tipo` = 0
                    AND `reclamo_estado`.`idreclamo_estado` <> 5
                   AND `reclamo`.`fecha` > '$fecha' 
                    AND reclamo.idfase = $idfase
                    AND `reclamo`.`activo` = 1 
                   ";

        $result = $this->sql->consultar($consulta, "sgrc");

        $fila = mysql_fetch_array($result);

        $total = $fila[total];

        $consulta = "SELECT 
                    $total as total,
                    `reclamo_estado`.`idreclamo_estado`,
                    `reclamo_estado`.`estado`,
                    `reclamo_estado`.`tipo`,
                    (SELECT count(*) AS `FIELD_1` FROM `reclamo`                     
                    WHERE `reclamo`.`idreclamo_estado` = `reclamo_estado`.`idreclamo_estado` 
                    AND `reclamo`.`fecha` > '$fecha' 
                    AND reclamo.idfase = $idfase
                    AND `reclamo`.`activo` = 1 ) AS `cantidad`,
                    (select fase from fase where idfase=$idfase) as fase
                  FROM
                    `reclamo_estado`
                  WHERE `reclamo_estado`.`tipo` = 0
                  AND `reclamo_estado`.`idreclamo_estado` <> 5
                  ORDER BY
                    `estado`";

        //echo $consulta;

        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }

    function listar_estado_compromiso($fecha_del, $fecha_al) {

        $consulta = "SELECT 
                    count(*) AS total FROM compromiso
                   WHERE
                    DATE_FORMAT(`compromiso`.`fecha`,'%Y-%m-%d') >= '$fecha_del'
                    AND DATE_FORMAT(`compromiso`.`fecha`,'%Y-%m-%d') <= '$fecha_al'                     
                    AND `compromiso`.`activo` = 1 ";

        $result = $this->sql->consultar($consulta, "sgrc");

        $fila = mysql_fetch_array($result);

        $total = $fila[total];

        $consulta = "SELECT 
                    $total AS total,
                    `compromiso_estado`.`idcompromiso_estado`,
                    `compromiso_estado`.`compromiso_estado`,                    
                    (SELECT count(*) AS `FIELD_1` FROM `compromiso`                     
                    WHERE `compromiso`.`idcompromiso_estado` = `compromiso_estado`.`idcompromiso_estado` 
                    AND DATE_FORMAT(`compromiso`.`fecha`,'%Y-%m-%d') >= '$fecha_del'
                    AND DATE_FORMAT(`compromiso`.`fecha`,'%Y-%m-%d') <= '$fecha_al'                     
                    AND `compromiso`.`activo` = 1 ) AS `cantidad`
                  FROM
                    `compromiso_estado`                 
                  ORDER BY
                    `orden`";

        //echo $consulta;

        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }

    function listar_interacciones($formato, $idpersona_compuesto, $limite) {

        if (isset($idpersona_compuesto) && strpos($idpersona_compuesto, "---")) {
            $aux = explode("---", $idpersona_compuesto);

            $condicion = "   AND CONCAT(idinteraccion,'---',idmodulo_interaccion)
                            IN (select CONCAT(idinteraccion,'---',idmodulo_interaccion) from interaccion_sh
                            where
                            interaccion.idinteraccion=interaccion_sh.idinteraccion
                            and interaccion.idmodulo_interaccion=interaccion_sh.idmodulo_interaccion
                            and interaccion_sh.activo=1
                            and interaccion_sh.idsh=$aux[0] 
                            and interaccion_sh.idmodulo=$aux[1]
                            UNION ALL 
                            select CONCAT(idinteraccion,'---',idmodulo_interaccion) from interaccion_rc
                            where
                            interaccion.idinteraccion=interaccion_rc.idinteraccion
                            and interaccion.idmodulo_interaccion=interaccion_rc.idmodulo_interaccion
                            and interaccion_rc.activo=1
                            and interaccion_rc.idrc=$aux[0] and interaccion_rc.idmodulo=$aux[1] ) ";
        }

        $consulta = "select count(*) as cantidad, 
            DATE_FORMAT(interaccion.fecha,'$formato') AS periodo           
            from interaccion
            where             
            interaccion.activo=1 AND interaccion.fecha <= DATE_FORMAT(NOW(),'%Y-%m-%d')
            $condicion
            group by periodo            
            order by periodo desc
            limit $limite";

        //echo $consulta;

        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }

    function listar_interacciones_tag($formato, $idpersona_compuesto, $fecha) {

        if (isset($idpersona_compuesto) && strpos($idpersona_compuesto, "---")) {
            $aux = explode("---", $idpersona_compuesto);

            $condicion = "   AND CONCAT(interaccion.idinteraccion,'---',interaccion.idmodulo_interaccion)
                            IN (select CONCAT(idinteraccion,'---',idmodulo_interaccion) from interaccion_sh
                            where
                            interaccion.idinteraccion=interaccion_sh.idinteraccion
                            and interaccion.idmodulo_interaccion=interaccion_sh.idmodulo_interaccion
                            and interaccion_sh.activo=1
                            and interaccion_sh.idsh=$aux[0] 
                            and interaccion_sh.idmodulo=$aux[1]
                            UNION ALL 
                            select CONCAT(idinteraccion,'---',idmodulo_interaccion) from interaccion_rc
                            where
                            interaccion.idinteraccion=interaccion_rc.idinteraccion
                            and interaccion.idmodulo_interaccion=interaccion_rc.idmodulo_interaccion
                            and interaccion_rc.activo=1
                            and interaccion_rc.idrc=$aux[0] and interaccion_rc.idmodulo=$aux[1] ) ";
        }

        $consulta = "select count(*) as cantidad, 
            DATE_FORMAT(interaccion.fecha,'$formato') AS periodo,
            tag
            from interaccion
            left join interaccion_tag
            on interaccion.idinteraccion = interaccion_tag.idinteraccion
            and interaccion.idmodulo_interaccion = interaccion_tag.idmodulo_interaccion
            left join tag
            on interaccion_tag.idtag=tag.idtag
            and interaccion_tag.idmodulo_tag=tag.idmodulo_tag
            where
            tag.activo=1
            AND interaccion_tag.activo=1
            AND interaccion.activo=1 
            AND interaccion.fecha <= DATE_FORMAT(NOW(),'%Y-%m-%d') 
            AND interaccion.fecha >= DATE_FORMAT('$fecha','%Y-%m-%d')
            $condicion
            group by periodo,tag            
            order by periodo desc
            ";

        //echo $consulta;

        $result = $this->sql->consultar($consulta, "sgrc");

        $aresult = array();

        while ($fila = mysql_fetch_array($result)) {
            $tag = utf8_encode($fila[tag]);
            $key = $fila[periodo];
            $aresult[$tag][$key] = $fila[cantidad];
        }

        return $aresult;
    }

    function listar_interaccion_tag_sh($fecha_del, $fecha_al, $idestadistico_complejo_tag) {

        $tags = count($idestadistico_complejo_tag);

        if ($tags > 0) {
            $ctag = " SELECT tag1.tag FROM tag tag1 WHERE CONCAT(`tag1`.`idtag`,'---', `tag1`.`idmodulo_tag`) IN ( ";

            foreach ($idestadistico_complejo_tag as $valor) {
                if (strpos($valor, "###")) {
                    $tags--;
                } else {
                    $ctag.= "'" . $valor . "',";
                }
            }

            $ctag = substr($ctag, 0, -1) . ") ";

            $ctag = "SELECT 
                    CONCAT(tag.idtag,'---',tag.`idmodulo_tag`)
                  FROM 
                    tag, 
                    ($ctag) AS tag1
                    WHERE
                    tag.ruta LIKE concat('%/',`tag1`.tag,'%/') OR tag.tag = tag1.tag AND
                    `tag`.`activo`=1";

            if ($tags == 0) {
                $ctag = "";
            }
        } else {
            $ctag = "";
        }
        if ($ctag == "") {
            $consulta = "SELECT 
                        DISTINCT tag.`idtag`, `tag`.`idmodulo_tag`, `tag`.`tag`,
                        interaccion_sh.idinteraccion, `interaccion_sh`.idmodulo_interaccion,
                        interaccion_sh.idsh, `interaccion_sh`.idmodulo,
                        sh.importancia
                    FROM 
                        ( SELECT * FROM interaccion_tag WHERE activo=1 ) AS interaccion_tag
                    LEFT OUTER JOIN (SELECT * FROM tag WHERE activo=1) AS tag
                        ON tag.idtag=interaccion_tag.`idtag`
                        AND tag.`idmodulo_tag`=`interaccion_tag`.`idmodulo_tag`
                    LEFT OUTER JOIN ( SELECT * FROM interaccion_sh WHERE activo=1) AS interaccion_sh
                        ON interaccion_tag.`idinteraccion` = interaccion_sh.idinteraccion
                        AND interaccion_tag.idmodulo_interaccion = interaccion_sh.`idmodulo_interaccion`
                    LEFT OUTER JOIN interaccion
                        ON interaccion_tag.`idinteraccion` = interaccion.idinteraccion
                        AND interaccion_tag.idmodulo_interaccion = interaccion.`idmodulo_interaccion`
                    LEFT OUTER JOIN `sh`
                        ON interaccion_sh.idsh = sh.idsh
                        AND interaccion_sh.idmodulo = sh.idmodulo
                    WHERE 
                        interaccion.activo=1
                    AND DATE_FORMAT(`interaccion`.`fecha`,'%Y-%m-%d') >= '$fecha_del'
                    AND DATE_FORMAT(`interaccion`.`fecha`,'%Y-%m-%d') <= '$fecha_al'";
        } else {
            $consulta = "SELECT 
                        DISTINCT tag.`idtag`, `tag`.`idmodulo_tag`, `tag`.`tag`,
                        interaccion_sh.idinteraccion, `interaccion_sh`.idmodulo_interaccion,
                        interaccion_sh.idsh, `interaccion_sh`.idmodulo,
                        sh.importancia
                    FROM 
                        ( SELECT * FROM interaccion_tag WHERE activo=1 ) AS interaccion_tag
                    LEFT OUTER JOIN (SELECT * FROM tag WHERE activo=1) AS tag
                        ON tag.idtag=interaccion_tag.`idtag`
                        AND tag.`idmodulo_tag`=`interaccion_tag`.`idmodulo_tag`
                    LEFT OUTER JOIN ( SELECT * FROM interaccion_sh WHERE activo=1) AS interaccion_sh
                        ON interaccion_tag.`idinteraccion` = interaccion_sh.idinteraccion
                        AND interaccion_tag.idmodulo_interaccion = interaccion_sh.`idmodulo_interaccion`
                    LEFT OUTER JOIN interaccion
                        ON interaccion_tag.`idinteraccion` = interaccion.idinteraccion
                        AND interaccion_tag.idmodulo_interaccion = interaccion.`idmodulo_interaccion`
                    LEFT OUTER JOIN `sh`
                        ON interaccion_sh.idsh = sh.idsh
                        AND interaccion_sh.idmodulo = sh.idmodulo
                    WHERE 
                        interaccion.activo=1 AND
                    CONCAT(tag.idtag,'---',tag.idmodulo_tag) IN ($ctag)
                    AND DATE_FORMAT(`interaccion`.`fecha`,'%Y-%m-%d') >= '$fecha_del'
                    AND DATE_FORMAT(`interaccion`.`fecha`,'%Y-%m-%d') <= '$fecha_al'";
        }

        //echo $consulta;
        $result = $this->sql->consultar($consulta, "sgrc");

        while (!!$fila = mysql_fetch_array($result)) {

            $aresult['tag'][$fila[idtag] . "-" . $fila[idmodulo_tag]] = $fila[tag];

            if (isset($fila[idinteraccion]) && $fila[idinteraccion] != "") {

                $aresult['interaccion_sh'][$fila[idsh] . "-" . $fila[idmodulo]][$fila[idinteraccion] . "-" . $fila[idmodulo_interaccion]] = 1;
                $aresult['interaccion_tag_sh'][$fila[idtag] . "-" . $fila[idmodulo_tag]][$fila[idsh] . "-" . $fila[idmodulo]][$fila[idinteraccion] . "-" . $fila[idmodulo_interaccion]] = 1;
                $aresult['interaccion_tag'][$fila[idtag] . "-" . $fila[idmodulo_tag]][$fila[idinteraccion] . "-" . $fila[idmodulo_interaccion]] = 1;


                if ($fila[importancia] > 0)
                    $aresult['importancia_sh'][$fila[idsh] . "-" . $fila[idmodulo]] = $fila[importancia];
                else
                    $aresult['importancia_sh'][$fila[idsh] . "-" . $fila[idmodulo]] = 1;
            }
        }
        //print_r($aresult);
        return $aresult;
    }

    function listar_persona_interaccion_tag_sh($fecha_del, $fecha_al) {

        $ayudante = new Ayudante();
        $fecha_del = $ayudante->FechaRevezMysql($fecha_del, "/");
        $fecha_al = $ayudante->FechaRevezMysql($fecha_al, "/");

        $cfecha = "left outer join interaccion
             on interaccion_tag.`idinteraccion` = interaccion.idinteraccion
             and interaccion_tag.idmodulo_interaccion = interaccion.`idmodulo_interaccion`
             where
            `interaccion`.`activo`=1 AND `interaccion`.`fecha`>='$fecha_del' AND `interaccion`.`fecha`<='$fecha_al'";


        $consulta = "CREATE TEMPORARY TABLE IF NOT EXISTS table2 AS (select count(*) as cantidad, 
                    idtag1,idmodulo_tag1,tag1 ,
                    idtag2,idmodulo_tag2, tag2  from (select distinct 
                    tag1.`idtag` as idtag1, `tag1`.`idmodulo_tag` as idmodulo_tag1, `tag1`.`tag` as tag1,
                    interaccion_sh.idinteraccion, `interaccion_sh`.idmodulo_interaccion,
                    interaccion_sh.idsh, `interaccion_sh`.idmodulo,
                    tag2.`idtag` as idtag2, `tag2`.`idmodulo_tag` as idmodulo_tag2, `tag2`.`tag` as tag2
                    from ( select * from interaccion_tag where activo=1 ) as interaccion_tag
                    left outer join (select * from tag where activo=1) as tag1
                    on tag1.idtag=interaccion_tag.`idtag`
                    and tag1.`idmodulo_tag`=`interaccion_tag`.`idmodulo_tag`
                    left outer join ( select * from interaccion_sh where activo=1) as interaccion_sh
                    on interaccion_tag.`idinteraccion` = interaccion_sh.idinteraccion
                    and interaccion_tag.idmodulo_interaccion = interaccion_sh.`idmodulo_interaccion`                    
                    left outer join ( select * from persona_tag where activo=1) as persona_tag
                    on persona_tag.`idpersona`=interaccion_sh.idsh
                    and persona_tag.`idmodulo`=`interaccion_sh`.idmodulo
                    left outer join (select * from tag where activo=1) as tag2
                    on tag2.idtag=persona_tag.`idtag`
                    and tag2.`idmodulo_tag`=`persona_tag`.`idmodulo_tag`
                    $cfecha
                    having tag2 is not NULL                                                        
                    
                    ) as tabla                    
                    group by tag1,tag2
                    order by cantidad desc
                    );";

        $result = $this->sql->consultar($consulta, "sgrc");

        //echo $consulta;

        $consulta = "CREATE TEMPORARY TABLE IF NOT EXISTS table1 AS (select count(*) as cantidad, 
                    tag2, idtag2,idmodulo_tag2  from (select distinct 
                    tag1.`idtag` as idtag1, `tag1`.`idmodulo_tag` as idmodulo_tag1, `tag1`.`tag` as tag1,
                    interaccion_sh.idinteraccion, `interaccion_sh`.idmodulo_interaccion,
                    interaccion_sh.idsh, `interaccion_sh`.idmodulo,
                    tag2.`idtag` as idtag2, `tag2`.`idmodulo_tag` as idmodulo_tag2, `tag2`.`tag` as tag2
                    from ( select * from interaccion_tag where activo=1 ) as interaccion_tag
                    left outer join (select * from tag where activo=1) as tag1
                    on tag1.idtag=interaccion_tag.`idtag`
                    and tag1.`idmodulo_tag`=`interaccion_tag`.`idmodulo_tag`
                    left outer join ( select * from interaccion_sh where activo=1) as interaccion_sh
                    on interaccion_tag.`idinteraccion` = interaccion_sh.idinteraccion
                    and interaccion_tag.idmodulo_interaccion = interaccion_sh.`idmodulo_interaccion`                    
                    left outer join ( select * from persona_tag where activo=1) as persona_tag
                    on persona_tag.`idpersona`=interaccion_sh.idsh
                    and persona_tag.`idmodulo`=`interaccion_sh`.idmodulo
                    left outer join (select * from tag where activo=1) as tag2
                    on tag2.idtag=persona_tag.`idtag`
                    and tag2.`idmodulo_tag`=`persona_tag`.`idmodulo_tag`
                    $cfecha
                    having tag2 is not NULL                                                        
                    
                    ) as tabla                    
                    group by tag2
                    order by cantidad desc
                    );";

        $result = $this->sql->consultar($consulta, "sgrc");

        $consulta = "select idtag1,idmodulo_tag1,tag1,
                    idtag2,idmodulo_tag2,tag2,cantidad,
                    (select count(*) from persona_tag
                    left join persona
                    on persona.idpersona = persona_tag.idpersona
                    and persona.idmodulo = persona_tag.idmodulo
                    where table2.idtag2=persona_tag.idtag
                    and persona.activo=1 and persona_tag.activo=1
                    and table2.idmodulo_tag2=persona_tag.idmodulo_tag) as sh,
                    (select count(distinct interaccion_sh.idinteraccion,interaccion_sh.idmodulo_interaccion) from interaccion_sh                    
                    left join persona_tag
                    on persona_tag.idpersona=interaccion_sh.idsh
                    and persona_tag.idmodulo=interaccion_sh.idmodulo
                    left outer join interaccion
                    on interaccion_sh.`idinteraccion` = interaccion.idinteraccion
                    and interaccion_sh.idmodulo_interaccion = interaccion.`idmodulo_interaccion`
                    where
                   `interaccion`.`activo`=1 AND `interaccion`.`fecha`>='$fecha_del' AND `interaccion`.`fecha`<='$fecha_al'
                    and 
                    table2.idtag2=persona_tag.idtag
                    and interaccion_sh.activo=1 and persona_tag.activo=1
                    and table2.idmodulo_tag2=persona_tag.idmodulo_tag) as interaccion

                    from table2 where table2.tag2 IN (select tag2 from table1) order by cantidad desc";

        $result = $this->sql->consultar($consulta, "sgrc");

        while (!!$fila = mysql_fetch_array($result)) {

            $aresult['tag_interaccion'][$fila[idtag1] . "-" . $fila[idmodulo_tag1]] = utf8_encode($fila[tag1]);

            $aresult['tag_stakeholder'][$fila[idtag2] . "-" . $fila[idmodulo_tag2]] = utf8_encode($fila[tag2]) . " [" . $fila[sh] . "]";

            $aresult['interaccion_tag_stakeholder'][$fila[idtag2] . "-" . $fila[idmodulo_tag2]] = $fila[interaccion];

            $aresult['tag_stakeholder_interaccion'][$fila[idtag2] . "-" . $fila[idmodulo_tag2]][$fila[idtag1] . "-" . $fila[idmodulo_tag1]] = $fila[cantidad];
        }

        $consulta = "select idtag,idmodulo_tag,tag,
                    (select count(*) from persona_tag
                    left join persona
                    on persona.idpersona = persona_tag.idpersona
                    and persona.idmodulo = persona_tag.idmodulo
                    where tag.idtag=persona_tag.idtag
                    and persona.activo=1 and persona_tag.activo=1
                    and tag.idmodulo_tag=persona_tag.idmodulo_tag) as sh

                    from tag where tag.activo=1 and tag.tag NOT IN (select tag2 from table2)
                    having sh>0
                    order by sh desc";

        $result = $this->sql->consultar($consulta, "sgrc");

        while (!!$fila = mysql_fetch_array($result)) {


            $aresult['tag_stakeholder'][$fila[idtag] . "-" . $fila[idmodulo_tag]] = utf8_encode($fila[tag]) . " [" . $fila[sh] . "]";

            $aresult['interaccion_tag_stakeholder'][$fila[idtag] . "-" . $fila[idmodulo_tag]] = 0;
        }
        //print_r($aresult); exit;
        return $aresult;
    }

    function listar_tag_interaccion_relevancia($fecha) {

        $consulta = "select 
                    tabla1.idtag,
                    tabla1.idmodulo_tag,
                    tabla3.tag,
                    (select count(*) from interaccion_tag tabla2
                    where tabla1.idinteraccion=tabla2.idinteraccion
                    and tabla1.idmodulo_interaccion = tabla2.idmodulo_interaccion
                    and tabla1.idinteraccion_tag >= tabla2.idinteraccion_tag
                    and tabla2.activo=1
                    ) as orden,
                    count(*) as cantidad
                    from interaccion_tag tabla1
                    left join tag tabla3
                    on tabla3.`idtag`=tabla1.idtag
                    and tabla3.`idmodulo_tag`=`tabla1`.`idmodulo_tag`
                    left join interaccion
                    on interaccion.idinteraccion=tabla1.idinteraccion
                    and interaccion.idmodulo_interaccion=tabla1.idmodulo_interaccion
                    where tabla1.activo=1
                    and interaccion.activo=1
                    group by idtag, idmodulo_tag, orden
                    order by cantidad DESC, orden ASC";


        /*
          $consulta = "select
          tabla1.idtag,
          tabla1.idmodulo_tag,
          tabla3.tag,
          tabla1.prioridad as orden,
          count(*) as cantidad
          from interaccion_tag tabla1
          left join tag tabla3
          on tabla3.`idtag`=tabla1.idtag
          and tabla3.`idmodulo_tag`=`tabla1`.`idmodulo_tag`
          left join interaccion
          on interaccion.idinteraccion=tabla1.idinteraccion
          and interaccion.idmodulo_interaccion=tabla1.idmodulo_interaccion
          where tabla1.activo=1
          and interaccion.activo=1
          group by idtag, idmodulo_tag, orden
          order by cantidad DESC, orden ASC";
         * 
         */

        $result = $this->sql->consultar($consulta, "sgrc");

        while (!!$fila = mysql_fetch_array($result)) {

            $aresult['tag'][$fila[idtag] . "-" . $fila[idmodulo_tag]] = $fila[tag];

            if ($fila[orden] > 3) {
                $aresult['tag_interaccion'][$fila[idtag] . "-" . $fila[idmodulo_tag]][4] = $fila[cantidad] + $aresult['tag_interaccion'][$fila[idtag] . "-" . $fila[idmodulo_tag]][4];
            } else {
                $aresult['tag_interaccion'][$fila[idtag] . "-" . $fila[idmodulo_tag]][$fila[orden]] = $fila[cantidad];
            }
        }
        //print_r($aresult); exit;
        return $aresult;
    }

}

?>