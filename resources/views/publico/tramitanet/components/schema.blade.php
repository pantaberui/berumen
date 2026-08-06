@php
    $schema = [
        '@context' => 'https://schema.org',
        '@graph' => [
            [
                '@type' => 'WebSite',
                '@id' => url('/') . '#website',
                'name' => 'TramitaNet',
                'url' => url('/'),
                'description' => 'Servicios digitales y trámites en línea.',
                'inLanguage' => 'es-MX',
            ],
            [
                '@type' => 'Organization',
                '@id' => url('/') . '#organization',
                'name' => 'TramitaNet',
                'legalName' => 'Servicios Digitales Berumen',
                'url' => url('/'),
                'email' => 'tramitanet.berumen@gmail.com',
                'telephone' => '+52 311 165 0343',
                'logo' => asset('images/tramitanet-icono.png'),
            ],
        ],
    ];
@endphp

<script type="application/ld+json">
{!! json_encode(
    $schema,
    JSON_UNESCAPED_UNICODE
    | JSON_UNESCAPED_SLASHES
    | JSON_PRETTY_PRINT
) !!}
</script>
