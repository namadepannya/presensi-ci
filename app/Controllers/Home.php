<?php

namespace App\Controllers;
use Codeigniter\HTTP\ResponseInterface;

class Home extends BaseController
{
    public function index(): string
    {
        return view('welcome_message');
    }
}