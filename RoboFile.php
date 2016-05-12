<?php
/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see http://robo.li/
 */
use Symfony\Component\Finder\Finder;
use Symfony\Component\Filesystem\Filesystem;

class RoboFile extends \Robo\Tasks
{
    private $newdir;
    private $suffix = '1.0';
    private $files;
    private $changes = array(
        'Router::toAction(' => 'Redirect::toAction(',
        'Router::to(' => 'Redirect::to(',
        'Router::route_to(' => 'Redirect::intern(',
        'Flash::notice(' => 'Flash::info(',
        'Flash::success(' => 'Flash::valid(',
        'Util::uncamelize(' => 'Util::smallcase(',
        "View::response('view')" => "View::template(null)"
    );
    private $delete = array();
	private $reemplazo = array();
	private $reemplaza = array();
	
    // define public methods as commands
    /**
    * @description Convertir una app beta2-0.9 a 1.0
    */
    public function kumbiaUpdate() {
        $this->say('<info>Actualizando aplicación de KumbiaPHP a v1.0</info>');
        $this->newdir = __DIR__.$this->suffix;
        $exist = file_exists($this->newdir) ? 'Existe':'No existe';
        $this->say($exist);
        if($exist === 'No existe') {
            $this->say('<info>Copiando</info> '.__DIR__.' en '.$this->newdir);
            $this->_copyDir(__DIR__, $this->newdir);
        }
        //$this->dir($this->newdir);
        $this->files();
        $this->kumbiaChanges();
    }
    private function kumbiaChanges() {
        foreach($this->changes as $from=>$to) {
            $this->say("Cambiando $from a $to");
            foreach($this->files as $file) {
                $this->taskReplaceInFile($file)
                     ->from($from)
                     ->to($to)
                     ->run();
            }
        }
    }
    private function kumbiaDelete() {
        $this->say('Eliminando Router::to() a Redirect::to()');
        foreach($this->files as $file) {
            $this->taskReplaceInFile($file)
                 ->from('Router::toAction')
                 ->to('Redirect::toAction')
                 ->run();
        }
    }
    private function files($dir = '/app', $extension = '*.php') {
        $this->files = Finder::create()
            ->name($extension)
            ->in($this->newdir.$dir);
        $this->say(count($this->files).' ficheros');
    }
    /**
    * @description Borrar la cache de la applicación
    */
    public function kumbiaCacheClean() {
        $this->_cleanDir('app/temp/cache');
        $this->say('<info>Cache borrada.</info>');
    }
    /**
    * @description Actualiza <?php echo a <?= (PHP 5.4+)
    */
    public function kumbiaEchoShort($dir = 'app/views', $extension = "*.phtml"){
      $this->say('<info>actualizando <?php echo a <?=</info>');
      $this->files($dir, $extension);
      foreach ($this->files as $file) {
          $this->taskReplaceInFile($file->getRealPath())
          ->from('<?php echo ')
          ->to('<?= ')
          ->run();
      }
      $this->say('<info>echo actualizado a php 5.4.</info>');
    }
	
	
	
