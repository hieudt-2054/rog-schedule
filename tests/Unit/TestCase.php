<?php

namespace Tests\Unit;

use Tests\SeedDatabaseState;
use Tests\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithoutEvents;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase, WithoutEvents;

    /**
     * {@inheritDoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        if (! SeedDatabaseState::$seeded) {
            $this->artisan('db:seed');
        }
    }
}
