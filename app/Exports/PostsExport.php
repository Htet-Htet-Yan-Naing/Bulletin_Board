<?php

namespace App\Exports;

use App\Models\Posts;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PostsExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Posts::all();
    }
    public function headings(): array
    {
        return [
            'ID',
            'Title',
            'description',
            'status',
            'created_user_id',
            'updated_user_id',
            'deleted_user_id',
            'deleted_at',
            'created_at',
            'updated_at'
        ];
    }
}
