<?php

namespace Tests\Feature\Repositories;

use App\Repositories\ShareRepository;
use App\Share;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Collection;
use Tests\TestCase;

/**
 * Class ShareRepositoryTest
 * @package Tests\Feature\Repositories
 * @covers ShareRepository
 */
class ShareRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    protected $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = new ShareRepository(new Share());
    }

    /** @test */
    function it_should_create_a_new_share_in_the_storage()
    {
        $share = $this->repository->create(
            factory(Share::class)->make()->toArray()
        );

        $this->assertDatabaseHas('shares', [
            'id' => $share->id
        ]);
    }

    /** @test */
    function it_should_find_an_share_by_its_id()
    {
        $share = factory(Share::class)->create();

        $result = $this->repository->find($share->id);

        $this->assertEquals($share->toArray(), $result->toArray());
    }

    /** @test */
    function it_should_return_all_the_shares()
    {
        $share = factory(Share::class)->create();

        $results = $this->repository->all();

        $this->assertInstanceOf(Collection::class, $results);
        $this->assertEquals($share->toArray(), $results->first()->toArray());
    }
}
