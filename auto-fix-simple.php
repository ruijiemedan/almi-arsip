<?php
/**
 * Auto Fix Script untuk CodeIgniter 4.5+ - VERSI SEDERHANA
 * Script ini akan otomatis memperbaiki file public/index.php
 * 
 * Cara pakai:
 * 1. Copy script ini ke root folder proyek Anda
 * 2. Jalankan: php auto-fix-simple.php
 */

echo "==============================================\n";
echo " AUTO FIX CODEIGNITER 4.5+ - SIMPLE VERSION\n";
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

// PERBAIKAN 1: Ganti bootstrap.php dengan Boot.php
echo "🔧 Perbaikan 1: bootstrap.php → Boot.php...\n";
if (strpos($content, "DIRECTORY_SEPARATOR . 'Boot.php'") !== false) {
    echo "   ℹ️  Sudah menggunakan Boot.php\n\n";
} else {
    $content = str_replace(
        "DIRECTORY_SEPARATOR . 'bootstrap.php'",
        "DIRECTORY_SEPARATOR . 'Boot.php'",
        $content
    );
    echo "   ✅ Berhasil diganti\n\n";
}

// PERBAIKAN 2: Tambahkan definisi ENVIRONMENT
echo "🔧 Perbaikan 2: Menambahkan definisi ENVIRONMENT...\n";
if (strpos($content, "if (!defined('ENVIRONMENT'))") !== false) {
    echo "   ℹ️  ENVIRONMENT sudah terdefinisi\n\n";
} else {
    // Cari baris yang berisi DotEnv load
    $lines = explode("\n", $content);
    $newLines = [];
    $added = false;
    
    foreach ($lines as $line) {
        $newLines[] = $line;
        
        // Jika ketemu baris DotEnv load dan belum ditambahkan
        if (!$added && strpos($line, 'DotEnv(ROOTPATH))->load()') !== false) {
            // Tambahkan kode ENVIRONMENT setelah baris ini
            $newLines[] = '';
            $newLines[] = '// Define ENVIRONMENT from .env file if not already defined';
            $newLines[] = "if (!defined('ENVIRONMENT')) {";
            $newLines[] = "    define('ENVIRONMENT', env('CI_ENVIRONMENT', 'production'));";
            $newLines[] = '}';
            $added = true;
        }
    }
    
    if ($added) {
        $content = implode("\n", $newLines);
        echo "   ✅ ENVIRONMENT definition ditambahkan\n\n";
    } else {
        echo "   ⚠️  WARNING: Tidak dapat menemukan baris DotEnv load\n";
        echo "      Tambahkan manual setelah baris:\n";
        echo "      (new CodeIgniter\\Config\\DotEnv(ROOTPATH))->load();\n\n";
    }
}

// Simpan file yang sudah diperbaiki
echo "💾 Menyimpan file yang diperbaiki...\n";
$bytesWritten = file_put_contents('public/index.php', $content);

if ($bytesWritten !== false) {
    echo "   ✅ File berhasil disimpan ($bytesWritten bytes)\n\n";
} else {
    echo "   ❌ Gagal menyimpan file!\n";
    echo "      Pastikan folder public/ bisa ditulis.\n\n";
    
    // Restore backup
    echo "🔄 Mengembalikan file dari backup...\n";
    if (copy($backupFile, 'public/index.php')) {
        echo "   ✅ File dikembalikan\n\n";
    }
    exit(1);
}

// Verifikasi hasil
echo "🔍 Memverifikasi hasil...\n";
$newContent = file_get_contents('public/index.php');

$checks = [
    'Boot.php' => strpos($newContent, "Boot.php") !== false,
    'ENVIRONMENT defined' => strpos($newContent, "define('ENVIRONMENT'") !== false
];

$allOk = true;
foreach ($checks as $check => $result) {
    echo "   - $check: ";
    if ($result) {
        echo "✅\n";
    } else {
        echo "❌\n";
        $allOk = false;
    }
}
echo "\n";

// Verifikasi file .env
echo "🔍 Memeriksa file .env...\n";
if (file_exists('.env')) {
    $envContent = file_get_contents('.env');
    
    if (preg_match('/CI_ENVIRONMENT\s*=/', $envContent)) {
        echo "   ✅ CI_ENVIRONMENT sudah terdefinisi\n";
    } else {
        echo "   ⚠️  WARNING: CI_ENVIRONMENT belum terdefinisi di .env\n";
        echo "       Tambahkan baris: CI_ENVIRONMENT = development\n";
    }
    
    if (preg_match('/database\.default\.hostname/', $envContent)) {
        echo "   ✅ Konfigurasi database ditemukan\n";
    } else {
        echo "   ⚠️  WARNING: Konfigurasi database belum lengkap\n";
    }
    echo "\n";
} else {
    echo "   ⚠️  File .env tidak ditemukan!\n";
    echo "      Copy file 'env' menjadi '.env' dan sesuaikan konfigurasi.\n\n";
}

// Cek permission writable folder
echo "🔍 Memeriksa folder writable/...\n";
if (is_dir('writable')) {
    if (is_writable('writable')) {
        echo "   ✅ Folder writable dapat ditulis\n\n";
    } else {
        echo "   ⚠️  WARNING: Folder writable tidak dapat ditulis!\n";
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            echo "      Jalankan di CMD as Admin:\n";
            echo "      icacls writable /grant Everyone:F /T\n\n";
        } else {
            echo "      Jalankan: chmod -R 777 writable/\n\n";
        }
    }
} else {
    echo "   ⚠️  Folder writable tidak ditemukan!\n\n";
}

echo "==============================================\n";
if ($allOk) {
    echo " ✅ PERBAIKAN SELESAI!\n";
} else {
    echo " ⚠️  PERBAIKAN SELESAI DENGAN WARNING\n";
}
echo "==============================================\n\n";

echo "📋 Langkah selanjutnya:\n";
echo "   1. Pastikan database 'e_arsip_ci4' sudah dibuat\n";
echo "   2. Sesuaikan konfigurasi di file .env jika perlu\n";
echo "   3. Jalankan: php spark serve\n";
echo "   4. Buka browser: http://localhost:8080\n\n";

echo "📁 File backup tersimpan di: $backupFile\n";
echo "   Hapus file backup jika semua sudah berjalan normal.\n\n";

if (!$allOk) {
    echo "⚠️  Ada beberapa hal yang perlu diperiksa manual.\n";
    echo "   Baca output di atas untuk detail.\n\n";
}

echo "ℹ️  Untuk troubleshooting, jalankan: php system-check.php\n";
echo "ℹ️  Untuk dokumentasi lengkap, baca file PANDUAN_PERBAIKAN.md\n\n";
