<?php

use Stonks\Router\Router;

require __DIR__ . "/vendor/autoload.php";

$route = new Router(BASE_PATH);

$route->namespace("Source\Controllers\Site");

$route->group(null);

$route->get('/', 'Web:home', 'web.home');
$route->get('/error/{error}', 'Web:error', 'web.error');

$route->get('/debug', 'Web:debug', 'web.debug');
$route->get('/login', 'Web:login', 'web.login');
$route->get('/register', 'Web:register', 'web.register');
$route->get('/deck-editor', 'Web:deckEditor', 'web.deckEditor');
$route->get('/user-decks-txt', 'Web:userDecksTxt', 'web.userDecksTxt');
$route->get('/wantList/{name}', 'Web:wantList', 'web.wantList');
$route->get('/haveList/{name}', 'Web:haveList', 'web.haveList');
$route->get('/cardImage/{id}', 'Request:cardImage', 'request.cardImage');
$route->get('/logout', 'Web:logout', 'web.logout');

$route->post('/deckTxt', 'Request:deckTxt', 'request.deckTxt');
$route->post('/debug', 'Request:debug', 'request.debug');
$route->post('/saveWantList', 'Request:saveWantList', 'request.saveWantList');
$route->post('/saveHaveList', 'Request:saveHaveList', 'request.saveHaveList');

/**
 * Library cards
 */
$route->namespace("Source\Controllers\Api");
$route->group('library');

$route->get('/', 'LibraryController:index', 'library.index');
$route->get('/selectLibraryForList', 'LibraryController:selectLibraryForList', 'library.selectLibraryForList');
$route->get('/id/{id}', 'LibraryController:show', 'library.show');
$route->get('/name/{name}', 'LibraryController:showByName', 'library.showByName');
$route->get('/part-name/{name}', 'LibraryController:partName', 'library.partName');
$route->get('/card-image/{name}', 'LibraryController:cardImage', 'library.cardImage');

/**
 * Crypt cards
 */
$route->group('crypt');

$route->get('/', 'CryptController:index', 'crypt.index');
$route->get('/selectCryptForList', 'CryptController:selectCryptForList', 'crypt.selectCryptForList');
$route->get('/id/{id}', 'CryptController:show', 'crypt.show');
$route->get('/name/{name}', 'CryptController:showByName', 'crypt.showByName');
$route->get('/part-name/{name}', 'CryptController:partName', 'cript.partName');
$route->get('/card-image/{name}', 'CryptController:cardImage', 'crypt.cardImage');

/**
 * Users
 */
$route->group('user');

$route->get('/', 'UserController:index', 'user.index');
$route->get('/id/{id}', 'UserController:show', 'user.show');
$route->get('/name/{name}', 'UserController:showByName', 'user.showByName');
$route->get('/email/{email}', 'UserController:showByEmail', 'user.showByEmail');
$route->get('/partName/{name}', 'UserController:partName', 'user.partName');

$route->post('/', 'UserController:store', 'user.store');
$route->post('/login', 'UserController:login', 'user.login');

$route->put('/{id}', 'UserController:update', 'user.update');

$route->delete('/{id}', 'UserController:destroy', 'user.destroy');

/**
 * Deck
 */
$route->group('deck');

$route->get('/', 'DeckController:index', 'deck.index');
$route->get('/{id}', 'DeckController:show', 'deck.show');

$route->post('/', 'DeckController:showByDeckId', 'deck.showByDeckId');
$route->post('/updateDeck', 'DeckController:updateDeck', 'deck.updateDeck'); // como fazer uma requisicao put com ajax jquery
$route->post('/createDeck', 'DeckController:createDeck', 'deck.createDeck');

/**
 * Library list
 */
$route->group('libraryList');

$route->get('/', 'LibraryListController:index', 'libraryList.index');
$route->get('/{id}', 'LibraryListController:show', 'libraryList.show');
//$route->get('/showByDeckId', 'LibraryListController:showByDeckId', 'libraryList.showByDeckId'); //-----

$route->post('/', 'LibraryListController:store', 'libraryList.store');

$route->put('/{id}', 'LibraryListController:update', 'libraryList.update');

$route->delete('/{id}', 'LibraryListController:destroy', 'libraryList.destroy');

/**
 * Crypt list
 */
$route->group('cryptList');

$route->get('/', 'CryptListController:index', 'cryptList.index');
$route->get('/id/{id}', 'CryptListController:show', 'cryptList.show');

$route->post('/store', 'CryptListController:store', 'cryptList.store');

$route->put('/update/{id}', 'CryptListController:update', 'cryptList.update');

$route->delete('/delete/{id}', 'CryptListController:destroy', 'cryptList.destroy');


$route->dispatch();

if ($route->error()) {
      $route->redirect('web.error',[
            "error" => $route->error()
      ]);
}
