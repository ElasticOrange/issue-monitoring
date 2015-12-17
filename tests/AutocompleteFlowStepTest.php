<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Issue\StepAutocomplete;

class AutocompleteFlowStepTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    /** @test */
    public function check_list_view_for_created_stepautocomplete()
    {
        $stepAutocomplete = StepAutocomplete::create($this->stepAutocompleteData());

        $this->visit(action('StepAutocompleteController@index'))
            ->see($stepAutocomplete->name);

        $stepAutocomplete->delete();
    }

    /** @test */
    public function check_list_view_for_newly_created_stepautocomplete_then_deleted()
    {
        $step = StepAutocomplete::create($this->stepAutocompleteData());

        $stepCreated = StepAutocomplete::find($step->id);
        $this->visit(action('StepAutocompleteController@index'))
            ->see($step->name);

        $this->call('GET', action('StepAutocompleteController@destroy', [$stepCreated]), []);

        $this->dontSee($step->name);
    }
}
