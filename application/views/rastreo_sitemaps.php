
<urlset xmlns="http://www.google.com/schemas/sitemap/0.90">
<?php foreach ($sitemap as $key => $value) {
    echo "<url>".
        "<loc>".$value."</loc>".
        "<lastmod>".date('Y-m-d')."</lastmod>".
        "<changefreq>daily</changefreq>".
        "<priority>0.5</priority>".
    "</url>";
}?>
</urlset>