# GlowHub2 - Admin Panel User Guide

## 🎯 Panduan Penggunaan Admin Panel

### Login & Dashboard

1. **Akses Admin Panel**

    - URL: `http://localhost:8000/admin`
    - Dashboard menampilkan statistik dan overview

2. **Navigation Menu**
    - **Dashboard**: Overview sistem
    - **Content**: Kelola artikel dan halaman
    - **Categories**: Kelola kategori konten
    - **Services**: Kelola layanan MUA
    - **Testimonials**: Kelola review pelanggan
    - **Hero Sections**: Kelola banner utama
    - **How It Works**: Kelola proses workflow

---

## 📝 Content Management

### Membuat Content Baru

1. **Akses Content Management**

    - Klik menu "Content" di sidebar
    - Klik tombol "Add New Content"

2. **Form Input**

    ```
    ✅ Title: Judul content (wajib)
    ✅ Slug: URL-friendly name (auto-generate)
    ✅ Category: Pilih kategori
    ✅ Type: page/article/service/portfolio/other
    ✅ Content: Editor WYSIWYG (TinyMCE)
    ✅ Excerpt: Ringkasan content
    ✅ Featured Image: Upload gambar utama
    ✅ Status: published/draft/archived
    ✅ Featured: Tandai sebagai unggulan
    ```

3. **Tips Content**
    - Gunakan heading structure (H1, H2, H3)
    - Tambahkan gambar untuk menarik pembaca
    - Tulis excerpt yang menarik (150-160 karakter)
    - Preview sebelum publish

### Filter & Search Content

-   **Search Box**: Cari berdasarkan title/content
-   **Category Filter**: Filter berdasarkan kategori
-   **Status Filter**: published/draft/archived
-   **Type Filter**: Jenis content

---

## 📁 Category Management

### Membuat Kategori

1. **Form Kategori**

    ```
    ✅ Name: Nama kategori
    ✅ Slug: URL-friendly (auto-generate)
    ✅ Description: Deskripsi kategori
    ```

2. **Best Practices**
    - Gunakan nama yang descriptive
    - Maksimal 2-3 level kategori
    - Konsisten dengan naming convention

---

## 🎨 Service Management

### Membuat Service Baru

1. **Basic Information**

    ```
    ✅ Title: Nama layanan
    ✅ Slug: URL identifier
    ✅ Description: Detail layanan lengkap
    ```

2. **Pricing & Features**

    ```
    ✅ Price From: Harga mulai dari
    ✅ Price To: Harga sampai (optional)
    ✅ Duration: Durasi dalam menit
    ✅ Features: Array fitur layanan
    ```

3. **Visual Elements**

    ```
    ✅ Icon: FontAwesome class (contoh: fas fa-palette)
    ✅ Image: Upload gambar layanan
    ✅ Sort Order: Urutan tampil
    ```

4. **Status Management**
    ```
    ✅ Active: Tampil di website
    ✅ Featured: Layanan unggulan
    ```

### Tips Service Management

