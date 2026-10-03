-- Creación de la base de datos (Opcional, descomentar si es necesario)
-- CREATE DATABASE IF NOT EXISTS mi_portafolio_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- USE mi_portafolio_db;

-- ==============================================================================
-- MÓDULO 1: ADMINISTRACIÓN Y ACCESO
-- ==============================================================================

CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE,
    descripcion VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    rol_id INT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    activo BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (rol_id) REFERENCES roles(id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE modulos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL, -- Para mostrar en el sidebar
    ruta VARCHAR(150) NOT NULL,   -- URL o endpoint
    icono VARCHAR(50) NULL,       -- Clase del icono (ej. fa-solid fa-user)
    orden INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE permisos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    rol_id INT NOT NULL,
    modulo_id INT NOT NULL,
    permiso_ver BOOLEAN DEFAULT FALSE,
    permiso_crear BOOLEAN DEFAULT FALSE,
    permiso_editar BOOLEAN DEFAULT FALSE,
    permiso_eliminar BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (rol_id) REFERENCES roles(id) ON DELETE CASCADE,
    FOREIGN KEY (modulo_id) REFERENCES modulos(id) ON DELETE CASCADE,
    UNIQUE KEY unq_rol_modulo (rol_id, modulo_id),
    -- Regla de negocio: Si no se puede ver, no se puede crear, editar ni eliminar
    CONSTRAINT chk_dependencia_ver CHECK (
        permiso_ver = 1 OR (permiso_crear = 0 AND permiso_editar = 0 AND permiso_eliminar = 0)
    )
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE logs_auditoria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NULL,          -- NULL si es una acción de sistema o intento fallido de login
    endpoint VARCHAR(255) NOT NULL,
    accion VARCHAR(50) NOT NULL,  -- GET, POST, PUT, DELETE, LOGIN, etc.
    detalles TEXT NULL,           -- JSON con el payload o descripción del cambio
    error BOOLEAN DEFAULT FALSE,  -- Flag para identificar rápidamente peticiones fallidas
    ip_address VARCHAR(45) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==============================================================================
-- MÓDULO 2: DATOS GENERALES Y CONFIGURACIÓN
-- ==============================================================================

CREATE TABLE empresa_datos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    descripcion TEXT NULL,
    mision TEXT NULL,
    vision TEXT NULL,
    valores TEXT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Se inserta el registro único inicial
INSERT INTO empresa_datos (id, nombre) VALUES (1, 'Mi Empresa / Mi Nombre');

CREATE TABLE configuracion_admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    -- Servidor de Correo (SMTP / PHPMailer)
    smtp_host VARCHAR(150) NULL,
    smtp_port INT NULL,
    smtp_usuario VARCHAR(150) NULL,
    smtp_password VARCHAR(255) NULL,
    smtp_cifrado ENUM('tls', 'ssl', 'none') DEFAULT 'tls',
    email_remitente VARCHAR(150) NULL,
    nombre_remitente VARCHAR(100) NULL,
    -- Pasarela de Pagos (Mercado Pago)
    mp_modo_sandbox BOOLEAN DEFAULT TRUE,
    mp_public_key_test VARCHAR(255) NULL,
    mp_access_token_test VARCHAR(255) NULL,
    mp_public_key_prod VARCHAR(255) NULL,
    mp_access_token_prod VARCHAR(255) NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Se inserta el registro único inicial
INSERT INTO configuracion_admin (id) VALUES (1);

-- ==============================================================================
-- MÓDULO 3: CONTENIDO DE LA PÁGINA WEB
-- ==============================================================================

CREATE TABLE proyectos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    descripcion TEXT NOT NULL,
    imagen VARCHAR(255) NOT NULL, -- Ruta o URL de la imagen
    tecnologias VARCHAR(255) NULL, -- Puede ser texto separado por comas o JSON
    link_externo VARCHAR(255) NULL,
    orden INT DEFAULT 0,
    activo BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE empresas_asociadas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    logo_url VARCHAR(255) NOT NULL,
    orden INT DEFAULT 0,
    activo BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE redes_sociales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    linkedin VARCHAR(255) NULL,
    github VARCHAR(255) NULL,
    instagram VARCHAR(255) NULL,
    youtube VARCHAR(255) NULL,
    facebook VARCHAR(255) NULL,
    x_twitter VARCHAR(255) NULL,
    telegram VARCHAR(255) NULL,
    discord VARCHAR(255) NULL,
    twitch VARCHAR(255) NULL,
    kick VARCHAR(255) NULL,
    enlace_adicional VARCHAR(255) NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Se inserta el registro único inicial
INSERT INTO redes_sociales (id) VALUES (1);

CREATE TABLE modulo_padre( id INT AUTO_INCREMENT PRIMARY KEY, nombre VARCHAR(50), icono VARCHAR(50), orden INT DEFAULT NULL, create_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ); 

ALTER TABLE modulos ADD COLUMN modulo_padre_id INT , ADD CONSTRAINT fk_modulo_padre FOREIGN KEY (modulo_padre_id) REFERENCES modulo_padre(id); 