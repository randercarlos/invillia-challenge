<?php

namespace Tests\Feature;

use App\Models\Job;
use App\Models\Person;
use App\Models\Recruiter;
use App\Models\ShipOrder;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Facades\JWTAuth;

class ShipOrderFeatureTest extends TestCase
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
    public function test_it_can_list_ship_orders()
    {
        factory(ShipOrder::class)->create();

        $response = $this->getJson('api/v1/orders', ['Authorization' => 'Bearer ' . $this->token]);

        $response
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id', 'person_id', 'destinatary_name', 'destinatary_address', 'destinatary_city',
                    'destinatary_country', 'created_at', 'updated_at'
                ]
            ]);

    }

    public function test_it_can_show_a_ship_order()
    {
        $shipOrder = factory(ShipOrder::class)->create();

        $response = $this->getJson('api/v1/orders/' . $shipOrder->id, ['Authorization' => 'Bearer ' . $this->token]);

        $response
            ->assertOk()
            ->assertJsonStructure([
                'id', 'person_id', 'destinatary_name', 'destinatary_address', 'destinatary_city',
                'destinatary_country', 'created_at', 'updated_at'
            ]);
    }

    public function test_it_cant_show_a_ship_order_with_nonexistent_id()
    {
        // create 10 ship_orders
        factory(ShipOrder::class)->create();

        $response = $this->get('api/v1/orders/9999999', ['Authorization' => 'Bearer ' . $this->token]);

        $response->assertStatus(302);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_can_import_ship_orders_sincronous()
    {
        factory(Person::class, 3)->create();

        $this->post('/upload', [
            'isAsynchronous' => false,
            'submit' => 'Enviar',
            '_token' => 'XOGh1rXc2lJk8KTuvL2TeXikAHbpkpNeDmNAXCyi',
            'file' => new \Illuminate\Http\UploadedFile(resource_path('test-files/shiporders.xml'), 'shiporders.xml', null, null, true),
        ],['Authorization' => 'Bearer ' . $this->token]);

        $this->assertDatabaseCount('ship_orders', 3);

        $this->assertDatabaseHas('ship_orders', [
            'id' => 1,
            'person_id' => 1,
            'destinatary_name' => 'Name 1',
            'destinatary_address' => 'Address 1',
            'destinatary_city' => 'City 1',
            'destinatary_country' => 'Country 1'
        ]);

        $this->assertDatabaseHas('ship_order_details', [
            'id' => 1,
            'ship_order_id' => 1,
            'title' => 'Title 1',
            'note' => 'Note 1',
            'quantity' => 745,
            'price' => 123.45
        ]);
    }

}
