<?
// tests/Feature/SportsCarTest.php

namespace Tests\Feature;

use App\Models\SportsCar;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SportsCarTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_all_sports_cars()
    {
        // Arrange: Create some sports cars
        SportsCar::factory()->count(3)->create();

        // Act: Request the index route
        $response = $this->get(route('sportscars.index'));

        // Assert: Check if the response is successful and contains expected content
        $response->assertStatus(200);
        $response->assertViewIs('sportscars.index');
        $response->assertSeeText('Sports Cars');
    }

    /** @test */
    public function it_can_create_a_new_sports_car()
    {
        // Arrange: Prepare the data for a new sports car
        $carData = [
            'make' => 'Ferrari',
            'model' => '488 GTB',
            'year' => 2022,
            'price' => 250000,
        ];

        // Act: Submit the data to the store route
        $response = $this->post(route('sportscars.store'), $carData);

        // Assert: Check if the car is in the database and redirect to the index
        $this->assertDatabaseHas('sports_cars', $carData);
        $response->assertRedirect(route('sportscars.index'));
    }

    /** @test */
    public function it_can_show_a_single_sports_car()
    {
        // Arrange: Create a sports car
        $car = SportsCar::factory()->create();

        // Act: Request the show route for the specific car
        $response = $this->get(route('sportscars.show', $car->id));

        // Assert: Check if the response shows the car details
        $response->assertStatus(200);
        $response->assertViewIs('sportscars.show');
        $response->assertSeeText($car->make);
        $response->assertSeeText($car->model);
    }

    /** @test */
    public function it_can_update_a_sports_car()
    {
        // Arrange: Create a sports car
        $car = SportsCar::factory()->create();

        // New data for update
        $updatedData = [
            'make' => 'Lamborghini',
            'model' => 'Aventador',
            'year' => 2023,
            'price' => 300000,
        ];

        // Act: Submit the updated data to the update route
        $response = $this->put(route('sportscars.update', $car->id), $updatedData);

        // Assert: Check if the car is updated in the database
        $this->assertDatabaseHas('sports_cars', $updatedData);
        $response->assertRedirect(route('sportscars.index'));
    }

    /** @test */
    public function it_can_delete_a_sports_car()
    {
        // Arrange: Create a sports car
        $car = SportsCar::factory()->create();

        // Act: Send a delete request to the destroy route
        $response = $this->delete(route('sportscars.destroy', $car->id));

        // Assert: Check if the car is removed from the database
        $this->assertDatabaseMissing('sports_cars', ['id' => $car->id]);
        $response->assertRedirect(route('sportscars.index'));
    }
}
