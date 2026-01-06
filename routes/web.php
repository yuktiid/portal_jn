<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\inputController;
use App\Http\Controllers\AuthLoginController;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

Route::get('/sitemap.xml', function () {
    Sitemap::create()
        ->add(Url::create('/'))
        ->add(Url::create('/informasi'))
        ->add(Url::create('/daerahan'))
        ->add(Url::create('/e-jurnal'))
        ->add(Url::create('/kategori/politik'))
        ->add(Url::create('/kategori/pemerintahan'))
        ->writeToFile(public_path('sitemap.xml'));

    return response()->file(public_path('sitemap.xml'));
});

// Route::middleware(['throttle'])->group(function () {
Route::get('/login-tes', function () {
    return view('login-tes');
});
Route::get('/logout', [AuthLoginController::class, 'logout']);
Route::get('/auth/google', [AuthLoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/gCallback', [AuthLoginController::class, 'handleGoogleCallback']);
Route::get('halaman-tidak-ditemukan', function () { return view('404'); });
Route::get('/informasi', [NewsController::class, 'informasi']);
Route::get('/tag/{slug_tag}', [NewsController::class,'tag'])->name('tag');
Route::get('search', [NewsController::class, 'search']);
Route::get('/', [NewsController::class,'index'])->name('home');
Route::get('/daerahan', [NewsController::class, 'daerah'])->name('daerahan');
Route::get('/daerahan/{wilayah_slug}', [NewsController::class,'getwilayah'])->name('wilayah');
Route::get('/e-jurnal', [NewsController::class, 'koran'])->name('e-jurnal');
Route::get('/e-jurnal/{id}', [NewsController::class, 'dkoran'])->name('e-jurnal.detail');
Route::get('/berita/{kategori}/{url}', [NewsController::class,'readmore'])->name('readmore');

/* Load more */
Route::get('/load-more-posts', [NewsController::class, 'loadMorePosts']);
Route::get('/load-more-daerah', [NewsController::class, 'loadMoreDaerah']);
Route::get('/load-more-detail', [NewsController::class, 'loadMoreDetail']);
Route::get('load-more-author', [NewsController::class, 'loadMoreAuthor']);
/* end Load more */

// komen
Route::post('/komentar', 'CommentController@store')->name('comment.store');
Route::get('writer/{email}', [NewsController::class, 'author'])->name('writer');
// rute dinamis akhirr
Route::get('/kategori/{kategorislug}', [NewsController::class, 'detail'])->name('kategori');

Route::middleware(['cekToken'])->group(function () {
    Route::post('/komentar', [inputController::class, 'komentar'])->name('comment.store');
    Route::get('author/{email}', [inputController::class, 'data'])->name('dashboard');
    Route::get('add-news', [inputController::class, 'addNews'])->name('guest.addnews');
    Route::post('add-news', [inputController::class, 'send'])->name('send');
    Route::get('update-news/{slug}', [inputController::class, 'updateNews'])->name('guest.update');
    Route::put('update-news/{id}', [inputController::class, 'PupdateNews'])->name('guest.Pupdate');
    Route::get('/delete-news-data/{id}', [inputController::class, 'deletePosts'])->name('deletePosts');
});


// Route::get('/{any}', function () {
//     return view('404');
// })->where('any', '.*');

// });