K2_Backend
==========

El mismo backend de la beta2 de kumbiaphp, ahora para K2

Instalación
-----------

Para instalar el Backend en una Aplicación solo se debe descargar el proyecto y colocarlo en la carpeta "app/modules/K2/Backend/" ( realmente puede ir donde sea, respetando las carpetas "K2/Backend" ), quedando la estructura de directorios como aparece a continuación:

    app/modules/K2/Backend/
                        |--Controller
                        |--Model
                        |--View
                        |--Demas archivos...
                        
Luego de tener los archivos descargados correctamente se debe agregar el módulo en el AppKernel:

    //archivo AppKernel.php
    protected function registerRoutes()
    {
        $routes = array(
            '/' => __DIR__ . '/modules/Index/',
            ... //otros módulos
            '/admin' => __DIR__ . '/modules/K2/Backend/', //acá se agrega el módulo del backend.
        );

        return $routes;
    }

Con esto ya debemos tener el Módulo instalado en el sistema, sin embargo aun faltan configurar algunas cosas para que todo funcione bien.

    * Copiar el contenido de la carpeta public del Backend en la carpeta public del Proyecto.

Gestión de Usuarios
-----

Permite la creación edición y eliminación de usuarios de la aplicación.

Los Usuarios tienen perfiles asociados, con ello se puede controlar que puede hacer cada usuario dependiendo de los perfiles que posea.

Gestión de Roles (Perfiles)
-----

Permite la creación edición y eliminación de Roles de la aplicación.

Los roles son un identificador de que tipo de papel juega un usuario dentro de la aplicacion. 

Ejemplo: usuarios visitantes, moderadores, administradores, etc.

Gestión de Recursos
-----

Los recursos son cada uno de los módulos ( páginas ) que tiene la aplicación.

Cada recurso está identificado por una url.

Ejemplos de recursos Validos:

- admin/usuarios/crear     especificamos el modulo controlador y acción.
- articulos/crear          controlador y acción.
- inicio/*                 controlador y todas las acciones del mismo. 
- modulo/controlador/*     Modulo controlador y todas las acciones del mismo. 
- modulo/*/*               Modulo todos los controladores y acciones del mismo. 

Gestión de Privilegios ( Permisos de roles a recursos )
-----

Permite establecer a que recursos tiene acceso cada rol en la aplicacion.

Gestión de Menus
-----

Permite la creación edición y eliminación de Menus de la aplicación.

Cada menu está asociado a un recurso, esto con el fin de poder tener menus inteligentes que solo carguen los items
a los que un rol tenga acceso.

Ademas los items pueden tener items padres asociados para crear menus hijos.