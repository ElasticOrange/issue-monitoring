<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Issue\FlowTemplate;
use Issue\LocationStep;

class FlowTemplateModelTest extends TestCase
{
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
}
