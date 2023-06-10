<?php

use App\Http\Controllers\TemplateManagerController;
use App\Models\Destination;
use App\Models\Quote;
use App\Models\Template;
use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('test', function () {
    $faker = Factory::create();

    $template = Template::create([
        1,
        'Your delivery to [quote:destination_name]',
        "
        Hi [user:first_name],
        
        Thanks for contacting us to deliver to [quote:destination_name].
        
        Regards,
        
        SAYNA team
        "
    ]);
    
    $message = (new TemplateManagerController)->getTemplateComputed(
        $template,
        [
            'quote' => Quote::create([$faker->randomNumber(), $faker->randomNumber(), $faker->randomNumber(), $faker->date()])
        ]
    );
    
    echo $message->subject . "\n" . $message->content;
});