	public function kumbiaCreateScaffoldController($controllerName, $modelName, $extendsFrom = 'AppController', $template = 'tpl')
	{
		$controllerName = strtolower($controllerName);
        $file = "app/controllers/{$controllerName}_controller.php";
        $viewsDir = "app/views/{$controllerName}";
        $fs = new Filesystem();
        if (!$fs->exists($file)) {
	        $this->say("<info>Creando Controlador $controllerName</info>");
	        //crear archivo
	        $fs->touch($file);
	        //escribir template
	        $controllerName = ucfirst($controllerName);
			$modelName = ucfirst($modelName);
			
			$fs->touch($file);

			//crear archivo a partir del template
			$this->taskWriteToFile($file)
			    ->textFromFile("templates/controller.{$template}.php")
			    ->run();
			
			//reemplazar elementos
			$reemplazar = array('%Item%','%BaseController%','%Model%','%lcaseModels%','%lcaseModel%');
			
			$reemplazo = array(
				 $controllerName, 
				 $extendsFrom,
				 $modelName,
				 strtolower($modelName) . 's',
				 strtolower($modelName),
			);
			
			$this->taskReplaceInFile($file)
					->from($reemplazar)
					->to($reemplazo)
					->run();
			
			$this->say("<info>Controlador $controllerName ha sido creado</info>");	
		} else {
			$this->say("<error>Controlador $controllerName ya existía!</error>");	
		}
        if (!$fs->exists($viewsDir)) {
          $fs->mkdir($viewsDir);
          $this->say("<info>Carpeta de Vistas creada en {$viewsDir}</info>");
        } else {
          $this->say("<error>Carpeta de Vistas ya existía en {$viewsDir}</error>");
        }
	}
	
	
    /**
    * @description Crea un controlador sencillo y su carpeta de vistas
    *
    * @param string $controllerName Nombre del controlador
    */
    public function kumbiaCreateController($controllerName, $baseController = 'AppController') {
      $controllerName = strtolower($controllerName);
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
	   	    ->textFromFile("templates/controller.simple.tpl.php")
	   	    ->run();
	
	   	//reemplazar elementos
	   	$reemplazar = array('%Item%','%BaseController%');
	
	   	$reemplazo = array(
	   		 $controllerName,
	   		 $baseController
	   	);
	
	   	$this->taskReplaceInFile($file)
	   			->from($reemplazar)
	   			->to($reemplazo)
	   			->run();
	
        $this->say("<info>Controlador creado en {$file}</info>");

      } else {
        $this->say("<error>Controlador ya existía en {$file}</error>");
      }
	  
