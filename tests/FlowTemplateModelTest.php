<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Issue\FlowTemplate;
use Issue\LocationStep;

class FlowTemplateModelTest extends TestCase
{
    use WithoutMiddleware;
    /**
     * A basic test example.
     *
     * @return void
     */
    /** @test */
    public function createFlowTemplate_Returns_Model()
    {
        $flowTemplate = FlowTemplate::create($this->flowTemplateData());

        $flowTemplateCreated = FlowTemplate::find($flowTemplate->id);

        $this->assertNotNull($flowTemplate);
        $this->assertEquals($flowTemplateCreated->name, $flowTemplate->name);

        $flowTemplate->delete();
    }

    /** @test */
    public function createFlowTemplate_WithLocationStep_Attached()
    {
        $flowTemplate = FlowTemplate::create($this->flowTemplateData());
        $locationStep = LocationStep::create($this->locationStepData());

        $flowTemplate->locationStep()->save($locationStep);

        $flowTemplateCreated = FlowTemplate::find($flowTemplate->id);

        $this->assertCount(1, $flowTemplateCreated->locationStep);

        $flowTemplate->delete();
        $locationStep->delete();
    }

    /** @test */
    public function createFlowTemplate_WithLocationStepAttached_ThenDeleted()
    {
        $flowTemplate = FlowTemplate::create($this->flowTemplateData());
        $locationStep = LocationStep::create($this->locationStepData());

        $flowTemplate->locationStep()->save($locationStep);
        $locationStep->delete();

        $flowTemplateCreated = FlowTemplate::find($flowTemplate->id);
        $this->assertCount(0, $flowTemplateCreated->locationStep);

        $flowTemplate->delete();
    }

    /** @test */
    public function createFlowTemplate_WithMultipleLocationStep_Attached()
    {
        $flowTemplate = FlowTemplate::create($this->flowTemplateData());

        $locationStep1 = LocationStep::create($this->locationStepData());
        $locationStep2 = LocationStep::create($this->locationStepData());
        $locationStep3 = LocationStep::create($this->locationStepData());
        $locationStep4 = LocationStep::create($this->locationStepData());

        $flowTemplate->locationStep()->save($locationStep1);
        $flowTemplate->locationStep()->save($locationStep2);
        $flowTemplate->locationStep()->save($locationStep3);
        $flowTemplate->locationStep()->save($locationStep4);

        $flowTemplateCreated = FlowTemplate::find($flowTemplate->id);

        $this->assertCount(4, $flowTemplateCreated->locationStep);

        $locationStep1->delete();
        $locationStep2->delete();
        $locationStep3->delete();
        $locationStep4->delete();
        $flowTemplate->delete();
    }

    /** @test */
    public function createFlowTemplate_WithMultipleLocationStepAttached_DeleteOneLocationStep()
    {
        $flowTemplate = FlowTemplate::create($this->flowTemplateData());

        $locationStep1 = LocationStep::create($this->locationStepData());
        $locationStep2 = LocationStep::create($this->locationStepData());
        $locationStep3 = LocationStep::create($this->locationStepData());
        $locationStep4 = LocationStep::create($this->locationStepData());

        $flowTemplate->locationStep()->save($locationStep1);
        $flowTemplate->locationStep()->save($locationStep2);
        $flowTemplate->locationStep()->save($locationStep3);
        $flowTemplate->locationStep()->save($locationStep4);

        $locationStep3->delete();
        $locationStep1->delete();

        $flowTemplateCreated = FlowTemplate::find($flowTemplate->id);

        $this->assertCount(2, $flowTemplateCreated->locationStep);

        $locationStep2->delete();
        $locationStep4->delete();
        $flowTemplate->delete();

    }

    /** @test */
    public function createFlowTemplate_WithMultipleLocationStepAttached_DeleteAllLocationStep()
    {
        $flowTemplate = FlowTemplate::create($this->flowTemplateData());

        $locationStep1 = LocationStep::create($this->locationStepData());
        $locationStep2 = LocationStep::create($this->locationStepData());
        $locationStep3 = LocationStep::create($this->locationStepData());
        $locationStep4 = LocationStep::create($this->locationStepData());

        $flowTemplate->locationStep()->save($locationStep1);
        $flowTemplate->locationStep()->save($locationStep2);
        $flowTemplate->locationStep()->save($locationStep3);
        $flowTemplate->locationStep()->save($locationStep4);

        $locationStep1->delete();
        $locationStep2->delete();
        $locationStep3->delete();
        $locationStep4->delete();

        $flowTemplateCreated = FlowTemplate::find($flowTemplate->id);

        $this->assertCount(0, $flowTemplateCreated->locationStep);

        $flowTemplate->delete();

    }

    /** @test */
    public function createFlowTemplate_CheckListView_ForFlowTemplateName()
    {
        $flowTemplate = FlowTemplate::create($this->flowTemplateData());

        $flowTemplateCreated = FlowTemplate::find($flowTemplate->id);

        $this->visit('/backend/flowtemplate')
            ->see($flowTemplateCreated->name);

        $flowTemplate->delete();
    }

    /** @test */
    public function createFlowTemplate_CheckListView_DeleteFlowTemplateName()
    {
        $flowTemplate = FlowTemplate::create($this->flowTemplateData());

        $flowTemplateCreated = FlowTemplate::find($flowTemplate->id);

        $this->visit('/backend/flowtemplate')
            ->see($flowTemplateCreated->name);

        $flowTemplate->delete();

        $this->visit('/backend/flowtemplate/')
            ->dontSee($flowTemplateCreated->name);
    }

    /** @test */
    public function create_a_flow_template_with_post_and_check_list_view_if_exists()
    {

        $params = [
            '_token' => csrf_token(),
            'name' => $this->faker->name
        ];

        $this->call('POST', action('FlowTemplateController@store'), $params);

        $this->assertResponseOk();

        $this->visit('/backend/flowtemplate')
            ->see($params['name']);
    }

    /** @test */
    public function create_a_complex_flowtemplate_with_locationsteps_and_flowsteps()
    {
        $params = [
            '_token' => csrf_token(),
            'name' => $this->faker->name,
            'location' => [
                'new-1' => [
                    'name' => 'Guvern',
                    'location_id' => 2,
                    'nr_inregistrare' => $this->faker->text,
                    'flow_steps' => [
                        'new-2'=> [
                            'flow_name' => "pas 1",
                            'estimated_duration' => "",
                            'start_date' => "2015-12-17",
                            'end_date' => "2015-12-17",
                            'location_step_id' => "",
                            'observatii' => [
                                'ro' => "",
                                'en' => ""
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $this->call('POST', action('FlowTemplateController@store'), $params);


        $this->assertResponseOk();

        $deleteLineFromDb = FlowTemplate::where('name', $params['name'])->first();
        $deleteLineFromDb->delete();
    }

    /** @test */
    public function create_a_complex_flowtemplate_with_locationsteps_and_flowsteps_and_edit()
    {
        $params = [
            '_token' => csrf_token(),
            'name' => $this->faker->name,
        ];

        $this->call('POST', action('FlowTemplateController@store'), $params);
        $deleteLineFromDb = FlowTemplate::where('name', $params['name'])->first();

        $this->call('POST',
            'backend/flowtemplate/'.$deleteLineFromDb->id,
            [
                '_method' => 'PUT',
                '_token' => csrf_token(),
                'name' => 'Mihai'
            ]
        );

        $newName = FlowTemplate::find($deleteLineFromDb->id);

        $this->assertResponseOk();
        $this->assertNotEquals($params['name'], $newName->name);

        $deleteLineFromDb->delete();
    }
}
