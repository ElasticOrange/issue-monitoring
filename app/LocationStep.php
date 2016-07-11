<?php

namespace Issue;

use Illuminate\Database\Eloquent\Model;

class LocationStep extends Model
{
    protected $guarded = ['id'];

    protected $with = ['issue'];

    protected $fillable = [
        'location_id',
        'issue_id',
        'step_order',
        'nr_inregistrare'
    ];

    public function issue()
    {
        return $this->belongsTo('Issue\Issue');
    }

    public function location()
    {
        return $this->belongsTo('Issue\Location');
    }

    public function flowsteps()
    {
        return $this->hasMany('Issue\FlowStep')->orderBy('flowstep_order', 'asc');
    }

    public function flowTemplate()
    {
        return $this->belongsTo('Issue\FlowTemplate', 'flow_template_id');
    }

    public function syncSteps($steps)
    {
        $currentSteps = $this->flowsteps()->get();

        if (! is_array($steps)) {
            $steps = [];
        }

        $index = 0;

        foreach ($steps as $id => $step) {
            $index++;
            $steps[$id]['flowstep_order'] = $index;
        }

        foreach ($currentSteps as $currentStep) {
            if (!array_key_exists($currentStep->id, $steps)) {
                $currentStep->delete();
                continue;
            }

            if (! array_key_exists('finalizat', $steps[$currentStep->id])) {
                $steps[$currentStep->id]['finalizat'] = 0;
            }

            $currentStep->fill($steps[$currentStep->id]);

            if (array_key_exists('observatii', $steps[$currentStep->id])) {
                foreach (\Config::get('app.all_locales') as $locale) {
                    $currentStep->translateOrNew($locale)->observatii = $steps[$currentStep->id]['observatii'][$locale];
                }
            }

            if (! array_key_exists('start_date', $stepData)) {
                $stepData['start_date'] = null;
            }

            if (array_key_exists('estimated_duration', $steps[$currentStep->id])) {
                if ($steps[$currentStep->id]['estimated_duration'] == '') {
//                    $currentStep->start_date = null;
                    $currentStep->end_date = null;
                    $currentStep->estimated_duration = null;
                }
                if ($steps[$currentStep->id]['end_date'] == '') {
                    $currentStep->end_date = null;
                }
                if ($steps[$currentStep->id]['start_date'] == '') {
                    $currentStep->start_date = null;
                }
//                elseif ($steps[$currentStep->id]['estimated_duration'] == '0') {
//                    $currentStep->end_date = null;
//                    $currentStep->estimated_duration = null;
//                }
            }

            $this->flowsteps()->save($currentStep);

            if (array_key_exists('addToLegalNews', $steps[$currentStep->id])) {
                if ($steps[$currentStep->id]['addToLegalNews'] == true) {
                    $legalNews = new LegalNews;

                    foreach (\Config::get('app.all_locales') as $locale) {
                        $legalNews->translateOrNew($locale)->title = $currentStep->flowstepsInLocation->issue->getAttribute('name:'.$locale);
                        $legalNews->translateOrNew($locale)->content = $currentStep->getAttribute('observatii:'.$locale);
                    }

                    $legalNews->issue_id = $currentStep->flowstepsInLocation->issue_id;
                    $legalNews->save();
                }
            }

            if (array_key_exists('published', $steps[$currentStep->id])) {
                if ($steps[$currentStep->id]['published'] == true
                    && Alert::getUnsentAlert($currentStep, 'Issue\FlowStep') == null) {
                    Alert::createAlert($currentStep, 'Issue\FlowStep');
                }
            } else {
                Alert::deleteUnsentAlert($currentStep, 'Issue\FlowStep');
            }

            if (!array_key_exists('document_id', $steps[$currentStep->id])) {
                $steps[$currentStep->id]['document_id'] = [];
            }
            $currentStep->syncStepDocuments($steps[$currentStep->id]['document_id']);

            unset($steps[$currentStep->id]);
        }

        foreach ($steps as $stepData) {
            $newFlowStep = new FlowStep;
            $newFlowStep->fill($stepData);

            if (array_key_exists('observatii', $stepData)) {
                foreach (\Config::get('app.all_locales') as $locale) {
                    $newFlowStep->translateOrNew($locale)->observatii = $stepData['observatii'][$locale];
                }
            }

            if (! array_key_exists('finalizat', $stepData)) {
                $stepData['finalizat'] = 0;
            }

            if (! array_key_exists('start_date', $stepData)) {
                $stepData['start_date'] = null;
            }

            if (array_key_exists('estimated_duration', $stepData)) {
                if ($stepData['estimated_duration'] == '') {
//                    $newFlowStep->start_date = null;
                    $newFlowStep->end_date = null;
                    $newFlowStep->estimated_duration = null;
//                } elseif ($stepData['estimated_duration'] == '0') {
//                    $newFlowStep->end_date = null;
//                    $newFlowStep->estimated_duration = null;
                }
            }

            $this->flowsteps()->save($newFlowStep);

            if (array_key_exists('addToLegalNews', $stepData)) {
                if ($stepData['addToLegalNews'] == true) {
                    $legalNews = new LegalNews;

                    foreach (\Config::get('app.all_locales') as $locale) {
                        $legalNews->translateOrNew($locale)->title = $newFlowStep->flowstepsInLocation->issue->getAttribute('name:'.$locale);
                        $legalNews->translateOrNew($locale)->content = $newFlowStep->getAttribute('observatii:'.$locale);
                    }

                    $legalNews->issue_id = $newFlowStep->flowstepsInLocation->issue_id;
                    $legalNews->save();
                }
            }

            if (array_key_exists('published', $stepData)) {
                if ($stepData['published'] == true) {
                    Alert::createAlert($newFlowStep, 'Issue\FlowStep');
                }
            }

            if (!array_key_exists('document_id', $stepData)) {
                $stepData['document_id'] = [];
            }
            $newFlowStep->syncStepDocuments($stepData['document_id']);
        }

        return true;
    }
}
