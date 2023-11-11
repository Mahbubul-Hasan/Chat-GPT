<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Chat GPT API",
 *      description="Chat GPT API description",
 *      @OA\Contact(
 *          email="mahbubul7497@gmail.com"
 *      )
 * )
 */

class Controller extends BaseController {
    use AuthorizesRequests, ValidatesRequests;
}
