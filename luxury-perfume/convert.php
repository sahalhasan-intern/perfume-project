<?php
try {
    $src = imagecreatefrompng('public/images/hero_model.png');
    if (!$src) throw new Exception("imagecreatefrompng failed");
    if (!function_exists('imagewebp')) throw new Exception("imagewebp does not exist");
    imagewebp($src, 'public/images/hero_model.webp', 80);
    imagedestroy($src);
    echo "Success!";
} catch (Exception $e) {
    file_put_contents('error.txt', $e->getMessage());
} catch (Error $e) {
    file_put_contents('error.txt', $e->getMessage());
}
