<?php
/**
 * Auto Fix Script untuk CodeIgniter 4.5+
 * Script ini akan otomatis memperbaiki file public/index.php
 * 
 * Cara pakai:
 * 1. Copy script ini ke root folder proyek Anda
 * 2. Jalankan: php auto-fix.php
 */

echo "==============================================\n";
echo " AUTO FIX CODEIGNITER 4.5+ - ALMI ARSIP\n";
echo "==============================================\n\n";

// Cek apakah di root folder yang benar
if (!file_exists('public/index.php')) {
    echo "❌ ERROR: File public/index.php tidak ditemukan!\n";
    echo "   Pastikan Anda menjalankan script ini di root folder proyek.\n\n";
    exit(1);
}

echo "📁 Lokasi proyek: " . getcwd() . "\n\n";

// Backup file lama
echo "💾 Membuat backup...\n";
$backupFile = 'public/index.php.backup-' . date('YmdHis');
if (copy('public/index.php', $backupFile)) {
    echo "   ✅ Backup berhasil: $backupFile\n\n";
} else {
    echo "   ❌ Gagal membuat backup!\n\n";
    exit(1);
}

// Baca file index.php
echo "📖 Membaca file public/index.php...\n";
$content = file_get_contents('public/index.php');

// Cek apakah sudah menggunakan Boot.php
if (strpos($content, "DIRECTORY_SEPARATOR . 'Boot.php'") !== false) {
    echo "   ℹ️  File sudah menggunakan Boot.php\n\n";
} else {
    // Ganti bootstrap.php dengan Boot.php
    echo "🔧 Memperbaiki bootstrap.php → Boot.php...\n";
    $content = str_replace(
        "DIRECTORY_SEPARATOR . 'bootstrap.php'",
        "DIRECTORY_SEPARATOR . 'Boot.php'",
        $content
    );
    echo "   ✅ Berhasil diganti\n\n";
}

// Cek apakah sudah ada definisi ENVIRONMENT
if (strpos($content, "if (!defined('ENVIRONMENT'))") !== false) {
    echo "   ℹ️  Definisi ENVIRONMENT sudah ada\n\n";
} else {
    // Tambahkan definisi ENVIRONMENT setelah load .env
    echo "🔧 Menambahkan definisi ENVIRONMENT...\n";
    
    $envDefinition = "\n// Define ENVIRONMENT from .env file if not already defined\nif (!defined('ENVIRONMENT')) {\n    define('ENVIRONMENT', env('CI_ENVIRONMENT', 'production'));\n}\n";
    
    // Cari posisi setelah load .env
    $pattern = "/(new CodeIgniter\\\\Config\\\\DotEnv\(ROOTPATH\)\)->load\(\);/";
    $replacement = "$1" . $envDefinition;
    
    $content = preg_replace($pattern, $replacement, $content);
    echo "   ✅ ENVIRONMENT definition ditambahkan\n\n";
}

// Simpan file yang sudah diperbaiki
echo "💾 Menyimpan file yang diperbaiki...\n";
if (file_put_contents('public/index.php', $content)) {
    echo "   ✅ File berhasil disimpan\n\n";
} else {
    echo "   ❌ Gagal menyimpan file!\n\n";
    exit(1);
}

// Verifikasi file .env
echo "🔍 Memeriksa file .env...\n";
if (file_exists('.env')) {
    $envContent = file_get_contents('.env');
    
    // Cek CI_ENVIRONMENT
    if (preg_match('/CI_ENVIRONMENT\s*=/', $envContent)) {
        echo "   ✅ CI_ENVIRONMENT sudah terdefinisi\n";
    } else {
        echo "   ⚠️  WARNING: CI_ENVIRONMENT belum terdefinisi di .env\n";
        echo "       Tambahkan: CI_ENVIRONMENT = development\n";
    }
    
    // Cek database config
    if (preg_match('/database\.default\.hostname/', $envContent)) {
        echo "   ✅ Konfigurasi database ditemukan\n";
    } else {
        echo "   ⚠️  WARNING: Konfigurasi database belum lengkap\n";
    }
    echo "\n";
} else {
    echo "   ❌ File .env tidak ditemukan!\n";
    echo "      Copy file 'env' menjadi '.env' dan sesuaikan konfigurasi.\n\n";
}

// Cek permission writable folder
echo "🔍 Memeriksa folder writable/...\n";
if (is_writable('writable')) {
    echo "   ✅ Folder writable dapat ditulis\n\n";
} else {
    echo "   ⚠️  WARNING: Folder writable tidak dapat ditulis!\n";
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        echo "      Jalankan: icacls writable /grant Everyone:F /T\n\n";
    } else {
        echo "      Jalankan: chmod -R 777 writable/\n\n";
    }
}

echo "==============================================\n";
echo " ✅ PERBAIKAN SELESAI!\n";
echo "==============================================\n\n";

echo "📋 Langkah selanjutnya:\n";
echo "   1. Pastikan database 'e_arsip_ci4' sudah dibuat\n";
echo "   2. Sesuaikan konfigurasi di file .env jika perlu\n";
echo "   3. Jalankan: php spark serve\n";
echo "   4. Buka browser: http://localhost:8080\n\n";

echo "📁 File backup tersimpan di: $backupFile\n";
echo "   Hapus file backup jika semua sudah berjalan normal.\n\n";

echo "ℹ️  Untuk dokumentasi lengkap, baca file PANDUAN_PERBAIKAN.md\n\n";
