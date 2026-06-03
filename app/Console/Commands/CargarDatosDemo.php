<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Atraccion;
use App\Models\Visita;
use App\Models\AnalisisParque;
use App\Services\AnalisisParqueService;
use Illuminate\Console\Command;

class CargarDatosDemo extends Command
{
    protected $signature = 'parkend:demo {--clear}';

    protected $description = 'Crea o elimina datos demo de ParkEnd';

    public function handle()
    {
        $correoDemo = 'demo@parkend.com';

        if ($this->option('clear')) {
            return $this->borrarDatosDemo($correoDemo);
        }

        return $this->crearDatosDemo($correoDemo);
    }

    private function borrarDatosDemo($correoDemo)
    {
        $usuario = User::where('email', $correoDemo)->first();

        if (!$usuario) {
            $this->warn('No existe el usuario demo.');
            return Command::SUCCESS;
        }

        $visitasIds = Visita::where('user_id', $usuario->id)->pluck('id');

        AnalisisParque::whereIn('visita_id', $visitasIds)->delete();

        Visita::where('user_id', $usuario->id)->delete();

        $usuario->delete();

        $this->info('Datos demo eliminados correctamente.');
        $this->info('Usuario eliminado: ' . $correoDemo);
        $this->info('Visitas eliminadas: ' . $visitasIds->count());

        return Command::SUCCESS;
    }

    private function crearDatosDemo($correoDemo)
    {
        $this->info('Iniciando carga de datos demo...');

        $service = new AnalisisParqueService();

        $usuario = User::firstOrCreate(
            ['email' => $correoDemo],
            [
                'name' => 'Usuario Demo',
                'password' => '123456',
                'login_count' => 0,
            ]
        );

        $visitasExistentes = Visita::where('user_id', $usuario->id)->count();

        if ($visitasExistentes > 0) {
            $this->warn('El usuario demo ya tiene registros.');
            $this->warn('Primero ejecuta: php artisan parkend:demo --clear');
            return Command::SUCCESS;
        }

        $atraccionesBase = [
            ['nombre' => 'Montaña Rusa Extrema', 'tipo' => 'Extrema', 'capacidad_hora' => 120, 'estado' => 'Activa'],
            ['nombre' => 'Río Salvaje', 'tipo' => 'Acuática', 'capacidad_hora' => 90, 'estado' => 'Activa'],
            ['nombre' => 'Casa del Terror', 'tipo' => 'Temática', 'capacidad_hora' => 60, 'estado' => 'Activa'],
            ['nombre' => 'Carrusel Infantil', 'tipo' => 'Familiar', 'capacidad_hora' => 150, 'estado' => 'Activa'],
            ['nombre' => 'Torre de Caída Libre', 'tipo' => 'Extrema', 'capacidad_hora' => 80, 'estado' => 'Activa'],
            ['nombre' => 'Tacitas Giratorias', 'tipo' => 'Familiar', 'capacidad_hora' => 100, 'estado' => 'Activa'],
            ['nombre' => 'Barco Pirata', 'tipo' => 'Extrema', 'capacidad_hora' => 85, 'estado' => 'Activa'],
            ['nombre' => 'Laberinto Encantado', 'tipo' => 'Temática', 'capacidad_hora' => 50, 'estado' => 'Activa'],
            ['nombre' => 'Tren Infantil', 'tipo' => 'Infantil', 'capacidad_hora' => 70, 'estado' => 'Activa'],
            ['nombre' => 'Simulador 4D', 'tipo' => 'Tecnológica', 'capacidad_hora' => 65, 'estado' => 'Activa'],
            ['nombre' => 'Sillas Voladoras', 'tipo' => 'Familiar', 'capacidad_hora' => 95, 'estado' => 'Activa'],
            ['nombre' => 'Splash Acuático', 'tipo' => 'Acuática', 'capacidad_hora' => 110, 'estado' => 'Activa'],
        ];

        foreach ($atraccionesBase as $item) {
            Atraccion::firstOrCreate(
                ['nombre' => $item['nombre']],
                $item
            );
        }

        $atracciones = Atraccion::where('estado', 'Activa')->get();

        for ($i = 1; $i <= 3000; $i++) {
            $atraccion = $atracciones->random();

            $hora = rand(9, 20);

            $visita = Visita::create([
                'user_id' => $usuario->id,
                'atraccion_id' => $atraccion->id,
                'fecha' => now()->subDays(rand(0, 60))->format('Y-m-d'),
                'hora_inicio' => str_pad($hora, 2, '0', STR_PAD_LEFT) . ':00:00',
                'hora_fin' => str_pad($hora + 1, 2, '0', STR_PAD_LEFT) . ':00:00',
                'cantidad_visitantes' => rand(5, 180),
                'promocion_activa' => rand(0, 1),
            ]);

            $porcentaje = $service->calcularPorcentaje(
                $visita->cantidad_visitantes,
                $atraccion->capacidad_hora
            );

            $nivel = $service->clasificarDemanda($porcentaje);

            $recomendacion = $service->generarRecomendacion($nivel);

            AnalisisParque::create([
                'atraccion_id' => $atraccion->id,
                'visita_id' => $visita->id,
                'visitantes_registrados' => $visita->cantidad_visitantes,
                'capacidad_maxima' => $atraccion->capacidad_hora,
                'porcentaje_ocupacion' => $porcentaje,
                'nivel_demanda' => $nivel,
                'recomendacion' => $recomendacion,
            ]);
        }

        $this->info('Carga demo terminada correctamente.');
        $this->info('Usuario demo: ' . $correoDemo);
        $this->info('Contraseña: 123456');
        $this->info('Visitas creadas: 3000');
        $this->info('Análisis creados: 3000');

        return Command::SUCCESS;
    }
}