K2_Backend
==========

El mismo backend de la beta2 de kumbiaphp, ahora para K2

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