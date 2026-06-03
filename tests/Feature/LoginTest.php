<?php

namespace Tests\Feature;

use Tests\TestCase;

class LoginTest extends TestCase
{
    public function test_la_pagina_login_carga_correctamente(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_la_pagina_registro_carga_correctamente(): void
    {
        $response = $this->get('/registro');

        $response->assertStatus(200);
    }
}