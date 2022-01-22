<?php

namespace App\Basket\Rules;

use Illuminate\Contracts\Validation\Rule;

class BasketCheckProducts implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($input)
    {
        $this->input= $input;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (!isset($this->input['products'])) {
            return false;
        }

        $products_count = count($this->input['products']);

        $ids_count = 0;
        $counts_count = 0;

        foreach ($this->input['products'] as $item) {

            if (isset($item['id'])) {
                if (!is_numeric($item['id'])) {
                    return false;
                }
                $ids_count++;
            }

            if (isset($item['count'])) {
                if (!is_numeric($item['count'])) {
                    return false;
                }
                $counts_count++;
            }

        }

        return $products_count === $ids_count and $products_count === $counts_count;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'incorrectly';
    }
}
