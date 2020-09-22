<?php

namespace Tests\Feature;

use App\Models\Author;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_an_author_can_be_created()
    {
        $response = $this->post('/authors', $this->data());

        $author = Author::all();

        $this->assertCount(1, $author);

        // Want to make sure that we're properly parsing the date as a carbon instance
        $this->assertInstanceOf(Carbon::class, $author->first()->dob);

        // Check to make sure that the date was parsed in the correct format
        // Since this is a carbon instance, we can use the format helper
        $this->assertEquals('2020/12/12', $author->first()->dob->format('Y/d/m'));
    }

    public function test_a_name_is_required()
    {
        $response = $this->post('/authors', array_merge($this->data(), ['name' => '']));

        $response->assertSessionHasErrors('name');
    }

    public function test_the_dob_is_required()
    {
        $response = $this->post('/authors', array_merge($this->data(), ['dob' => '']));

        $response->assertSessionHasErrors('dob');
    }

    private function data(): array
    {
        return [
            'name' => 'Dino Cajic',
            'dob' => '12/12/2020',
        ];
    }
}
