<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Role;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new User();
        $role->email = 'pablo12_jip3@hotmail.com';
        $role->password = Hash::make('secret');;
        $role->nombres = 'Pablo de Jesús';
        $role->apellido_paterno = 'Pérez';
        $role->apellido_materno = 'Jip';
        $role->role_id = Role::where('nombre', 'Administrador')->firstOrFail()->id;

        $role->save();
    }
}
