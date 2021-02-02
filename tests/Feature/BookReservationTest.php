<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Book;
use Tests\TestCase;

class BookReservationTest extends TestCase
{

    use RefreshDatabase;
    /**
     * @test
    */
    public function test_a_book_can_be_added_to_the_library()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('books', [
            'title' => 'Rifles for Waitie',
            'author' => 'Edward'
        ]);

        $response->assertOk();

        $this->assertCount(1, Book::all());
    }

    /**
     * @test
     */
    public function test_a_title_is_required()
    {
        $response = $this->post('/books', [
            'title' => '',
            'author' => 'Edward'
        ]);
        $response->assertSessionHasErrors('title');
    }


      /**
     * @test
     */
    public function test_an_author_is_required()
    {
        $response = $this->post('/books', [
            'title' => 'Rifles for Waite',
            'author' => ''
        ]);
        $response->assertSessionHasErrors('author');
    }

    /**
     * @test
     */
     public function test_a_book_can_be_updated()
     {
         $this->withoutExceptionHandling();
         $this->post('/books', [
             'title' => 'Rifles for Waitie',
             'author' => 'Edward'
         ]);

         $book = Book::first();

         $response = $this->patch('/books/' . $book->id, [
             'title' => 'Changed title',
             'author' => 'New Author'
         ]);

         $this->assertEquals('Changed title', Book::first()->title);
         $this->assertEquals('New Author', Book::first()->author);

         
     }
}
