# API Space Reservation
Hola TOTS, se le puso amor a todo el proyecto en general, espero que les guste! 


Requisitos previos
Antes de comenzar, asegúrate de tener instalados los siguientes componentes:


1. Clonar el repositorio

git clone https://github.com/NahuelBlangetti/space-reservation-back
cd space-reservation-back

2. Instalar dependencias de PHP
Usa Composer para instalar las dependencias del proyecto.

composer install


3. Configurar el archivo .env
Copia el archivo .env.example y renómbralo como .env. Luego, configura las variables de entorno según tus necesidades, como la conexión a la base de datos.

cp .env.example .env
Configura los detalles de tu base de datos en el archivo .env:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre_base_datos
DB_USERNAME=usuario
DB_PASSWORD=contraseña


4. Generar la clave de la aplicación


php artisan key:generate

5. Generar el token JWT_SECRET
   
Si el proyecto utiliza autenticación JWT, es necesario generar el token secreto para firmar los JWT. Para ello, ejecuta el siguiente comando:


php artisan jwt:secret
Este comando generará una clave aleatoria y la agregará al archivo .env como JWT_SECRET.

6. Migrar la base de datos
Ejecuta las migraciones para crear las tablas en la base de datos:



php artisan migrate
7. Ejecutar los seeders
Para poblar la base de datos con datos iniciales, ejecuta los seeders:



php artisan db:seed
8. Instalar dependencias de NPM (opcional)
Si el proyecto incluye assets frontend, asegúrate de instalar las dependencias de Node.js y compilar los assets:



npm install
npm run dev

#Rutas de la API
### Rutas de Autenticación

POST /login: Autenticar un usuario existente.
POST /register: Registrar un nuevo usuario.

Estas rutas permiten la autenticación de usuarios mediante JWT, donde podrás obtener el token que necesitarás para acceder a las rutas protegidas.

### Espacios
Estas rutas están disponibles sin autenticación:

GET /spaces: Lista todos los espacios.
GET /spaces/{id}: Muestra la información de un espacio específico.

### Reservas y Espacios protegidos

Estas rutas requieren autenticación mediante el Bearer Token.

### Reservas
GET /reservations: Lista todas las reservas.

GET /reservations/{id}: Muestra la información de una reserva específica.

POST /reservations: Crea una nueva reserva.

PUT /reservations/{id}: Actualiza una reserva existente.

DELETE /reservations/{id}: Elimina una reserva específica.

Espacios (operaciones protegidas)

PUT /spaces/{space}: Actualiza la información de un espacio específico.

PUT /spaces/available/{space}: Actualiza la disponibilidad de un espacio.

POST /spaces: Crea un nuevo espacio.

DELETE /spaces/{space}: Elimina un espacio específico.


Middleware
Las rutas protegidas por el middleware auth:api requieren un token JWT para poder ser accedidas. Asegúrate de autenticarte antes de realizar cualquier petición a estas rutas.

Levantar el servidor
Finalmente, levanta el servidor de desarrollo con el siguiente comando:

php artisan serve
El proyecto estará disponible en http://localhost:8000.


Usuario: user@admin.com
Contraseña: admin123


php artisan queue:work
Si hay tareas programadas (cron jobs), asegúrate de añadirlas a tu cron local:


* * * * * php /ruta-a-tu-proyecto/artisan schedule:run >> /dev/null 2>&1
