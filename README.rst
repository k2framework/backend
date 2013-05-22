K2_Backend
==========

.. contents:: El mismo backend de la beta2 de kumbiaphp, ahora para K2

Instalacion
-----------

la instalación más sencilla es mediante composer, agregar el paquete al composer.json del proyecto:

.. code-block:: json

    {
        "require" : {
            "k2/backend": "dev-master"
        }
    }
                        
                        
Ejecutar el comando:

::
    
    composer install
    
    
Luego de tener los archivos descargados correctamente se debe agregar el módulo en el app/config/modules.php:

.. code-block:: php

    <?php //archivo app/config/modules.php

    /* * *****************************************************************
     * Iinstalación de módulos
     */
    App::modules(array(
        '/' => include APP_PATH . '/modules/Index/config.php',
        '/admin' => include composerPath('k2/backend', 'K2/Backend'),
    ));

Con esto ya debemos tener el Módulo instalado en el sistema, sin embargo aun faltan configurar algunas cosas para que todo funcione bien.

1. abrir una consola y colocarse en dirProyecto/default u ejecutar el comando:

::

    php app/console asset:install
    
Este comando instalará los assets en la carpeta public del proyecto.

2. Configurar el archivo config/security.ini (para darle seguridad a la app), debemos tener la config como está en el archivo `security.ini <https://github.com/manuelj555/K2_Backend/tree/master/config/security.ini>`_.
3. Crear la base de datos y configurar la conexion en el "app/config/databases.ini".
4. Por ultimo verificar que este activado el firewall de la app en el "app/modules/Index/config.php".

Con esto ya debemos tener corriendo el backend de la aplicación.

Podemos probar entrando a http://dirProyecto/admin/usuarios, y nos debe aparecer un formulario de logueo.

Cualquier duda, error ó problema, dejarlo como un `issue <https://github.com/k2framework/backend/issues>`_ en el repo.

Cualquier persona que desee colaborar con el desarrollo es bienvenida :-)

Gestion de Usuarios
-----

Permite la creación edición y eliminación de usuarios de la aplicación.

Los Usuarios tienen perfiles asociados, con ello se puede controlar que puede hacer cada usuario dependiendo de los perfiles que posea.

Gestion de Roles (Perfiles)
-----

Permite la creación edición y eliminación de Roles de la aplicación.

Los roles son un identificador de que tipo de papel juega un usuario dentro de la aplicacion. 

Ejemplo: usuarios visitantes, moderadores, administradores, etc.

Gestion de Recursos
-----

Los recursos son cada uno de los módulos ( páginas ) que tiene la aplicación.

Cada recurso está identificado por una url.

Ejemplos de recursos Validos:

- admin/usuarios/crear     especificamos el modulo controlador y acción.
- articulos/crear          controlador y acción.
- inicio/*                 controlador y todas las acciones del mismo. 
- modulo/controlador/*     Modulo controlador y todas las acciones del mismo. 
- modulo/*/*               Modulo todos los controladores y acciones del mismo. 

Gestion de Privilegios ( Permisos de roles a recursos )
-----

Permite establecer a que recursos tiene acceso cada rol en la aplicacion.

Gestion de Menus
-----

Permite la creación edición y eliminación de Menus de la aplicación.

Cada menu está asociado a un recurso, esto con el fin de poder tener menus inteligentes que solo carguen los items
a los que un rol tenga acceso.

Ademas los items pueden tener items padres asociados para crear menus hijos.
