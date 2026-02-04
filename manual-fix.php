<?php
/**
 * Manual Fix Helper - CodeIgniter 4.5+
 * Script ini akan menampilkan instruksi manual fix
 * dan membuat file index.php yang sudah diperbaiki
 * 
 * Cara pakai: php manual-fix.php
 */

echo "==============================================\n";
echo " MANUAL FIX HELPER - CODEIGNITER 4.5+\n";
echo "==============================================\n\n";

echo "Script ini akan membuat file 'public/index.php.FIXED'\n";
echo "yang sudah diperbaiki. Anda tinggal copy paste isinya.\n\n";

// Cek apakah file index.php ada
if (!file_exists('public/index.php')) {
    echo "❌ ERROR: File public/index.php tidak ditemukan!\n\n";
    exit(1);
}

// Buat file index.php yang sudah diperbaiki
$fixedContent = <<<'PHP'
<?php

/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * @package    CodeIgniter
 * @author     CodeIgniter Dev Team
 * @copyright  2019-2024 CodeIgniter Foundation
 * @license    https://opensource.org/licenses/MIT	MIT License
 * @link       https://codeigniter.com
 * @since      Version 4.0.0
 */

// Check PHP version.
$minPhpVersion = '7.4';
if (version_compare(PHP_VERSION, $minPhpVersion, '<')) {
    die("Your PHP version must be {$minPhpVersion} or higher to run CodeIgniter. Current version: " . PHP_VERSION);
}

// Path to the front controller (this file)
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

// Ensure the current directory is pointing to the front controller's directory
if (getcwd() . DIRECTORY_SEPARATOR !== FCPATH) {
    chdir(FCPATH);
}

/*
 *---------------------------------------------------------------
 * BOOTSTRAP THE APPLICATION
 *---------------------------------------------------------------
 * This process sets up the path constants, loads and registers
 * our autoloader, along with Composer's, loads our constants
 * and fires up an environment-specific bootstrapping.
 */

// Load our paths config file
// This is the line that might need to be changed, depending on your folder structure.
require FCPATH . '../app/Config/Paths.php';
// ^^^ Change this line if you move your application folder

$paths = new Config\Paths();

// Location of the framework bootstrap file - UPDATED FOR CI 4.5+
require rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'Boot.php';

// Load environment settings from .env files into $_SERVER and $_ENV
require_once SYSTEMPATH . 'Config/DotEnv.php';
(new CodeIgniter\Config\DotEnv(ROOTPATH))->load();

// Define ENVIRONMENT from .env file if not already defined
if (!defined('ENVIRONMENT')) {
    define('ENVIRONMENT', env('CI_ENVIRONMENT', 'production'));
}

/*
 * ---------------------------------------------------------------
 * GRAB OUR CODEIGNITER INSTANCE
 * ---------------------------------------------------------------
 *
 * The CodeIgniter class contains the core functionality to make
 * the application run, and does all of the dirty work to get
 * the pieces all working together.
 */

$app = Config\Services::codeigniter();
$app->initialize();
$context = is_cli() ? 'php-cli' : 'web';
$app->setContext($context);

/*
 *---------------------------------------------------------------
 * LAUNCH THE APPLICATION
 *---------------------------------------------------------------
 * Now that everything is set up, it's time to actually fire
 * up the engines and make this app do its thang.
 */

$app->run();
PHP;

// Simpan file yang sudah diperbaiki
$outputFile = 'public/index.php.FIXED';
if (file_put_contents($outputFile, $fixedContent)) {
    echo "✅ File berhasil dibuat: $outputFile\n\n";
} else {
    echo "❌ Gagal membuat file!\n\n";
    exit(1);
}

echo "==============================================\n";
echo " CARA MANUAL FIX\n";
echo "==============================================\n\n";

echo "OPSI 1 - COPY PASTE KONTEN:\n";
echo "1. Buka file: public/index.php (file lama Anda)\n";
echo "2. Backup dulu: Save As → index.php.backup\n";
echo "3. Buka file: public/index.php.FIXED (file yang baru dibuat)\n";
echo "4. Copy semua isi file index.php.FIXED\n";
echo "5. Paste ke file index.php (replace semua)\n";
echo "6. Save\n\n";

echo "OPSI 2 - RENAME FILE:\n";
echo "1. Rename: public/index.php → public/index.php.backup\n";
echo "2. Rename: public/index.php.FIXED → public/index.php\n";
echo "3. Selesai!\n\n";

echo "OPSI 3 - COMMAND LINE:\n";
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    echo "   copy public\\index.php public\\index.php.backup\n";
    echo "   copy /Y public\\index.php.FIXED public\\index.php\n\n";
} else {
    echo "   cp public/index.php public/index.php.backup\n";
    echo "   cp public/index.php.FIXED public/index.php\n\n";
}

echo "==============================================\n";
echo " PERUBAHAN YANG DILAKUKAN\n";
echo "==============================================\n\n";

echo "1. Baris 49 - Ganti bootstrap.php dengan Boot.php:\n";
echo "   LAMA: require ... 'bootstrap.php';\n";
echo "   BARU: require ... 'Boot.php';\n\n";

echo "2. Setelah load .env - Tambah definisi ENVIRONMENT:\n";
echo "   if (!defined('ENVIRONMENT')) {\n";
echo "       define('ENVIRONMENT', env('CI_ENVIRONMENT', 'production'));\n";
echo "   }\n\n";

echo "==============================================\n";
echo " SETELAH PERBAIKAN\n";
echo "==============================================\n\n";

echo "1. Pastikan file .env ada dan sudah dikonfigurasi\n";
echo "2. Pastikan database 'e_arsip_ci4' sudah dibuat\n";
echo "3. Jalankan: php spark serve\n";
echo "4. Buka: http://localhost:8080\n\n";

echo "Jika masih error, jalankan:\n";
echo "   php system-check.php\n\n";

echo "📁 File yang dibuat: $outputFile\n";
echo "   File ini bisa dihapus setelah berhasil.\n\n";
