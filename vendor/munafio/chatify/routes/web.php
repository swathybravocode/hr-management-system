<?php
/**
 * -----------------------------------------------------------------
 * NOTE : There is two routes has a name (user & group),
 * any change in these two route's name may cause an issue
 * if not modified in all places that used in (e.g Chatify class,
 * Controllers, chatify javascript file...).
 * -----------------------------------------------------------------
 */


/*
* This is the main app route [Chatify Messenger]
*/
Route::get('/', 'MessagesController@index')->name(config('chatify.path'))->middleware('XSS');

/**
 *  Fetch info for specific id [user/group]
 */
Route::post('/idInfo', 'MessagesController@idFetchData')->middleware('XSS');

/**
 * Send message route
 */
Route::post('/sendMessage', 'MessagesController@send')->name('send.message')->middleware('XSS');

/**
 * Fetch messages
 */
Route::post('/fetchMessages', 'MessagesController@fetch')->name('fetch.messages')->middleware('XSS');

/**
 * Download attachments route to create a downloadable links
 */
Route::get('/download/{fileName}', 'MessagesController@download')->name(config('chatify.attachments.route'))->middleware('XSS');

/**
 * Authintication for pusher private channels
 */
Route::post('/chat/auth', 'MessagesController@pusherAuth')->name('pusher.auth')->middleware('XSS');

/**
 * Make messages as seen
 */
Route::post('/makeSeen', 'MessagesController@seen')->name('messages.seen')->middleware('XSS');

/**
 * Get contacts
 */
Route::post('/getContacts', 'MessagesController@getContacts')->name('contacts.get')->middleware('XSS');

/**
 * Update contact item data
 */
Route::post('/updateContacts', 'MessagesController@updateContactItem')->name('contacts.update')->middleware('XSS');


/**
 * Star in favorite list
 */
Route::post('/star', 'MessagesController@favorite')->name('star')->middleware('XSS');

/**
 * get favorites list
 */
Route::post('/favorites', 'MessagesController@getFavorites')->name('favorites')->middleware('XSS');

/**
 * Search in messenger
 */
Route::post('/search', 'MessagesController@search')->name('search')->middleware('XSS');

/**
 * Get shared photos
 */
Route::post('/shared', 'MessagesController@sharedPhotos')->name('shared')->middleware('XSS');

/**
 * Delete Conversation
 */
Route::post('/deleteConversation', 'MessagesController@deleteConversation')->name('conversation.delete')->middleware('XSS');

/**
 * Delete Conversation
 */
Route::post('/updateSettings', 'MessagesController@updateSettings')->name('avatar.update')->middleware('XSS');

/**
 * Set active status
 */
Route::post('/setActiveStatus', 'MessagesController@setActiveStatus')->name('activeStatus.set')->middleware('XSS');


/*
* [Group] view by id
*/
Route::get('/group/{id}', 'MessagesController@index')->name('group')->middleware('XSS');

/*
* user view by id.
* Note : If you added routes after the [User] which is the below one,
* it will considered as user id.
*
* e.g. - The commented routes below :
*/
// Route::get('/route', function(){ return 'Munaf'; }); // works as a rout->middleware('XSS)e
Route::get('/{id}', 'MessagesController@index')->name('user')->middleware('XSS');
// Route::get('/route', function(){ return 'Munaf'; }); // works as a user i->middleware('XSS)d
Route::get('/message/data', 'MessagesController@getMessagePopup')->name('message.data')->middleware('XSS');
Route::get('/message/seen', 'MessagesController@messageSeen')->name('message.seen')->middleware('XSS');
