<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Rspafs\Models\Blog;

class BlogTest extends TestCase
{
    const CREATE_BLOG = 'create a blog';
    const UPDATE_BLOG = 'update a blog';
    const BLOG_CONTENT = 'blog content';
    const IS_RELEASED = 1;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testBlogIndex()
    {
        $this->call('get', route('blogs.index'))
             ->assertStatus(Response::HTTP_OK);
    }

    public function testBlogShow()
    {
        $blogId = Blog::first()->_id;
        $this->call('get', '/blogs/show/' . $blogId)
             ->assertStatus(Response::HTTP_OK)
             ->assertJsonStructure([ 'name', 'desc', 'is_released', 'user_id', 'created_at', 'updated_at']);
    }

    /**
     * Test create task.
     *
     * @return void
     */
    public function testCreateBlog()
    {
        $user = $this->loginAsUser();

        $this->call('POST', route('blogs.store'), [
            'name' => self::CREATE_BLOG,
            'desc' => self::BLOG_CONTENT
        ])  ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([ 'name', 'desc', 'is_released', 'user_id', 'created_at', 'updated_at']);
    }

    /**
     * It is used to test when create a blog, the name is empty.
     *
     * @return void
     */
    public function testCreateBlogFail()
    {
        $user = $this->loginAsUser();

        $this->postJson(route('blogs.store'), [
            'desc' => '',
            'name' => ''
        ])  ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors('name')
            ->assertJsonValidationErrors('desc');
    }

    public function testUpdateBlog()
    {
        $user = $this->loginAsUser();

        $blog = $user->blogs()->create([
            'name' => self::CREATE_BLOG,
            'desc' => self::BLOG_CONTENT,
            'user_id' => $user->id,
            'is_released' => self::IS_RELEASED
        ]);

        $this->call('PUT', '/blogs/update/' . $blog->_id , [
            'name' => self::UPDATE_BLOG,
            'desc' => self::BLOG_CONTENT
        ])  ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([ 'name', 'desc', 'is_released', 'user_id', 'created_at', 'updated_at']);

        $this->assertDatabaseHas('logs', [
            'user_id'  => $user->id,
            'desc' => 'Blog ' . $blog->_id . ' is updated by user ' . $user->id,
        ]);
    }

    /**
     * It is used to test when update a blog, the name is empty.
     *
     * @return void
     */
    public function testUpdateBlogFail()
    {
        $user = $this->loginAsUser();

        $blog = $user->blogs()->create([
            'name' => self::CREATE_BLOG,
            'desc' => self::BLOG_CONTENT,
            'user_id' => $user->id,
            'is_released' => self::IS_RELEASED
        ]);

        $this->putJson('/blogs/update/' . $blog->_id, [
            'desc' => '',
            'name' => ''
        ])  ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors('name')
            ->assertJsonValidationErrors('desc');
    }

    public function testDeleteBlog()
    {
        $user = $this->loginAsUser();
        $blog = $user->blogs()->create([
            'name' => self::CREATE_BLOG,
            'desc' => self::BLOG_CONTENT,
            'user_id' => $user->id,
            'is_released' => self::IS_RELEASED
        ]);

        $this->delete('/blogs/delete/' . $blog->_id)
             ->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseHas('logs', [
            'user_id'  => $user->id,
            'desc' => 'Blog ' . $blog->_id . ' is deleted by user ' . $user->id,
        ]);
    }
}
