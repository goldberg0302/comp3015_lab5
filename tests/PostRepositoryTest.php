<?php

require_once __DIR__ . '/../src/Repositories/PostRepository.php';
require_once __DIR__ . '/../src/Models/Post.php';
require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;

use src\Repositories\PostRepository;

class PostRepositoryTest extends TestCase {

	private PostRepository $postRepository;

	/**
	 * Runs before each test
	 */
	protected function setUp(): void {
		parent::setUp();
		$this->postRepository = new PostRepository();
		$this->postRepository->beginDbTransaction();
	}

	/**
	 * Runs after each test
	 */
	protected function tearDown(): void {
		parent::tearDown();
		$this->postRepository->rollBackTransaction();
	}

	public function testPostCreation() {
		$post = $this->postRepository->savePost('test', 'body');
		$this->assertEquals('test', $post->title);
		$this->assertEquals('body', $post->body);
	}

	public function testPostRetrieval() {
		// TODO test the "get" methods in the PostRepository class
		$post = $this->postRepository->savePost('test', 'body');
		$id = $post->id;

		// Assert that the retreival is successful
		$retrievedPost = $this->postRepository->getPostById($id);
		$this->assertEquals('test', $retrievedPost->title);
		$this->assertEquals('body', $retrievedPost->body);
	}

	public function testPostUpdate() {
		// TODO create a post, update the title and body, and check that you get the expected title and body
		$post = $this->postRepository->savePost('test', 'body');
		$id = $post->id;

		// Assert that the update is successful
		$updated = $this->postRepository->updatePost($id, 'new title', 'new body');
		$this->assertTrue($updated);

		// Assert the attributes of the updated post
		$retrievedPost = $this->postRepository->getPostById($id);
		$this->assertEquals('new title', $retrievedPost->title);
		$this->assertEquals('new body', $retrievedPost->body);
	}

	public function testPostDeletion() {
		// TODO: delete a post by ID and check that it isn't in the database anymore
		$post = $this->postRepository->savePost('test', 'body');
		$id = $post->id;

		// Assert that the deletion is successful
		$deleted = $this->postRepository->deletePostById($id);
		$this->assertTrue($deleted);
		
		// Assert that the retreival is failed (because the post does not exist)
		$retrievedPost = $this->postRepository->getPostById($id);
		$this->assertFalse($retrievedPost);
	}
}
