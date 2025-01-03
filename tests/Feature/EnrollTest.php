<?php

use App\Models\Enroll;
use App\Models\VaccineCenter;

it('can see vaccine enroll page', function () {
    $response = $this->get(route('enroll.index'));

    $response->assertStatus(200);
});

it('can enroll for vaccines!', function () {

    //Arrange
    $vaccineCenter = VaccineCenter::factory()->create();
    $enroll = Enroll::factory()->make([
        'vaccine_center_id' => $vaccineCenter->id,
    ]);

    \App\Services\VerificationService::setVerified($enroll->nid, 'email');

    $response = $this->post(route('enroll.store'), $enroll->toArray());

    //Assert
    $response->assertRedirect(route('home'));

    $this->assertDatabaseHas('enrolls', [
        'name'              => $enroll->name,
        'vaccine_center_id' => $vaccineCenter->id,
        'nid'               => $enroll->nid,
        'email'             => $enroll->email,
        'phone'             => $enroll->phone,
    ]);

    $this->assertDatabaseCount('enrolls', 1);

});

it('can check enroll status', function () {
    //Arrange
    $vaccineCenter = VaccineCenter::factory()->create();
    $enroll = Enroll::factory()->create([
        'vaccine_center_id' => $vaccineCenter->id,
    ]);

    $response = $this->post(route('api.v1.enrolls.status'), $enroll->toArray());

    $response->assertStatus(200);

    $this->assertDatabaseCount('enrolls', 1);

    $response->assertJsonStructure([
        'payload' => [
            'name',
            'email',
            'nid',
            'phone',
            'status',
            'schedule_at'
        ]
    ]);

});
