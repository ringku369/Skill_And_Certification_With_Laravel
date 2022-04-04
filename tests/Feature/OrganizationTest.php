<?php

namespace Tests\Feature;

use App\Models\Organization;
use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\UploadedFile;

class OrganizationTest extends TestCase
{
    //use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $user = User::findOrFail(1);
        $this->actingAs($user);
        DB::beginTransaction();
    }

    protected function tearDown(): void
    {
        DB::rollBack();

        //parent::tearDown(); // TODO: Change the autogenerated stub
    }


    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreateOrganization()
    {
        $this->setUp();
        $faker = Faker::create();


        $response = $this->post(route('admin.organizations.store'), [
            '_token' => csrf_token(),
            'title' => $faker->company,
            'address' => $faker->address,
            'mobile' => '01757808214',
            'email' => $faker->email,
            'fax_no' => '12345678',
            'contact_person_name' => $faker->name,
            'contact_person_mobile' => '01757000000',
            'contact_person_email' => $faker->companyEmail,
            'contact_person_designation' => $faker->jobTitle,
            'domain' => 'https://www.csrhymes.com',
            'organization_type_id' => 1,
            'description' => 'none',
            'logo' => UploadedFile::fake()->image('avatar.jpg')
        ]);
        $response->assertSessionHasNoErrors();
        $response->assertStatus(302);
        $this->tearDown();
    }

    public function testUpdateOrganization()
    {
        $this->setUp();

        $faker = Faker::create();

        $organization = Organization::first();

        $response = $this->put(route('admin.organizations.update', $organization->id), [
            '_token' => csrf_token(),
            'title' => $faker->company,
            'address' => $faker->address,
            'mobile' => '01757808214',
            'email' => $faker->email,
            'fax_no' => '12345678',
            'contact_person_name' => $faker->name,
            'contact_person_mobile' => '01757000000',
            'contact_person_email' => $faker->companyEmail,
            'contact_person_designation' => $faker->jobTitle,
            'domain' => 'https://www.csrhymes.com',
            'organization_type_id' => 1,
            'description' => 'none',
            'logo' => UploadedFile::fake()->image('avatar.jpg')
        ]);
        $response->assertSessionHasNoErrors();
        $response->assertStatus(302);
        $this->tearDown();

    }

    public function testDeleteOrganization()
    {
        $this->setUp();

        $organization = Organization::first();
        $response = $this->get(route('admin.organizations.destroy', $organization->id), [
            '_token' => csrf_token(),
        ]);
        $response->assertStatus(200);

    }

}
