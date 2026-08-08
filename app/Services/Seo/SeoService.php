<?php

namespace App\Services\Seo;

class SeoService
{
    public function home(): SeoData
    {
        $seo = $this->default();

        return new SeoData(
            title: 'TramitaNet | Trámites y Servicios en Línea',
            description: 'Realiza trámites y solicita servicios en línea de forma rápida, segura y sin salir de casa mediante TramitaNet.',
            canonical: url('/'),
            image: $seo->image,
        );
    }


    public function faq(): SeoData
    {
        $seo = $this->default();

        return new SeoData(
            title: 'Preguntas Frecuentes | TramitaNet',
            description: 'Consulta las preguntas más frecuentes sobre nuestros servicios, pagos y tiempos de atención.',
            canonical: url('/tramitanet/preguntas-frecuentes'),
            image: $seo->image,
        );
    }

    public function privacy(): SeoData
    {
        $seo = $this->default();

        return new SeoData(
            title: 'Aviso de Privacidad | TramitaNet',
            description: 'Conoce cómo TramitaNet recopila, utiliza y protege tus datos personales durante la prestación de nuestros servicios.',
            canonical: url('/tramitanet/aviso-de-privacidad'),
            image: $seo->image,
        );
    }

    public function terms(): SeoData
    {
        $seo = $this->default();

        return new SeoData(
            title: 'Términos y Condiciones | TramitaNet',
            description: 'Consulta los términos y condiciones aplicables al uso de la plataforma TramitaNet y a los servicios ofrecidos.',
            canonical: url('/tramitanet/terminos-y-condiciones'),
            image: $seo->image,
        );
    }

    public function default(): SeoData
    {
        return new SeoData(
            title: 'TramitaNet | Trámites y Servicios en Línea',
            description: 'Realiza trámites y solicita servicios en línea de forma rápida, segura y confiable mediante TramitaNet.',
            canonical: url('/'),
            image: asset('images/tramitanet/seo/default.jpg'),
        );
    }

    public function servicio($servicio): SeoData
    {
        return new SeoData(
            title: $servicio->nombre . ' | TramitaNet',

            description:
                $servicio->descripcion
                ?: 'Solicita ' . $servicio->nombre .
                ' en línea mediante TramitaNet.',

            canonical: url('/servicio/' . $servicio->slug),

            image: asset('images/tramitanet/seo/default.jpg')
        );
    }


}
