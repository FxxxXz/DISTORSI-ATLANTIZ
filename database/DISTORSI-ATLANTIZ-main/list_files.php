<?php

function listDirectory($dir, $indent = 0) {
    $files = scandir($dir);
    
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;
        
        $path = $dir . '/' . $file;
        $prefix = str_repeat('  ', $indent) . ($indent > 0 ? '├── ' : '');
        
        if (is_dir($path)) {
            echo $prefix . "📁 " . $file . "\n";
            listDirectory($path, $indent + 1);
        } else {
            echo $prefix . "📄 " . $file . "\n";
        }
    }
}

echo "📂 STRUKTUR PROJECT LARAVEL\n";
echo "============================\n\n";

// List root directory
listDirectory('.');

echo "\n\n📂 STRUKTUR KHUSUS VIEWS\n";
echo "==========================\n\n";
if (is_dir('./resources/views')) {
    listDirectory('./resources/views');
} else {
    echo "Folder resources/views tidak ditemukan!\n";
}

echo "\n\n📂 STRUKTUR ROUTES\n";
echo "==================\n\n";
if (is_dir('./routes')) {
    listDirectory('./routes');
}

echo "\n\n📂 STRUKTUR CONTROLLERS\n";
echo "=======================\n\n";
if (is_dir('./app/Http/Controllers')) {
    listDirectory('./app/Http/Controllers');
}

echo "\n\n📂 STRUKTUR MODELS\n";
echo "==================\n\n";
if (is_dir('./app/Models')) {
    listDirectory('./app/Models');
} else {
    listDirectory('./app');
}