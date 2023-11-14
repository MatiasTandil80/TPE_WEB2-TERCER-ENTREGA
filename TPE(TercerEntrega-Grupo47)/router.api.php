<?php
require_once './libs/router.class.php';
require_once './app/controllers/api.modelos.controller.php';

$router = new Router();

//Armo la tabla de Ruteo de la Api Rest
$router->addRoute('modelos', 'GET', 'ApiModelosController', 'getModelos');
$router->addRoute('modelos', 'POST', 'ApiModelosController', 'insertModelo');
$router->addRoute('modelos/:ID', 'PUT', 'ApiModelosController', 'updateModelo');
$router->addRoute('modelos/:ID', 'DELETE', 'ApiModelosController', 'deleteModelo');

$router->addRoute('marcas', 'GET', 'ApiModelosController', 'getMarcas');
$router->addRoute('marcas', 'POST', 'ApiModelosController', 'insertMarca');
$router->addRoute('marcas/:ID', 'PUT', 'ApiModelosController', 'updateMarca');
$router->addRoute('marcas/:ID', 'DELETE', 'ApiModelosController', 'deleteMarca');

$router->addRoute('reseñas', 'GET','ApiModelosController', 'getReseñasMarcas' );
$router->addRoute('reseñas', 'POST','ApiModelosController', 'insertReseñaMarca' );
$router->addRoute('reseñas/:ID', 'PUT', 'ApiModelosController', 'updateReseñaMarca');
$router->addRoute('reseñas/:ID', 'DELETE', 'ApiModelosController', 'deleteReseñaMarca');

// rutea
$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);