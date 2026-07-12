<?php

namespace App\Http\Controllers\Publico;

use App\Http\Controllers\Controller;
use App\Services\TramitaNet\CaptchaService;
use Illuminate\Http\Response;

class TramitaNetCaptchaController extends Controller
{
    public function imagen(): Response
    {
        $codigo = CaptchaService::generar();

        $svg = $this->generarSvg($codigo);

        return response($svg, 200, [
            'Content-Type' => 'image/svg+xml',
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
        ]);
    }

    private function generarSvg(string $codigo): string
    {
        $caracteres = str_split($codigo);

        $texto = collect($caracteres)
            ->map(function (string $caracter, int $indice) {
                $x = 34 + ($indice * 42);
                $y = random_int(51, 66);
                $rotacion = random_int(-14, 14);

                return sprintf(
                    '<text x="%d" y="%d" transform="rotate(%d %d %d)">%s</text>',
                    $x,
                    $y,
                    $rotacion,
                    $x,
                    $y,
                    htmlspecialchars($caracter, ENT_XML1)
                );
            })
            ->implode('');

        return <<<SVG
<svg xmlns="http://www.w3.org/2000/svg"
     width="260"
     height="90"
     viewBox="0 0 260 90"
     role="img"
     aria-label="Código de seguridad">

    <defs>
        <linearGradient id="fondo" x1="0" x2="1">
            <stop offset="0%" stop-color="#0f172a"/>
            <stop offset="55%" stop-color="#172554"/>
            <stop offset="100%" stop-color="#4c1d95"/>
        </linearGradient>
    </defs>

    <rect width="260" height="90" rx="16" fill="url(#fondo)"/>

    <path d="M8 23 C65 75, 165 4, 252 62"
          fill="none"
          stroke="#f97316"
          stroke-width="3"
          opacity=".70"/>

    <path d="M4 69 C75 8, 173 88, 258 26"
          fill="none"
          stroke="#60a5fa"
          stroke-width="2"
          opacity=".65"/>

    <g fill="#ffffff"
       font-family="Arial, sans-serif"
       font-size="38"
       font-weight="800"
       letter-spacing="3">
        {$texto}
    </g>

    <g opacity=".35" fill="#ffffff">
        <circle cx="18" cy="17" r="2"/>
        <circle cx="232" cy="18" r="3"/>
        <circle cx="219" cy="75" r="2"/>
        <circle cx="75" cy="14" r="2"/>
        <circle cx="146" cy="77" r="2"/>
    </g>
</svg>
SVG;
    }
}
