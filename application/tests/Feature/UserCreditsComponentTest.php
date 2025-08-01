<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Livewire\Components\UserCredits;
use Livewire\Livewire;

class UserCreditsComponentTest extends TestCase
{
    public function test_user_credits_component_can_render()
    {
        $user = User::factory()->create([
            'credits' => 100,
            'knowledge_credits' => 2500,
        ]);

        $this->actingAs($user);

        Livewire::test(UserCredits::class)
            ->assertSee('100')
            ->assertSee('2,500');
    }

    public function test_user_credits_component_can_refresh()
    {
        $user = User::factory()->create([
            'credits' => 100,
            'knowledge_credits' => 2500,
        ]);

        $this->actingAs($user);

        $component = Livewire::test(UserCredits::class)
            ->assertSee('100')
            ->assertSee('2,500');

        // Update user credits
        $user->update([
            'credits' => 50,
            'knowledge_credits' => 2000,
        ]);

        // Dispatch the refresh event
        $component->dispatch('creditsUpdated')
            ->assertSee('50')
            ->assertSee('2,000');
    }
}