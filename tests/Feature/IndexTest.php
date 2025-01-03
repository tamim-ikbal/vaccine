<?php

use App\Models\Enroll;
use App\Models\VaccineCenter;

it('can see home page', function () {
    $vaccineCenter = VaccineCenter::factory()->create();
    $enroll = Enroll::factory()->create();

    $response = $this->get(route('home'));

    $response->assertInertia(fn ($page) => $page->component('Index'));
});
