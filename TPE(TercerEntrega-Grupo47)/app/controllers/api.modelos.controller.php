<?php
require_once './app/models/modelos.model.php';
require_once './app/models/marcas.model.php';
require_once './app/models/reseñas.marcas.model.php';
require_once 'api.controller.php';

class ApiModelosController extends ApiController{

    private $model;         //Model que toma los Modelos de Motos
    private $modelMarcas;   //Model que toma las Marcas de Motos
    private $modelReseñas;  //Model que toma las Reseñas de las Marcas

    function __construct(){
        parent::__construct();
        $this->model = new ModelosModel();
        $this->modelMarcas = new MarcasModel();
        $this->modelReseñas = new ReseñasModel();

    }

    private function campoValidoModelos($campo){

        $camposModelos = ["id_marca","nombre", "cilindrada_cm3", "tipo", "potencia_hp", "peso_kg"];



        return in_array($campo, $camposModelos);

    }

    public function getModelos($params = null){

        $id= $_GET['id']??null;
        
        if($id!=null){//consulta por id y retorna
            $modelo = $this->model->getModelo($id);
            
            if(!empty($modelo))
                $this->view->response($modelo, 200);
            else
                $this->view->response("La moto con el id:$id no existe", 404);

            return;
        }
        
        $filterField=null;
        $filterValue=null;
        if(isset($_GET['filterBy'])){
        
            $arrFilter=explode('=',$_GET['filterBy']);
           
            if($this->campoValidoModelos($arrFilter[0])){
                $filterField=$arrFilter[0];
                $filterValue=$arrFilter[1];
            }else{
                $this->view->response("Filtro no Valido. Se realiza consulta general", 400);
            }
            
        }

        $orderField=null;
        $orderValue=null;
        if(isset($_GET['orderBy'])){
            $arrOrder=explode('=',$_GET['orderBy']);
          
            if($this->campoValidoModelos($arrOrder[0])&&(($arrOrder[1]=="ASC")||($arrOrder[1]=="DESC"))){
                $orderField=$arrOrder[0];
                $orderValue=$arrOrder[1];
            }else{
                $this->view->response("Orden no Valido. Se realiza consulta general", 400);   
            }
        }

        //consulta con criterios                //filter                    //order
        $modelos = $this->model->getModelos($filterField,$filterValue,$orderField,$orderValue);
        

            if($modelos!=null){
                //paginado
                $offset= 0;
                $pagination=count($modelos);
                
                if(isset($_GET['offset'])&&(isset($_GET['pagination']))&&($_GET['offset'] > 0)&&($_GET['offset'] <= $_GET['pagination'])){
                    $offset= $_GET['offset']-1;
                    $pagination=$_GET['pagination'];
                }

                if(!isset($_GET['offset'])&&(isset($_GET['pagination']))){
                    $pagination=$_GET['pagination'];
                }

                if(isset($_GET['offset'])&&(!isset($_GET['pagination']))&&($_GET['offset'] > 0)&&($_GET['offset'] <= $pagination)){

                    $offset= $_GET['offset']-1;
                    
                }
                $subarreglo = array_slice($modelos, $offset, $pagination);

                if(isset($subarreglo)){// Si hubo paginado
                    $this->view->response($subarreglo, 200);
                }else{
                    $this->view->response($modelos, 200);
                }
                
            }else{
                $this->view->response("No existe modelos para ese criterio", 404);
            }
            return;  
            
       
    }

    public function insertModelo($params = null){
        // devuelve el objeto JSON enviado por POST
        $body = $this->getData();

        if (empty($body->id_marca) || empty($body->nombre)|| empty($body->cilindrada_cm3)|| empty($body->tipo)|| empty($body->potencia_hp)|| empty($body->peso_kg)) {
            $this->view->response("Complete los datos", 400);
        } else {
            
            $id_marca=$body->id_marca;
            $nombre=$body->nombre;
            $cilindrada_cm3=$body->cilindrada_cm3;
            $tipo=$body->tipo;
            $potencia_hp=$body->potencia_hp; 
            $peso_kg=$body->peso_kg;

            $id =$this->model->insertModelo($id_marca, $nombre, $cilindrada_cm3, $tipo, $potencia_hp, $peso_kg);
           
            //Devolvemos el recurso creado
            $modelo = $this->model->getModelo($id);
           
            if($modelo){
                $this->view->response($modelo, 201);
            }else{
                $this->view->response("Ese modelo ya existe", 404);
            }
            
        }

    }
 
