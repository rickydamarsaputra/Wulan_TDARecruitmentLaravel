<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\TdaSendMail;
use App\Mail\TdaMail;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function test()
    {
        $data = [
            'message' => 'hello world',
            'kodeMember' => null,
        ];
        Mail::to('20390100007@dinamika.ac.id')->send(new TdaMail($data));
        return 'mail test';
    }
}
