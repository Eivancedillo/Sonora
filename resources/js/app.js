// Reproductor SIMULADO de Sonora.
// No hay audio: un temporizador avanza el progreso cada segundo.
// El estado se guarda en sessionStorage para que siga al cambiar de pantalla.

const pistas = window.sonora?.pistas ?? [];
const CLAVE = "sonora:estado";

const inicial = {
    indice: 0,
    segundos: 0,
    reproduciendo: false,
    aleatorio: false,
    megusta: [],
    guardadas: [],
    volumen: 70,
};

function leer() {
    try {
        return {
            ...inicial,
            ...JSON.parse(sessionStorage.getItem(CLAVE) ?? "{}"),
        };
    } catch (_) {
        return { ...inicial };
    }
}

function guardar() {
    try {
        sessionStorage.setItem(CLAVE, JSON.stringify(estado));
    } catch (_) {}
}

const estado = leer();
let temporizador = null;

const todos = (selector) => document.querySelectorAll(selector);
const actual = () => pistas[estado.indice];
const limitar = (n, min, max) => Math.min(max, Math.max(min, n));
const formato = (s) =>
    `${String(Math.floor(s / 60)).padStart(2, "0")}:${String(s % 60).padStart(2, "0")}`;

// ---------- Pintar la interfaz según el estado ----------

function pintarSlider(slider, porcentaje, texto) {
    const barra = slider.querySelector('[role="slider"]');
    barra.setAttribute("aria-valuenow", porcentaje);
    barra.setAttribute("aria-valuetext", texto);
    slider.querySelector('[data-progreso="relleno"]').style.width =
        `${porcentaje}%`;
}

function pintar() {
    const pista = actual();
    if (!pista) return;

    todos('[data-reproductor="titulo"]').forEach(
        (el) => (el.textContent = pista.titulo),
    );
    todos('[data-reproductor="artista"]').forEach(
        (el) => (el.textContent = pista.artista),
    );
    todos('[data-reproductor="album"]').forEach(
        (el) => (el.textContent = pista.album),
    );

    todos('[data-reproductor="portada"]').forEach((portada) => {
        portada.querySelectorAll("i").forEach((barra, k) => {
            barra.style.height = `${pista.barras[k] ?? 50}%`;
        });
    });

    const porcentaje = Math.round((estado.segundos / pista.dur) * 100);
    todos('[data-slider="progreso"]').forEach((slider) => {
        pintarSlider(
            slider,
            porcentaje,
            `${formato(estado.segundos)} de ${formato(pista.dur)}`,
        );
        const tiempo = slider.querySelector('[data-progreso="tiempo"]');
        const total = slider.querySelector('[data-progreso="total"]');
        if (tiempo) tiempo.textContent = formato(estado.segundos);
        if (total) total.textContent = formato(pista.dur);
    });

    todos('[data-slider="volumen"]').forEach((slider) => {
        pintarSlider(slider, estado.volumen, `${estado.volumen}%`);
    });

    todos('[data-accion="alternar"]').forEach((boton) => {
        boton.setAttribute(
            "aria-label",
            estado.reproduciendo ? "Pausar" : "Reproducir",
        );
        boton
            .querySelector('[data-icono="play"]')
            ?.classList.toggle("hidden", estado.reproduciendo);
        boton
            .querySelector('[data-icono="pausa"]')
            ?.classList.toggle("hidden", !estado.reproduciendo);
    });

    todos('[data-accion="aleatorio"]').forEach((boton) => {
        boton.setAttribute("aria-pressed", String(estado.aleatorio));
    });

    todos('[data-accion="me-gusta"]').forEach((boton) => {
        boton.setAttribute(
            "aria-pressed",
            String(estado.megusta.includes(pista.id)),
        );
    });

    todos('[data-accion="guardar"]').forEach((boton) => {
        const guardada = estado.guardadas.includes(boton.dataset.slug);
        boton.setAttribute("aria-pressed", String(guardada));
        const aviso = document.querySelector('[data-estado="guardado"]');
        if (aviso)
            aviso.textContent = guardada ? "Guardado en tu biblioteca" : "";
    });

    todos("[data-pista]").forEach((fila) => {
        if (Number(fila.dataset.pista) === pista.id)
            fila.setAttribute("aria-current", "true");
        else fila.removeAttribute("aria-current");
    });
}

// ---------- Reproducción ----------

function reproducir() {
    clearInterval(temporizador);
    estado.reproduciendo = true;
    temporizador = setInterval(() => {
        estado.segundos++;
        if (estado.segundos >= actual().dur) {
            siguiente();
            return;
        }
        pintar();
        guardar();
    }, 1000);
    pintar();
    guardar();
}

function pausar() {
    clearInterval(temporizador);
    temporizador = null;
    estado.reproduciendo = false;
    pintar();
    guardar();
}

function ir(indice) {
    estado.indice = (indice + pistas.length) % pistas.length;
    estado.segundos = 0;
    pintar();
    guardar();
}

function siguiente() {
    if (estado.aleatorio && pistas.length > 1) {
        let nuevo;
        do {
            nuevo = Math.floor(Math.random() * pistas.length);
        } while (nuevo === estado.indice);
        ir(nuevo);
    } else {
        ir(estado.indice + 1);
    }
}

