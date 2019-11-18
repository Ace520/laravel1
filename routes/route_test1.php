<?php
Route::get('test1','Home\Test1Controller@index')->name('home.test1.index');
Route::match(['get', 'post'],'test1/update','Home\Test1Controller@update')->name('home.test1.update');
Route::post('test1/delete','Home\Test1Controller@delete')->name('home.test1.delete');