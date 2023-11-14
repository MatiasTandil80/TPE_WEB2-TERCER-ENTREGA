<?php

class ModelosModel {
    private $db;

    function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=motos;charset=utf8', 'root', '');
    }

    /**
     * Obtiene y devuelve de la base de datos todos los modelos.
     */
    function getModelos($filterField,$filterValue,$orderField,$orderValue) {


            //filter                    //order
        if(($filterField!=null)&&($orderField==null)){
            //consulta solo con filter
  
            $query = $this->db->prepare("SELECT * FROM modelos WHERE $filterField = ?");
            $query->execute([$filterValue]);
        }
        if(($filterField==null)&&($orderField!=null)){
            //consulta solo con order
                                                                            
            $query = $this->db->prepare("SELECT * FROM modelos ORDER BY  $orderField $orderValue");
            $query->execute();

        }
        if(($filterField!=null)&&($orderField!=null)){
            //consulta con filter y order
            $query = $this->db->prepare("SELECT * FROM modelos WHERE $filterField = ? ORDER BY $orderField $orderValue");
            $query->execute([$filterValue]);

        }
        if(($filterField==null)&&($orderField==null)){
            //consulta con estandar
            $query = $this->db->prepare("SELECT * FROM modelos");
            $query->execute();
        }


        // $modelos es un arreglo de modelos de motos
        $modelos = $query->fetchAll(PDO::FETCH_OBJ);

        return $modelos;
    }

       

    
    /**
     * Obtiene de la base de datos un modelo de moto, según un id y lo retorna.
     */
    function getModelo($id) {
       $query = $this->db->prepare("SELECT modelos.*, marcas.nombre AS nombre_marca
       FROM modelos
       INNER JOIN marcas ON modelos.id_marca = marcas.id
       WHERE modelos.id = $id");
       
        $query->execute();
        
        // $modelo es un arreglo que contiene un sólo modelo de moto
        $modelo = $query->fetch(PDO::FETCH_OBJ);
        

        return $modelo;
        
    }


    /**
     * Inserta un modelo de moto en la base de datos
     */
    function insertModelo($id_marca, $nombre, $cilindrada_cm3, $tipo, $potencia_hp, $peso_kg) {
        
        $consulta = "SELECT EXISTS(
            SELECT *
            FROM marcas
            WHERE id = :id
        );";
        
        $statement = $this->db->prepare($consulta);
        $statement->bindParam(':id', $id_marca);

        $statement->execute();

        $consulta_nombre = "SELECT EXISTS( SELECT * FROM modelos WHERE nombre = :nombre );";
        
        $statement2 = $this->db->prepare($consulta_nombre);
        $statement2->bindParam(':nombre', $nombre);

        $statement2->execute();
                

        if ($statement->fetchColumn() == 1){
            if($statement2->fetchColumn() == 0) {
                $query = $this->db->prepare('INSERT INTO modelos (id_marca, nombre, cilindrada_cm3, tipo, potencia_hp, peso_kg) VALUES(?,?,?,?,?,?)');
                $query->execute([$id_marca, $nombre, $cilindrada_cm3, $tipo, $potencia_hp, $peso_kg]);
                return $this->db->lastInsertId();
            } 
        
        }
        return 0;
    }

   
function deleteModelo($id) {
    $query = $this->db->prepare('DELETE FROM modelos WHERE id = ?');
    $query->execute([$id]);
    return $query->rowCount();//Numero de filas afectadas
}

function updateModelo($modelo) {    
    
    $query = $this->db->prepare('UPDATE modelos SET nombre = ?, cilindrada_cm3 = ?, tipo = ?, potencia_hp = ?, peso_kg = ? WHERE id = ?');
    
    $query->execute(array($modelo->nombre, $modelo->cilindrada_cm3, $modelo->tipo, $modelo->potencia_hp, $modelo->peso_kg, $modelo->id));
}

function getModelosMarca($id_marca) {
    
        $modelos = $this->getModelos();

        $arrModelos=array();

        foreach($modelos as $modelo){
            if($id_marca == $modelo->id_marca){
                array_push($arrModelos,$modelo);
            }

        }
       return $arrModelos;
}

function getModelosOrd($orderby){
    //nombre ASC, peso_kg DESC
    try{
            $query = $this->db->prepare("SELECT * FROM modelos ORDER BY $orderby ");
            $query->execute();

            // $modelos es un arreglo de modelos de motos
            $modelos = $query->fetchAll(PDO::FETCH_OBJ);

            return $modelos;
    }
     catch (PDOException $e) {
            return null;
        }


}

function getModelosFilter($column,$value) {
    $query = $this->db->prepare("SELECT * FROM modelos WHERE $column = ? ");
    
    $query->execute([$value]);

    // $modelos es un arreglo de modelos de motos
    $modelos = $query->fetchAll(PDO::FETCH_OBJ);

    return $modelos;
}


}