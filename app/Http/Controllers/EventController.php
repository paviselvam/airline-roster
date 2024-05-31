<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Services\RosterService;
use Carbon\Carbon;

class EventController extends Controller
{
    protected $parser;

    public function __construct(RosterService $parser)
    {
        $this->parser = $parser;
    }

    public function index(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        return Event::whereBetween('start_time', [$startDate, $endDate])->get();
    }

    public function flightsNextWeek()
    {
        $startDate = Carbon::parse('2022-01-14');
        $endDate = $startDate->copy()->addWeek();

        return Event::where('type', 'FLT')
            ->whereBetween('start_time', [$startDate, $endDate])
            ->get();
    }

    public function standbyNextWeek()
    {
        $startDate = Carbon::parse('2022-01-14');
        $endDate = $startDate->copy()->addWeek();

        return Event::where('type', 'SBY')
            ->whereBetween('start_time', [$startDate, $endDate])
            ->get();
    }

    public function flightsByLocation(Request $request)
    {
        $location = $request->query('location');

        return Event::where('type', 'FLT')
            ->where('start_location', $location)
            ->get();
    }

    public function upload(Request $request)
    {
        // Validate the request to ensure a file is uploaded
        $request->validate([
            'roster' => 'required|file|mimes:txt,xlsx,pdf',
        ]);

        // Retrieve the uploaded file
        $file = $request->file('roster');
        $extension = $file->getClientOriginalExtension();

        // Parse the content based on file type
        switch ($extension) {
            case 'txt':
                $content = file_get_contents($file);
                $this->parser->parse($content);
                break;
            case 'xlsx':
                $this->parser->parseExcelRoster($file);
                break;
            case 'pdf':
                $this->parser->parsePdfRoster($file);
                break;
        }

        // Return a response
        return response()->json(['message' => 'Roster uploaded and processed successfully']);
    }

}



