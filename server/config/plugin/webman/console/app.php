<?php
return [
    'enable'              => true,

    'build_dir'           => BASE_PATH . DIRECTORY_SEPARATOR . 'build',

    'phar_filename'       => 'q.phar',

    'bin_filename'        => 'q.bin',

    'signature_algorithm' => Phar::SHA256, //set the signature algorithm for a phar and apply it. The signature algorithm must be one of Phar::MD5, Phar::SHA1, Phar::SHA256, Phar::SHA512, or Phar::OPENSSL.

    'private_key_file'    => '', // The file path for certificate or OpenSSL private key file.

    'exclude_pattern'     => '#^(?!.*(composer.json|/.github/|/.idea/|/.vscode/|/.git/|/.setting/|/runtime/|/vendor-bin/|/build/|/upload/))(.*)$#',

    'exclude_files'       => [
        '.env',
        '.env.example',
        'LICENSE',
        'start.php',
        'webman.phar',
        'webman.bin',
        'README.md',
        'LICENSE.txt'
    ]
];
