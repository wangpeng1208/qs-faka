<?php

return [
  'user.register' => [
    [app\merchantapi\event\User::class, 'signinSpread'],
  ],
  'user.login'    => [
  ],
];