function anterior() {
    // Pasados 3 segundos, "anterior" reinicia la canción actual.
    if (estado.segundos > 3) {
        estado.segundos = 0;
        pintar();
        guardar();
    } else {
        ir(estado.indice - 1);
    }
}

function buscar(porcentaje) {
    const dur = actual().dur;
    estado.segundos = limitar(Math.round((porcentaje / 100) * dur), 0, dur - 1);
    pintar();
    guardar();
}

function ajustarVolumen(porcentaje) {
    estado.volumen = limitar(Math.round(porcentaje), 0, 100);
    pintar();
    guardar();
}

function alternarEn(lista, valor) {
    const posicion = lista.indexOf(valor);
    if (posicion >= 0) lista.splice(posicion, 1);
    else lista.push(valor);
    pintar();
    guardar();
}

// ---------- Tema claro / oscuro ----------

function aplicarTema(tema) {
    document.documentElement.dataset.theme = tema;
    todos('[data-tema="texto"]').forEach((el) => {
        el.textContent = tema === "light" ? "Tema oscuro" : "Tema claro";
    });
}

function alternarTema() {
    const nuevo =
        document.documentElement.dataset.theme === "light" ? "dark" : "light";
    aplicarTema(nuevo);
    try {
        localStorage.setItem("sonora:tema", nuevo);
    } catch (_) {}
}

// ---------- Buscar ----------

// Pasa a minúsculas y quita acentos para que "ultimo" encuentre "Último".
const normalizar = (texto) =>
    texto
        .toLowerCase()
        .normalize("NFD")
        .replace(/[\u0300-\u036f]/g, "");

function filtrar(campo) {
    const consulta = normalizar(campo.value.trim());
    let total = 0;

    todos("[data-seccion]").forEach((seccion) => {
        let visibles = 0;
        seccion.querySelectorAll("[data-busqueda]").forEach((elemento) => {
            const coincide = normalizar(elemento.dataset.busqueda).includes(
                consulta,
            );
            elemento.hidden = !coincide;
            if (coincide) visibles++;
        });
        seccion.hidden = visibles === 0;
        total += visibles;
    });

    const aviso = document.querySelector("[data-sin-resultados]");
    if (aviso) {
        aviso.textContent =
            total === 0
                ? `No encontramos resultados para “${campo.value.trim()}”.`
                : "";
    }
}

// ---------- Eventos ----------

const acciones = {
    alternar: () => (estado.reproduciendo ? pausar() : reproducir()),
    tema: alternarTema,
    anterior,
    siguiente,
    aleatorio: () => {
        estado.aleatorio = !estado.aleatorio;
        pintar();
        guardar();
    },
    "me-gusta": () => alternarEn(estado.megusta, actual().id),
    "reproducir-lista": (boton) => {
        const i = pistas.findIndex(
            (p) => p.id === Number(boton.dataset.inicio),
        );
        if (i >= 0) {
            ir(i);
            reproducir();
        }
    },
    guardar: (boton) => alternarEn(estado.guardadas, boton.dataset.slug),
};

function mover(barra, porcentaje) {
    const tipo = barra.closest("[data-slider]")?.dataset.slider;
    if (tipo === "progreso") buscar(porcentaje);
    if (tipo === "volumen") ajustarVolumen(porcentaje);
}

document.addEventListener("click", (e) => {
    const boton = e.target.closest("[data-accion]");
    if (boton) {
        acciones[boton.dataset.accion]?.(boton);
        return;
    }

    const barra = e.target.closest('[role="slider"]');
    if (barra) {
        const caja = barra.getBoundingClientRect();
        mover(
            barra,
            limitar(((e.clientX - caja.left) / caja.width) * 100, 0, 100),
        );
        return;
    }

    const fila = e.target.closest("[data-pista]");
    if (fila) {
        const i = pistas.findIndex((p) => p.id === Number(fila.dataset.pista));
        if (i >= 0) {
            ir(i);
            reproducir();
        }
        return;
    }

    const chip = e.target.closest("[data-chips] [aria-pressed]");
    if (chip) {
        chip.closest("[data-chips]")
            .querySelectorAll("[aria-pressed]")
            .forEach((c) => c.setAttribute("aria-pressed", String(c === chip)));
    }
});

document.addEventListener("keydown", (e) => {
    const barra = e.target.closest?.('[role="slider"]');
    if (!barra) return;

    const pasos = { ArrowRight: 5, ArrowUp: 5, ArrowLeft: -5, ArrowDown: -5 };
    const valor = Number(barra.getAttribute("aria-valuenow"));
    let nuevo;

    if (e.key in pasos) nuevo = valor + pasos[e.key];
    else if (e.key === "Home") nuevo = 0;
    else if (e.key === "End") nuevo = 100;
    else return;

    e.preventDefault();
    mover(barra, limitar(nuevo, 0, 100));
});

window.addEventListener("pagehide", guardar);

// ---------- Arranque ----------

if (!actual()) {
    estado.indice = 0;
    estado.segundos = 0;
}
if (actual() && estado.segundos >= actual().dur) estado.segundos = 0;

pintar();
if (estado.reproduciendo) reproducir();

aplicarTema(document.documentElement.dataset.theme);

const campoBusqueda = document.querySelector("[data-campo-busqueda]");
campoBusqueda?.addEventListener("input", () => filtrar(campoBusqueda));
