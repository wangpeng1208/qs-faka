<?php
return [
    'secret_key' => getenv('JWT_SECRET_KEY'),
    'algorithms' => ['HS256'],
]; 