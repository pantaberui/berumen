<?php

namespace App\Services\Seo;

final readonly class SeoData
{
    public function __construct(
        public string $title,
        public string $description,
        public string $canonical,
        public string $image,
        public string $robots = 'index,follow',
        public string $type = 'website',
        public string $siteName = 'TramitaNet',
        public string $locale = 'es_MX',
    ) {
    }
}
