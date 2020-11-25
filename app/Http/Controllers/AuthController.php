<?php


namespace App\Http\Controllers;


use App\Models\Bot;
use Illuminate\Routing\Controller as BaseController;


class AuthController extends BaseController
{

    public function view()
    {
        $bot = new Bot();
        $statuses = $bot->auth();
        dd($statuses);
    }

}
