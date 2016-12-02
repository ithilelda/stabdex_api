<?php

  use Phalcon\Mvc\Micro;
  use Phalcon\Loader;
  use Phalcon\Di\FactoryDefault;
  use Phalcon\Mvc\Micro\Collection as MicroCollection;
  use Phalcon\Config\Adapter\Ini as ConfigIni;
  use Phalcon\Db\Adapter\Pdo\Mysql as MysqlAdapter;
  use Phalcon\Mvc\Url;
  
  $config = new ConfigIni("config/config.ini");
  $loader = new Loader();
  $loader->registerNamespaces(
    [
      "StabDex\\Models" => __DIR__ . "/models/",
      "StabDex\\Controllers" => __DIR__ . "/controllers/",
      "StabDex\\Utils" => __DIR__ . "/utils/",
    ]
  )->register();
  $di = new FactoryDefault();
  $di->set(
    "config",
    function () use($config) {
        return $config;
    },
    true
  );
  $di->set(
    "db",
    function () use($config) {
      return new MysqlAdapter(
        [
            "host"     => $config->database->host,
            "username" => $config->database->username,
            "password" => $config->database->password,
            "dbname"   => $config->database->dbname,
        ]
      );
    }
  );
  $di->set(
    "packer",
    "StabDex\\Utils\\Packer",
    true
  );
  $di->set(
    "url",
    function () {
      $url = new Url();
      $url->setBaseUri("/api/a1");
      return $url;
    }
  );
  $app = new Micro($di);

  // Controller grouped routes.
  $pokemons = new MicroCollection();
  $pokemons->setHandler("StabDex\\Controllers\\PokemonsController", true);
  $pokemons->setPrefix($app->config->url->pokemons);
  $pokemons->get("/", "getAll");
  $pokemons->get("/{name:[a-zA-Z\-]+}", "getName");
  $pokemons->get("/{id:[0-9]+}", "getID");
  $app->mount($pokemons);
  
  $types = new MicroCollection();
  $types->setHandler("StabDex\\Controllers\\TypesController", true);
  $types->setPrefix($app->config->url->types);
  $types->get("/", "getAll");
  $types->get("/{name:[a-zA-Z\-]+}", "getName");
  $app->mount($types);
  
  // some simple routes.
  $app->notFound(
    function () use ($app) {
      $app->response->setStatusCode(404, "Not Found");
      $app->response->sendHeaders();
      echo "This is crazy, but this page was not found!";
    }
  );
  $app->get(
    "/",
    function () use($app) {
      echo "<h1>Welcome!</h1>";
    }
  );

  $app->handle();