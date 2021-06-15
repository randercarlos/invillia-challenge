<?php

namespace Tests\Feature;

use App\Models\Person;
use App\Models\User;
use App\Services\UploadService;
use Illuminate\Support\Facades\File;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tymon\JWTAuth\Facades\JWTAuth;

class PeopleFeatureTest extends TestCase
{
    use RefreshDatabase;

    private $token;
    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        // configure the jwt and refresh expires to only 1 minute because it's a test.
        config(['jwt.ttl' => 1, 'refresh_ttl' => 1]);

        // create a user
        $this->user = factory(User::class)->create();

        // generate a JWT Token from user inserted in DB and save in $token property
        $this->token = JWTAuth::fromUser($this->user);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_can_list_people()
    {
        factory(Person::class)->create();

        $response = $this->getJson('api/v1/people', ['Authorization' => 'Bearer ' . $this->token]);

        $response
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id', 'name', 'created_at', 'updated_at'
                ]
            ]);

    }

    public function test_it_can_show_a_person()
    {
        $person = factory(Person::class)->create();

        $response = $this->getJson('api/v1/people/' . $person->id, ['Authorization' => 'Bearer ' . $this->token]);

        $response
            ->assertOk()
            ->assertJsonStructure([
                'id', 'name', 'created_at', 'updated_at'
            ]);
    }

    public function test_it_cant_show_a_person_with_nonexistent_id()
    {
        // create 10 people
        factory(Person::class, 1);

        $response = $this->getJson('api/v1/people/9999999', ['Authorization' => 'Bearer ' . $this->token]);

        $response->assertStatus(302);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_can_import_people_sincronous()
    {
        $this->post('/upload', [
            'isAsynchronous' => false,
            'submit' => 'Enviar',
            '_token' => 'XOGh1rXc2lJk8KTuvL2TeXikAHbpkpNeDmNAXCyi',
            'file' => new \Illuminate\Http\UploadedFile(resource_path('test-files/people.xml'), 'people.xml', null, null, true),
        ],['Authorization' => 'Bearer ' . $this->token]);


        $this->assertDatabaseCount('people', 3);

        $this->assertDatabaseHas('people', [
            'id' => 1,
            'name' => 'Name 1'
        ]);

        $this->assertDatabaseHas('phones', [
            'phone' => '2345678',
            'person_id' => 1
        ]);
    }

}
