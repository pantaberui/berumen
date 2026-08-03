<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class CatalogoCuentaBancaria extends Model
{
    use HasFactory;

    protected $table = 'catalogo_cuentas_bancarias';

    protected $fillable = [
        'alias',
        'slug',
        'banco',
        'titular',
        'numero_cuenta',
        'clabe_interbancaria',
        'numero_tarjeta',
        'tipo_cuenta',
        'moneda',
        'acepta_transferencia',
        'acepta_deposito',
        'logo',
        'instrucciones',
        'es_principal',
        'activo',
        'orden',
    ];

    protected function casts(): array
    {
        return [
            'acepta_transferencia' => 'boolean',
            'acepta_deposito' => 'boolean',
            'es_principal' => 'boolean',
            'activo' => 'boolean',
            'orden' => 'integer',
        ];
    }

    public function scopeActivas(Builder $query): Builder
    {
        return $query->where('activo', true);
    }

    public function scopeOrdenadas(Builder $query): Builder
    {
        return $query
            ->orderByDesc('es_principal')
            ->orderBy('orden')
            ->orderBy('alias');
    }

    public function scopePrincipal(Builder $query): Builder
    {
        return $query
            ->where('activo', true)
            ->where('es_principal', true);
    }

    public function getLogoUrlAttribute(): ?string
    {
        if (!$this->logo) {
            return null;
        }

        return asset('images/bancos/' . $this->logo);
    }

    protected function slug(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => strtolower(trim($value))
        );
    }

    protected function logo(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => filled($value)
                ? strtolower(trim($value))
                : null
        );
    }
}
