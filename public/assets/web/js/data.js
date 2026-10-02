// ============================================================================
//  DATOS DEL PORTAFOLIO
//  Edita TODO aquí: tu información, tecnologías y proyectos.
//  - Para agregar una tecnología: agrega un string al array "items" de su grupo.
//  - Para agregar un grupo nuevo de tecnologías: agrega un objeto al array "groups".
//  - Para agregar un proyecto: agrega un objeto al array "projects".
//  - Los textos con { es, en } se traducen automáticamente con el toggle ES/EN.
// ============================================================================

const PORTFOLIO = {
  // ----------------------- Perfil -----------------------
  profile: {
    name: "Tu Nombre",
    role: {
      es: "Fullstack Developer · Enfoque Backend",
      en: "Fullstack Developer · Backend Focus"
    },
    tagline: {
      es: "Construyo APIs, servicios y sistemas que escalan. Me apasiona el backend, la automatización y mis servidores homelab.",
      en: "I build APIs, services and scalable systems. I'm passionate about backend, automation and my homelab servers."
    },
    bio: [
      {
        es: "Hola, soy <strong>Tu Nombre</strong>. Desarrollador fullstack con foco especial en backend, trabajando principalmente con <strong>PHP, Python, Node.js y JavaScript</strong>. Me gusta entender el sistema completo: desde la base de datos hasta el despliegue.",
        en: "Hi, I'm <strong>Your Name</strong>. Fullstack developer with a strong backend focus, working mainly with <strong>PHP, Python, Node.js and JavaScript</strong>. I like to understand the whole system: from the database to deployment."
      },
      {
        es: "Fuera del código administro mi propio <strong>homelab con Proxmox</strong>, donde pruebo <strong>Docker, CI/CD y despliegues</strong> en un entorno que controlo al 100%. También conozco Java y Go, y siempre estoy aprendiendo algo nuevo.",
        en: "Outside of code, I run my own <strong>homelab with Proxmox</strong>, where I try out <strong>Docker, CI/CD and deployments</strong> in an environment I control 100%. I also know Java and Go, and I'm always learning something new."
      }
    ],
    highlights: [
      {
        icon: "server",
        title: { es: "Homelab & Proxmox", en: "Homelab & Proxmox" },
        text: {
          es: "Administro servidores virtualizados con Proxmox en casa para experimentar sin límites.",
          en: "I run virtualized servers with Proxmox at home to experiment without limits."
        }
      },
      {
        icon: "docker",
        title: { es: "Docker & CI/CD", en: "Docker & CI/CD" },
        text: {
          es: "Containerizo aplicaciones y automatizo despliegues con pipelines de CI/CD.",
          en: "I containerize applications and automate deployments with CI/CD pipelines."
        }
      },
      {
        icon: "code",
        title: { es: "Backend-first", en: "Backend-first" },
        text: {
          es: "APIs, lógica de negocio y arquitecturas robustas, sin descuidar el frontend.",
          en: "APIs, business logic and robust architectures, without neglecting the frontend."
        }
      }
    ],
    github: "https://github.com/tu-usuario",
    linkedin: "https://www.linkedin.com/in/tu-usuario",
    email: "tu@email.com",
    location: { es: "Ciudad, País", en: "City, Country" },
    stats: {
      years: "5+",
      projects: "20+",
      tech: "12+"
    }
  },

  // ------------------- Tecnologías / skills -------------------
  // Agrega o quita tecnologías en "items". Para un grupo nuevo, copia un objeto.
  skills: {
    groups: [
      {
        id: "backend",
        icon: "code",
        title: { es: "Backend", en: "Backend" },
        items: ["PHP", "Python", "Node.js", "JavaScript", "Java", "Go", "MySQL", "PostgreSQL"]
      },
      {
        id: "frontend",
        icon: "layout",
        title: { es: "Frontend", en: "Frontend" },
        items: ["HTML", "CSS", "JavaScript", "Responsive Design"]
      },
      {
        id: "devops",
        icon: "server",
        title: { es: "DevOps & Servidores", en: "DevOps & Servers" },
        items: ["Docker", "Proxmox", "Linux", "Nginx", "Git", "GitHub Actions", "CI/CD", "Homelab"]
      }
    ]
  },

  // ----------------------- Proyectos -----------------------
  // "live" y "repo" opcionales: si no los tienes aún, deja el string vacío "".
  projects: [
    {
      name: "API REST — Gestión de usuarios",
      year: "2025",
      description: {
        es: "API REST construida con PHP y MySQL con autenticación JWT, dockerizada y desplegada en el homelab con CI/CD.",
        en: "REST API built with PHP and MySQL with JWT authentication, dockerized and deployed on the homelab with CI/CD."
      },
      tags: ["PHP", "MySQL", "Docker", "JWT"],
      live: "",
      repo: "https://github.com/tu-usuario/tu-proyecto"
    },
    {
      name: "Dashboard de métricas",
      year: "2025",
      description: {
        es: "Dashboard en tiempo real con Node.js y WebSockets que consume datos de sensores del homelab y los visualiza.",
        en: "Real-time dashboard with Node.js and WebSockets that consumes homelab sensor data and visualizes it."
      },
      tags: ["Node.js", "JavaScript", "WebSockets", "Docker"],
      live: "",
      repo: "https://github.com/tu-usuario/tu-proyecto"
    },
    {
      name: "Automatización de deploys",
      year: "2024",
      description: {
        es: "Pipelines de GitHub Actions que compilan, testean y despliegan contenedores a Proxmox tras cada push.",
        en: "GitHub Actions pipelines that build, test and deploy containers to Proxmox after every push."
      },
      tags: ["Python", "Docker", "GitHub Actions", "Proxmox"],
      live: "",
      repo: "https://github.com/tu-usuario/tu-proyecto"
    }
  ],

  // --------------- Experiencia (para el CV imprimible) ---------------
  experience: [
    {
      role: { es: "Fullstack Developer", en: "Fullstack Developer" },
      company: "Empresa / Freelance",
      period: { es: "2022 — Actualidad", en: "2022 — Present" },
      description: {
        es: "Desarrollo de APIs, servicios backend y herramientas internas. Despliegues con Docker y CI/CD.",
        en: "Development of APIs, backend services and internal tools. Deployments with Docker and CI/CD."
      }
    },
    {
      role: { es: "Proyectos personales & homelab", en: "Personal projects & homelab" },
      company: "Autodidacta",
      period: { es: "2020 — Actualidad", en: "2020 — Present" },
      description: {
        es: "Administración de servidores con Proxmox, virtualización, redes y automatización de servicios propios.",
        en: "Server administration with Proxmox, virtualization, networking and automation of personal services."
      }
    }
  ],

  // ----------------- Educación (para el CV imprimible) -----------------
  education: [
    {
      degree: { es: "Ingeniería / Técnico en Informática", en: "Computer Science Degree / Diploma" },
      school: "Institución",
      period: "2020 — 2023"
    }
  ]
};
