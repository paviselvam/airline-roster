<?php
namespace App\Services;


use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Imports\RosterImport;

class RosterService
{
    public function parse($fileContent)
    {
        $lines = explode("\n", $fileContent);
        foreach ($lines as $line) {
            if (preg_match('/^(DO|SBY|FLT|CI|CO|UNK)(\d*)\s+(\d{2}:\d{2}Z)\s+(\d{2}:\d{2}Z)\s+(.*)\s+(.*)$/', $line, $matches)) {
                Event::create([
                    'type' => $matches[1],
                    'flight_number' => $matches[2] ?? null,
                    'start_time' => Carbon::createFromFormat('H:i\Z', $matches[3])->toDateTimeString(),
                    'end_time' => Carbon::createFromFormat('H:i\Z', $matches[4])->toDateTimeString(),
                    'start_location' => $matches[5] ?? null,
                    'end_location' => $matches[6] ?? null,
                ]);
            }
        }
    }

    public function parseExcelRoster($file)
    {
        Excel::import(new RosterImport, $file);
    }

    public function parsePdfRoster($file)
    {
        $content = (new \Spatie\PdfToText\Pdf())->setPdf($file->getRealPath())->text();
        return $this->parse($content);
    }
}



