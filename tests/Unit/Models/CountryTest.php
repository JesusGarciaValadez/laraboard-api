<?php

namespace Tests\Unit\Models;

use App\Models\Country;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CountryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function it_can_share_all_the_countries()
    {
        self::assertStringContainsStringIgnoringCase('Canada', Country::getCountries());
        self::assertStringContainsStringIgnoringCase('Mexico', Country::getCountries());
        self::assertStringContainsStringIgnoringCase('Denmark', Country::getCountries());
    }
}
