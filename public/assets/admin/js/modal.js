/**
* SISTEMA 1: LEGACY (Callback-based)
* Usa el modal estático #globalDynamicModal
*/
function showDynamicModal(url, title = "Detalles", size = "md", backdrop = true) {
    const modalElement = document.getElementById("globalDynamicModal");
    const modalTitle = document.getElementById("globalDynamicModalLabel");
    const modalBody = modalElement.querySelector(".modal-body");
    const modalDialog = modalElement.querySelector(".modal-dialog");

    modalTitle.textContent = title;
    modalDialog.classList.remove("modal-sm", "modal-md", "modal-lg", "modal-xl");
    if (size !== "md") modalDialog.classList.add(`modal-${size}`);

    if (backdrop === false) {
        modalElement.setAttribute("data-bs-backdrop", "static");
        modalElement.setAttribute("data-bs-keyboard", "false");
    } else {
        modalElement.setAttribute("data-bs-backdrop", "true");
        modalElement.setAttribute("data-bs-keyboard", "true");
    }

    modalBody.innerHTML = `<div class="text-center p-5"><div class="spinner-border text-primary" role="status"></div></div>`;
    $("#globalDynamicModal").modal("show");

    fetch(url).then(r => {
        if (!r.ok) throw new Error("Error red");
        return r.text();
    })
        .then(html => {
            modalBody.innerHTML = html;
            modalBody.querySelectorAll("script").forEach(s => {
                const script = document.createElement("script");
                const srcOriginal = s.getAttribute("src");
                if (srcOriginal) {
                    script.src = window.appUrl(srcOriginal);
                } else {
                    script.textContent = s.textContent;
                }
                document.body.appendChild(script);
                document.body.removeChild(script);
            });
        })
        .catch(e => modalBody.innerHTML = `<div class="alert alert-danger">${e.message}</div>`);

    // Evento legacy para recargar tablas
    $("#globalDynamicModal").off("hidden.bs.modal").on("hidden.bs.modal", function () {
        modalBody.innerHTML = "";
        if (typeof table !== "undefined") table.ajax.reload(null, false);
        if (typeof tabla_dinamica === "function") {
            // Solo recargamos si NO estamos usando el sistema nuevo (para evitar doble recarga)
            // Pero como es legacy, lo dejamos por seguridad.
            let pag = typeof paginaActual !== "undefined" ? paginaActual : 1;
            let term = document.getElementById("input-busqueda") ? document.getElementById("input-busqueda").value : "";
            tabla_dinamica(pag, term);
        }
    });
}

/**
* MODERNO (Promise-based / Stackable)
* Crea modales nuevos en el DOM. Permite abrir uno encima de otro.
*/
function crearModalApilable(url, title = "Detalles", size = "md", onLoadCallback = null) {
    return new Promise((resolve, reject) => {
        const uniqueId = 'modal_' + Date.now() + Math.floor(Math.random() * 1000);


        const modalesAbiertos = document.querySelectorAll('.modal.show').length;
        const zIndexModal = 1055 + (modalesAbiertos * 10);
        const zIndexBackdrop = 1050 + (modalesAbiertos * 10);

        const modalHtml = `
        <div class="modal fade" id="${uniqueId}" tabindex="-1" aria-labelledby="${uniqueId}Label" aria-hidden="true" 
             data-bs-backdrop="static" data-bs-keyboard="false"
             style="z-index: ${zIndexModal}"> 
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-${size}">
                <div class="modal-content" style="border-radius: 15px 15px 0 0;">
                    <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px 15px 0 0;">
                        <h5 class="modal-title" id="${uniqueId}Label">${title}</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center p-5"><div class="spinner-border text-primary" role="status"></div></div>
                    </div>
                </div>
            </div>
        </div>`;

        document.body.insertAdjacentHTML('beforeend', modalHtml);
        const modalElement = document.getElementById(uniqueId);
        const bsModal = new bootstrap.Modal(modalElement, {
            backdrop: 'static',
            keyboard: false
        });
        let promesaResuelta = false;

        modalElement.enviarRespuesta = (datos) => {
            promesaResuelta = true;
            resolve(datos);
            bsModal.hide();
        };

        modalElement.addEventListener('hidden.bs.modal', function () {
            if (!promesaResuelta) resolve(null);
            bsModal.dispose();
            modalElement.remove();
        });

        // --- NUEVA LÓGICA DE SINCRONIZACIÓN ---
        let isModalShown = false;
        let isHtmlLoaded = false;

        // Esta función verifica que tanto el HTML como la animación estén listos
        const ejecutarCallbackSiListo = () => {
            if (isModalShown && isHtmlLoaded && typeof onLoadCallback === 'function') {
                onLoadCallback(modalElement);
            }
        };

        // Escuchamos cuando Bootstrap termina al 100% de abrir y pintar el modal
        modalElement.addEventListener('shown.bs.modal', function () {
            isModalShown = true;
            ejecutarCallbackSiListo();
        });

        bsModal.show();

        setTimeout(() => {
            const backdrops = document.querySelectorAll('.modal-backdrop');
            const nuevoBackdrop = backdrops[backdrops.length - 1];
            if (nuevoBackdrop) {
                nuevoBackdrop.style.zIndex = zIndexBackdrop;
            }
        }, 0);

        fetch(url).then(r => {
            if (!r.ok) throw new Error("Error");
            return r.text();
        })
            .then(html => {
                modalElement.querySelector(".modal-body").innerHTML = html;
                modalElement.querySelector(".modal-body").querySelectorAll("script").forEach(s => {
                    const script = document.createElement("script");
                    s.src ? script.src = s.src : script.textContent = s.textContent;
                    document.body.appendChild(script);
                    document.body.removeChild(script);
                });

                // --- CONFIRMAMOS QUE EL HTML ESTÁ INYECTADO ---
                isHtmlLoaded = true;
                ejecutarCallbackSiListo();
            })
            .catch(e => modalElement.querySelector(".modal-body").innerHTML = `<div class="alert alert-danger">${e.message}</div>`);
    });
}

/**
* Función Universal para cerrar y responder
*/
function cerrarConRespuesta(boton, datos = null) {

    if (boton) {
        boton.blur();
    }

    const modalDiv = boton.closest('.modal');

    if (modalDiv && modalDiv.enviarRespuesta) {
        modalDiv.enviarRespuesta(datos);
    } else if (modalDiv) {
        const bsModal = bootstrap.Modal.getInstance(modalDiv);
        bsModal ? bsModal.hide() : $(modalDiv).modal('hide');
    }
}

