<?php
/**
 * Onur Canalp - 2014
 *
 * CSS Minify Etmece, Sıkıştırmaca
 *
 * Projemizde bulunan 3-5 adet css i tek dosya haline getirip tek satırda basmamıza yarıyor bu dosya.
 * Bu sayede hem boyut düşecektir, hem dışardan bakanlar için ilk bakıştaki okunabilirliği azalacaktır.
 *
 * Örnek Kullanım:
 * <link rel="stylesheet" type="text/css" media="screen" href="/css/minify.css.php" />
 *
 */
 
/* Projemizde kullandığımız css dosyaları */
$files = array(
        "main.css",
        "layout.css",
        "mobile.css",
        "site.css",
        "screen.css"
);
 

$output = "";
foreach ($files as $file) {
  $output .= file_get_contents($file);
}
 
// Yorumları temizleyelim
$output = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $output);
 
// : dan sonraki boşlukları silelim
$output = str_replace(': ', ':', $output);
 
// tablerı, yeni satırları ve diğer boşlukları temizleyelim
$output = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $output);
 
// GZip encodingi aktif edelim. Çıktımızı gzip le sıkıştıralım
ob_start("ob_gzhandler");
 
// cache aktif edelim. 
header('Cache-Control: public');
 
// CSS lerimizi günlük tutacağız. 1gün olarak ayarlayalım
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 86400) . ' GMT');
 
// MIME type ayarı yapalım. Apache yoksa css gibi görmez..
header("Content-type: text/css");
 
// Çıktımızı basalım.. 
echo($output);
?>