<?php
/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see http://robo.li/
 */
use Symfony\Component\Filesystem\Filesystem;

class RoboFile extends \Robo\Tasks
{
    /* permite crear un controllador sencillo y su respectiva carpeta en views*/
    public function kumbiaCreateController($controllerName) {
      $file = "app/controllers/{$controllerName}_controller.php";
      $viewsDir = "app/views/{$controllerName}";
      $fs = new Filesystem();
      if (!$fs->exists($file)) {
        $this->say("<info>Creando Controlador</info>");
        //crear archivo
        $fs->touch($file);
        //escribir template
        $controllerName = ucfirst($controllerName);
        $this->taskWriteToFile($file)
           ->line("<?php")
           ->line("\tclass {$controllerName}Controller extends AppController {")
           ->line("\t\t")
           ->line("\t}")
           ->run();
        //crear directorio para las vistas
        $this->say("<info>Controlador creado en {$file}</info>");

      } else {
        $this->say("<error>Controlador ya existía en {$file}</error>");
      }
      if (!$fs->exists($viewsDir)) {
        $fs->mkdir($viewsDir);
        $this->say("<info>Carpeta de Vistas creada en {$viewsDir}</info>");
      } else {
        $this->say("<error>Carpeta de Vistas ya existía en {$viewsDir}</error>");
      }
    }

  /* permite crear un modelo ActiveRecord */
  public function kumbiaCreateModel($modelName, $modelClass = 'ActiveRecord') {
    $file = "app/models/{$modelName}.php";
    $fs = new Filesystem();
    if (!$fs->exists($file)) {
      $this->say("<info>Creando Modelo</info>");
      //crear archivo
      $fs->touch($file);
      //escribir template
      $modelName = ucfirst($modelName);
      $this->taskWriteToFile($file)
         ->line("<?php")
         ->line("\tclass {$modelName} extends {$modelClass} {")
         ->line("\t\t")
         ->line("\t}")
         ->run();

      $this->say("<info>Modelo creado en {$file}</info>");
    } else {
      $this->say("<error>Modelo ya existía en {$file}</error>");
    }
  }

  /* permite crear un controllador scaffold para un modelo particular */
  public function kumbiaCreateScaffoldController($controllerName, $modelName) {
    $file = "app/controllers/{$controllerName}_controller.php";
    $fs = new Filesystem();
    if (!$fs->exists($file)) {
      $this->say("<info>Creando Controlador</info>");
      //crear archivo
      $fs->touch($file);
      //escribir template
      $controllerName = ucfirst($controllerName);
      $this->taskWriteToFile($file)
         ->line("<?php")
         ->line("\tclass {$controllerName}Controller extends ScaffoldController {")
         ->line("\t\t" . 'public $model = "' . $modelName . '";')
         ->line("\t}")
         ->run();

      $this->say("<info>Controlador creado en {$file}</info>");
    } else {
      $this->say("<error>Controlador ya existía en {$file}</error>");
    }
    //verificar existencia del modelo, y en caso que no exista crearlo
    $modelFile = "app/models/{$modelName}.php";
    if (!$fs->exists($modelFile)) {
      $this->kumbiaCreateModel($modelName);
    }
  }
  
  


}
