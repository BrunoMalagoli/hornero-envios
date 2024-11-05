
![Logo](https://i.ibb.co/cQWMVZL/LOGO-TRANSPARENTE.png)


# HORNERO ENVIOS


Este proyecto es una aplicación web desarrollada en **PHP** con **MySQL** como motor de base de datos, utilizando **XAMPP** como entorno de desarrollo. La aplicación permite gestionar envíos, gestionar usuarios y sucursales. Además, hace uso de la API de **Nominatim** para geolocalización y de **OpenRouteService** para calcular rutas y distancias para cotizar el precio de los envios.


## Tecnologías utilizadas

- **PHP**: Lenguaje de programación principal del proyecto.
- **MySQL**: Motor de base de datos para almacenar información.
- **XAMPP**: Entorno de desarrollo que incluye Apache y MySQL para simular el servidor.
- **Nominatim API**: API para obtener información de ubicación a partir de direcciones.
- **OpenRouteService API**: API para calcular rutas y distancias entre ubicaciones.

## Requisitos

Antes de ejecutar el proyecto, asegúrate de tener instalados los siguientes componentes:

- **XAMPP** (versión que incluye PHP y MySQL)
- **Git** (opcional, para clonar el repositorio desde GitHub)

## Configuración e instalación

Sigue estos pasos para configurar XAMPP y levantar el proyecto en tu entorno local.

### Paso 1: Instalar XAMPP

1. Descarga XAMPP desde [Apache Friends](https://www.apachefriends.org/index.html).
2. Ejecuta el instalador y sigue las instrucciones para completar la instalación.

### Paso 2: Clonar el repositorio

1. Abre una terminal o consola.
2. Clona este repositorio en tu equipo con el siguiente comando:

   ```bash
   git clone https://github.com/BrunoMalagoli/hornero-envios 

### Paso 3: Navega al directorio de tu proyecto
    ```bash 
    cd tu-repositorio

### Paso 4 : Abrir y configurar XAMPP.
Abre el panel de control de XAMPP.

Inicia los módulos de Apache y MySQL haciendo clic en el botón "Start" correspondiente a cada uno.

Además deberás configurar la API KEY de OpenRouteService
para eso deberás crear una API_KEY en el archivo .htaccess de tu carpeta apache/conf en XAMPP.

### Paso 5: Copiar archivos al directorio de XAMPP
Copia todos los archivos del proyecto al directorio htdocs de XAMPP. 

Este directorio se encuentra normalmente en:
Windows: C:\xampp\htdocs
Linux/Mac: /opt/lampp/htdocs

Por ejemplo, si tu proyecto se llama gestor-envios, deberías copiarlo en:

Windows: C:\xampp\htdocs\gestor-envios
Linux/Mac: /opt/lampp/htdocs/gestor-envios

### Paso 6: Configuración de la base de datos
Abre tu navegador y accede a phpMyAdmin ingresando en la URL: http://localhost/phpmyadmin.

Crea una nueva base de datos llamada nombre_de_base_datos.
Importa el siguiente DDL en la base de datos creada. 

[Descargar instrucciones](sql/DDL.txt)
Este archivo contiene la estructura inicial.

### Paso 7: Ejecutar el proyecto
Abre tu navegador y accede al proyecto en 

http://localhost/tu-repositorio.


Ahora deberías poder ver la aplicación en funcionamiento.
Para poder acceder a las funcionalidades deberías crear un usuario administrador para poder crear los datos necesarios.
## Autores

- [@BrunoMalagoli](https://github.com/BrunoMalagoli/)
- [@NicolasGauna](https://github.com/nicodgauna)
- [@ValentinaZagman](https://github.com/valentinazag)
- [@MarianoZagman](https://github.com/marianzag)
- [@FaridFragozo](https://github.com/fafrgZ)
