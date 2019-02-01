<?php

Route::resource('/cruds', 'CrudsController', [
  'except' => ['edit', 'show', 'store']
]);
