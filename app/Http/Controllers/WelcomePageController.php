<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Producto;
class WelcomePageController extends Controller
{


        public function __invoke(){

            return view('welcome');

    }



}
