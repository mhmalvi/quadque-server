# Quadque Server

The rewritten backend server for the **Quadque Technologies** digital platform. Built on Laravel 8 with a Vue.js frontend layer, this application serves as the primary API and web backend powering the Quadque ecosystem, handling authentication, content management, media processing, and client-facing services.

Part of the **Quadque digital platform ecosystem**.

---

## Features

- RESTful API architecture with Laravel Sanctum token-based authentication
- Vue 2 frontend with Element UI and rich text editing (TinyMCE, CKEditor, Tiptap)
- Media management with video playback (Video.js, DPlayer)
- Full-page layouts with carousel components and marquee animations
- Lottie animation integration for dynamic visual content
- Mailgun email integration for transactional communications
- User agent detection for device-specific responses
- Database migrations and seeders for structured schema management
- SASS/SCSS preprocessing with Laravel Mix build pipeline
- Bootstrap 5 responsive layout foundation

## Tech Stack

| Layer        | Technology                                          |
|--------------|------------------------------------------------------|
| Backend      | PHP 7.3+/8.0, Laravel 8                             |
| Frontend     | Vue 2, Element UI, Bootstrap 5                       |
| Auth         | Laravel Sanctum                                      |
| Database     | MySQL (via Doctrine DBAL)                            |
| Email        | Symfony Mailgun Mailer                               |
| Rich Text    | TinyMCE, CKEditor 4, Tiptap                         |
| Media        | Video.js, Vue DPlayer, Lottie                        |
| Build        | Laravel Mix 6, Webpack, SASS                         |
| Testing      | PHPUnit 9, Mockery, Faker                            |

## Getting Started

### Prerequisites

- PHP >= 7.3
- Composer
- Node.js >= 14
- MySQL

### Installation

```bash
git clone https://github.com/mhmalvi/quadque-server.git
cd quadque-server
composer install
npm install
```

### Environment Configuration

```bash
cp .env-example .env
php artisan key:generate
```

Update `.env` with your database credentials, Mailgun keys, and application settings.

### Database Setup

```bash
php artisan migrate
php artisan db:seed
```

### Development

```bash
php artisan serve
npm run dev
```

### Production Build

```bash
npm run production
```

## Project Structure

```
quadque-server/
├── app/                 # Application logic (Models, Controllers, Middleware)
├── bootstrap/           # Framework bootstrap files
├── config/              # Configuration files
├── database/
│   ├── factories/       # Model factories
│   ├── migrations/      # Database migrations
│   └── seeders/         # Database seeders
├── public/              # Public assets and entry point
├── resources/
│   ├── js/              # Vue components and JavaScript
│   ├── views/           # Blade templates
│   └── css/             # Stylesheets
├── routes/
│   ├── api.php          # API routes
│   └── web.php          # Web routes
├── storage/             # Logs, cache, and uploaded files
├── tests/               # PHPUnit test suites
└── webpack.mix.js       # Laravel Mix configuration
```

## License

Proprietary — Quadque Technologies. All rights reserved.
