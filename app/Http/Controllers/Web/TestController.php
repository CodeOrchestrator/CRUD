<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Repositories\ProviderTest;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function __construct(protected ProviderTest $provider)
    {
    }

    public function index($num){
        $this->provider->num($num);
    }
}
