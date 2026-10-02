// ============================================================================
//  LÓGICA PRINCIPAL: render dinámico, idioma, menú, animaciones y CV.
// ============================================================================

(function () {
  "use strict";

  const state = {
    lang: "es",
    savedLangKey: "portafolio-lang"
  };

  // ---------- Utilidades ----------
  const $ = (sel) => document.querySelector(sel);
  const $$ = (sel) => Array.from(document.querySelectorAll(sel));

  const t = (key) => I18N[state.lang][key] || key;

  // Devuelve el texto en el idioma activo si el objeto es { es, en }
  const L = (obj) =>
    obj && typeof obj === "object"
      ? obj[state.lang] ?? obj.es ?? ""
      : obj;

  const esc = (str) =>
    String(str).replace(/[&<>"']/g, (c) => ({
      "&": "&amp;",
      "<": "&lt;",
      ">": "&gt;",
      '"': "&quot;",
      "'": "&#39;"
    }[c]));

  // ---------- Iconos SVG ----------
  const ICONS = {
    code: '<path d="m8 7-5 5 5 5"/><path d="m16 7 5 5-5 5"/><path d="m13 5-2 14"/>',
    server: '<rect x="2" y="2" width="20" height="8" rx="2"/><rect x="2" y="14" width="20" height="8" rx="2"/><line x1="6" y1="6" x2="6.01" y2="6"/><line x1="6" y1="18" x2="6.01" y2="18"/>',
    docker: '<path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/>',
    layout: '<rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/>',
    database: '<ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/>',
    rocket: '<path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"/><path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"/><path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"/><path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"/>',
    briefcase: '<rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>',
    graduation: '<path d="M22 10 12 5 2 10l10 5 10-5z"/><path d="M6 12v5c0 1.66 2.69 3 6 3s6-1.34 6-3v-5"/>',
    external: '<path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/>',
    link: '<path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>',
    mail: '<rect x="2" y="4" width="20" height="16" rx="2"/><path d="m2 6 10 7L22 6"/>'
  };

  const SOCIAL = {
    github:
      '<svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 .5C5.65.5.5 5.65.5 12c0 5.08 3.29 9.39 7.86 10.91.58.11.79-.25.79-.56 0-.27-.01-1.17-.02-2.13-3.2.7-3.88-1.36-3.88-1.36-.52-1.33-1.28-1.68-1.28-1.68-1.04-.71.08-.7.08-.7 1.15.08 1.76 1.18 1.76 1.18 1.03 1.76 2.7 1.25 3.36.96.1-.75.4-1.25.72-1.54-2.55-.29-5.23-1.28-5.23-5.68 0-1.26.45-2.28 1.18-3.09-.12-.29-.51-1.46.11-3.05 0 0 .96-.31 3.15 1.18a10.9 10.9 0 0 1 5.74 0c2.19-1.49 3.15-1.18 3.15-1.18.62 1.59.23 2.76.11 3.05.73.81 1.18 1.83 1.18 3.09 0 4.41-2.69 5.38-5.25 5.67.41.35.77 1.05.77 2.12 0 1.53-.01 2.76-.01 3.14 0 .31.21.67.8.55A11.51 11.51 0 0 0 23.5 12C23.5 5.65 18.35.5 12 .5z"/></svg>',
    linkedin:
      '<svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20.45 20.45h-3.55v-5.57c0-1.33-.03-3.04-1.85-3.04-1.86 0-2.14 1.45-2.14 2.94v5.67H9.36V9h3.41v1.56h.05c.47-.9 1.63-1.85 3.36-1.85 3.6 0 4.27 2.37 4.27 5.45v6.29zM5.34 7.43a2.06 2.06 0 1 1 0-4.12 2.06 2.06 0 0 1 0 4.12zM7.12 20.45H3.56V9h3.56v11.45z"/></svg>',
    mail:
      '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m2 6 10 7L22 6"/></svg>'
  };

  const icon = (name, size) =>
    `<svg width="${size || 20}" height="${size || 20}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">${ICONS[name] || ""}</svg>`;

  // ---------- Render: perfil / hero ----------
  function renderProfile() {
    const p = PORTFOLIO.profile;

    $("#logoName").textContent = p.name.split(" ")[0];
    $("#heroName").textContent = p.name;
    $("#heroRole").textContent = L(p.role);
    $("#heroTagline").textContent = L(p.tagline);

    document.title = `${p.name} · ${L(p.role)}`;

    $("#contactEmail").textContent = p.email;
    $("#contactEmail").href = `mailto:${p.email}`;

    const socials = $("#socials");
    const items = [
      { href: p.github, label: "GitHub", svg: SOCIAL.github },
      { href: p.linkedin, label: "LinkedIn", svg: SOCIAL.linkedin },
      { href: `mailto:${p.email}`, label: "Email", svg: SOCIAL.mail }
    ];
    socials.innerHTML = items
      .filter((i) => i.href)
      .map(
        (i) =>
          `<a class="social" href="${esc(i.href)}" target="_blank" rel="noopener noreferrer" aria-label="${i.label}">${i.svg}</a>`
      )
      .join("");

    const stats = [
      { value: p.stats.years, label: t("hero.stat_years") },
      { value: p.stats.projects, label: t("hero.stat_projects") },
      { value: p.stats.tech, label: t("hero.stat_tech") }
    ];
    $("#heroStats").innerHTML = stats
      .map(
        (s) =>
          `<div class="stat"><span class="stat-value">${esc(s.value)}</span><span class="stat-label">${esc(s.label)}</span></div>`
      )
      .join("");
  }

  // ---------- Render: sobre mí ----------
  function renderAbout() {
    const p = PORTFOLIO.profile;

    $("#aboutText").innerHTML = p.bio
      .map((b) => `<p>${L(b)}</p>`)
      .join("");

    $("#aboutHighlights").innerHTML = p.highlights
      .map(
        (h) => `
        <div class="highlight reveal">
          <div class="highlight-icon">${icon(h.icon, 22)}</div>
          <div>
            <h3>${esc(L(h.title))}</h3>
            <p>${esc(L(h.text))}</p>
          </div>
        </div>`
      )
      .join("");
  }

  // ---------- Render: tecnologías ----------
  function renderSkills() {
    const groups = PORTFOLIO.skills.groups;
    const el = $("#skillsGroups");

    el.innerHTML = groups
      .map(
        (g) => `
        <div class="skill-group reveal">
          <div class="skill-group-head">
            <span class="skill-group-icon">${icon(g.icon, 20)}</span>
            <h3>${esc(L(g.title))}</h3>
          </div>
          <div class="skill-badges">
            ${g.items.map((item) => `<span class="skill-badge">${esc(item)}</span>`).join("")}
          </div>
        </div>`
      )
      .join("");
  }

  // ---------- Render: proyectos ----------
  function renderProjects() {
    const projects = PORTFOLIO.projects;
    const el = $("#projectsGrid");

    el.innerHTML = projects
      .map(
        (pr) => `
        <article class="project-card reveal">
          <div class="project-top">
            <h3>${esc(pr.name)}</h3>
            ${pr.year ? `<span class="project-year">${esc(pr.year)}</span>` : ""}
          </div>
          <p class="project-desc">${esc(L(pr.description))}</p>
          <div class="project-tags">
            ${pr.tags.map((tag) => `<span class="tag">${esc(tag)}</span>`).join("")}
          </div>
          <div class="project-links">
            ${pr.live ? `<a href="${esc(pr.live)}" target="_blank" rel="noopener noreferrer">${icon("external", 16)} <span>${t("projects.live")}</span></a>` : ""}
            ${pr.repo ? `<a href="${esc(pr.repo)}" target="_blank" rel="noopener noreferrer">${icon("link", 16)} <span>${t("projects.repo")}</span></a>` : ""}
          </div>
        </article>`
      )
      .join("");
  }

  // ---------- Render: sección CV ----------
  function renderCvInfo() {
    const p = PORTFOLIO.profile;
    const backendGroup =
      PORTFOLIO.skills.groups.find((g) => g.id === "backend") ||
      PORTFOLIO.skills.groups[0] ||
      { items: [] };
    const stack = backendGroup.items.slice(0, 4).join(", ");

    const facts = [
      { icon: "database", label: t("cv.facts_stack"), value: stack },
      { icon: "server", label: t("cv.facts_location"), value: L(p.location) },
      { icon: "mail", label: t("cv.facts_email"), value: p.email }
    ];

    $("#cvInfo").innerHTML = `
      <p>${L(p.bio[0])}</p>
      <ul class="cv-facts">
        ${facts
          .map(
            (f) => `
          <li>
            <span class="cv-fact-icon">${icon(f.icon, 18)}</span>
            <span class="cv-fact-label">${esc(f.label)}</span>
            <span class="cv-fact-value">${esc(f.value)}</span>
          </li>`
          )
          .join("")}
      </ul>`;
  }

  // ---------- Render: CV imprimible ----------
  function renderCvPrint() {
    const p = PORTFOLIO.profile;

    const skillsHtml = PORTFOLIO.skills.groups
      .map(
        (g) => `
        <div class="cvp-skill-group">
          <h4>${esc(L(g.title))}</h4>
          <p>${esc(g.items.join(" · "))}</p>
        </div>`
      )
      .join("");

    const expHtml = PORTFOLIO.experience
      .map(
        (e) => `
        <div class="cvp-item">
          <div class="cvp-item-head">
            <h4>${esc(L(e.role))}</h4>
            <span>${esc(e.period ? L(e.period) : "")}</span>
          </div>
          <p class="cvp-company">${esc(e.company)}</p>
          <p>${esc(L(e.description))}</p>
        </div>`
      )
      .join("");

    const eduHtml = PORTFOLIO.education
      .map(
        (e) => `
        <div class="cvp-item">
          <div class="cvp-item-head">
            <h4>${esc(L(e.degree))}</h4>
            <span>${esc(e.period)}</span>
          </div>
          <p class="cvp-company">${esc(e.school)}</p>
        </div>`
      )
      .join("");

    $("#cv-print").innerHTML = `
      <div class="cvp">
        <header class="cvp-header">
          <h1>${esc(p.name)}</h1>
          <p class="cvp-role">${esc(L(p.role))}</p>
          <p class="cvp-contact">
            ${esc(p.email)} · ${esc(L(p.location))}
            ${p.github ? ` · github.com/${esc(p.github.replace(/^https?:\/\/(www\.)?github\.com\//, ""))}` : ""}
            ${p.linkedin ? ` · linkedin.com/in/${esc(p.linkedin.replace(/^https?:\/\/(www\.)?linkedin\.com\/in\//, ""))}` : ""}
          </p>
        </header>

        <section class="cvp-section">
          <h2>${t("cv.section_profile")}</h2>
          <p>${L(p.tagline)} ${L(p.bio[1])}</p>
        </section>

        <section class="cvp-section">
          <h2>${t("cv.section_experience")}</h2>
          ${expHtml}
        </section>

        <section class="cvp-section">
          <h2>${t("cv.section_education")}</h2>
          ${eduHtml}
        </section>

        <section class="cvp-section">
          <h2>${t("cv.section_skills")}</h2>
          <div class="cvp-skills">${skillsHtml}</div>
        </section>
      </div>`;
  }

  // ---------- Idioma ----------
  function applyLang(lang) {
    state.lang = lang;
    localStorage.setItem(state.savedLangKey, lang);
    document.documentElement.lang = lang;

    $$("[data-i18n]").forEach((el) => {
      el.textContent = t(el.dataset.i18n);
    });

    const toggle = $("#langToggle");
    toggle.textContent = lang === "es" ? "EN" : "ES";

    renderProfile();
    renderAbout();
    renderSkills();
    renderProjects();
    renderCvInfo();
    renderCvPrint();
    renderFooter();

    revealObserve();
  }

  function initLang() {
    const saved = localStorage.getItem(state.savedLangKey);
    let lang = saved;
    if (!lang) {
      lang = (navigator.language || "es").toLowerCase().startsWith("en") ? "en" : "es";
    }
    applyLang(lang);
  }

  // ---------- Menú móvil ----------
  function initMenu() {
    const toggle = $("#menuToggle");
    const links = $("#navLinks");
    const header = $("#siteHeader");

    toggle.addEventListener("click", () => {
      links.classList.toggle("open");
      toggle.classList.toggle("open");
    });

    links.addEventListener("click", (e) => {
      if (e.target.closest("a")) {
        links.classList.remove("open");
        toggle.classList.remove("open");
      }
    });

    window.addEventListener("scroll", () => {
      header.classList.toggle("scrolled", window.scrollY > 20);
    }, { passive: true });
  }

  // ---------- Nav activo (scroll spy) ----------
  function initScrollSpy() {
    const sections = $$("section[id]");
    const navLinks = $$(".nav-link");

    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            const id = entry.target.id;
            navLinks.forEach((link) => {
              link.classList.toggle("active", link.getAttribute("href") === `#${id}`);
            });
          }
        });
      },
      { rootMargin: "-45% 0px -50% 0px" }
    );

    sections.forEach((s) => observer.observe(s));
  }

  // ---------- Animación de aparición ----------
  let revealObserver = null;
  function revealObserve() {
    if (revealObserver) revealObserver.disconnect();
    revealObserver = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add("in-view");
            revealObserver.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.12 }
    );
    $$(".reveal:not(.in-view)").forEach((el) => revealObserver.observe(el));
  }

  // ---------- CV: imprimir ----------
  function initCvPrint() {
    $("#cvPrint").addEventListener("click", () => {
      window.print();
    });
  }

  // ---------- Footer ----------
  function renderFooter() {
    $("#footerRights").textContent = t("footer.rights").replace("{year}", new Date().getFullYear());
  }

  // ---------- Init ----------
  document.addEventListener("DOMContentLoaded", () => {
    $("#langToggle").addEventListener("click", () => {
      applyLang(state.lang === "es" ? "en" : "es");
    });

    initLang();
    initMenu();
    initScrollSpy();
    initCvPrint();
    renderFooter();
    revealObserve();
  });
})();
