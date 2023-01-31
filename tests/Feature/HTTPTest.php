<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HTTPTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_registration_with_validation()
    {
        $response = $this->post('/api/register', [
            'email' => 'ken',
            'password' => 'ken123'
        ], [
                'Accept' => 'application/json'
            ]);

        $response->assertStatus(400);
    }

    public function test_registration()
    {
        $response = $this->post('/api/register', [
            'email' => 'ken@email.com',
            'password' => 'ken123456'
        ], [
                'Accept' => 'application/json'
            ]);

        $response->assertStatus(201);
    }

    public function test_registration_with_email_unique()
    {
        $response = $this->post('/api/register', [
            'email' => 'ken@email.com',
            'password' => 'ken123456'
        ], [
                'Accept' => 'application/json'
            ]);

        $response->assertStatus(400);
    }

    public function test_login()
    {
        $response = $this->post('/api/login', [
            'email' => 'ken@email.com',
            'password' => 'ken123456'
        ], [
                'Accept' => 'application/json'
            ]);

        $response->assertStatus(200);

    }

    public function test_get_product_list_authentication()
    {
        $response = $this->get('/api/products', [
            'Accept' => 'application/json',
            'Authorization' => "Bearer 123"
        ]);

        $response->assertStatus(401);
    }

    public function test_get_product_list_with_authenticated()
    {
        $for_token = $this->post('/api/login', [
            'email' => 'ken@email.com',
            'password' => 'ken123456'
        ], [
                'Accept' => 'application/json'
            ]);


        $decode = json_decode($for_token->content());
        $access_token = $decode->access_token;

        $response = $this->get('/api/products', [
            'Accept' => 'application/json',
            'Authorization' => "Bearer $access_token"
        ]);

        $response->assertStatus(200);
    }

    public function test_make_order_with_authentication()
    {
        $response = $this->post('/api/order/1', [
            'quantity' => 'One',
        ], [
                'Accept' => 'application/json',
                'Authorization' => "Bearer 123"
            ]);

        $response->assertStatus(401);
    }

    public function test_make_order_with_authenticated_and_validation()
    {
        $for_token = $this->post('/api/login', [
            'email' => 'ken@email.com',
            'password' => 'ken123456'
        ], [
                'Accept' => 'application/json'
            ]);


        $decode = json_decode($for_token->content());
        $access_token = $decode->access_token;

        $response = $this->post('/api/order/1', [
            'quantity' => 'One',
        ], [
                'Accept' => 'application/json',
                'Authorization' => "Bearer $access_token"
            ]);

        $response->assertStatus(400);
    }

    public function test_make_order_with_authenticated_but_product_not_found()
    {
        $for_token = $this->post('/api/login', [
            'email' => 'ken@email.com',
            'password' => 'ken123456'
        ], [
                'Accept' => 'application/json'
            ]);


        $decode = json_decode($for_token->content());
        $access_token = $decode->access_token;

        $response = $this->post('/api/order/20', [
            'quantity' => 1,
        ], [
                'Accept' => 'application/json',
                'Authorization' => "Bearer $access_token"
            ]);

        $response->assertStatus(400);
    }


    public function test_make_order_with_authenticated_but_zero_item_stock()
    {
        $for_token = $this->post('/api/login', [
            'email' => 'ken@email.com',
            'password' => 'ken123456'
        ], [
                'Accept' => 'application/json'
            ]);


        $decode = json_decode($for_token->content());
        $access_token = $decode->access_token;

        $response = $this->post('/api/order/4', [
            'quantity' => 1,
        ], [
                'Accept' => 'application/json',
                'Authorization' => "Bearer $access_token"
            ]);

        $response->assertStatus(400);
    }

    public function test_make_order_with_authenticated()
    {
        $for_token = $this->post('/api/login', [
            'email' => 'ken@email.com',
            'password' => 'ken123456'
        ], [
                'Accept' => 'application/json'
            ]);


        $decode = json_decode($for_token->content());
        $access_token = $decode->access_token;

        $response = $this->post('/api/order/1', [
            'quantity' => 1,
        ], [
                'Accept' => 'application/json',
                'Authorization' => "Bearer $access_token"
            ]);

        $response->assertStatus(201);
    }

    public function test_unauthenticated_logout()
    {
        $response = $this->delete('/api/logout', [], [
            'Accept' => 'application/json',
            'Authorization' => "Bearer asdfasdf"
        ]);

        $response->assertStatus(401);
    }

    public function test_authenticated_logout()
    {
        $for_token = $this->post('/api/login', [
            'email' => 'ken@email.com',
            'password' => 'ken123456'
        ], [
                'Accept' => 'application/json'
            ]);


        $decode = json_decode($for_token->content());
        $access_token = $decode->access_token;

        $response = $this->delete('/api/logout', [], [
            'Accept' => 'application/json',
            'Authorization' => "Bearer $access_token"
        ]);

        $response->assertStatus(204);
    }
}