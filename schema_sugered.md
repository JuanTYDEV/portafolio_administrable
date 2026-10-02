project/
├── app/                              # O src/ (ambas son válidas)
│   ├── Core/                         # Núcleo de la aplicación
│   │   ├── Bootstrap/
│   │   │   ├── App.php              # Inicialización de la app
│   │   │   └── Container.php         # Contenedor de dependencias
│   │   ├── Database/
│   │   │   ├── Connection.php
│   │   │   ├── QueryBuilder.php
│   │   │   └── Migrations/
│   │   ├── Routing/
│   │   │   ├── Router.php
│   │   │   ├── RouteRegistrar.php
│   │   │   └── RouteGroup.php
│   │   ├── View/
│   │   │   ├── View.php
│   │   │   ├── ViewComposer.php
│   │   │   └── Blade.php            # Si usas motor de plantillas
│   │   └── Http/
│   │       ├── Kernel.php           # Registro de middleware global
│   │       ├── Request.php
│   │       └── Response.php
│   │
│   ├── Http/                         # Capa HTTP
│   │   ├── Controllers/
│   │   │   ├── Web/                 # Controllers para vistas públicas
│   │   │   │   ├── PageController.php
│   │   │   │   ├── HomeController.php
│   │   │   │   └── Auth/
│   │   │   │       ├── LoginController.php
│   │   │   │       └── RegisterController.php
│   │   │   ├── Dashboard/           # Controllers del panel admin
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── UsersController.php
│   │   │   │   ├── ProductsController.php
│   │   │   │   └── SettingsController.php
│   │   │   └── Api/                 # Controllers para API
│   │   │       ├── V1/
│   │   │       │   ├── AuthController.php
│   │   │       │   └── UserController.php
│   │   │       └── BaseApiController.php
│   │   │
│   │   ├── Middleware/
│   │   │   ├── Global/              # Middleware global (toda la app)
│   │   │   │   ├── CorsMiddleware.php
│   │   │   │   ├── SessionMiddleware.php
│   │   │   │   └── SecurityHeaders.php
│   │   │   ├── Web/                 # Middleware para rutas web
│   │   │   │   ├── AuthMiddleware.php
│   │   │   │   ├── GuestMiddleware.php
│   │   │   │   └── VerifiedMiddleware.php
│   │   │   └── Api/                 # Middleware para API
│   │   │       ├── AuthApiMiddleware.php
│   │   │       └── RateLimitMiddleware.php
│   │   │
│   │   └── Requests/                # Validaciones
│   │       ├── Web/
│   │       │   ├── LoginRequest.php
│   │       │   └── RegisterRequest.php
│   │       └── Api/
│   │           └── ApiLoginRequest.php
│   │
│   ├── Models/                       # Modelos
│   │   ├── User.php
│   │   ├── Product.php
│   │   └── Category.php
│   │
│   ├── Services/                     # Servicios de negocio
│   │   ├── Auth/
│   │   │   ├── AuthService.php
│   │   │   └── JWTService.php
│   │   ├── Payment/
│   │   │   ├── MercadoPagoService.php
│   │   │   └── PaymentGateway.php
│   │   ├── Storage/
│   │   │   ├── ImageService.php
│   │   │   └── FileService.php
│   │   ├── Mail/
│   │   │   └── MailService.php
│   │   └── Cache/
│   │       └── CacheService.php
│   │
│   ├── Repositories/                 # Acceso a datos
│   │   ├── BaseRepository.php
│   │   ├── UserRepository.php
│   │   ├── ProductRepository.php
│   │   └── CategoryRepository.php
│   │
│   ├── Helpers/                      # Helpers globales
│   │   ├── ValidationHelper.php
│   │   ├── DateHelper.php
│   │   ├── MenuHelper.php
│   │   └── SecurityHelper.php
│   │
│   └── Exceptions/                   # Manejo de excepciones
│       ├── Handler.php
│       ├── AuthException.php
│       └── ValidationException.php
│
├── config/                           # Configuraciones
│   ├── app.php
│   ├── database.php
│   ├── auth.php
│   ├── mercadopago.php
│   ├── mail.php
│   ├── filesystems.php
│   └── cors.php
│
├── routes/                           # Definición de rutas
│   ├── web.php                      # Rutas públicas (landing)
│   ├── dashboard.php                # Rutas del panel admin
│   └── api/
│       └── v1.php                   # Rutas API versionadas
│
├── resources/                        # Recursos
│   ├── views/                       # Vistas
│   │   ├── web/                     # Vistas públicas (landing)
│   │   │   ├── layouts/
│   │   │   │   ├── app.php         # Layout principal
│   │   │   │   └── auth.php        # Layout para páginas de auth
│   │   │   ├── partials/
│   │   │   │   ├── header.php
│   │   │   │   ├── footer.php
│   │   │   │   └── navbar.php
│   │   │   ├── auth/
│   │   │   │   ├── login.php
│   │   │   │   ├── register.php
│   │   │   │   └── recover-password.php
│   │   │   └── pages/
│   │   │       ├── home.php
│   │   │       ├── about.php
│   │   │       ├── products/
│   │   │       │   ├── index.php
│   │   │       │   └── detail.php
│   │   │       └── contact.php
│   │   │
│   │   └── dashboard/               # Vistas del panel admin
│   │       ├── layouts/
│   │       │   └── dashboard.php   # Layout del dashboard
│   │       ├── partials/
│   │       │   ├── sidebar.php
│   │       │   ├── topbar.php
│   │       │   └── scripts.php
│   │       ├── index.php           # Dashboard principal
│   │       ├── users/
│   │       │   ├── index.php
│   │       │   ├── create.php
│   │       │   └── edit.php
│   │       ├── products/
│   │       │   ├── index.php
│   │       │   └── create.php
│   │       └── settings/
│   │           └── index.php
│   │
│   ├── lang/                        # Traducciones
│   │   ├── en/
│   │   └── es/
│   │
│   └── assets/                      # Assets source (para compilar)
│       ├── scss/
│       ├── js/
│       └── images/
│
├── public/                           # Archivos públicos (document root)
│   ├── index.php                    # Entry point único
│   ├── .htaccess
│   ├── assets/                      # Assets compilados
│   │   ├── css/
│   │   │   ├── app.css
│   │   │   ├── dashboard.css
│   │   │   └── fonts.css
│   │   ├── js/
│   │   │   ├── app.js
│   │   │   ├── dashboard.js
│   │   │   └── vendor/
│   │   ├── images/
│   │   └── fonts/
│   └── uploads/                     # Archivos subidos
│       ├── users/
│       ├── products/
│       └── temp/
│
├── database/                         # Base de datos
│   ├── migrations/
│   │   ├── 2026_01_01_000000_create_users_table.php
│   │   └── 2026_01_02_000000_create_products_table.php
│   ├── seeders/
│   │   ├── UserSeeder.php
│   │   └── ProductSeeder.php
│   └── factories/
│       └── UserFactory.php
│
├── storage/                          # Archivos temporales y logs
│   ├── logs/
│   │   ├── app.log
│   │   └── error.log
│   ├── cache/
│   │   ├── views/
│   │   └── config/
│   ├── sessions/
│   └── framework/                   # Cache de framework
│
├── tests/                            # Pruebas
│   ├── Unit/
│   │   ├── Models/
│   │   └── Services/
│   ├── Feature/
│   │   ├── Web/
│   │   └── Api/
│   └── TestCase.php
│
├── bootstrap/                        # Arranque de la app
│   └── app.php
│
├── vendor/                           # Dependencias
├── .env                              # Variables de entorno
├── .env.example
├── .gitignore
├── composer.json
├── phpunit.xml
└── README.md