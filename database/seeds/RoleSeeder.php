<?php

use Illuminate\Database\Seeder;

use App\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //inicializamos los roles
        $role = new Role();
        $role->nombre = 'Administrador';
        $role->descripcion = 'Administrador';
        $role->save();

        $role = new Role();
        $role->nombre = 'Alumno';
        $role->descripcion = 'Alumno';
        $role->save();

        $role = new Role();
        $role->nombre = 'Maestro';
        $role->descripcion = 'Maestro';
        $role->save();
    }
}
