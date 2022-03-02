<?php

namespace App\Traits;

use Illuminate\Support\Facades\Config;
use Illuminate\Encryption\Encrypter;

trait EncryptionGeneratorTrait {
    private function getEncryptionKey(): string {
        return 'base64:'.base64_encode(
            Encrypter::generateKey(Config::get('app.cipher'))
        );
    }
}