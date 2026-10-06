// Funcion encargada de que cuente con una session valida cada cambio de modulo
document.addEventListener("DOMContentLoaded", () => {
    // checkSessionAndLoadData();
});

let user_name_session_active = "";
const btnLogout = document.getElementById('btn-logout');

/** 
*  ==== Funcionalidad del cierre de session ====
*/

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