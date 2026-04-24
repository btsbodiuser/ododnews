<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ url('/') }}</loc>
        <changefreq>hourly</changefreq>
        <priority>1.0</priority>
    </url>
    @foreach($categories as $c)
    <url>
        <loc>{{ url('/category/' . $c->slug) }}</loc>
        <lastmod>{{ optional($c->updated_at)->toAtomString() }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.7</priority>
    </url>
    @endforeach
    @foreach($articles as $a)
    <url>
        <loc>{{ url('/article/' . $a->slug) }}</loc>
        <lastmod>{{ optional($a->updated_at)->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    @endforeach
</urlset>
