<?php
// views/admin/auth/login.php
if (!defined('APP_RUNNING')) {
    http_response_code(404);
    exit;
}
?>
<div id="alerta-error" style="display: none; color: red; margin-bottom: 15px;"></div>

<form id="formLogin">
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

    <button type="submit" class="btn-login" id="btnSubmit">Iniciar Sesión</button>
</form>