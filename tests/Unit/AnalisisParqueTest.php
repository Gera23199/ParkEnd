<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\AnalisisParqueService;

class AnalisisParqueTest extends TestCase
{
    public function test_calcula_porcentaje_ocupacion()
    {
        $service = new AnalisisParqueService();

        $resultado = $service->calcularPorcentaje(95, 120);

        $this->assertEquals(79.17, round($resultado, 2));
    }

    public function test_clasifica_demanda_baja()
    {
        $service = new AnalisisParqueService();

        $this->assertEquals('Baja', $service->clasificarDemanda(20));
    }

    public function test_clasifica_demanda_media()
    {
        $service = new AnalisisParqueService();

        $this->assertEquals('Media', $service->clasificarDemanda(40));
    }

    public function test_clasifica_demanda_alta()
    {
        $service = new AnalisisParqueService();

        $this->assertEquals('Alta', $service->clasificarDemanda(70));
    }

    public function test_clasifica_demanda_saturada()
    {
        $service = new AnalisisParqueService();

        $this->assertEquals('Saturada', $service->clasificarDemanda(90));
    }
}