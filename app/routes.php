<?php

Validator::extend('correct_date', function($attribute, $value)
        {
            $month = $value[0];
            $day = $value[1];
            $year = $value[2];
            return checkdate( $month , $day , $year ); 
        });
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
//----------------
//--ОСНОВНОЙ САЙТ
//----------------
Route::get('/', 'NewsController@getThree');//главная
Route::get('/training.php', 'TrainingController@getTraining');//страница "тренировки"
/* Route::get('/training.php', function()//страница "тренировки"
{ return View::make('training'); }); */
Route::get('/events.php', 'EventsController@getEvents');//страница "события"
Route::get('/preparephoto/{dir}/{path}/{width}/{mrand?}', function($dir,$path,$width)//загрузка фото для каждого раздела галереи
        {Photo::showGalleryPhoto($dir,$path,$width); });
Route::get('/catalog.php', 'CatalogController@getCategories');//страница "каталог"
Route::get('/goodphoto/{name}/{width}/{mrand?}', function($name,$width)//загрузка больших фото товаров
        {Good::showPhoto($name,$width); });


//-----------
//--АДМИНКА--
//-----------

//Route::get('/admin', function()
//    { return View::make('admin'); });
Route::get('/admin/{message?}', 'UsersController@signin');
Route::post('/admin/userlogin', 'UsersController@userlogin');

Route::group(['before' => 'auth'], function () { 
    Route::post('/admin/register', 'UsersController@regUser');
    Route::post('/admin/userlogout', 'UsersController@userlogout');

        
    //-----------
    //--Главная--
    //-----------
    //--редактирование раздела новости
    Route::get('/admin/content/posts/{tab?}', 'AdmincontentController@editPosts');
    Route::post('/admin/posts/deletepost', 'AdmincontentController@deletePost');
    Route::post('/admin/posts/updatepost', 'AdmincontentController@updatePost');
    Route::post('/admin/posts/movepost', 'AdmincontentController@movePost');
    Route::post('/admin/posts/addpost', 'AdmincontentController@addPost');
    //-----------
    //--редактирование текстов
    Route::get('/admin/content/texts', 'AdmincontentController@editTexts');
    Route::get('/admin/content/trainers', 'AdmincontentController@editTrainers');
    Route::get('/admin/content/wards', 'AdmincontentController@editWards');
    Route::post('/admin/updatetext', 'AdmincontentController@updateTexts');
    Route::post('/admin/addtrainer', 'AdmincontentController@addTrainer');
    Route::post('/admin/updatetrainer', 'AdmincontentController@updateTrainer');
    Route::post('/admin/deltrainer', 'AdmincontentController@delTrainer');
    Route::post('/admin/addward', 'AdmincontentController@addWard');
    Route::post('/admin/updateward', 'AdmincontentController@updateWard');
    Route::post('/admin/delward', 'AdmincontentController@delWard');
    //-----------
    //--Галерея--
    //-----------
    Route::get('/admin/gallery/addfolder', 'AdmingalleryController@addFolder');
    Route::get('/admin/gallery/delfolder', 'AdmingalleryController@delFolder');
    Route::post('/admin/gallery/addfolder', 'AdmingalleryController@newFolder');
    Route::post('/admin/gallery/addphoto', 'AdmingalleryController@newPhoto');
    Route::post('/admin/gallery/movefolder', 'AdmingalleryController@moveFolder');
    Route::post('/admin/gallery/changeTitle', 'AdmingalleryController@changeFolder');
    Route::post('/admin/gallery/delPhoto', 'AdmingalleryController@delPhoto');
    Route::post('/admin/gallery/delFolder', 'AdmingalleryController@delDir');
    //-----------
    //--Каталог--
    //-----------
    //--управление категориями товаров
    Route::get('/admin/catalog/categories/{message?}', 'AdmincatalogController@editCategories');
    Route::post('/admin/catalog/deletecategory', 'AdmincatalogController@deleteCategory');
    Route::post('/admin/catalog/updatecategory', 'AdmincatalogController@updateCategory');
    Route::post('/admin/catalog/addcategory', 'AdmincatalogController@addCategory');
    Route::post('/admin/catalog/movecategory', 'AdmincatalogController@moveCategory');
    //--управление ПОДкатегорями товаров
    Route::get('/admin/catalog/subcategories/{message?}', 'AdmincatalogController@editSubcategories');
    Route::post('/admin/catalog/deletesubcategory', 'AdmincatalogController@deleteSubcategories');
    Route::post('/admin/catalog/updatesubcategory', 'AdmincatalogController@updateSubcategory');
    Route::post('/admin/catalog/addsubcategory', 'AdmincatalogController@addSubcategory');
    Route::post('/admin/catalog/setcatsubcategory', 'AdmincatalogController@setcatSubcategory');
    Route::post('/admin/catalog/movesubcategory', 'AdmincatalogController@moveSubcategory');
    //--управление товарами
    Route::get('/admin/catalog/addgoods', 'AdmincatalogController@addGoods');
    Route::post('/admin/goods/newgood', 'AdmincatalogController@newGood');
    Route::get('/admin/catalog/delete', 'AdmincatalogController@deleteGoods');
    Route::get('/admin/catalog/update', 'AdmincatalogController@updateGoods');
    Route::post('/admin/goods/editgood', 'AdmincatalogController@editGood');
    Route::get('/admin/catalog/delete', 'AdmincatalogController@deleteGoods');
    Route::post('/admin/catalog/delgood', 'AdmincatalogController@delGood');
    Route::post('/admin/goods/setsub', 'AdmincatalogController@setSub');
    Route::get('/admin/catalog/tech', 'AdmincatalogController@updateTech');
    Route::post('/admin/catalog/addtech', 'AdmincatalogController@newTech');
    Route::post('/admin/catalog/deltech', 'AdmincatalogController@delTech');
    Route::post('/admin/catalog/edittech', 'AdmincatalogController@editTech');
    Route::post('/admin/catalog/bindtech', 'AdmincatalogController@bindTech');

});
