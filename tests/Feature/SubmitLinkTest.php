<?php

namespace Tests\Feature;

use App\Http\Clients\ApiClient;
use App\Http\Livewire\SubmitLink;
use App\Rules\UniqueLink;
use Livewire\Livewire;
use Tests\TestCase;

class SubmitLinkTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        ApiClient::fake();
        UniqueLink::fake();
    }

    /** @test */
    public function it_validates_website_input_is_required()
    {
        Livewire::test(SubmitLink::class)
            ->set([
                'website' => ''
            ])
            ->assertHasErrors(['website' => ['required']]);
    }

    /** @test */
    public function it_validates_website_input_is_an_active_and_unique()
    {
        Livewire::test(SubmitLink::class)
            ->set([
                'website' => 'http://www.gugal.come'
            ])
            ->assertHasErrors(['website' => ['active_url', UniqueLink::class]]);
    }

    /** @test */
    public function it_generates_a_cover_image_from_the_website()
    {
        Livewire::test(SubmitLink::class)
            ->set([
                'website' => 'http://www.google.com'
            ])
            ->call('generateCoverImage')
            ->assertNotSet('generatedPhoto', null);
    }
}
