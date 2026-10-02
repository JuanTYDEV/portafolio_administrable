// Funcion encargada de que cuente con una session valida cada cambio de modulo
document.addEventListener("DOMContentLoaded", () => {
    checkSessionAndLoadData();
});

let user_name_session_active = "";
const btnLogout = document.getElementById('btn-logout');

/** 
*  ==== Funcionalidad del cierre de session ====
*/

if (btnLogout) {
    btnLogout.addEventListener('click', async (e) => {
        e.preventDefault();

        try {
            // Hacemos la petición a la ruta de routes_back.php
            const respuesta = await fetch(window.API_BASE + 'funcionalidad/user/logout', {
                method: 'POST', // o GET, como prefieras manejarlo
                headers: {
                    'Content-Type': 'application/json'
                }
            });

            const data = await respuesta.json();

            if (data.status === 'success') {
                // data.redirect ya llega como ruta absoluta de la app (base_url)
                window.location.href = data.redirect && data.redirect.indexOf('/') === 0 ?
                    data.redirect :
                    window.APP_BASE + '/' + (data.redirect || '');
            } else {
                console.error("Error al cerrar sesión");
            }

        } catch (error) {
            console.error("Error de conexión:", error);
        }
    });
}

async function checkSessionAndLoadData() {
    try {
        // 1. Primero validamos la sesión (rápido, sin HTML innecesario)
        const sessionResponse = await fetch(
            window.API_BASE + "funcionalidad/auth/validar", {
            method: "GET",
            headers: {
                Accept: "application/json",
                "Content-Type": "application/json",
            },
            credentials: "include",
        },
        );

        const sessionResult = await sessionResponse.json();

        if (sessionResult.status === "error") {
            const destino = sessionResult.redirect && sessionResult.redirect.indexOf('/') === 0 ?
                sessionResult.redirect :
                window.APP_BASE + '/' + (sessionResult.redirect || '');
            window.location.replace(destino);
            return;
        }
        user_name_session_active = sessionResult.data.nombre;
        console.log("Session valida aun tienes permisos");
    } catch (error) {
        console.error("Error al verificar la sesión:", error);
    }
}