<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\TdaSendMail;

class MailController extends Controller
{
    public function test()
    {

        for ($i = 0; $i < 3; $i++) {
            TdaSendMail::dispatch([
                'email' => 'retrocode.email@gmail.com',
                'message' => 'selamat [namaPelamar]<br />anda masuk di [namaPerusahaan], assalamualaiku [namaPelamar]',
            ]);
        }
        return 'mail test';
    }
}