    public function updateModelo($params = null) {
        $id = $params[':ID'];
        $modelo = $this->model->getModelo($id);

        if($modelo) {
            $body = $this->getData();
            
            $newmodelo=new StdClass();
            
            $newmodelo->id=$id;
            if(isset($body->id_marca)){
                $newmodelo->id_marca=$body->id_marca;
            }else{
                $newmodelo->id_marca=$modelo->id_marca;
            }

            if(isset($body->nombre)){
                $newmodelo->nombre=$body->nombre;
            }else{
                $newmodelo->nombre=$modelo->nombre;
            } 
            
            if(isset($body->cilindrada_cm3)){
                $newmodelo->cilindrada_cm3=$body->cilindrada_cm3;
            }else{
                $newmodelo->cilindrada_cm3=$modelo->cilindrada_cm3;
            }   
            
            if(isset($body->tipo)){
                $newmodelo->tipo=$body->tipo;
            }else{
                $newmodelo->tipo=$modelo->tipo;
            }  
            
            if(isset($body->potencia_hp)){
                $newmodelo->potencia_hp=$body->potencia_hp;
            }else{
                $newmodelo->potencia_hp=$modelo->potencia_hp;
            }  
            
            if(isset($body->peso_kg)){
                $newmodelo->peso_kg=$body->peso_kg;
            }else{
                $newmodelo->peso_kg=$modelo->peso_kg;
            }
            $this->model->updateModelo($newmodelo);

            $this->view->response('La moto con id='.$id.' ha sido modificada.', 200);
        } else {
            $this->view->response('La moto con id='.$id.' no existe.', 404);
        }
    }

    function deleteModelo($params = null){
        $id = $params[':ID'];
        $modelo = $this->model->deleteModelo($id);

        if($modelo >0){//pregunto por el num de filas afectadas por el borrado
            $this->view->response('La moto con id='.$id.' ha sido borrada.', 200);
        } else {
            $this->view->response('La moto con id='.$id.' no existe.', 404);
        }

    }

    public function getMarcas($params = null){
        
        if(isset($_GET['id'])){//consulta por id y retorna
            $id= $_GET['id'];
            $marca = $this->modelMarcas->getMarca($id);
            
            if(!empty($marca))
                $this->view->response($marca, 200);
            else
                $this->view->response("La marca con el id:$id no existe", 404);

            return;
        }


        $marcas = $this->modelMarcas->getMarcas();//get general
        if(!empty($marcas))
            $this->view->response($marcas, 200);
        else
            $this->view->response("La base está vacía", 404);
            
    }

    public function insertMarca($params = null){
        // devuelve el objeto JSON enviado por POST
        $body = $this->getData();

        if (empty($body->nombre)|| empty($body->origen)|| empty($body->año_fundacion)|| empty($body->cant_empleados)|| empty($body->produccion_anual) || empty($body->facturacion_M_USD)) {
            $this->view->response("Complete los datos", 400);
        } else {
            
            $nombre = $body->nombre; 
            $origen =  $body->origen;
            $año_fundacion =  $body->año_fundacion;
            $cant_empleados =  $body->cant_empleados;
            $produccion_anual =  $body->produccion_anual;
            $facturacion_M_USD = $body->facturacion_M_USD;

            $id =$this->modelMarcas->insertMarca($nombre, $origen, $año_fundacion, $cant_empleados, $produccion_anual, $facturacion_M_USD);
            //Devolvemos el recurso creado
            $marca = $this->modelMarcas->getMarca($id);
            
            if($marca){
                $this->view->response($marca, 201);
            }else{
                $this->view->response("Esa marca ya existe", 404);
            }
            

        }

    }

