<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_a_book_can_be_added_to_the_library()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/book', [
            'title'  => 'An Illustrative Introduction to Algorithms',
            'author' => 'Dino Cajic',
        ]);

        // Assert that we got a successful response
        $response->assertOk();

        // After the post hits, we expect that our database will have a record for this book
        $this->assertCount(1, Book::all());
    }

    public function test_a_title_is_required() {

        $response = $this->post('/book', [
            'title'  => '',
            'author' => 'Dino Cajic',
        ]);

        $response->assertSessionHasErrors('title');
    }

    public function test_the_author_is_required() {

        $response = $this->post('/book', [
            'title'  => 'An Illustrative Introduction to Algorithms',
            'author' => '',
        ]);

        $response->assertSessionHasErrors('author');
    }

    public function test_a_book_can_be_updated() {

        $this->withoutExceptionHandling();

        // First add a book
        // We already know that this works from our first test
        $this->post('/book', [
            'title'  => 'An Illustrative Introduction to Algorithms',
            'author' => 'Dino Cajic',
        ]);

        $book = Book::first();

        // Now modify the book
        $response = $this->patch('/book/' . $book->id, [
            'title' => 'New Title',
            'author' => 'New Author',
        ]);

        $this->assertEquals('New Title', Book::first()->title);
        $this->assertEquals('New Author', Book::first()->author);
    }
}
