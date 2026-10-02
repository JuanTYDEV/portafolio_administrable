<?php
// views/admin/auth/login.php
if (!defined('APP_RUNNING')) {
    http_response_code(404);
    exit;
}
?>
<form action="#" method="POST">
    <div class="input-group">
        <label for="email">Correo electrónico</label>
        <input type="email" id="email" name="email" placeholder="ejemplo@correo.com" required>
    </div>

    <div class="input-group">
        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" placeholder="••••••••" required>
    </div>

    <div class="options">
        <label class="remember-me">
            <input type="checkbox" name="remember"> Recordarme
        </label>
        <a href="#" class="forgot-password">¿Olvidaste tu contraseña?</a>
    </div>

    <button type="submit" class="btn-login">Iniciar Sesión</button>
</form>

<h1>Iniciar Sesión</h1>