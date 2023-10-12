<?php

namespace App\Casts;

use App\Helpers\Money;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use InvalidArgumentException;

class MoneyCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function get($model, string $key, $value, array $attributes): ?Money
    {
        //dd($beforeMoney);
        $beforeMoney = json_decode($value);

        if (!$beforeMoney) {
            return null;
        }

        $money = new Money(
            $beforeMoney->currency,
            $beforeMoney->price,
            $beforeMoney->currency_rate
        );

        return $money;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function set($model, string $key, $value, array $attributes): mixed
    {
        if ($value instanceof Money) {
            return $value;
        }

        return null;
    }
}
