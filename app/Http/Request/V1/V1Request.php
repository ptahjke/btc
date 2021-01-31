<?php

declare(strict_types=1);

namespace App\Http\Request\V1;

use App\Http\Controllers\V1\Router;
use App\Http\Request\Request;

class V1Request extends Request
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'method' => ['required', 'string', 'in:' . implode(',', Router::AVAILABLE_METHODS)],
        ];
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return (string) $this->input('method');
    }
}