	  //crear directorio para las vistas del controlador
      if (!$fs->exists($viewsDir)) {
        $fs->mkdir($viewsDir);
        $this->say("<info>Carpeta de Vistas creada en {$viewsDir}</info>");
      } else {
        $this->say("<error>Carpeta de Vistas ya existía en {$viewsDir}</error>");
      }
    }

  /**
   * @description Crea un modelo, por defecto de ActiveRecord
   *
   * @param string $modelName Nombre del modelo
   */
  public function kumbiaCreateModel($modelName, $modelClass = 'ActiveRecord') {
    $modelName = strtolower($modelName);
    $file = "app/models/{$modelName}.php";
    $fs = new Filesystem();
    if (!$fs->exists($file)) {
      $this->say("<info>Creando Modelo</info>");
      //crear archivo
      $fs->touch($file);
      //escribir template
      $modelName = ucfirst($modelName);
	//crear archivo a partir del template
	$this->taskWriteToFile($file)
	    ->textFromFile("templates/model.tpl.php")
	    ->run();
	
	//reemplazar elementos
	$reemplazar = array('%Model%','%ModelExtends%');
	
	$reemplazo = array(
		 $modelName,
		 $modelClass
	);
	
	$this->taskReplaceInFile($file)
			->from($reemplazar)
			->to($reemplazo)
			->run();
	
      $this->say("<info>Modelo creado en {$file}</info>");
    } else {
      $this->say("<error>Modelo ya existía en {$file}</error>");
    }
  }

  public function kumbiaCreateView($controller, $accion, $formato = 'tpl') {
    $file = "app/views/{$controller}/{$accion}.phtml";
    $viewsDir = "app/views/{$controller}";
    $fs = new Filesystem();
	
    if (!$fs->exists($file)) {
      $this->say("<info>Creando Vista</info>");
      //crear archivo
      $fs->touch($file);
      //escribir template
      
      $this->taskWriteToFile($file)
  	    ->textFromFile("templates/{$formato}/view.{$accion}.phtml")
  	    ->run();	
  	
  	  $this->taskReplaceInFile($file)
  			->from($this->reemplaza)
  			->to($this->reemplazo)
  			->run();
      $this->say("<info>Vista creada en {$file}</info>");
    } else {
      $this->say("<error>Vista ya existía en {$file}</error>");
    }      
  }
  

  /**
   * @description Consola Interactiva para crear Scaffolds Estáticos
   *
   */
  public function kumbiaScaffoldConsole()
  {
      $this->say("<info>Bienvenido al generador de Cruds</info>");
      
      $seguir = "s";
      while ($seguir === "s") {
        $modelo = "";
        $modelo = $this->ask("Indique nombre del modelo: ");
        
        $this->say("<info>Modelo extiende de [ActiveRecord|LiteRecord|ActRecord]</info>");
        $formatoModelo = $this->ask("Modelo extiende: ");
        $formatoController = "lite";
        
        if (strlen(trim($formatoModelo)) == 0 ) {
        	$formatoModelo = "ActiveRecord";
        	$formatoController = "tpl";
        }

        if ($this->ask("Generar archivo del Modelo (s/n): ") === "s") {       
            $modelo = strtolower($modelo);
            $this->kumbiaCreateModel($modelo,$formatoModelo);
        }

        $modelo_class = ucfirst($modelo);
        $modelo_input = strtolower($modelo);

        $controlador = $this->ask("Nombre de clase para controlador (sin sufijo Controller): ");
        $controlador_archivo = strtolower($controlador) . "_controller.php";
        $extiendeDe = $this->ask("Controlador hereda de [AppController]: ");
        if (strlen($extiendeDe) == 0) {
            $extiendeDe = "AppController";
        }
        
        
        if ($this->ask("Crear acciones del CRUD predeterminadas (s/n): ") === "s") {       
            $this->kumbiaCreateScaffoldController($controlador, $modelo, $extiendeDe, $formatoController);
        } else {
        	$this->kumbiaCreateController($controlador, $extiendeDe);
        }
        
        //crear vistas
        if ($this->ask("Crear vistas CRUD predeterminadas? (s/n)") === "s") {
            $this->say("<info>Indique los atributos separados por coma (no indique id)</info>");
            $atributos = $this->ask("Atributos: ");
            
			if (strpos($atributos, ",") != FALSE) {
				$atributos_arr = explode(",", $atributos);
			} else {
				$atributos_arr = array($atributos); //elemento unico
			}
			
            $this->say("<info>Indique formato de las vitas [tpl]</info>");
            $formato = $this->ask("Formato: ");
			
			if (strlen(trim($formato)) == 0 ) {
				$formato = "tpl";
			}
			
            
            $cListHead = "";
			$cListBody = "";
			$cFormContent = "";
			$cTextContent = "";
            for($i = 0; $i < count($atributos_arr); $i++) {
                $atributos_arr[$i] = trim(strtolower($atributos_arr[$i]));
				$cListHead .= "<th>" . $atributos_arr[$i] . "</th>" . PHP_EOL;
				$cListBody .= '<td><?= $fila->' . $atributos_arr[$i] . ';?></td>' . PHP_EOL;
				
				$cFormContent .= "<p>" . PHP_EOL;
				$cFormContent .= "<strong>" . ucfirst($atributos_arr[$i]) . "</strong><br/>" . PHP_EOL;
				$cFormContent .= "<?= Form::text('" . $modelo . "." . $atributos_arr[$i] . "');?>" . PHP_EOL;
				$cFormContent .= "</p>" . PHP_EOL;
				
				$cTextContent .= "<p>" . PHP_EOL;
				$cTextContent .= "<strong>" . ucfirst($atributos_arr[$i]) . "</strong><br/>" . PHP_EOL;
				$cTextContent .= "<span><?= $" . $modelo ."->" . $atributos_arr[$i] . ";?></span>" . PHP_EOL;
				$cTextContent .= "</p>" . PHP_EOL;
				
            }
            
			//contenido para index
			$this->reemplaza = array("%Model%","%lcaseModels%","%columnListHead%","%columnListBody%");
			$this->reemplazo = array(ucfirst($modelo), $modelo . "s", $cListHead, $cListBody);
			$this->kumbiaCreateView(strtolower($controlador), "index", $formato);            
            
			//contenido para add
			$this->reemplaza = array("%Model%","%formContent%");
			$this->reemplazo = array(ucfirst($modelo), $cFormContent);
            $this->kumbiaCreateView(strtolower($controlador), "add", $formato);
            
            //contenido para edit
            $this->reemplaza = array("%Model%","%formContent%","%lcaseModel%");
			$this->reemplazo = array(ucfirst($modelo), $cFormContent, strtolower($modelo));            
            $this->kumbiaCreateView(strtolower($controlador), "edit", $formato);
			
			//contenido para show
			$this->reemplaza = array("%Model%","%lcaseModel%","%textContent%");
			$this->reemplazo = array(ucfirst($modelo), $modelo, $cTextContent);
			$this->kumbiaCreateView(strtolower($controlador), "show", $formato);
        }
        
        
        $seguir = $this->ask("Crear otro CRUD (s/n): ");
        
        
      }
      $this->say("<info>Hasta pronto!</info>");          
  }
}
