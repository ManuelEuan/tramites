## Requerimientos para la instalación del sistema
- Servidor Apache
- PHP >= 7.2.5
- Composer >= version 1.9.1
- MySql


## Pasos para la instalación del sistema
- Crear database a utilizar(Solo se crea la db, la estructura sale posteriormente)
- Crear .env con los parametros requeridos
- Dar permisos de lectura, escritura y ejecución a las carpetas storage y bootstrap
- correr los siguientes comandos: php artisan migrate && php artisan passport:install

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
