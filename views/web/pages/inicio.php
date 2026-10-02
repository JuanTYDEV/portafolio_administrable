<?php if (!defined('APP_RUNNING')) {
    http_response_code(404);
    exit;
} ?>
<!-- Hero -->
<section id="inicio" class="hero">
    <div class="container hero-inner">
        <p class="hero-greeting"><span class="hero-greeting-line"></span> <span data-i18n="hero.greeting">Hola, soy</span></p>
        <h1 class="hero-name" id="heroName"></h1>
        <p class="hero-role" id="heroRole"></p>
        <p class="hero-tagline" id="heroTagline"></p>

        <div class="hero-actions">
            <a href="#proyectos" class="btn btn-primary" data-i18n="hero.cta_projects">Ver proyectos</a>
            <a href="#cv" class="btn btn-ghost" data-i18n="hero.cta_cv">Descargar CV</a>
        </div>

        <div class="hero-stats" id="heroStats"></div>

        <a href="#sobre-mi" class="hero-scroll" aria-label="Scroll">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 5v14" />
                <path d="m19 12-7 7-7-7" />
            </svg>
        </a>
    </div>
</section>

<!-- Sobre mí -->
<section id="sobre-mi" class="section">
    <div class="container">
        <div class="section-head reveal">
            <span class="section-tag" data-i18n="section.about">Sobre mí</span>
            <h2 data-i18n="about.title">Quién soy</h2>
        </div>
        <div class="about-grid">
            <div class="about-text reveal" id="aboutText"></div>
            <div class="about-highlights" id="aboutHighlights"></div>
        </div>
    </div>
</section>

<!-- Tecnologías -->
<section id="tecnologias" class="section section-alt">
    <div class="container">
        <div class="section-head reveal">
            <span class="section-tag" data-i18n="section.skills">Tecnologías</span>
            <h2 data-i18n="skills.title">Stack y herramientas</h2>
            <p data-i18n="skills.subtitle">Tecnologías que uso día a día y otras que sigo aprendiendo.</p>
        </div>
        <div class="skills-groups" id="skillsGroups"></div>
    </div>
</section>

<!-- Proyectos -->
<section id="proyectos" class="section">
    <div class="container">
        <div class="section-head reveal">
            <span class="section-tag" data-i18n="section.projects">Proyectos</span>
            <h2 data-i18n="projects.title">Trabajo seleccionado</h2>
            <p data-i18n="projects.subtitle">Algunos proyectos en los que he trabajado, del backend a la infraestructura.</p>
        </div>
        <div class="projects-grid" id="projectsGrid"></div>
    </div>
</section>

<!-- CV -->
<section id="cv" class="section section-alt">
    <div class="container">
        <div class="section-head reveal">
            <span class="section-tag" data-i18n="section.cv">CV</span>
            <h2 data-i18n="cv.title">Mi currículum</h2>
        </div>
        <div class="cv-card reveal">
            <div class="cv-info" id="cvInfo"></div>
            <div class="cv-actions">
                <a id="cvDownload" class="btn btn-primary" href="assets/pdfs/CV_JuanFranciscoOjedaBecerra.pdf" download>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 3v10.17l3.59-3.58L17 11l-5 5-5-5 1.41-1.41L12 13.17V3h2z" />
                        <path d="M5 19h14v2H5v-2z" />
                    </svg>
                    <span data-i18n="cv.download_pdf">Descargar PDF</span>
                </a>
                <button id="cvPrint" class="btn btn-ghost">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 8H5c-1.66 0-3 1.34-3 3v6h4v4h12v-4h4v-6c0-1.66-1.34-3-3-3z" />
                        <path d="M17 4H7v4h10V4z" />
                        <circle cx="17" cy="14" r=".5" />
                    </svg>
                    <span data-i18n="cv.print">Imprimir / guardar PDF</span>
                </button>
            </div>
        </div>
    </div>
</section>