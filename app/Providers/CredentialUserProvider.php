<?php
namespace App\Providers;

use Illuminate\Auth\EloquentUserProvider as UserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;

class CredentialUserProvider extends UserProvider {

  public function validateCredentials(UserContract $user, array $credentials)
  {
    $plain = $credentials['clave'];

    return $this->hasher->check($plain, $user->getAuthPassword());
  }

}
