<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>
<hr />


# Proyecto Final- DTW135 | 06. Registro de Libros
## Integrantes del grupo de trabajo

- Maricela Espin
- Henry Vallejo
- Mónica Bonilla

## Descripción
Esta aplicación, desarrollada con Laravel 13, la aplicacion permite la gestion de una Biblioteca a traves de operaciones CRUD (Crear, Leer, Actualizar, Eliminar). Esta aplicación nos permite sostener un inventario de libros, con informacion de: título, autor, género, año de publicación y estado (disponible o prestado).

## Funcionalidades

- Crear: Permite añadir nuevos libros al registro.
- Leer: Permite visualizar la información de cada libro registrado.
- Actualizar: Permite modificar la información de los libros previamente ingresados.
- Eliminar: Permite eliminar libros del registro.
- Listado y Filtro: Permite visualizar los libros registrados y filtrarlos por criterios (ejemplo, género, autor o estado).

## Como instalarlo

A continuación se detallan los pasos para instalar y ejecutar el proyecto desde cero en tu entorno local:

1. Clonamos el repositorio

```bash
git clone https://github.com/hfvallejo/biblioteca-UEB
cd biblioteca-UEB
```


2. Instalamos dependencias de PHP con Composer

Previamente debe estar instalado Composer para poder ejecutar:

```bash
composer install
```

3. Instalamos las dependencias de Node, de igual manera deben estar previamenmte instaladas Node.js y npm.

con eso instalamos las dependencias necesaria usando el comando:

```bash
npm install
```

4. Configuracion del archivo de entorno
   
Se debe editar el archivo .env aqui debemos colocar los valores que hacen referncia a la base de datos, credenciales del acceso a gestor de base de datos, en este caso mariaDB.

5. Configuración de la base de datos, considerando que la aplicacion se desarrollo bajo plataforma Linux con MariaDB (MySQL)

El entorno de desarrollo utiliza Linux Debian 13, MariaDB, PHP 8.4, y Laravel 13

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=libreria
DB_USERNAME=admin
DB_PASSWORD=
```

Al realizar las migraciones Laravel creará la base de datos (libreria) con los permisos de acceso respectivos indicados en las variables de .env

6. Generar la clave de la aplicación

Cada proyecto requier una clave o has de identificacion unica es importante generar una cada vez que se implementa un proyecto, para ello colocamos la siguiente instruccion.

```bash
php artisan key:generate
```

7. Ejecutamos las migraciones

Para crear la base de datos y las tablas necesarias ejecutamos:

```bash
php artisan migrate
```

8. Alimentar datos de ejemplo en la base de datos

En el repositorio se incluyen seeders para poblar la base de datos con usuarios de ejemplo. Para ello ejecutamos la instruccion:

```bash
php artisan db:seed
``` 

9. Levantar el servidor de desarrollo

Finalmente, inicia el servidor local de Laravel, nótese que en este caso la aplicacion se encuentra en un servdior con una IP específica desde donde se ejecuta; por lo tanto la instruccion siguiente le dice a artisan que brinde el servidio en esa IP y por defecto el puerto 8000:

```bash
php artisan serve --host=192.168.1.20
```

El proyecto estará disponible desde http://192.168.1.20:8000

## Uso de la aplicación

1. Para usar la aplicacion debe usar las siguientes credenciales por defecto del usuario admin, que debe ingresar el momento que se requiera al lanzarse de manera automática el login.

```
usuario: admin
contraseña: 1234
```
