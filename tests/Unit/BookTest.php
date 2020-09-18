<?php

namespace Tests\Unit;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{

    use RefreshDatabase;

    public function test_an_author_id_is_recorded()
    {
        $this->withoutExceptionHandling();

        Book::create([
            'title' => 'An Illustrative Introduction to Algorithms',
            'author_id' => 1,
        ]);

        $this->assertCount(1, Book::all());
    }
}
