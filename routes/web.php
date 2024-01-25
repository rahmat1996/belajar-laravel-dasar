<?php

use App\Exceptions\ValidationException;
use App\Http\Controllers\CookieController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\HelloController;
use App\Http\Controllers\InputController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\SessionController;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return "My name Rahmat";
});

// Route for redirect
Route::redirect('/youtube', '/about');

// Route for not found using fallback
Route::fallback(function () {
    return "404";
});

// Route using view
Route::view('/hello', 'hello', ['name' => 'Rahmat']);

Route::get('/hello-again', function () {
    return view('hello', ['name' => 'Rahmat']);
});

// Route using view in deep directory
Route::view('/hello-world', 'hello.world', ['name' => 'Rahmat']);

// Route using parameter
Route::get('/products/{id}', function ($productId) {
    return "Product $productId";
})->name('product.detail');

Route::get('/products/{product}/items/{item}', function ($productId, $itemId) {
    return "Product $productId, Item $itemId";
})->name('product.item.detail');

// Route using regex parameter
Route::get('/categories/{id}', function (string $categoryId) {
    return "Categories : " . $categoryId;
})->where('id', '[0-9]+')->name('category.detail');

// Route using optional parameter
Route::get('/users/{id?}', function ($userId = '404') {
    return "User : $userId";
})->name('user.detail');

// Route conflict (will using first definition route for use and not using other)

Route::get('/conflict/rahmat', function () {
    return "Conflict Rahmat Meong";
});

Route::get('/conflict/{name}', function ($name) {
    return "Conflict $name";
});

Route::get('/produk/{id}', function ($id) {
    $link = route('product.detail', ['id' => $id]);
    return "Link : $link";
});

Route::get('/produk-redirect/{id}', function ($id) {
    return redirect()->route('product.detail', ['id' => $id]);
});

// Route using controller

Route::get('/controller/hello/request', [HelloController::class, 'request']);

Route::get('/controller/hello/{name}', [HelloController::class, 'hello']);


Route::get('/input/hello', [InputController::class, 'hello']);
Route::post('/input/hello', [InputController::class, 'hello']);
Route::post('/input/hello/first', [InputController::class, 'helloFirst']);
Route::post('/input/hello/input', [InputController::class, 'helloInput']);
Route::post('/input/hello/array', [InputController::class, 'helloArray']);

Route::get('/input/hello/query', [InputController::class, 'helloInputQuery']);

Route::post('/input/type', [InputController::class, 'inputType']);

Route::post('/input/filter/only', [InputController::class, 'filterOnly']);
Route::post('/input/filter/except', [InputController::class, 'filterExcept']);
Route::post('/input/filter/merge', [InputController::class, 'filterMerge']);

Route::post('/file/upload', [FileController::class, 'upload'])->withoutMiddleware([VerifyCsrfToken::class]);

Route::get('/response/hello', [ResponseController::class, 'response']);
Route::get('/response/header', [ResponseController::class, 'header']);

Route::prefix("/response/type")->group(function () {
    Route::get('/view', [ResponseController::class, 'responseView']);
    Route::get('/json', [ResponseController::class, 'responseJson']);
    Route::get('/file', [ResponseController::class, 'responseFile']);
    Route::get('/download', [ResponseController::class, 'responseDownload']);
});

Route::controller(CookieController::class)->group(function () {
    Route::get('/cookie/set', 'createCookie');
    Route::get('/cookie/get', 'getCookie');
    Route::get('/cookie/clear', 'clearCookie');
});

Route::get('/redirect/from', [RedirectController::class, 'redirectFrom']);
Route::get('/redirect/to', [RedirectController::class, 'redirectTo']);
Route::get('/redirect/name', [RedirectController::class, 'redirectName']);
Route::get('/redirect/name/{name}', [RedirectController::class, 'redirectHello'])->name('redirect-hello');
Route::get('/redirect/named', function () {
    return URL::route('redirect-hello', ['name' => 'Rahmat']);
});
Route::get('/redirect/action', [RedirectController::class, 'redirectAction']);
Route::get('/redirect/google', [RedirectController::class, 'redirectAway']);

Route::middleware(['contoh:RTZ,401'])->prefix('/middleware')->group(function () {

    Route::get('/api', function () {
        return "OK";
    });

    Route::get('/group', function () {
        return "GROUP";
    });
});

Route::get('/form', [FormController::class, 'form']);
Route::post('/form', [FormController::class, 'submitForm']);

Route::get('/url/current', function () {
    return URL::full();
});

Route::get('/url/action', function () {
    return URL::action([FormController::class, 'form'], []);
});

Route::get('/session/create', [SessionController::class, 'createSession']);
Route::get('/session/get', [SessionController::class, 'getSession']);

Route::get('/error/sample', function () {
    throw new Exception("Sample Error");
});

Route::get('/error/manual', function () {
    report(new Exception("Sample Error"));
    return "OK";
});

Route::get('/error/validation', function () {
    throw new ValidationException("Validation Error");
});

Route::get('/abort/400', function () {
    abort(400,"Validation Error");
});

Route::get('/abort/401', function () {
    abort(401);
});

Route::get('/abort/500', function () {
    abort(500);
});
