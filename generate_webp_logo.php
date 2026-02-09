<?php
/**
 * Gera versão WebP do logo (execute uma vez: php generate_webp_logo.php)
 * Reduz tamanho para melhorar LCP no mobile.
 */
$png = __DIR__ . '/public/images/logo_i_love_carros.png';
$webp = __DIR__ . '/public/images/logo_i_love_carros.webp';

if (!file_exists($png)) {
    fwrite(STDERR, "Arquivo não encontrado: $png\n");
    exit(1);
}

$img = @imagecreatefrompng($png);
if ($img === false) {
    fwrite(STDERR, "Não foi possível ler o PNG.\n");
    exit(1);
}

// Preserva transparência para WebP
imagealphablending($img, true);
imagesavealpha($img, true);

if (!function_exists('imagewebp')) {
    fwrite(STDERR, "PHP GD não tem suporte a WebP. Gere o WebP manualmente (ex: squoosh.app).\n");
    exit(1);
}

$ok = imagewebp($img, $webp, 85); // qualidade 85
imagedestroy($img);

if (!$ok) {
    fwrite(STDERR, "Falha ao salvar WebP.\n");
    exit(1);
}

echo "Criado: public/images/logo_i_love_carros.webp\n";