-   **Icon Selection**: Kunjungi [FontAwesome](https://fontawesome.com/icons)
-   **Image Quality**: Gunakan gambar minimal 800x600px
-   **Features Format**: Gunakan bullet points yang jelas
-   **Pricing**: Berikan range harga yang realistis

---

## ⭐ Testimonial System

### Input Testimonial

1. **Customer Information**

    ```
    ✅ Name: Nama pelanggan
    ✅ Email: Email pelanggan
    ✅ Image: Foto pelanggan (optional)
    ```

2. **Review Content**
    ```
    ✅ Content: Isi testimonial
    ✅ Rating: 1-5 bintang
    ✅ Status: active/inactive
    ```

### Best Practices

-   **Authentic Reviews**: Gunakan testimonial asli
-   **Varied Ratings**: Mix antara 4-5 star reviews
-   **Photo Guidelines**: Foto pelanggan yang profesional
-   **Content Length**: 50-150 kata optimal

---

## 🖼️ Hero Section Management

### Setup Hero Banner

1. **Content Setup**

    ```
    ✅ Title: Judul utama yang menarik
    ✅ Subtitle: Sub-judul pendukung
    ✅ Description: Deskripsi detail value proposition
    ```

2. **Call-to-Action**

    ```
    ✅ Button Text: Teks tombol (contoh: "Browse Artists")
    ✅ Button URL: Link tujuan tombol
    ```

3. **Visual Design**
    ```
    ✅ Background Image: Gambar background HD
    ```

### Design Tips

-   **Title**: Maksimal 60 karakter
-   **Description**: 150-200 karakter
-   **Background**: Resolusi minimal 1920x1080px
-   **CTA Button**: Gunakan action words

---

## 🔄 How It Works Process

### Setup Process Steps

1. **Step Information**

    ```
    ✅ Title: Judul langkah
    ✅ Description: Penjelasan detail
    ✅ Step Number: Urutan proses (1, 2, 3...)
    ```

2. **Visual Elements**
    ```
    ✅ Icon: FontAwesome icon class
    ✅ Image: Gambar ilustrasi (optional)
    ✅ Status: active/inactive
    ```

### Process Design Guidelines

-   **Steps**: Maksimal 3-5 langkah
-   **Title**: Singkat dan jelas (2-4 kata)
-   **Description**: 1-2 kalimat explanation
-   **Icons**: Konsisten dengan brand style

---

## 📱 Mobile Admin Usage

### Mobile Navigation

1. **Sidebar Menu**

    - Tap hamburger button (☰) untuk buka menu
    - Tap overlay untuk tutup menu
    - Menu collapse otomatis setelah pilih item

2. **Table Views**

    - Desktop: Table format
    - Mobile: Card format dengan action buttons
    - Swipe actions untuk quick access

3. **Form Input**
    - Form fields stack vertically
    - Touch-friendly buttons
    - Auto-zoom prevention pada input

### Mobile Best Practices

-   **Image Upload**: Gunakan kamera langsung dari mobile
-   **Text Input**: Manfaatkan voice-to-text
-   **Navigation**: Gunakan browser bookmark untuk quick access

---

## 🔧 Advanced Features

### Bulk Actions

1. **Content Management**

    - Select multiple items dengan checkbox
    - Bulk publish/draft/archive
    - Bulk delete dengan confirmation

2. **Category Assignment**
    - Bulk assign kategori ke multiple content
    - Bulk status changes

### Search & Filter

1. **Global Search**

    - Search across title dan content
    - Real-time search results
    - Search highlighting

2. **Advanced Filters**
    - Kombinasi multiple filters
    - Date range filtering
    - Status combinations

### Image Management

1. **Upload Guidelines**

    - Max file size: 2MB
    - Supported formats: JPG, PNG, GIF
    - Auto-resize untuk optimasi

2. **Storage Management**
    - Files tersimpan di `storage/app/public/`
    - Auto-cleanup untuk file yang tidak terpakai
    - CDN ready untuk production

---

## 🚨 Troubleshooting Common Issues

### Upload Issues

**Problem**: Gambar tidak muncul
**Solution**:

```bash
php artisan storage:link
chmod -R 755 storage/
```

### Performance Issues

**Problem**: Admin panel lambat
**Solution**:

-   Clear browser cache
-   Optimize database dengan index
-   Enable Laravel caching

### Mobile Issues

**Problem**: Layout rusak di mobile
**Solution**:

-   Hard refresh browser (Ctrl+F5)
-   Clear browser cache
-   Update browser ke versi terbaru

---

## 📊 Dashboard Metrics

### Statistics Cards

1. **Content Statistics**

    - Total contents
    - Published contents
    - Draft contents
    - Content growth

2. **Service Metrics**

    - Active services
    - Featured services
    - Service bookings
    - Revenue tracking

3. **Customer Engagement**
    - Total testimonials
    - Average rating
    - Customer satisfaction
    - Review trends

### Quick Actions

-   **Recent Contents**: 5 content terbaru
-   **Pending Reviews**: Testimonials yang perlu approval
-   **Quick Links**: Shortcut ke form creation
-   **System Status**: Health check

---

## 💡 Tips & Best Practices

### Content Strategy

1. **SEO Optimization**

    - Gunakan keywords dalam title
    - Meta description yang menarik
    - Alt text untuk semua gambar
    - Internal linking strategy

2. **Content Calendar**
    - Plan content schedule
    - Batch creation untuk efisiensi
    - Regular content updates
    - Seasonal content planning

### User Experience

1. **Navigation Design**

    - Clear menu structure
    - Breadcrumb navigation
    - Search functionality
    - Mobile-first approach

2. **Performance Optimization**
    - Compress gambar sebelum upload
    - Minimal plugin usage
    - Regular database cleanup
    - Monitor loading times

---

**Happy Managing!** 🎉

Untuk bantuan lebih lanjut, silakan refer ke dokumentasi lengkap atau submit issue di repository GitHub.
