# Robo-task
Robo es un manejador de tareas en php http://robo.li al estilo de Gulp en javascript.

Tareas listas para aplicaciones de KumbiaPHP

# Uso
Copiar `RoboFile.php` en la carpeta default (o carpeta de la aplicación), al lado de app y public.

Tener `Robo` instalado global (recomendado) o con composer.

En el directorio de la aplicación donde se ha copiado el RoboFile.php, usar estos comandos en la consola:


Comando | Acción
------- | ------
robo                    |  Lista los comandos
robo kumbia:cache-clean |  Limpia la cache de la app
robo kumbia:update      |  Copia la aplicación y la actualiza a v1.0 (no esta terminado)

TIP: Usa una aplicación DIFF para ver las diferencias entre las dos carpetas.

# Información sobre el progreso
Crear una tarea en robo, para automatizar pasar aplicaciones beta2 - v0.9 a v1.0

Robo es un manejador de tareas en php http://robo.li al estilo de Gulp en javascript.

Normalmente usaremos la tarea replace: http://robo.li/tasks/File/#replace para modificar los ficheros del directorio ``default`` o el nombre de la carpeta de la app.

También podemos compartir tareas que nos sean útiles para KumbiaPHP o para desarrollo.

Esta lista de cambios también es útil para quien quiera pasar sus apps manualmente.

## Cambios

Obsoletos (se usan igual)

- [x] ``Router::redirect`` a ``Redirect::to``
- [x] ``Router::toAction`` a ``Redirect::toAction``
- [x] ``Router::route_to`` a ``Redirect::route_to``
- [x] ``Flash::notice`` a ``Flash::info``
- [x] ``Flash::success`` a ``Flash::valid()``
- [x] ``Util::uncamelize`` a ``Util::smallcase``
- [x] ``View::response('view')`` a ``View::template(null)``
- [ ] ``Util::mkpath()`` a ``FileUtil::mkdir()``
- [ ] ``Util::removedir()`` a ``FileUtil::rmdir()``
- [ ] ``Util::array_merge_overwrite($a1, $a2)`` a ``$a2 + $a1``
- [ ] ``Util::array_insert($array, $position, $insert)`` a ``array_splice($array, $position, 0, $insert)``
- [ ] ``Html::trClass()`` a ??  css



Eliminar

- [ ] ``Load::lib()``
- [ ] ``Load::coreLib()``
- [ ] ``Load::models()``
- [ ] ``View::helpers()``

Obsoleto (no se puede pasar de beta1 a 1.0) primera comprobación para informar y parar

- extends ApplicationController
- tags.php
- lib report

Falta documentar cambios de:

- timezone
- locale
- encoding
- error_reporting (posiblemente)

