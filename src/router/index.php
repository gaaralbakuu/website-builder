<?php

use Core\Response;
use Core\Route;

Route::Get("/", function () {
    return Response::Controller("");
});
