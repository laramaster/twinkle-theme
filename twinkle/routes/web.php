<?php 


Route::group(['namespace'=> 'Twinkle\Themes\twinkle\app\http\controllers'],function(){

    // Write Your routes here
    Route::get('/tw','HelloController@hello');
});
