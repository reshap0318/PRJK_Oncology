<?php

namespace App\Http\Requests\System;

use App\Models\System\ScheduleModel;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ScheduleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        $model      = new ScheduleModel();
        $commands   = config('value.schedule.available_command', []);

        return [
            'description'           => 'required|max:100',
            'command'               => ['required', Rule::in(array_keys($commands))],
            'expression'            => 'nullable|required_if:type,expression',
            'frequencies'           => 'required_if:type,frequency|array',
            'timezone'              => 'required',
            'notification_email'    => 'nullable|email',
            'notification_webhook'  => 'nullable|url',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'dont_overlap'          => $this->dont_overlap ?? 0,
            'run_in_maintenance'    => $this->run_in_maintenance ?? 0,
            'run_in_background'     => $this->run_in_background ?? 0,
            'is_active'             => $this->is_active ?? 0
        ]);
    }
}
