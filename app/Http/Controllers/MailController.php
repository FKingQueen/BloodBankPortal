<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailNotify;

class MailController extends Controller
{
    public function approvedRegistration(){
        Mail::to('pcborja@mmsu.edu.ph')->send(new MailNotify());
        return view('mail/approvedRegistration');
    }
}
