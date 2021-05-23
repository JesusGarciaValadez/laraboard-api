<?php

namespace Tests\Unit;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StoreLogoTest extends TestCase
{
    /**
     * @test
     */
    public function it_stores_an_image()
    {
        Storage::fake();
        $logo = UploadedFile::fake()->image('image.jpg', 100, 100);

        storeLogo(Request::create('', 'GET', ['company' => 'blah blah blah'], [], ['logo' => $logo]));

        Storage::disk()->assertExists('/public/blah-blah-blah.jpg');
    }

    /**
     * @test
     */
    public function it_fails_when_a_file_is_not_valids()
    {
        Storage::fake();

        $logo = UploadedFile::fake()->create('logo.jpg', 0, 'image/jpg');
        $response = storeLogo(Request::create('', 'GET', ['company' => 'blah blah blah'], [], ['logo' => $logo]));

        $this->assertNull($response);
        Storage::disk()->assertMissing('/public/blah-blah-blah.jpg');
    }
}
