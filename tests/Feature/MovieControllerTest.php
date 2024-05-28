<?php

use App\Services\Movies\MovieAggregator;
use Tests\TestCase;

class MovieControllerTest extends TestCase
{
    public function test_get_titles_success()
    {
        $this->mock(MovieAggregator::class, function ($mock) {
            $mock->shouldReceive('getAggregatedTitles')
                ->andReturn([
                    'Star Wars: Episode IV - A New Hope',
                    'The Devil and Miss Jones',
                    'The Kentucky Fried Movie',
                    'The Public Enemy',
                    'Dog Day Afternoon',
                    'Attack of the 50 Foot Woman',
                    'The Fish That Saved Pittsburgh',
                    'Army of Darkness',
                ]);
        });

        $response = $this->getJson('/api/titles');

        $response->assertStatus(200)
            ->assertJson([
                'Star Wars: Episode IV - A New Hope',
                'The Devil and Miss Jones',
                'The Kentucky Fried Movie',
                'The Public Enemy',
                'Dog Day Afternoon',
                'Attack of the 50 Foot Woman',
                'The Fish That Saved Pittsburgh',
                'Army of Darkness',
            ]);
    }

    public function test_get_titles_failure()
    {
        $this->mock(MovieAggregator::class, function ($mock) {
            $mock->shouldReceive('getAggregatedTitles')
                ->andThrow(new Exception('Service is unavailable after multiple attempts.'));
        });

        $response = $this->getJson('/api/titles');

        $response->assertStatus(500)
            ->assertJson([
                'status' => 'failure',
                'message' => 'Service is unavailable after multiple attempts.',
            ]);
    }
}
