<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TagControllerTest extends TestCase
{
    use RefreshDatabase;
    public function testStore()
    {
        //$this->whitoutExceptionHandling();
        $this
            ->post('tags', ['name' => 'PHP'])
            ->assertRedirect('/');

        $this->assertDatabaseHas('tags', ['name' => 'PHP']);
    }

    public function testDestroy() {
        // Creamos un elementos para poder eliminar
        $tag = Tag::factory()->create();

        // Vamos a la ruta de eliminar, (tags, con el id), y que redireccione, con el otro $this se omite el siguiente paso
        $this->withoutExceptionHandling();
        $this
            ->delete("tags/$tag->id")
            ->assertRedirect('/');

        // Comprobamos que este elemento ya no existe en la tabla tags
        //$this->assertDatabaseMissing('tags', ['name' => $tag->name]);
    }

    public function test_validate_name_field_has_a_value_when_create_a_new_tag() {
        // Test para validar post y la ruta "tags" en caso de que este vacio, que devuelva error
        $this
            ->post('tags', ['name' => ''])
            ->assertSessionHasErrors('name');
    }
}
