<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
{
    Validator::make($input, [
        'name' => ['required', 'string', 'max:255'],
        'email' => [
            'required',
            'string',
            'email',
            'max:255',
            Rule::unique(User::class),
        ],
        'password' => $this->passwordRules(),
        'birthdate' => ['required', 'date'],
        'gender' => ['required', 'string'],
        'role' => ['required', 'string', Rule::in(['user', 'artist'])],
    ])->validate();

   // Crear el usuario
   $user = User::create([
    'name' => $input['name'],
    'email' => $input['email'],
    'password' => Hash::make($input['password']),
    'birthdate' => $input['birthdate'],
    'gender' => $input['gender'],
]);

// Crear el rol y asociarlo al usuario
$roleName = $input['role'];
if ($roleName === 'artist' || $roleName === 'user') {
    // Crear el nuevo rol
    $role = Role::create(['name' => $roleName]);
    // Establecer el user_id en el modelo de Role
    $role->user_id = $user->id;
    // Guardar el rol
    $role->save();
}

return $user;
}
}