    public function updateMarca($params = null) {
        $id = $params[':ID'];
        $marca = $this->modelMarcas->getMarca($id);

        if($marca) {
            $body = $this->getData();
            
            $newmarca=new StdClass();
           
            $newmarca->id=$id;
            
            if(isset($body->nombre)){
                if($body->nombre==$marca->nombre){
                    $newmarca->nombre=$body->nombre;
                }else{
                    if($this->modelMarcas->existNameMarca($body->nombre)){
                        $this->view->response("La marca con nombre: $body->nombre ya existe.", 404);
                        $newmarca->nombre=$marca->nombre;
                    }else{
                        $newmarca->nombre=$body->nombre;
                    }
                    
                }
            }
            else
                $newmarca->nombre=$marca->nombre;
            
            if(isset($body->origen))
                $newmarca->origen=$body->origen;
            else
                $newmarca->origen=$marca->origen;

            if(isset($body->año_fundacion))
                $newmarca->año_fundacion=$body->año_fundacion;
            else
                $newmarca->año_fundacion=$marca->año_fundacion;                
            
            if(isset($body->cant_empleados))
                $newmarca->cant_empleados=$body->cant_empleados;
            else
                $newmarca->cant_empleados=$marca->cant_empleados;                
            
            if(isset($body->produccion_anual))
                $newmarca->produccion_anual=$body->produccion_anual;
            else
                $newmarca->produccion_anual=$marca->produccion_anual;                
                
            if(isset($body->facturacion_M_USD))
                $newmarca->facturacion_M_USD=$body->facturacion_M_USD;
            else
                $newmarca->facturacion_M_USD=$marca->facturacion_M_USD;                

            $this->modelMarcas->updateMarca($newmarca);

            $this->view->response('La marca con id='.$id.' ha sido modificada.', 200);
        } else {
            $this->view->response('La marca con id='.$id.' no existe.', 404);
        }
    }

    function deleteMarca($params = null){
        $id = $params[':ID'];
        $marca = $this->modelMarcas->deleteMarca($id);
        
        if($marca >0){//pregunto por el num de filas afectadas por el borrado
            $this->view->response('La marca con id='.$id.' ha sido borrada.', 200);
        } else {
            $this->view->response('La marca con id='.$id.' no existe.', 404);
        }

    }


    function getReseñasMarcas($params = null){

        if(isset($_GET['id'])){//consulta por nombre
            $id= $_GET['id'];
            $reseña = $this->modelReseñas->getReseña($id);
            
            if(!empty($reseña))
                $this->view->response($reseña, 200);
            else
                $this->view->response("La reseña con el id de marca: $id no existe", 404);

            return;
        }

        $reseñas= $this->modelReseñas->getReseñas();
            
        if(!empty($reseñas))
            $this->view->response($reseñas, 200);
        else
            $this->view->response("La tabla reseñas está vacía", 404);
        
    }

    function updateReseñaMarca($params = null){

        /*
        {
        "idMarca": "140",
        "detalle": "Esta fabrica fue hecha con mucho esfuerzo"
         }
         */

        if(isset($params[':ID'])){

                $id=$params[':ID'];
                $body = $this->getData();
                
                $reseña = $this->modelReseñas->getReseña($id);




                if(($reseña!=null)&&(isset($body->detalle))){
                    $reseña->detalle=$body->detalle;
                    $num= $this->modelReseñas->updateReseña($reseña);
                    $this->view->response("La marca $id fue modificada", 200);
                }else{
                        if($this->modelMarcas->existIdMarca($id)==null){
                            $this->view->response("La marca con id: $id no existe", 404);    
                        }else{
                            if(!isset($body->detalle)){
                                $this->view->response("Debe ingresar un detalle para la reseña", 400);
                            }else{
                                $this->view->response("La marca con id: $id no posee reseña", 404);
                            }
                                
                        }
                        
                
                }
            }

    }

    function deleteReseñaMarca($params = null){

        if(!empty($params[':ID'])){
            $id = $params[':ID'];
            $deletedRows = $this->modelReseñas->deleteReseña($id);
            if($deletedRows){
                $this->view->response("La reseña con id de marca: $id fue borrada", 200);
            }else{
                $this->view->response("La marca con id: $id no posee reseña", 404);
            }
    
        }       
    }

    function insertReseñaMarca($params = null){

        /*
        {
        "id_marca": "140",
        "detalle": "Esta fabrica fue hecha con mucho esfuerzo"
         }
         */

         $body = $this->getData();

         if(!isset($body->detalle)||(!isset($body->id_marca))){
            $this->view->response("Debe completar los campos", 400);
            return;
         }

         $reseña = $this->modelReseñas->getReseña($body->id_marca);
         
         $existIdMarca = $this->modelMarcas->existIdMarca($body->id_marca);
         
         if(($existIdMarca > 0)){
                if(!$reseña){
                    $newReseña = new StdClass();
                    $newReseña->detalle = $body->detalle;
                    $newReseña->id_marca = $existIdMarca;
                    $num= $this->modelReseñas->insertReseña($newReseña);
                    $this->view->response("La reseña de $body->id_marca fue insertada", 201);
                }else{
                    $this->view->response("La marca con id: $body->id_marca ya posee reseña", 404);
                }
        }else{
                    $this->view->response("La marca con id: $body->id_marca no existe", 404);
                
        }

    }
}