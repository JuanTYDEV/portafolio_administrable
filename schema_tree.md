miproyecto/
├── public/                 ⭐ DOCUMENT ROOT (Punto de entrada)
│   ├── index.php           # Front Controller (Inicializa la app)
│   ├── .htaccess           # Redirección a index.php (Apache)
│   └── assets/             
│       ├── admin/          # Estilos/JS del dashboard
│       ├── web/            # Estilos/JS del sitio público
│       ├── shared/         # Librerías comunes (Bootstrap, FontAwesome)
│       └── uploads/        # Directorio simlink (Acceso público a storage/app/public)
│
├── src/                    ⚙️ LÓGICA DE LA APLICACIÓN (Namespace: App\)
│   ├── Controllers/
│   │   ├── Admin/          # Controladores del Dashboard
│   │   ├── Web/            # Controladores de vistas públicas
│   │   └── Api/            # Endpoints (ej. WebhooksController para MercadoPago)
│   ├── Middlewares/        🛡️ FILTROS DE PETICIÓN
│   │   ├── AuthMiddleware.php      # Verifica si hay sesión activa
│   │   ├── RoleMiddleware.php      # Verifica si es Admin o Cliente
│   │   ├── CsrfMiddleware.php      # Previene ataques CSRF en formularios
│   │   └── CorsMiddleware.php      # Cabeceras de seguridad
│   ├── Models/             # Representación de tablas (Active Record o Data Mapper)
│   ├── Services/           # Lógica compleja que no debe ir en el Controlador
│   │   ├── MercadoPagoService.php
│   │   └── ReportGeneratorService.php
│   ├── Exceptions/         # ⚠️ NUEVO: Errores personalizados (ej. PaymentFailedException)
│   └── Helpers/            # Funciones puras (Fechas, validación de strings, formateo)
│
├── core/                   🧠 TU MINI-FRAMEWORK (El motor)
│   ├── Application.php     # Contenedor principal
│   ├── Router.php          # Enrutador (Ahora debe ejecutar Middlewares antes del Controlador)
│   ├── Request.php         # Orientado a objetos: encapsula $_GET, $_POST, $_FILES
│   ├── Response.php        # Orientado a objetos: métodos html(), json(), redirect()
│   ├── Database.php        # Conector PDO (Singleton o inyectado)
│   └── View.php            # Motor de plantillas (Renderiza y pasa variables)
│
├── database/               💾 CONTROL DE VERSIONES DE BASE DE DATOS
│   ├── migrations/         # Scripts PHP/SQL para crear/modificar tablas (historial)
│   ├── seeders/            # Scripts para insertar datos iniciales (ej. superadmin, catálogo de disciplinas)
│   └── schema.sql          # Respaldo completo de la estructura actual
│
├── views/                  🎨 VISTAS
│   ├── admin/              
│   ├── web/                
│   ├── emails/             # 📧 NUEVO: Plantillas HTML exclusivas para correos electrónicos
│   └── errors/             # Páginas 404, 403, 500 personalizadas
│
├── routes/                 🛣️ DEFINICIÓN DE RUTAS
│   ├── admin.php           # Rutas bajo AuthMiddleware y RoleMiddleware(Admin)
│   ├── web.php             # Rutas públicas (Inicio, Login, Portafolio)
│   └── api.php             # Rutas sin protección CSRF (Webhooks)
│
├── storage/                📦 ARCHIVOS GENERADOS O PRIVADOS (No va en Git)
│   ├── logs/               # app.log, error.log (Crítico para debug)
│   ├── cache/              # Vistas compiladas o queries oxidados
│   ├── sessions/           # Archivos de sesión (si no usas la DB o PHP por defecto)
│   └── app/
│       ├── private/        # PDFs de corte de caja, respaldos, CVs (NO accesibles por URL)
│       └── public/         # Fotos de perfil, imágenes de clases (Accesibles vía simlink en public/)
│
├── tests/                  🧪 NUEVO: PRUEBAS AUTOMATIZADAS
│   ├── Unit/               # Pruebas de clases/métodos aislados (ej. CalculoDeDescuentosTest)
│   └── Feature/            # Pruebas de integración (ej. LoginTest, FlujoDePagoTest)
│
├── config/                 🔧 CONFIGURACIONES (Mapean el archivo .env)
│   ├── app.php             # Zona horaria, entorno (local/prod), modo debug
│   ├── database.php        # Credenciales mapeadas
│   ├── mail.php            # Configuración SMTP
│   └── services.php        # Tokens de APIs externas
│
├── docker/                 🐳 ENTORNO DE DESARROLLO aislando servicios
│   ├── php/                # Dockerfile de PHP-FPM con extensiones
│   ├── nginx/ o apache/    # Archivos de configuración del servidor web
│   └── mysql/              # Archivos de inicialización de BD
│
├── docker-compose.yml      # Levanta web, db, phpmyadmin/adminer
├── phpunit.xml             # Configuración del framework de testing
├── composer.json           # Autocarga (PSR-4) y dependencias (MercadoPago SDK, PHPMailer)
├── .env                    🔒 VARIABLES DE ENTORNO REALES (¡No se sube a Git!)
├── .env.example            # Plantilla de variables para el equipo
└── .gitignore              # Excluye vendor/, storage/, .env