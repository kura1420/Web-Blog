<?php

use App\Livewire\Article;
use App\Livewire\Home;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class);
Route::get('/article/{slug}', Article::class)->name('article');
