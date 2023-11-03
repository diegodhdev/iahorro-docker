# iAhorro Code Challenge propuesta

He seguido un enfoque CQRS para la realización del challenge. El código fuente de la prueba
se encuentra principalmente en la carpeta "src", separado por agregados y capas de arquitectura
 según el objetivo de cada clase creada, para separar responsabilidades
y promover el testeo de la aplicación. Se hace uso de Repository Pattern, Command Pattern, Value Objects, y algunos patterns de arquitectura más. He tratado de escribir el nombre
de clases y métodos para que se entienda el proposito de cada componente de la aplicación. Y que todo lo que toca entrada salida,
ámbito externo al dominio pueda ser inyectado y mockeado en tiempo de testing.

El frontend lo he obviado en su mayoria, me he enfocado en clean code en el backend, solo he generado las vistas mínimas para poder generar el enrutado.

### En cada agregado encontrarás carpetas:
- Appplication: Contiene los application services, casos de uso de la aplicación.
- Infrastructure: Contiene la implementación concreta acoplada con la infrastructura, servicios externos, etc...
- Domain: Codigo de negocio, modelado del dominio con los agregados, value objects, validaciones, etc...

He usado buses de escritura, lectura y eventos:
- CommandBus
- QueryBus
- EventBus

El testing lo centro en la capa de application, aparte para probar la infrastructura en si testeo los repositorios de cada agregado, servicios, etc... Para evitar
escribir directamente utilizo transacciones, aparte de generar mocks cuando me interesa según el tipo de test concreto.

Scoring Service:
Con propositos de hacer fake de un servicio externo de scoring he creado una clase (SpecificLeadScoringService) que implementa una interfaz generica para gestionar el servicio LeadScoringService. Este realiza una petición a una url y tiene
una lógica inventada, solo queria poder simular la llamada al servicio y hacer algunos tests que reflejen la gestion de errores en servicios externos y como gestionarlo
a nivel de testing.

### Respuesta y errores
He usado los status code de respuestas de endpoints según verbos http usados más acción completada en los endpoints.
Se podria haber traducido las exceptions en esos puntos a json para api en lugar de lanzar excepciones, pero por el enfoque de la aplicación tipo crud he visto más
conveniente dejarlo tal como lo pongo.

A nivel de testing, hago uso de mockery y modulo los tests manteniendo la estructura de carpetas con respecto a las clases reales que se testean en src. Uso patrones como object mother para la generación de instancias
en tiempos de testing, etc...

Cubro los casos unitarios y pruebas de integración con phpunit y algunas pruebas end to end con behat, no para todos solo con
algunos para mostrar el uso. En cuanto a unit testing se podrian seguir cubriendo algunos objetos 
más como value objects, excepciones, etc...

He usado herramientas como "rector" para mantener el código actualizado a php 8.1.
Me he ayudado de herramientas como infection para la realización de tests, ecs para mantener el estilo de código y algunas cosas más...

A nivel de infrastructura, he usado docker para levantar la aplicación. Más abajo explico como usarla.

### Aclaraciones de como he entendido la lógica:

Hay alguna cosa de la lógica de la aplicación que me han generado dudas, como el objetivo entiendo que es mostrar clean code
, separación de responsabilidades, buenas prácticas en general he intentado no cambiar casi nada la lógica que he visto. He eliminado algún metodo que veia
que no se usaba como la llamada a lead scoring service en el updateController:

`$score = $this->leadScoringService->getLeadScore($lead);`

He entendido que un cliente por el código solo tiene "email" y "lead_id" proveniente de la tabla leads. Entiendo que en algún punto
un lead se convierte en cliente. He tratado de dejarlo todo como estaba, he refactorizado, como he visto que el email era único en la tabla clientes, 
he creado este campo allí también, he separado la lógica de la parte de leads de la de la parte de clients usando eventos de dominio.
Lo he enfocado como si fuese una aplicación grande que tiene que ser escalable y testeable

En cuanto a la eliminación de registros, al eliminar se elimina de la tabla de leads, la tabla de clientes queda con la información, es lo que he entendido al ver el código.

Al actualizar un lead veo que se puede sobreescribir el email, y no se actualiza clients, con lo que el registro em ambas tablar puede
quedar desincronizado en cuando email usado. 

### Entorno:
Docker con 3 container:

Ajusta el fichero docker-compose.yml con tu usuario local:
- `user: tu_usuario_de_sistema`

  - app:
    - build:
      - args:
        - user: { pon tu usuario de sistema aqui }

Para la DB:
  - mysql: localhost:3308
  - MYSQL_ROOT_PASSWORD: root_password
  - MYSQL_PASSWORD: your_user_password
  - MYSQL_USER: your_user

En los ficheros .env y .env.behat ajusta la variable de entorno para usuario de base de datos a la que quieras antes de construir el entorno docker:

`app, nginx y mysql` confiugrados para acceder via localhost:port
- mysql: localhost:3308
- nginx: localhost:8081

- Para acceder a los containers usar comando:
- `docker exec -it iahorro-app-php bash`
- `docker exec -it iahorro-db-mysql bash`
- `docker exec -it iahorro-nginx-server bash`

Accede al container `docker exec -it iahorro-app-php bash` y ejecuta el comando para migrar la base de datos:
`php artisan migrate`

Dentro del php container podemos tirar los siguientes comandos:
- phpunit: `vendor/bin/phpunit` // Unit testing
- behat: `vendor/bin/behat` // End to end testing
- mutation testing: `vendor/bin/infection` // Mutation testing
- rector: `vendor/bin/rector` // Actualizar a la versión php 8.1 el código
- ecs: `vendor/bin/ecs --fix` // Actua sobre la carpeta src para mantener el código con formato adecuado

He dajado los ficheros de configuración con el objetivo de que podais configurarlo rapido, se que está información no deberia estar
presente en el repo, pero es para facilitaros la tarea de prueba del sistema.

Ajustad .env y .env.behat como lo veais conveniente para vuestro entorno.

Rutas (Los ids son de ejemplo, coger uno en la base de datos para probar):
- http://localhost:8081/lead/create
- http://localhost:8081/lead/store
- http://localhost:8081/lead/edit/05e51d6b-3b73-4ca4-96df-169ab5abc7df
- http://localhost:8081/lead/show/05e51d6b-3b73-4ca4-96df-169ab5abc7df
- http://localhost:8081/lead/destroy/05e51d6b-3b73-4ca4-96df-169ab5abc7df

Cualquier duda contactar a diegodominguez.h@gmail.com