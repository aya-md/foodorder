# FoodOrder

A multi-vendor food ordering platform built with Laravel — a lightweight, white-label ordering system independent restaurants, cafés, and food trucks can use to take orders online, manage their menu, and fulfill orders in real time.

Built as an internship project at Zydev.

## Features

- **Multi-vendor**: any number of independent businesses, each with their own menu, staff, and orders — fully isolated from one another
- **No-login customer ordering**: browse, order, and track status via a guest session — no account required
- **QR-code table ordering**: dine-in customers scan a table's code and land straight on checkout with their table pre-filled
- **Real-time updates**: live order status via Laravel Reverb (WebSockets) — kitchen staff see new orders instantly; customers see status changes on their tracking page without refreshing
- **Role-based access**: business owner, kitchen staff, and platform super admin, each with their own scoped view
- **Stats dashboard**: daily orders/revenue and top-selling items, with charts
- **Two visual identities**: a warm, receipt-styled theme for customers; a dense, dark console theme for the back office

## Tech Stack

Laravel 13 · PHP 8.5 · MySQL · Laravel Reverb · Tailwind CSS · Alpine.js · Chart.js

## Running Locally

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm run build
```

Start these three, each in its own terminal:

```bash
php artisan serve          # the app itself
npm run dev                # asset compilation (dev mode)
php artisan reverb:start   # real-time WebSocket server
```

Visit `http://localhost:8000`.

## Running with Docker

The entire stack — app, Nginx, MySQL, and Reverb — runs as four coordinated containers.

```bash
cp .env .env.docker
```

Then edit `.env.docker`, setting:

DB_HOST=db
DB_PORT=3306
REVERB_HOST=reverb

Build and start:
```bash
docker compose build
docker compose up -d
docker compose exec app php artisan migrate
docker compose exec app php artisan session:table
docker compose exec app php artisan migrate
```

Visit `http://localhost:8000`.

## Testing

```bash
php artisan test
```

Covers authentication, checkout (including price snapshotting and validation), and tenant isolation — automated proof that one business can never see or modify another's orders.

## CI

Every push to `main` runs automatically via GitHub Actions (`.github/workflows/ci.yml`):
- Code style check (Laravel Pint)
- Full test suite
- Docker image build verification

## Project Structure Notes

- `app/Models/Concerns/BelongsToBusiness.php` — the trait enforcing tenant isolation across every business-owned model
- `resources/css/console.css` / `ticket.css` — the two visual themes, each scoped under its own wrapper class so they never conflict
- `docker/nginx.conf` — Nginx config routing requests to PHP-FPM

Item photo uploads require the storage symlink to be created *inside* the container specifically — running `storage:link` on your host machine creates a symlink pointing to a host-only path that won't resolve inside Docker.
docker compose exec app php artisan storage:link
