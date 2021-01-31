<?php

declare(strict_types=1);

namespace App\Http\Request;

use Urameshibr\Requests\FormRequest;

class Request extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Retrieve an input item from the request.
     *
     * @param  string|null  $key
     * @param  string|array|null  $default
     * @return mixed
     */
    public function input($key = null, $default = null)
    {
        return data_get(
            $this->getInputSource()->all() + $this->query->all(), $key, $default
        );
    }
}
