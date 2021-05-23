<?php

namespace Tests\Feature\Api;

use App\Http\Enums\HttpResponseStatus;
use App\Models\JobPost;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
//use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class JobPostControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @var Collection|Model|mixed
     */
    private mixed $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        Auth::setUser($this->user);
    }

    public function jobPostsProvider(): array
    {
        $logo = UploadedFile::fake()->image('image.jpg', 100, 100);
        $today = now();
        $todayOneMonthForward = $today->addMonth();
        $validPayload = [
            'countries' => '[{}]',
            'company' => 'aaaaaa',
            'title' => 'xxxxxx',
            'description' => 'yyyyyy',
            'is_remote' => true,
            'url' => 'https://www.xxxxxxx.com/',
            'tags' => '[{}]',
            'logo' => $logo,
            'enhancements' => '[{}]',
            'go_live_date' => $today,
            'due_date' => $todayOneMonthForward,
            'is_active' => true,
        ];

        return [
            [
                [
                    'countries' => '[{}]',
                    'company' => 'aaaaaa',
                    'title' => 'xxxxxx',
                    'description' => 'yyyyyy',
                    'is_remote' => true,
                    'url' => 'https://www.xxxxxxx.com/',
                    'tags' => '[{}]',
                    'logo' => $logo,
                    'enhancements' => '[{}]',
                    'go_live_date' => $today,
                    'due_date' => $todayOneMonthForward,
                    'is_active' => true,
                ],
                HttpResponseStatus::CREATED, 1,
                [
                    'created_by' => '1',
                    'updated_by' => '1',
                    'countries' => "\"[{}]\"",
                    'company' => 'aaaaaa',
                    'title' => 'xxxxxx',
                    'description' => 'yyyyyy',
                    'is_remote' => '1',
                    'url' => 'https://www.xxxxxxx.com/',
                    'tags' => "\"[{}]\"",
                    'logo_url' => 'aaaaaa.jpg',
                    'enhancements' => "\"[{}]\"",
                    'go_live_date' => $today->format('Y-m-d H:i:s'),
                    'due_date' => $todayOneMonthForward->format('Y-m-d H:i:s'),
                    'is_active' => '1',
                ],
                '/public/aaaaaa.jpg'
            ], // 00. Stores all the data
            [
                [
                    'countries' => '[{}]',
                    'company' => 'aaaaaa',
                    'title' => 'xxxxxx',
                    'description' => 'yyyyyy',
                    'is_remote' => false,
                    'url' => 'https://www.xxxxxxx.com/',
                    'tags' => '[{}]',
                    'logo' => $logo,
                    'enhancements' => '[{}]',
                    'go_live_date' => $today,
                    'due_date' => $todayOneMonthForward,
                    'is_active' => false,
                ],
                HttpResponseStatus::CREATED, 1,
                [
                    'created_by' => '1',
                    'updated_by' => '1',
                    'countries' => "\"[{}]\"",
                    'company' => 'aaaaaa',
                    'title' => 'xxxxxx',
                    'description' => 'yyyyyy',
                    'is_remote' => '0',
                    'url' => 'https://www.xxxxxxx.com/',
                    'tags' => "\"[{}]\"",
                    'logo_url' => 'aaaaaa.jpg',
                    'enhancements' => "\"[{}]\"",
                    'go_live_date' => $today->format('Y-m-d H:i:s'),
                    'due_date' => $todayOneMonthForward->format('Y-m-d H:i:s'),
                    'is_active' => '0',
                ],
                '/public/aaaaaa.jpg'
            ], // 01. Stores only the required valid data
            [
                [
                    'countries' => '',
                    'company' => $validPayload['company'],
                    'title' => $validPayload['title'],
                    'description' => $validPayload['description'],
                    'is_remote' => (bool) $validPayload['is_remote'],
                    'url' => $validPayload['url'],
                    'tags' => $validPayload['tags'],
                    'logo' => $validPayload['logo'],
                    'enhancements' => $validPayload['enhancements'],
                    'go_live_date' => $validPayload['go_live_date'],
                    'due_date' => $validPayload['due_date'],
                    'is_active' => (bool) $validPayload['is_active'],
                ],
                HttpResponseStatus::FOUND
            ], // 02. The validation fails when the countries are not a valid JSON
            [
                [
                    'countries' => $validPayload['countries'],
                    'company' => null,
                    'title' => $validPayload['title'],
                    'description' => $validPayload['description'],
                    'is_remote' => (bool) $validPayload['is_remote'],
                    'url' => $validPayload['url'],
                    'tags' => $validPayload['tags'],
                    'logo' => $validPayload['logo'],
                    'enhancements' => $validPayload['enhancements'],
                    'go_live_date' => $validPayload['go_live_date'],
                    'due_date' => $validPayload['due_date'],
                    'is_active' => (bool) $validPayload['is_active'],
                ],
                HttpResponseStatus::FOUND
            ], // 03. The validation fails when the company is not valid
            [
                [
                    'countries' => $validPayload['countries'],
                    'company' => $validPayload['company'],
                    'title' => '',
                    'description' => $validPayload['description'],
                    'is_remote' => (bool) $validPayload['is_remote'],
                    'url' => $validPayload['url'],
                    'tags' => $validPayload['tags'],
                    'logo' => $validPayload['logo'],
                    'enhancements' => $validPayload['enhancements'],
                    'go_live_date' => $validPayload['go_live_date'],
                    'due_date' => $validPayload['due_date'],
                    'is_active' => (bool) $validPayload['is_active'],
                ],
                HttpResponseStatus::FOUND
            ], // 04. The validation fails when the title is not valid
            [
                [
                    'countries' => $validPayload['countries'],
                    'company' => $validPayload['countries'],
                    'title' => $validPayload['title'],
                    'description' => $validPayload['description'],
                    'is_remote' => 'true',
                    'url' => $validPayload['url'],
                    'tags' => $validPayload['tags'],
                    'logo' => $validPayload['logo'],
                    'enhancements' => $validPayload['enhancements'],
                    'go_live_date' => $validPayload['go_live_date'],
                    'due_date' => $validPayload['due_date'],
                    'is_active' => 'false',
                ],
                HttpResponseStatus::FOUND
            ], // 05. The validation fails when is_remote and is_active aren't a valid boolean
            [
                [
                    'countries' => $validPayload['countries'],
                    'company' => $validPayload['countries'],
                    'title' => $validPayload['title'],
                    'description' => $validPayload['description'],
                    'is_remote' => (bool) $validPayload['is_remote'],
                    'url' => 'www.xxxxxxx.com/',
                    'tags' => $validPayload['tags'],
                    'logo' => $validPayload['logo'],
                    'enhancements' => $validPayload['enhancements'],
                    'go_live_date' => $validPayload['go_live_date'],
                    'due_date' => $validPayload['due_date'],
                    'is_active' => (bool) $validPayload['is_active'],
                ],
                HttpResponseStatus::FOUND
            ], // 06. The validation fails when the url is not a valid url
            [
                [
                    'countries' => $validPayload['countries'],
                    'company' => $validPayload['company'],
                    'title' => $validPayload['title'],
                    'description' => $validPayload['description'],
                    'is_remote' => (bool) $validPayload['is_remote'],
                    'url' => $validPayload['url'],
                    'tags' => 'tags',
                    'logo' => $validPayload['logo'],
                    'enhancements' => $validPayload['enhancements'],
                    'go_live_date' => $validPayload['go_live_date'],
                    'due_date' => $validPayload['due_date'],
                    'is_active' => (bool) $validPayload['is_active'],
                ],
                HttpResponseStatus::FOUND
            ], // 07. The validation fails when the tags are not a valid JSON
            [
                [
                    'countries' => $validPayload['countries'],
                    'company' => $validPayload['countries'],
                    'title' => $validPayload['title'],
                    'description' => $validPayload['description'],
                    'is_remote' => (bool) $validPayload['is_remote'],
                    'url' => $validPayload['url'],
                    'tags' => $validPayload['tags'],
                    'logo' => UploadedFile::fake()->create('logo.pdf', 100, 'application/pdf'),
                    'enhancements' => $validPayload['enhancements'],
                    'go_live_date' => $validPayload['go_live_date'],
                    'due_date' => $validPayload['due_date'],
                    'is_active' => (bool) $validPayload['is_active'],
                ],
                HttpResponseStatus::FOUND, 0, [], ''
            ], // 08. The validation fails when the file is not a valid image
            [
                [
                    'countries' => $validPayload['countries'],
                    'company' => $validPayload['company'],
                    'title' => $validPayload['title'],
                    'description' => $validPayload['description'],
                    'is_remote' => (bool) $validPayload['is_remote'],
                    'url' => $validPayload['url'],
                    'tags' => $validPayload['tags'],
                    'logo' => $validPayload['logo'],
                    'enhancements' => 'enhancements',
                    'go_live_date' => $validPayload['go_live_date'],
                    'due_date' => $validPayload['due_date'],
                    'is_active' => (bool) $validPayload['is_active'],
                ],
                HttpResponseStatus::FOUND
            ], // 09. The validation fails when the enhancements are not a valid JSON
            [
                [
                    'countries' => $validPayload['countries'],
                    'company' => $validPayload['company'],
                    'title' => $validPayload['title'],
                    'description' => $validPayload['description'],
                    'is_remote' => (bool) $validPayload['is_remote'],
                    'url' => $validPayload['url'],
                    'tags' => $validPayload['tags'],
                    'logo' => $validPayload['logo'],
                    'enhancements' => $validPayload['enhancements'],
                    'go_live_date' => '',
                    'due_date' => $validPayload['due_date'],
                    'is_active' => (bool) $validPayload['is_active'],
                ],
                HttpResponseStatus::FOUND
            ], // 10. The validation fails when the go_live_date is not valid
            [
                [
                    'countries' => $validPayload['countries'],
                    'company' => $validPayload['company'],
                    'title' => $validPayload['title'],
                    'description' => $validPayload['description'],
                    'is_remote' => (bool) $validPayload['is_remote'],
                    'url' => $validPayload['url'],
                    'tags' => $validPayload['tags'],
                    'logo' => $validPayload['logo'],
                    'enhancements' => $validPayload['enhancements'],
                    'go_live_date' => $validPayload['go_live_date'],
                    'due_date' => 'cccccc',
                    'is_active' => (bool) $validPayload['is_active'],
                ],
                HttpResponseStatus::FOUND
            ], // 11. The validation fails when the due_date is not valid
        ];
    }

    /** @test */
    public function it_shows_all_the_job_posts()
    {
        JobPost::factory()->create(['created_by' => \Auth::id(), 'title' => 'Gardenia']);
        JobPost::factory()->create(['created_by' => \Auth::id(), 'title' => 'Iggy Pop']);

        $response = $this->actingAs($this->user)->get(route('job_post.index'));

        $response->assertJson(['data' => [
            ['title' => 'Gardenia'],
            ['title' => 'Iggy Pop'],
        ]]);
        $response->assertJsonStructure([
            'data' => [
                [
                    'countries',
                    'title',
                    'description',
                    'is_remote',
                    'url',
                    'tags',
                    'logo_url',
                    'enhancements',
                    'go_live_date',
                    'due_date',
                    'is_active',
                    'is_live',
                    'order',
                    'createdBy',
                    'updatedBy',
                ],
            ],
        ]);
    }

    /**
     * @test
     * @dataProvider jobPostsProvider
     */
    public function it_stores_a_job_post(
        $input,
        $expectedStatus,
        $expectedCount = null,
        $expectedModel = null,
        $expectedImagePath = null
    ) {
        Storage::fake();

        $response = $this->actingAs($this->user)->post(route('job_post.store'), $input);

        $response->assertStatus($expectedStatus);
        if ($expectedStatus === HttpResponseStatus::CREATED) {
            $this->assertDatabaseCount('job_posts', $expectedCount);
            $this->assertDatabaseHas('job_posts', $expectedModel);
            Storage::disk()->assertExists($expectedImagePath);
        }
    }

    /** @test  */
    public function it_shows_a_job_post()
    {
        $jobPost = JobPost::factory()->create(['title' => 'Death Magnetic']);

        $response = $this->actingAs($this->user)->get(route('job_post.show', [$jobPost->id]));

        $response->assertStatus(HttpResponseStatus::OK);
        $response->assertJson(['title' => 'Death Magnetic']);
        $response->assertJsonStructure([
            'countries',
            'title',
            'description',
            'is_remote',
            'url',
            'tags',
            'logo_url',
            'enhancements',
            'go_live_date',
            'due_date',
            'is_active',
            'is_live',
            'order',
            'createdBy',
            'updatedBy',
        ]);
    }

    /**  @test */
    public function it_updates_a_job_post()
    {
        Storage::fake();
        $logo = (UploadedFile::fake()->image('image.jpg', 100, 100))->storePubliclyAs('public', 'aaaaaa.jpg');
        $newLogo = UploadedFile::fake()->image('image.png', 100, 100);
        $today = now();
        $todayOneMonthForward = $today->addMonth();
        $newDate = now()->addDay();
        $jobPost = JobPost::factory()->create([
            'countries' => '[{}]',
            'company' => 'aaaaaa',
            'title' => 'xxxxxx',
            'description' => 'yyyyyy',
            'is_remote' => true,
            'url' => 'https://www.xxxxxxx.com/',
            'tags' => '[{}]',
            'logo_url' => $logo,
            'enhancements' => '[{}]',
            'go_live_date' => $today,
            'due_date' => $todayOneMonthForward,
            'is_active' => true,
        ]);
        $validPayload = [
            'countries' => '[{}]',
            'company' => 'bbbbbb',
            'title' => 'cccccc',
            'description' => 'dddddd',
            'is_remote' => true,
            'url' => 'https://www.zzzzzz.com/',
            'tags' => '[{}]',
            'logo' => $newLogo,
            'enhancements' => '[{}]',
            'go_live_date' => $newDate,
            'due_date' => null,
            'is_active' => false,
        ];

        $response = $this->actingAs($this->user)->put(route('job_post.update', [$jobPost->id]), $validPayload);

        $response->assertStatus(HttpResponseStatus::NO_CONTENT);
        if ($response->status() === HttpResponseStatus::NO_CONTENT) {
            $this->assertDatabaseCount('job_posts', 1);
            $this->assertDatabaseHas('job_posts', [
                'updated_by' => '1',
                'countries' => "\"[{}]\"",
                'company' => 'bbbbbb',
                'title' => 'cccccc',
                'description' => 'dddddd',
                'is_remote' => '1',
                'url' => 'https://www.zzzzzz.com/',
                'tags' => "\"[{}]\"",
                'logo_url' => 'bbbbbb.png',
                'enhancements' => "\"[{}]\"",
                'go_live_date' => $newDate->format('Y-m-d H:i:s'),
                'due_date' => null,
                'is_active' => '0',
            ]);
            Storage::disk()->assertExists('/public/bbbbbb.png');
        }
    }

    /** @test  */
    public function it_destroy_a_job_post()
    {
        $jobPost = JobPost::factory()->create(['title' => 'Death Magnetic']);

        $response = $this->actingAs($this->user)->delete(route('job_post.destroy', [$jobPost->id]));

        $response->assertStatus(HttpResponseStatus::NO_CONTENT);
        $this->assertDatabaseCount('job_posts', 0);
    }
}
