document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('formLogin');
    const alertaError = document.getElementById('alerta-error');
    const btnSubmit = document.getElementById('btnSubmit');

    form.addEventListener('submit', async function (e) {
        // 1. Evitamos que el formulario recargue la página usando GET/POST clásico
        e.preventDefault();

        // 2. Capturamos los datos y limpiamos los mensajes de error
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        alertaError.style.display = 'none';
        btnSubmit.disabled = true; // Prevenir múltiples clics
        btnSubmit.innerText = 'Cargando...';

        try {
            // 3. Hacemos la petición a nuestra API (Controlador base lo leerá con php://input)
            const respuesta = await fetch(BASE_URL + 'api/v1/auth/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    email: email,
                    password: password
                })
            });

            // 4. Decodificamos la respuesta JSON del servidor
            const datos = await respuesta.json();

            // 5. Evaluamos el resultado
            if (respuesta.ok && datos.exito) {
                // Si el servidor envía código 200 y éxito, redirigimos usando JS
                window.location.href = BASE_URL + datos.redirect; // Esto mandará a /panel/dashboard
            } else {
                // Si hay error (400, 401, 403), mostramos el mensaje que armaste en PHP
                alertaError.innerText = datos.mensaje || 'Error de autenticación.';
                alertaError.style.display = 'block';
                btnSubmit.disabled = false;
                btnSubmit.innerText = 'Entrar';
            }

        } catch (error) {
            // Error de red o si el servidor devuelve HTML en vez de JSON (ej. un error 500 fatal)
            console.error('Fetch error:', error);
            alertaError.innerText = 'Ocurrió un error al conectar con el servidor.';
            alertaError.style.display = 'block';
            btnSubmit.disabled = false;
            btnSubmit.innerText = 'Entrar';
        }
    });
});