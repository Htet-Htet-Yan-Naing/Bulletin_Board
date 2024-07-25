<?php

namespace Tests\Unit;

use App\Services\PostService;
use Tests\TestCase;
use App\Models\Posts;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Testing\File;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PostModelFunctionalityTest extends TestCase
{
    public function test_postSave()
    {
        $data = [
            'title' => 'testTitle6',
            'description' => 'description6',
            'create_user_id' => 1,
            'updated_user_id' => 1,
        ];
        Posts::create($data);
        $this->assertDatabaseHas('posts', $data);
    }

    public function testUpdatePost()
    {
        $post = Posts::create([
            'title' => 'TestTitle7',
            'description' => 'description7',
            'create_user_id' => 1,
            'updated_user_id' => 1,
        ]);
        $post->update([
            'title' => 'UpdatedTitle7',
            'description' => 'updated description7',
            'updated_user_id' => 3,
        ]);
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'UpdatedTitle7',
            'description' => 'updated description7',
            'updated_user_id' => 3,
        ]);
    }

    public function testDeletePost()
    {
        $post = Posts::create([
            'title' => 'testDeletePost',
            'description' => 'testDeletePost_desc',
            'create_user_id' => 1,
            'updated_user_id' => 1,
        ]);
        $post->update([
            'title' => 'testDeletePost',
            'description' => 'testDeletePost_desc',
            'updated_user_id' => 3,
        ]);
        $post = Posts::findOrFail($post->id);
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'testDeletePost',
            'description' => 'testDeletePost_desc',
            'updated_user_id' => 3,
        ]);
        $post->delete();
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }
        public function testUploadValidCSV()
    {

        Storage::fake('public'); 
        $file = File::create('test.csv', 'Title 1,Title 2,Title 3', 'text/csv');
        $response = $this->post('/uploadedpost', ['csvfile' => $file]);
        $response->assertSessionDoesntHaveErrors('csvfile');
        $this->assertGreaterThan(0, Posts::count());

    }
    public function testUploadInvalidFileType()
    {
        Storage::fake('public'); 
        $file = File::create('test.png', '', 'image/png');
        $response = $this->post('/uploadedpost', ['csvfile' => $file]);
        $response->assertSessionHasErrors('csvfile');
    }
}

