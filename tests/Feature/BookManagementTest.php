<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_book_can_be_added_to_the_library()
    {
        $response = $this->post('/books', [
            'title'  => 'An Illustrative Introduction to Algorithms',
            'author' => 'Dino Cajic',
        ]);

        $book = Book::first();

        // After the post hits, we expect that our database will have a record for this book
        $this->assertCount(1, Book::all());

        $response->assertRedirect('/books/' . $book->id);
    }

    public function test_a_title_is_required()
    {
        $response = $this->post('/books', [
            'title'  => '',
            'author' => 'Dino Cajic',
        ]);

        $response->assertSessionHasErrors('title');
    }

    public function test_the_author_is_required()
    {
        $response = $this->post('/books', [
            'title'  => 'An Illustrative Introduction to Algorithms',
            'author' => '',
        ]);

        $response->assertSessionHasErrors('author');
    }

    public function test_a_book_can_be_updated()
    {
        // First add a book
        // We already know that this works from our first test
        $this->post('/books', [
            'title'  => 'An Illustrative Introduction to Algorithms',
            'author' => 'Dino Cajic',
        ]);

        $book = Book::first();

        // Now modify the book
        $response = $this->patch('/books/' . $book->id, [
            'title' => 'New Title',
            'author' => 'New Author',
        ]);

        $this->assertEquals('New Title', Book::first()->title);
        $this->assertEquals('New Author', Book::first()->author);

        $response->assertRedirect('/books/' . $book->id);
    }

    public function test_a_book_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $this->post('/books', [
            'title'  => 'An Illustrative Introduction to Algorithms',
            'author' => 'Dino Cajic',
        ]);

        $book = Book::first();

        // Make sure the book has been added to the DB table
        $this->assertCount(1, Book::all());

        // Now delete a book that's been added
        $response = $this->delete('/books/' . $book->id);

        // Make sure that it has been deleted
        $this->assertCount(0, Book::all());

        // Test to make sure that the user is redirected to /book
        $response->assertRedirect('/books');
    }
}
