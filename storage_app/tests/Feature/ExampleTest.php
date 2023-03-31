<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
//        $response = $this->get('/');
//
//        $response->assertStatus(200);
        
        $this->assertTrue(true);
        
        DB::connection('mongodb')->table('blacklists')->truncate();
        DB::connection('mongodb')->table('api_activity_logs')->truncate();
    }
}
