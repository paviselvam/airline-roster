<?php

namespace App\Imports;

use App\Models\Event;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class RosterImport implements ToModel, WithHeadingRow, WithStartRow
{
    public function startRow(): int
    {
        return 2; // If your headings are on the first row
    }

    public function model(array $row)
    {
        try {
            $startTime = Carbon::createFromFormat('H:i\Z', $row['start_time']);
            $endTime = Carbon::createFromFormat('H:i\Z', $row['end_time']);
        } catch (\Exception $e) {
            // Handle the exception or log it for debugging
            // Here we log the issue and skip the row for now
            \Log::error("Invalid time format in row: " . json_encode($row) . " Error: " . $e->getMessage());
            return null; // Skip this row
        }

        return new Event([
            'type' => $row['type'],
            'flight_number' => $row['flight_number'],
            'start_time' => $startTime->toDateTimeString(),
            'end_time' => $endTime->toDateTimeString(),
            'start_location' => $row['start_location'],
            'end_location' => $row['end_location'],
        ]);
    }
}


