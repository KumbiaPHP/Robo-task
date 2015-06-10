# Robo-task
Crear una tarea en robo, para automatizar pasar aplicaciones beta2 - v0.9 a v1.0

Robo es un manejador de tareas en php http://robo.li al estilo de Gulp en javascript.

Normalmente usaremos la tarea replace: http://robo.li/tasks/File/#replace para modificar los ficheros del directorio ``default`` o el nombre de la carpeta de la app.

También podemos compartir tareas que nos sean útiles para KumbiaPHP o para desarrollo.

Esta lista de cambios también es útil para quien quiera pasar sus apps manualmente.

## Cambios

Obsoletos (se usan igual)

- [ ] ``Router::redirect`` a ``Redirect::to``
- [ ] ``Router::toAction`` a ``Redirect::toAction``
- [ ] ``Router::route_to`` a ``Redirect::route_to``
- [ ] ``Flash::notice`` a ``Flash::info``
- [ ] ``Flash::success`` a ``Flash::valid()``
- [ ] ``Util::uncamelize`` a ``Util::smallcase``
- [ ] ``View::response('view')`` a ``View::template(null)``
- [ ] ``Util::mkpath()`` a ``FileUtil::mkdir()``
- [ ] ``Util::removedir()`` a ``FileUtil::rmdir()``
- [ ] ``Util::array_merge_overwrite($a1, $a2)`` a ``$a2 + $a1``
- [ ] ``Util::array_insert($array, $position, $insert)`` a ``array_splice($array, $position, 0, $insert)``
- [ ] ``Html::trClass()`` a ??  css



Eliminar

- [ ] ``Load::lib()``
- [ ] ``Load::coreLib()``
- [ ] ``View::helpers()``

Obsoleto (no se puede pasar de beta1 a 1.0) primera comprobación para informar y parar

- ApplicationController
- tags.php
- lib report


