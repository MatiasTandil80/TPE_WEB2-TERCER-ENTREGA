<?php

class ReseñasModel{

    private $db;

    function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=motos;charset=utf8', 'root', '');
    }

    function getReseñas(){
    
        $query = $this->db->prepare("SELECT reseñas_marcas.*, marcas.nombre AS nombre_marca
        FROM reseñas_marcas INNER JOIN marcas ON reseñas_marcas.id_marca = marcas.id");
           
        $query->execute();
            
            // $modelo es un arreglo que contiene un sólo modelo de moto
        $reseñas = $query->fetchAll(PDO::FETCH_OBJ);
          
        return $reseñas;
            
    }

    function getReseña($idMarca){

        $query = $this->db->prepare("SELECT reseñas_marcas.*, marcas.nombre AS nombre_marca
        FROM reseñas_marcas
        INNER JOIN marcas ON reseñas_marcas.id_marca = marcas.id
        WHERE marcas.id = :idMarca");
        $query->bindParam(':idMarca', $idMarca);
        $query->execute();
        $reseña = $query->fetch(PDO::FETCH_OBJ);

        if($reseña!=null){
            return $reseña;
        }else{
            return null;
        }
        
    }

    function insertReseña($reseña) {
     
          $query = $this->db->prepare('INSERT INTO reseñas_marcas (id_marca,detalle) VALUES(?,?)');
          $query->execute([$reseña->id_marca,$reseña->detalle]);
          return $query->rowCount();
    }
               
    
    
    function updateReseña($reseña){
        $query = $this->db->prepare('UPDATE reseñas_marcas SET detalle = ? WHERE id_marca = ?');
        $query->execute(array($reseña->detalle, $reseña->id_marca));
        $rowCount = $query->rowCount();
        return $rowCount;
    }

    function deleteReseña($idMarca){

        $reseña = $this->getReseña($idMarca);

        if($reseña){
            $query = $this->db->prepare('DELETE FROM reseñas_marcas WHERE id_marca = ?');
            $query->execute([$reseña->id_marca]);

            return $query->rowCount(); 
        }else{
            return 0;
        }
        
    }

    
}