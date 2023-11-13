<?php

namespace App\Rules;

use App\Models\Commission;
use Illuminate\Contracts\Validation\Rule;

class ValidateRowRanges implements Rule
{
    public function passes($attribute, $value)
    {
        $data = request()->all();
        $from = $data['from'];
        $to = $data['to'];

        if ($from >= $to) {
            return false; // Invalid range
        }

        // Fetch existing rows from the database
        $existingRows = Commission::where('id', '!=', request()->route('commission')->id)->get();

        foreach ($existingRows as $row) {
            if ($from >= $row->from && $from <= $row->to) {
                return false; // Invalid range
            }
            if ($to >= $row->from && $to <= $row->to) {
                return false; // Invalid range
            }
        }

        return true; // Valid range
    }

    public function message()
    {
        return 'Invalid range overlap with existing rows.';
    }
}
