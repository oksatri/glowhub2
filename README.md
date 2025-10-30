# GlowHub2 Backend - README

![GlowHub2 Logo](https://via.placeholder.com/400x100/ff6b6b/ffffff?text=GlowHub2+Backend)

## 🌟 Overview

**GlowHub2** adalah platform backend lengkap untuk menghubungkan makeup artist profesional dengan klien. Dibangun dengan Laravel dan PostgreSQL, sistem ini menyediakan admin panel yang powerful dan mobile-responsive untuk mengelola semua aspek platform beauty services.

### ✨ Key Features

🎨 **Content Management System** - Kelola artikel, halaman, dan konten website
📁 **Category Management** - Sistem kategori yang fleksibel dan hierarkis  
💼 **Service Catalog** - Manajemen layanan MUA dengan pricing dan features
⭐ **Testimonial System** - Sistem review dan rating pelanggan
🖼️ **Hero Section Control** - Kelola banner dan call-to-action homepage
🔄 **Process Workflow** - Manajemen "How It Works" step-by-step
📱 **Mobile Responsive** - Admin panel yang fully responsive
🔍 **Search & Filter** - Sistem pencarian dan filter yang advanced
📊 **Dashboard Analytics** - Overview dan statistik sistem

## 🚀 Quick Start

### Prasyarat

-   PHP 8.1+
-   PostgreSQL 12+
-   Composer
-   Node.js & NPM (optional)

### Instalasi Cepat

```bash
# Clone repository
git clone https://github.com/oksatri/glowhub2.git
cd glowhub2

# Install dependencies
composer install

# Setup environment
cp .env.example .env
php artisan key:generate

# Setup database
php artisan migrate:fresh
php artisan db:seed --class=DefaultContentSeeder

# Create storage link
php artisan storage:link

# Start development server
php artisan serve --host=0.0.0.0 --port=8000
```

### 🌐 Access URLs

-   **Website**: http://localhost:8000
-   **Admin Panel**: http://localhost:8000/admin

## 📋 Feature Details

### 🎯 Admin Panel Features

| Feature                 | Description                                  | Status |
| ----------------------- | -------------------------------------------- | ------ |
| **Dashboard**           | Overview dengan statistik dan quick actions  | ✅     |
| **Content Management**  | CRUD untuk artikel, halaman, dan konten      | ✅     |
| **Category System**     | Manajemen kategori dengan slug auto-generate | ✅     |
| **Service Catalog**     | Kelola layanan MUA dengan pricing fleksibel  | ✅     |
| **Testimonial Manager** | Sistem review dengan rating 1-5 bintang      | ✅     |
| **Hero Section**        | Banner homepage dengan CTA customizable      | ✅     |
| **How It Works**        | Step-by-step process workflow                | ✅     |
| **Image Upload**        | Upload dan manajemen gambar terintegrasi     | ✅     |
| **Search & Filter**     | Multi-filter dan real-time search            | ✅     |
| **Mobile Interface**    | Responsive design dengan mobile navigation   | ✅     |

## 📖 Documentation

### Available Documentation

-   **[BACKEND_DOCUMENTATION.md](BACKEND_DOCUMENTATION.md)** - Technical documentation lengkap
-   **[ADMIN_USER_GUIDE.md](ADMIN_USER_GUIDE.md)** - Panduan lengkap admin panel
-   **[CHANGELOG.md](CHANGELOG.md)** - Version history dan features

## 🎨 Screenshots

### Admin Dashboard

![Dashboard](https://via.placeholder.com/800x400/f8f9fa/333?text=GlowHub2+Admin+Dashboard)

### Content Management

![Content Management](https://via.placeholder.com/800x400/ffffff/333?text=Content+Management+Interface)

### Mobile Responsive

![Mobile Interface](https://via.placeholder.com/400x600/ff6b6b/ffffff?text=Mobile+Admin+Panel)

## 🔧 Tech Stack

-   **Framework**: Laravel 10+
-   **Database**: PostgreSQL 12+
-   **Frontend**: Bootstrap 5, FontAwesome, TinyMCE
-   **Storage**: Local/Cloud storage support
-   **Authentication**: Laravel built-in auth
-   **API**: RESTful API ready

## 📞 Support & Community

### Getting Help

-   **GitHub Issues**: Bug reports dan feature requests
-   **Documentation**: Comprehensive guides dan tutorials
-   **Code Comments**: Inline documentation dalam kode

### Contributing

1. Fork repository
2. Create feature branch
3. Commit changes
4. Push to branch
5. Open Pull Request

## 📜 License

This project is licensed under the **MIT License** - see the [LICENSE](LICENSE) file for details.

## 🏆 Acknowledgments

### Built With Love Using

-   **[Laravel](https://laravel.com)** - The PHP Framework for Web Artisans
-   **[PostgreSQL](https://postgresql.org)** - Advanced Open Source Database
-   **[Bootstrap](https://getbootstrap.com)** - CSS Framework
-   **[FontAwesome](https://fontawesome.com)** - Icon Library
-   **[TinyMCE](https://tinymce.com)** - Rich Text Editor

---

<div align="center">

**⭐ Star this repo if you find it helpful!**

**Made with ❤️ for the Beauty Industry**

[🌟 Star](https://github.com/oksatri/glowhub2) • [🐛 Report Bug](https://github.com/oksatri/glowhub2/issues) • [✨ Request Feature](https://github.com/oksatri/glowhub2/issues)

</div>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

-   [Simple, fast routing engine](https://laravel.com/docs/routing).
-   [Powerful dependency injection container](https://laravel.com/docs/container).
-   Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
-   Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
-   Database agnostic [schema migrations](https://laravel.com/docs/migrations).
-   [Robust background job processing](https://laravel.com/docs/queues).
-   [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

-   **[Vehikl](https://vehikl.com)**
-   **[Tighten Co.](https://tighten.co)**
-   **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
-   **[64 Robots](https://64robots.com)**
-   **[Curotec](https://www.curotec.com/services/technologies/laravel)**
-   **[DevSquad](https://devsquad.com/hire-laravel-developers)**
-   **[Redberry](https://redberry.international/laravel-development)**
-   **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
