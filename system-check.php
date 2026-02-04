<?php
/**
 * System Check Script
 * Script untuk memeriksa konfigurasi dan requirement CodeIgniter 4
 * 
 * Cara pakai: php system-check.php
 */

echo "==============================================\n";
echo " SYSTEM CHECK - CODEIGNITER 4\n";
echo "==============================================\n\n";

$errors = 0;
$warnings = 0;

// 1. PHP Version
echo "1. PHP Version\n";
$phpVersion = PHP_VERSION;
$minVersion = '7.4';
$recommendedVersion = '8.1';

echo "   Current: $phpVersion\n";

if (version_compare($phpVersion, $minVersion, '<')) {
    echo "   ❌ ERROR: PHP version harus minimal $minVersion\n";
    $errors++;
} elseif (version_compare($phpVersion, $recommendedVersion, '<')) {
    echo "   ⚠️  WARNING: Disarankan menggunakan PHP $recommendedVersion+\n";
    $warnings++;
} else {
    echo "   ✅ PHP version OK\n";
}
echo "\n";

// 2. PHP Extensions
echo "2. PHP Extensions\n";
$requiredExtensions = [
    'intl',
    'mbstring',
    'json',
    'mysqlnd', // atau mysqli
    'xml',
    'curl'
];

foreach ($requiredExtensions as $ext) {
    echo "   - $ext: ";
    if (extension_loaded($ext)) {
        echo "✅\n";
    } else {
        echo "❌ MISSING\n";
        $errors++;
    }
}
echo "\n";

// 3. File Structure
echo "3. File Structure\n";
$requiredFiles = [
    'app/Config/Paths.php',
    'app/Config/Constants.php',
    'public/index.php',
    'spark',
    'vendor/autoload.php'
];

foreach ($requiredFiles as $file) {
    echo "   - $file: ";
    if (file_exists($file)) {
        echo "✅\n";
    } else {
        echo "❌ MISSING\n";
        $errors++;
    }
}
echo "\n";

// 4. Writable Directories
echo "4. Writable Directories\n";
$writableDirs = [
    'writable/cache',
    'writable/logs',
    'writable/session',
    'writable/uploads'
];

foreach ($writableDirs as $dir) {
    echo "   - $dir: ";
    if (!is_dir($dir)) {
        echo "❌ NOT EXISTS\n";
        $errors++;
    } elseif (!is_writable($dir)) {
        echo "⚠️  NOT WRITABLE\n";
        $warnings++;
    } else {
        echo "✅\n";
    }
}
echo "\n";

// 5. Environment File
echo "5. Environment Configuration\n";
if (file_exists('.env')) {
    echo "   ✅ .env file exists\n";
    
    $envContent = file_get_contents('.env');
    
    // Check important configs
    $configs = [
        'CI_ENVIRONMENT' => '/CI_ENVIRONMENT\s*=\s*\w+/',
        'database.default.hostname' => '/database\.default\.hostname\s*=/',
        'database.default.database' => '/database\.default\.database\s*=/',
        'app.baseURL' => '/app\.baseURL\s*=/'
    ];
    
    foreach ($configs as $name => $pattern) {
        echo "   - $name: ";
        if (preg_match($pattern, $envContent)) {
            echo "✅\n";
        } else {
            echo "⚠️  NOT SET\n";
            $warnings++;
        }
    }
} else {
    echo "   ❌ .env file not found\n";
    echo "      Copy 'env' to '.env' and configure it\n";
    $errors++;
}
echo "\n";

// 6. public/index.php Check
echo "6. public/index.php Configuration\n";
if (file_exists('public/index.php')) {
    $indexContent = file_get_contents('public/index.php');
    
    // Check for Boot.php (new way)
    echo "   - Using Boot.php: ";
    if (strpos($indexContent, "Boot.php") !== false) {
        echo "✅\n";
    } else {
        echo "❌ Still using bootstrap.php\n";
        echo "      Run: php auto-fix.php\n";
        $errors++;
    }
    
    // Check for ENVIRONMENT definition
    echo "   - ENVIRONMENT defined: ";
    if (strpos($indexContent, "define('ENVIRONMENT'") !== false) {
        echo "✅\n";
    } else {
        echo "⚠️  NOT DEFINED\n";
        echo "      Run: php auto-fix.php\n";
        $warnings++;
    }
} else {
    echo "   ❌ public/index.php not found\n";
    $errors++;
}
echo "\n";

// 7. Composer Dependencies
echo "7. Composer Dependencies\n";
if (file_exists('vendor/autoload.php')) {
    echo "   ✅ Composer dependencies installed\n";
    
    if (file_exists('vendor/codeigniter4/framework/system/Boot.php')) {
        echo "   ✅ CodeIgniter 4 framework found\n";
    } else {
        echo "   ❌ CodeIgniter 4 framework not found\n";
        echo "      Run: composer install\n";
        $errors++;
    }
} else {
    echo "   ❌ Composer dependencies not installed\n";
    echo "      Run: composer install\n";
    $errors++;
}
echo "\n";

// 8. Database Connection (optional)
echo "8. Database Connection (Optional)\n";
if (file_exists('.env')) {
    $envContent = file_get_contents('.env');
    
    // Extract database config
    preg_match('/database\.default\.hostname\s*=\s*(.+)/', $envContent, $host);
    preg_match('/database\.default\.database\s*=\s*(.+)/', $envContent, $dbname);
    preg_match('/database\.default\.username\s*=\s*(.+)/', $envContent, $user);
    
    if (!empty($host[1]) && !empty($dbname[1]) && !empty($user[1])) {
        $hostname = trim($host[1]);
        $database = trim($dbname[1]);
        $username = trim($user[1]);
        
        echo "   Database: $database@$hostname\n";
        echo "   ℹ️  Jalankan aplikasi untuk test koneksi database\n";
    } else {
        echo "   ⚠️  Database config incomplete\n";
        $warnings++;
    }
} else {
    echo "   ⚠️  Cannot check (no .env file)\n";
}
echo "\n";

// Summary
echo "==============================================\n";
echo " SUMMARY\n";
echo "==============================================\n";

if ($errors === 0 && $warnings === 0) {
    echo "✅ All checks passed! System ready to run.\n\n";
    echo "Run: php spark serve\n";
} elseif ($errors === 0) {
    echo "⚠️  $warnings warning(s) found.\n";
    echo "   System dapat berjalan tapi ada beberapa hal yang perlu diperbaiki.\n\n";
} else {
    echo "❌ $errors error(s) and $warnings warning(s) found.\n";
    echo "   Perbaiki error terlebih dahulu sebelum menjalankan aplikasi.\n\n";
}

if ($errors > 0) {
    echo "📋 Recommended Actions:\n";
    echo "   1. Run: php auto-fix.php (untuk fix index.php)\n";
    echo "   2. Pastikan .env file ada dan sudah dikonfigurasi\n";
    echo "   3. Run: composer install (jika vendor tidak ada)\n";
    echo "   4. Set permission: chmod -R 777 writable/ (Linux/Mac)\n";
    echo "                atau: icacls writable /grant Everyone:F /T (Windows)\n\n";
}

echo "ℹ️  Untuk bantuan lebih lanjut, baca PANDUAN_PERBAIKAN.md\n\n";
