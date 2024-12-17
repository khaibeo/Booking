<?php

namespace App\Http\Controllers;

use App\Services\OpeningService;
use App\Traits\APIResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use APIResponse, AuthorizesRequests, ValidatesRequests;

    protected OpeningService $openingService;

    public function __construct(OpeningService $openingService)
    {
        $this->openingService = $openingService;
    }
}
