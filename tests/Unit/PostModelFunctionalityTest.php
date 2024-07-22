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

    //public function testUploadValidCSV()
    //{
    //    Storage::fake('public');
    //    $file = new UploadedFile(
    //        storage_path('app/testfiles/valid.png'), 
    //        'valid.png',
    //        'png', 
    //        null,
    //        true 
    //    );
    //    $response = $this->post('/posts/uploadCSV', ['csvfile' => $file]);
    //    $response->assertSessionDoesntHaveErrors('csvfile');
    //    $this->assertGreaterThan(0, Posts::count());
    //}

    //    public function testUploadInvalidCSV()
//    {
//        Storage::fake('public');
//       // $file = UploadedFile::fake()->create('file.csv');
//          $file = new UploadedFile(
//            storage_path('app/testfiles/valid.csv'), 
//            'valid.csv',
//            'text/csv', 
//            null,
//            true 
//        );
//        $response = $this->post('/posts/uploadCSV', [
//            'csvfile' => $file,
//        ]);
//
//        $response->assertStatus(200); 
//        //$file = new UploadedFile(
//        //    storage_path('app/testfiles/invalid.txt'), 
//        //    'invalid.txt',
//        //    'text', 
//        //    null,
//        //    true 
//        //);
//        //$response = $this->post('/posts/uploadCSV', ['csvfile' => $file]);
//        //$response->assertSessionDoesntHaveErrors('csvfile');
//        //$this->assertGreaterThan(0, Posts::count());
//    }

    //public function can_upload_csv_file()
    //{
    //  
    //        Storage::fake('avatars');
    // 
    //        $file = UploadedFile::fake()->image('avatar.jpg');
    // 
    //        $response = $this->post('/avatar', [
    //            'avatar' => $file,
    //        ]);
    // 
    //        Storage::disk('avatars')->assertExists($file->hashName());
    //    
    //}


    public function testUploadValidCSV()
    {

        Storage::fake('public'); // Use fake storage for testing

        // Create a valid CSV file using File class
        $file = File::create('test.csv', 'Title 1,Title 2,Title 3', 'text/csv');

        // Simulate a POST request with the valid CSV file
        $response = $this->post('/uploadedpost', ['csvfile' => $file]);

        // Assert that no validation errors occurred
        $response->assertSessionDoesntHaveErrors('csvfile');

        // Assert that posts were created due to the valid CSV file
        $this->assertGreaterThan(0, Posts::count());

    }
    public function testUploadInvalidFileType()
    {
        Storage::fake('public'); // Use fake storage for testing

        // Create an invalid file type (e.g., PNG) using File class
        $file = File::create('test.png', '', 'image/png');

        // Simulate a POST request with the invalid file type
        $response = $this->post('/uploadedpost', ['csvfile' => $file]);

        // Assert that validation errors occurred
        $response->assertSessionHasErrors('csvfile');
    }

    // If you need database interactions
    
        /** @test */
    public function download()
    {
        // Create an instance of PostService
        $postService = new PostService();

        // Mock a Request object with necessary parameters
        $request = new Request([
            'pageSize' => 4,
            'search' => null,
        ]);

        $user = new User();
        $user->type = 'admin';
        // Call the download method
        $response = $postService->download($request);

        // Assertions
        $this->assertInstanceOf(StreamedResponse::class, $response);

        // Get the content of the streamed response
        ob_start();
        $response->sendContent();
        $downloadedContent = ob_get_clean();

        // Verify the content of the downloaded file
        $expectedHeader = "id,title,description,status,create_user_id,updated_user_id,deleted_user_id,deleted_at,created_at,updated_at\n";
        $expectedRow1 = "1,Title 1,Description 1,Active,1,1,,2023-07-22 12:00:00,2023-07-22 12:00:00,2023-07-22 12:00:00\n";
        // Adjust expected content based on your specific data

        $this->assertStringContainsString($expectedHeader, $downloadedContent);
        $this->assertStringContainsString($expectedRow1, $downloadedContent);

        // Optionally, assert headers if necessary
        $this->assertEquals('text/csv', $response->headers->get('Content-Type'));
        $this->assertStringContainsString('attachment; filename="posts.csv"', $response->headers->get('Content-Disposition'));

        // Clean up: Delete the generated file after test (if applicable)
        //$this->deleteGeneratedFile($response);
    }

    


}

