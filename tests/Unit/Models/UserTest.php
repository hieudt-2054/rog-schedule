<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Tests\Unit\Models\ModelTestCase;

class UserTest extends ModelTestCase
{
    /**
     * Test model configuration.
     *
     * @test
     *
     * @return void
     */
    public function model_configuration()
    {
        $this->runConfigurationAssertions(new User(), [
            'name',
            'email',
            'password',
        ], ['password','remember_token']);
    }
}