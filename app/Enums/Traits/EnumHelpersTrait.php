<?php

namespace App\Enums\Traits;

// labels et defaults sont a redefinir
trait EnumHelpersTrait
{
    /**
     * Retourne toutes les valeurs
     * @return array<string|int>
     */
    public static function values(): array
    {
        return array_map(fn(self $case) => $case->value, self::cases());
    }

    /**
     * Retourne toutes les clés (noms)
     * @return array<string>
     */
    public static function keys(): array
    {
        return array_map(fn(self $case) => $case->name, self::cases());
    }

    /**
     * Tableau clé => valeur
     * @return array<string, string|int>
     */
    public static function toArray(): array
    {
        $result = [];
        foreach (self::cases() as $case) {
            $result[$case->name] = $case->value;
        }
        return $result;
    }

    /**
     * Vérifie si une valeur existe
     */
    public static function hasValue(string|int $value): bool
    {
        foreach (self::cases() as $case) {
            if ($case->value === $value) {
                return true;
            }
        }
        return false;
    }

    /**
     * Vérifie si une clé (nom) existe
     */
    public static function hasKey(string $key): bool
    {
        foreach (self::cases() as $case) {
            if ($case->name === $key) {
                return true;
            }
        }
        return false;
    }

    /**
     * Clé pour une valeur, ou null
     */
    public static function keyForValue(string|int $value): ?string
    {
        foreach (self::cases() as $case) {
            if ($case->value === $value) {
                return $case->name;
            }
        }
        return null;
    }

    /**
     * Valeur pour une clé, ou null
     */
    public static function valueForKey(string $key): string|int|null
    {
        foreach (self::cases() as $case) {
            if ($case->name === $key) {
                return $case->value;
            }
        }
        return null;
    }

    /**
     * Labels (à surcharger dans l'enum)
     * @return array<string|int, string>
     */
    public static function labels(): array
    {
        return [];
    }

    public function label()
    {
        return self::labels()[$this->value] ?? $this->value;
    }

    /**
     * Label pour une valeur, ou null
     */
    public static function labelForValue(string|int $value): ?string
    {
        $labels = static::labels();
        return $labels[$value] ?? null;
    }

    /**
     * Options pour select (valeur => label)
     */
    public static function selectOptions(): array
    {
        return static::labels();
    }

    /**
     * Valeur par défaut (à surcharger dans l'enum)
     * @return self|null
     */
    public static function default(): ?self
    {
        return null;
    }

    /**
     * Valeur suivante (circulaire) ou null
     */
    public static function next(string|int $currentValue)
    {
        $values = static::values();
        $pos = array_search($currentValue, $values, true);
        if ($pos === false) {
            return null;
        }
        $nextPos = ($pos + 1) % count($values);
        return $values[$nextPos];
    }

    /**
     * Valeur précédente (circulaire) ou null
     */
    public static function previous(string|int $currentValue)
    {
        $values = static::values();
        $pos = array_search($currentValue, $values, true);
        if ($pos === false) {
            return null;
        }
        $prevPos = ($pos - 1 + count($values)) % count($values);
        return $values[$prevPos];
    }
}
