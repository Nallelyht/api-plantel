<?php
/*
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/../vendor/autoload.php';

session_start();

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

// Register middleware
require __DIR__ . '/../src/middleware.php';

// Register routes
require __DIR__ . '/../src/routes.php';

// Run app
$app->run();
*/
error_reporting(0);
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
spl_autoload_register(function ($classname) {
    require ("../src/classes/" . $classname . ".php");
});

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$config['db']['host']   = "127.0.0.1";
$config['db']['user']   = "root";
$config['db']['pass']   = "admin0112358";
$config['db']['dbname'] = "plantel";

$app = new \Slim\App(["settings" => $config]);
$container = $app->getContainer();

$container['db'] = function ($c) {
    $db = $c['settings']['db'];
    $pdo = new PDO("mysql:host=" . $db['host'] . ";dbname=" . $db['dbname'].";charset=utf8",  $db['user'], $db['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
    return $pdo;
};

$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});



//Catálogo de giros
$app->get("/alumnos/lista", function(Request $request, Response $response, $args){
    $utils = new AlumnoController($this->db);
    $res = $utils->getAlumnos();
  
    $response = $response->withJson($res);
    return $response;
});


$app->post("/alumnos/agregar",  function(Request $request, Response $response){
    $data = $request->getParsedBody();

    $object = new stdClass();
    foreach ($data as $key => $value)
    {
        $object->$key = $value;
    }
    $eventoController = new AlumnoController($this->db);
    $res = $eventoController->addAlumno($object);
  
    $response = $response->withJson($res);
    return $response;
});



$app->post("/alumnos/actualizar",  function(Request $request, Response $response){
    $data = $request->getParsedBody();

    $object = new stdClass();
    foreach ($data as $key => $value)
    {
        $object->$key = $value;
    }
    $eventoController = new AlumnoController($this->db);
    $res = $eventoController->actualizarAlumno($object);
  
    $response = $response->withJson($res);
    return $response;
});



$app->post("/alumnos/eliminar",  function(Request $request, Response $response){
    $data = $request->getParsedBody();

    $object = new stdClass();
    foreach ($data as $key => $value)
    {
        $object->$key = $value;
    }
    $eventoController = new AlumnoController($this->db);
    $res = $eventoController->eliminarAlumno($object);
    
    $response = $response->withJson($res);
    return $response;
});

//Catálogo de giros
$app->get("/grupo/lista", function(Request $request, Response $response, $args){
    $utils = new GrupoController($this->db);
    $res = $utils->getGrupos();
    $response = $response->withJson($res);
    return $response;
});

/*

$app->get("/grupo/listaAlumnos", function(Request $request, Response $response, $args){
    $utils = new GrupoController($this->db);
    $res = $utils->getGrupos();
    $response = $response->withJson($res);
    return $response;
});


$app->post("/alumnos/asignar",  function(Request $request, Response $response){
    $data = $request->getParsedBody();

    $object = new stdClass();
    foreach ($data as $key => $value)
    {
        $object->$key = $value;
    }
    $eventoController = new AlumnoController($this->db);
    $res = $eventoController->actualizarAlumno($object);
  
    $response = $response->withJson($res);
    return $response;
});

*/



$app->run();
