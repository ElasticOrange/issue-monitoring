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
    public function testCreateFlowTemplate_Returns_Model()
    {
        $flowTemplate = FlowTemplate::create($this->flowTemplateData());

        $flowTemplateCreated = FlowTemplate::find($flowTemplate->id);

        $this->assertNotNull($flowTemplate);
        $this->assertEquals($flowTemplateCreated->name, $flowTemplate->name);

        $flowTemplate->delete();
    }

    public function testCreateFlowTemplate_WithLocationStep_Attached()
    {
        $flowTemplate = FlowTemplate::create($this->flowTemplateData());

        $locationStep = LocationStep::create($this->locationStepData());

        $flowTemplate->locationSteps()->save($locationStep);

        $flowTemplateCreated = FlowTemplate::find($flowTemplate->id);

        $this->assertEquals(1, count($flowTemplateCreated->locationSteps));
    }
}
