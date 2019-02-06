<?php

Route::resource('/insects', 'InsectsController', [
  'except' => ['edit', 'show', 'create']
]);
