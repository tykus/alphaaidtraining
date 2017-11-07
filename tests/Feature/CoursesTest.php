<?php

namespace Tests\Feature;

use App\User;
use App\Course;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CoursesTest extends TestCase
{
    use RefreshDatabase;

    function setUp()
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

    /** @test */
    function can_view_a_list_of_courses_available()
    {
        $courses = factory(Course::class, 3)->create();

        $response = $this->getJson(route('courses.index'));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'courses' => [
                ['title', 'description']
            ]
        ]);
    }

    /** @test */
    function can_view_an_individual_course()
    {
        $course = factory(Course::class)->create();

        $response = $this->getJson(route('courses.show', $course->id));

        $response->assertStatus(200);
        $response->assertJsonStructure(['title', 'description']);
        $response->assertExactJson([
            'title' => $course->title,
            'description' => $course->description
        ]);
    }

    /** @test */
    function guests_cannot_create_courses()
    {
        $response = $this->postJson(route('courses.store'), $this->validParams([
            'title' => 'New First Aid Course',
            'description' => 'Lorem ipsum'
        ]));

        $response->assertStatus(401);   
    }

    /** @test */
    function can_add_a_new_course()
    {
        $response = $this->actingAs($this->user)->postJson(route('courses.store'), $this->validParams([
            'title' => 'New First Aid Course',
            'description' => 'Lorem ipsum'
        ]));

        $response->assertStatus(201);
        $response->assertJsonStructure(['title', 'description']);
        $response->assertExactJson([
            'title' => 'New First Aid Course',
            'description' => 'Lorem ipsum'
        ]);
    }

    /** @test */
    function cannot_add_new_course_without_a_title()
    {
        $response = $this->actingAs($this->user)->postJson(
            route('courses.store'),
            $this->validParams(['title' => ''])
        );

        $response->assertStatus(422);
    }

    /** @test */
    function cannot_add_course_if_title_is_less_than_five_characters()
    {
        $response = $this->actingAs($this->user)->postJson(
            route('courses.store'),
            $this->validParams(['title' => 'aaaa'])
        );

        $response->assertStatus(422);
    }

    /** @test */
    function cannot_add_course_if_title_is_not_unique()
    {
        $existingCourse = factory(Course::class)->create(['title' => 'First Aid Course']);

        $response = $this->actingAs($this->user)->postJson(
            route('courses.store'),
            $this->validParams(['title' => 'First Aid Course'])
        );

        $response->assertStatus(422);
    }

    /** @test */
    function cannot_add_new_course_without_a_description()
    {
        $response = $this->actingAs($this->user)->postJson(
            route('courses.store'),
            $this->validParams(['description' => ''])
        );

        $response->assertStatus(422);
    }

    /** @test */
    function guests_cannot_update_a_course()
    {
        $course = factory(Course::class)->create();

        $response = $this->patchJson(route('courses.update', $course->id), []);

        $response->assertStatus(401);
    }

    /** @test */
    function can_update_a_course()
    {
        $course = factory(Course::class)->create(['title' => 'First Aid Course']);

        $response = $this->actingAs($this->user)
            ->patchJson(route('courses.update', $course->id), ['title' => 'Another First Aid Course']);

        $response->assertStatus(200);
        $response->assertJsonStructure(['title', 'description']);
        $response->assertJson(['title' => 'Another First Aid Course']);
    }

    /** @test */
    function cannot_update_course_without_a_title()
    {
        $course = factory(Course::class)->create();

        $response = $this->actingAs($this->user)
            ->patchJson(route('courses.update', $course->id), ['title' => '']);

        $response->assertStatus(422);
    }

    /** @test */
    function cannot_update_course_if_title_is_not_unique()
    {
        $course = factory(Course::class)->create(['title' => 'First Aid Course']);
        $otherCourse = factory(Course::class)->create(['title' => 'Other First Aid Course']);

        $response = $this->actingAs($this->user)
            ->patchJson(route('courses.update', $course->id), ['title' => 'Other First Aid Course']);

        $response->assertStatus(422);
    }

    /** @test */
    function cannot_update_course_if_title_is_less_than_five_characters()
    {
        $course = factory(Course::class)->create();

        $response = $this->actingAs($this->user)
            ->patchJson(route('courses.update', $course->id), ['title' => 'aaaa']);

        $response->assertStatus(422);
    }

    /** @test */
    function cannot_update_course_without_a_description()
    {
        $course = factory(Course::class)->create();

        $response = $this->actingAs($this->user)
            ->patchJson(route('courses.update', $course->id), ['description' => '']);

        $response->assertStatus(422);
    }

    /** @test */
    function guests_cannot_delete_a_course()
    {
        $course = factory(Course::class)->create();

        $response = $this->deleteJson(route('courses.destroy', $course->id));

        $response->assertStatus(401);
    }

    /** @test */
    function can_be_delete_a_course()
    {
        $course = factory(Course::class)->create();

        $response = $this->actingAs($this->user)->deleteJson(route('courses.destroy', $course->id));

        $response->assertStatus(204);
        $this->assertSoftDeleted('courses', ['id' => $course->id]);
    }

    /**
     * Valid parameters for a course resource
     * @param array $overrides
     * @return array
     */
    private function validParams($overrides = [])
    {
        return factory(Course::class)->make($overrides)->toArray();
    }
}
