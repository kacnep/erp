<?php
namespace App\Excel;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExampleExcel implements FromCollection
{
    use Exportable;

    public function collection()
    {
        $data = collect();
        $data->push([
            'Title',
            'Description',
            'Organization',
            'Start',
            'End',
            'Type',
            'Skills',
        ], [
            'Example Title',
            'Example Description',
            'Example Organization',
            Carbon::yesterday()->format('Y-m-d H:m:s'),
            Carbon::tomorrow()->format('Y-m-d H:m:s'),
            'Example Type',
            'Example Skill 1|Example Skill 1|Example Skill 1',
        ]);

        return $data;
    }
}