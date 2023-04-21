<?php

namespace Tests;

use Storage;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    
    /**
     * Indicates whether the default seeder should run before each test.
     *
     * @var bool
     */
    protected $seed = true;
    
    public function setUp() :void  {
    parent::setUp();
    \Artisan::call('passport:install',['-vvv' => true]);
    
    Storage::deleteDirectory('testing/avatar');
    Storage::deleteDirectory('testing/files');
}
}
