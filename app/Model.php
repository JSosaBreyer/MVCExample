<?php

class Model
{
    protected $conexion;

    public function __construct($dbname,$dbuser,$dbpass,$dbhost)
    {
      $mvc_bd_conexion = mysql_connect($dbhost, $dbuser, $dbpass);

      if (!$mvc_bd_conexion) {
          die('No ha sido posible realizar la conexión con la base de datos: '
           . mysql_error());
      }
      mysql_select_db($dbname, $mvc_bd_conexion);

      mysql_set_charset('utf8');

      $this->conexion = $mvc_bd_conexion;
    }

    public function dameAlimentos()
    {
        $sql = "select * from alimentos order by energia desc";

        $result = mysql_query($sql, $this->conexion);

        $alimentos = array();
        while ($row = mysql_fetch_assoc($result)) {
            $alimentos[] = $row;
        }

        return $alimentos;
    }

    public function buscarAlimentosPorNombre($nombre)
    {
        $nombre = htmlspecialchars($nombre);

        $sql = "select * from alimentos where nombre like '"
               . mysql_real_escape_string($nombre) .
               "' order by energia desc";

        $result = mysql_query($sql, $this->conexion);

        $alimentos = array();
        while ($row = mysql_fetch_assoc($result)) {
            $alimentos[] = $row;
        }

        return $alimentos;
    }

    public function buscarAlimentosPorEnergia($energia)
    {
        $energia = htmlspecialchars($energia);

        $sql = "select * from alimentos where energia like '"
               . mysql_real_escape_string($energia) .
               "' order by energia desc";

        $result = mysql_query($sql, $this->conexion);

        $alimentos = array();
        while ($row = mysql_fetch_assoc($result)) {
            $alimentos[] = $row;
        }

        return $alimentos;
    }	 

    public function buscarAlimentosCombinada($nombre,$energia,$proteina,$hc,$fibra,$grasa)
    {
        $nombre = htmlspecialchars($nombre);
        $energia = htmlspecialchars($energia);
        $proteina = htmlspecialchars($proteina);
        $hc = htmlspecialchars($hc);
        $fibra = htmlspecialchars($fibra);
        $grasa = htmlspecialchars($grasa);
        $sql = "select * from alimentos ";
        $where = '';

        if ($nombre != '') {
            $where = $where ."where nombre like '" .
                     mysql_real_escape_string($nombre);
        }
        if ($energia != '') {
            if ($where != '') {
                $where = $where ." and energia like '" . 
                        mysql_real_escape_string($energia) . "' ";
            } else {
                $where = $where ."where energia like '" . 
                        mysql_real_escape_string($energia) . "' ";
            }	
        }

        if ($proteina != '') {
            if ($where != '') {
                $where = $where ." and proteina like '" . 
                        mysql_real_escape_string($proteina) ."' ";
            } else {
                $where = $where ."where proteina like '" . 
                        $proteina ."' ";
            }
        }
        if ($hc != '') {
            if ($where != '') {
                $where = $where ." and hidratocarbono like '" .
                        mysql_real_escape_string($hc) . "' ";
            } else {
                $where = $where ."where hidratocarbono like '" .
                        mysql_real_escape_string($hc) . "' ";
            }
        }
        if ($fibra != '') {
            if ($where != '') {
                    $where = $where ." and fibra like '". 
                            mysql_real_escape_string($fibra) ."' ";
            } else {
                    $where = $where ."where fibra like '". 
                            mysql_real_escape_string($fibra) ."' ";
            }
        }
        if ($grasa != '') {
            if ($where != '') {
                $where = $where ." and grasatotal like '" .
                        mysql_real_escape_string($grasa) ."' ";
            } else {
                $where = $where ."where grasatotal like '" .
                        mysql_real_escape_string($grasa) ."' ";
            }		
        }

        $query = $sql.$where;
        echo $query;
        $result = mysql_query($query, $this->conexion);

        $alimentos = array();
        while ($row = mysql_fetch_assoc($result)) {
            $alimentos[] = $row;
        }

        return $alimentos;
    }

    public function dameAlimento($id)
    {
        $id = htmlspecialchars($id);

        $sql = "select * from alimentos where id = " . $id;

        $result = mysql_query($sql, $this->conexion);

        $row = mysql_fetch_assoc($result);

        return $row;

    }

    public function insertarAlimento($n, $e, $p, $hc, $f, $g)
    {
        $n = htmlspecialchars($n);
        $e = htmlspecialchars($e);
        $p = htmlspecialchars($p);
        $hc = htmlspecialchars($hc);
        $f = htmlspecialchars($f);
        $g = htmlspecialchars($g);

        $sql = "insert into alimentos (nombre, energia, proteina,
                hidratocarbono, fibra, grasatotal) values ('" .
                mysql_real_escape_string($n) . "'," . 
                mysql_real_escape_string($e) . "," . 
                mysql_real_escape_string($p) . "," . 
                mysql_real_escape_string($hc) . "," . 
                mysql_real_escape_string($f) . "," . 
                mysql_real_escape_string($g) . ")";

        $result = mysql_query($sql, $this->conexion);

        return $result;
    }

    public function validarDatos($n, $e, $p, $hc, $f, $g)
    {
        return (is_string($n) &
                is_numeric($e) &
                is_numeric($p) &
                is_numeric($hc) &
                is_numeric($f) &
                is_numeric($g));
    }

}