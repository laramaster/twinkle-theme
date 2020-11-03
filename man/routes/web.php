<?php 


Route::group(['namespace'=>'Twinkle\Themes\man\app\http\controllers','middleware'=>'web'],function(){

	Route::get('/','WelcomeController@index')->name('welcome');

});

Route::group(['namespace'=>'Twinkle\Themes\man\app\http\controllers','middleware'=>['web','auth','admin'],'prefix'=>'admin/', 'as'=>'admin.'],function(){

	Route::resource('theme-option','WelcomeController');
});	