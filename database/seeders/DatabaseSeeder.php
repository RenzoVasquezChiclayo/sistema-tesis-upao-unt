<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsuarioSeeder::class);
        $this->call(FacultadSeeder::class);
        $this->call(SedeSeeder::class);
        $this->call(EscuelaSeeder::class);
        //$this->call(AsesorSeeder::class);
        $this->call(TipoReferenciaSeeder::class);
        $this->call(TipoInvestigacionSeeder::class);
        $this->call(PresupuestoSeeder::class);
        $this->call(EgresadoSeeder::class);

        User::factory(1)->create(['name'=>'jmiranda','rol'=>'director']);

        User::factory(1)->create(['name'=>'rvasquez','rol'=>'docente']);

        User::factory(1)->create(['name'=>'secretaria','rol'=>'secretaria']);

        User::factory(1)->create(['name'=>'jmiranda-CTesis','rol'=>'d-CTesis2022-1']);

    }
}
