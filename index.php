<?php

  use Phalcon\Mvc\Micro;
  use Phalcon\Loader;
  use Phalcon\Di\FactoryDefault;
  use Phalcon\Mvc\Micro\Collection as MicroCollection;
  use Phalcon\Config\Adapter\Ini as ConfigIni;
  use Phalcon\Db\Adapter\Pdo\Mysql as MysqlAdapter;
  use Phalcon\Db\Adapter\Pdo\Sqlite as SqliteAdapter;
  use Phalcon\Mvc\Model\MetaData\Memory as MemoryMetaData;
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
  if ($config->database->engine == "mysql") {
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
  }
  elseif ($config->database->engine == "sqlite") {
    $di->set(
      "db",
      function () use($config) {
        return new SqliteAdapter(['dbname' => $config->database->dbname]);
      }
    );
  }
  $di->set(
    "metadata",
    function() {
      $metadata = new MemoryMetaData();
      return $metadata;
    }
  );
  $di->set(
    "packer",
    "StabDex\\Utils\\Packer",
    true
  );
  $di->set(
    "parser",
    "StabDex\\Utils\\Parser",
    true
  );
  $di->set(
    "url",
    function () {
      $url = new Url();
      $api_root = substr(__DIR__, strlen($_SERVER["DOCUMENT_ROOT"]));
      $url->setBaseUri($api_root);
      return $url;
    }
  );
  $di->set(
    "testsEP",
    function () { return "/tests";}
  );
  $di->set(
    "pokemonsEP",
    function () { return "/pokemons";}
  );
  $di->set(
    "typesEP",
    function () { return "/types";}
  );
  $di->set(
    "abilitiesEP",
    function () { return "/abilities";}
  );
  $app = new Micro($di);

  // Controller grouped routes.
  $tests = new MicroCollection();
  $tests->setHandler("StabDex\\Controllers\\TestsController", true);
  $tests->setPrefix($di->get("testsEP"));
  $tests->get("/lexer/url/{str}", "lexerTest1");
  $tests->get("/lexer/query", "lexerTest2");
  $tests->get("/lexer/loop", "lexerTest3");
  $app->mount($tests);
  
  $pokemons = new MicroCollection();
  $pokemons->setHandler("StabDex\\Controllers\\PokemonsController", true);
  $pokemons->setPrefix($di->get("pokemonsEP"));
  $pokemons->get("/", "getAll");
  $pokemons->get("/name/{name:[a-zA-Z\-]+}", "getName");
  $pokemons->get("/pmid/{id:[0-9]+}", "getID");
  $pokemons->get("/stats/{stat:height|weight|htp|atk|def|sak|sdf|spd|total}", "getStats");
  $app->mount($pokemons);
  
  $types = new MicroCollection();
  $types->setHandler("StabDex\\Controllers\\TypesController", true);
  $types->setPrefix($di->get("typesEP"));
  $types->get("/", "getAll");
  $types->get("/{name:[a-zA-Z\-]+}", "getName");
  $types->get("/{id:[0-9]+}", "getID");
  $app->mount($types);
  
  // some simple routes.
  $app->notFound(
    function () use ($app) {
      $app->response->setStatusCode(404, "Not Found");
      $app->response->sendHeaders();
      $uri = $app->request->getURI();
      echo "Sorry, \"$uri\" was not found!";
    }
  );
  $app->get(
    "/",
    function () use($app) {
      echo "<h1>Welcome!</h1>";
    }
  );

  $app->handle();