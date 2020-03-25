<?php
namespace App\Excel;

use App\Project;
use App\Skill;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ImportExcel implements ToModel, WithStartRow, WithHeadingRow, WithValidation
{

    public function model(array $row)
    {
        $project = Project::create([
            'user_id' => Auth::id(),
            'title' => $row['title'],
            'description' => $row['description'],
            'organization' => $row['organization'],
            'start' => $row['start'],
            'end' => $row['end'],
            'type' => $row['type'],
        ]);

        $project->skill()->save(new Skill([
            'skills' => json_encode(explode('|', $row['skills']))
        ]));

        return $project;

    }

    public function rules(): array
    {
        return [
            'title' => 'required',
            'description' => 'required|max:2000',
            'start' => function ($attribute, $value, $onFailure) {
                if (isset($value)) return 'date_format:Y-m-d H:m:s';
            },
            'end' => function ($attribute, $value, $onFailure) {
                if (isset($value)) return 'sometimes|date_format:Y-m-d H:m:s|after_or_equal:start';
            },
            'type' => 'required',
            'skills' => 'required',
        ];
    }

    public function startRow(): int
    {
        return 2;
    }

}