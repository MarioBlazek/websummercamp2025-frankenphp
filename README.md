# 🐘 Web Summer Camp 2025 – FrankenPHP Workshop

This project is a Symfony-based demo for the [Web Summer Camp 2025](https://websummercamp.com/2025) workshop, demonstrating how to migrate to FrankenPHP, integrate async workers, and use Mercure for real-time updates.

---

## 🧰 Requirements

Before you begin, make sure you have the following tools installed on your machine:

- [Docker](https://www.docker.com/products/docker-desktop)
- [Docker Compose](https://docs.docker.com/compose/) (comes bundled with Docker Desktop)
- [Make](https://www.gnu.org/software/make/) (available by default on macOS and Linux; install via [Chocolatey](https://community.chocolatey.org/packages/make) or [Scoop](https://scoop.sh/) on Windows)

> 💡 You do **not** need to install PHP, Composer, or a local database — everything runs inside Docker.

---

## 🚀 Getting Started

```bash
git clone https://github.com/MarioBlazek/websummercamp2025-frankenphp.git wsc2025
cd wsc2025
make build         # Build Docker containers
make up            # Start containers in background
make install       # Install PHP dependencies via Composer (inside container)
make db            # Create DB, run migrations, and seed poll data
```
---

## 🌐 Access the App

Once everything is set up, open your browser and go to:

- [http://localhost:8010](http://localhost:8010)

If everything went well, you should see a Symfony 7 welcome page running inside Docker.

✅ That's it for now — see you soon at the workshop!
