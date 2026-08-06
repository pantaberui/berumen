{!! '<?xml version="1.0" encoding="UTF-8"?>' !!}

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    {{-- Páginas principales --}}
    <url>
        <loc>{{ url('/') }}</loc>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>

    <url>
        <loc>{{ route('tramitanet.faq') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
    </url>

    <url>
        <loc>{{ route('tramitanet.aviso-privacidad') }}</loc>
        <changefreq>yearly</changefreq>
        <priority>0.3</priority>
    </url>

    <url>
        <loc>{{ route('tramitanet.terminos') }}</loc>
        <changefreq>yearly</changefreq>
        <priority>0.3</priority>
    </url>

    {{-- Instituciones --}}
    @foreach ($instituciones as $institucion)
        <url>
            <loc>{{ url('/institucion/' . $institucion->slug) }}</loc>

            @if ($institucion->updated_at)
                <lastmod>{{ $institucion->updated_at->toAtomString() }}</lastmod>
            @endif

            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach

    {{-- Servicios --}}
    @foreach ($servicios as $servicio)
        <url>
            <loc>{{ url('/servicio/' . $servicio->slug) }}</loc>

            @if ($servicio->updated_at)
                <lastmod>{{ $servicio->updated_at->toAtomString() }}</lastmod>
            @endif

            <changefreq>weekly</changefreq>
            <priority>0.9</priority>
        </url>
    @endforeach

</urlset>
