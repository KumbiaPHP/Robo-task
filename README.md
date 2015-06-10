# Robo-task
Crear una tarea en robo, para automatizar pasar aplicaciones beta2 - v0.9 a v1.0

Robo es un manejador de tareas en php http://robo.li al estilo de Gulp en javascript.

Normalmente usaremos la tarea replace: http://robo.li/tasks/File/#replace para modificar los ficheros del directorio ``default`` o el nombre de la carpeta de la app.

Esta lista de cambios también es útil para quien quiera pasar sus apps manualmente.

## Cambios

- [ ] ``Router::redirect`` a ``Redirect::to``
- [ ] ``Router::toAction`` a ``Redirect::toAction``
- [ ] ``Router::route_to`` a ``Redirect::route_to``
- [ ] ``Flash::notice`` a ``Flash::info``
- [ ] ``Flash::success`` a ``Flash::valid()``
