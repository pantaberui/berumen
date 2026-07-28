<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CatalogoCuentaBancariaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'alias' => trim((string) $this->alias),
            'slug' => trim((string) $this->slug),
            'banco' => trim((string) $this->banco),
            'titular' => trim((string) $this->titular),
            'numero_cuenta' => $this->limpiarNumero($this->numero_cuenta),
            'clabe_interbancaria' => $this->limpiarNumero($this->clabe_interbancaria),
            'numero_tarjeta' => $this->limpiarNumero($this->numero_tarjeta),
            'moneda' => strtoupper(trim((string) $this->moneda)),
            'acepta_transferencia' => $this->boolean('acepta_transferencia'),
            'acepta_deposito' => $this->boolean('acepta_deposito'),
            'es_principal' => $this->boolean('es_principal'),
            'activo' => $this->boolean('activo'),
        ]);
    }

    public function rules(): array
    {
        $cuenta = $this->route('catalogoCuentaBancaria');

        $cuentaId = $cuenta instanceof \App\Models\CatalogoCuentaBancaria
            ? $cuenta->id
            : $cuenta;

        return [
            'alias' => [
                'required',
                'string',
                'max:100',
            ],

            'slug' => [
                'required',
                'string',
                'max:255',
                'alpha_dash',
                Rule::unique('catalogo_cuentas_bancarias', 'slug')
                    ->ignore($cuentaId),
            ],

            'banco' => [
                'required',
                'string',
                'max:100',
            ],

            'titular' => [
                'required',
                'string',
                'max:150',
            ],

            'numero_cuenta' => [
                'nullable',
                'digits_between:4,30',
                'required_without_all:clabe_interbancaria,numero_tarjeta',
            ],

            'clabe_interbancaria' => [
                'nullable',
                'digits:18',
                'required_without_all:numero_cuenta,numero_tarjeta',
            ],

            'numero_tarjeta' => [
                'nullable',
                'digits_between:15,19',
                'required_without_all:numero_cuenta,clabe_interbancaria',
            ],

            'tipo_cuenta' => [
                'nullable',
                'string',
                'max:50',
            ],

            'moneda' => [
                'required',
                'string',
                'size:3',
            ],

            'acepta_transferencia' => [
                'boolean',
            ],

            'acepta_deposito' => [
                'boolean',
            ],

            'logo' => [
                'nullable',
                'string',
                'max:255',
            ],

            'instrucciones' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'es_principal' => [
                'boolean',
            ],

            'activo' => [
                'boolean',
            ],

            'orden' => [
                'required',
                'integer',
                'min:1',
                'max:9999',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'alias.required' => 'El alias de la cuenta bancaria es obligatorio.',
            'slug.required' => 'El slug es obligatorio.',
            'slug.alpha_dash' => 'El slug solo puede contener letras, números, guiones y guiones bajos.',
            'slug.unique' => 'Ya existe una cuenta bancaria con este slug.',

            'banco.required' => 'Debes seleccionar o capturar el banco.',
            'titular.required' => 'El nombre del titular es obligatorio.',

            'numero_cuenta.required_without_all' =>
                'Debes proporcionar al menos un número de cuenta, CLABE o número de tarjeta.',
            'numero_cuenta.digits_between' =>
                'El número de cuenta debe contener entre 4 y 30 dígitos.',

            'clabe_interbancaria.required_without_all' =>
                'Debes proporcionar al menos un número de cuenta, CLABE o número de tarjeta.',
            'clabe_interbancaria.digits' =>
                'La CLABE interbancaria debe contener exactamente 18 dígitos.',

            'numero_tarjeta.required_without_all' =>
                'Debes proporcionar al menos un número de cuenta, CLABE o número de tarjeta.',
            'numero_tarjeta.digits_between' =>
                'El número de tarjeta debe contener entre 15 y 19 dígitos.',

            'moneda.required' => 'La moneda es obligatoria.',
            'moneda.size' => 'La moneda debe indicarse con un código de 3 letras, por ejemplo MXN.',

            'orden.required' => 'El orden es obligatorio.',
            'orden.integer' => 'El orden debe ser un número entero.',
            'orden.min' => 'El orden debe ser mayor o igual a 1.',

            'instrucciones.max' => 'Las instrucciones no pueden exceder los 2000 caracteres.',
        ];
    }

    private function limpiarNumero(mixed $valor): ?string
    {
        if ($valor === null || $valor === '') {
            return null;
        }

        $numero = preg_replace('/\D+/', '', (string) $valor);

        return $numero !== '' ? $numero : null;
    }
}
