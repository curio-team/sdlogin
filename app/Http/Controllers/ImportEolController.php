<?php

namespace App\Http\Controllers;

use App\Imports\EolUsersImport;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

define("VNAAM", 0);
define("TV", 2);
define("ANAAM", 3);
define("CODE", 4);
define("GROEP", 5);

class ImportEolController extends Controller
{
    public $duplicates = 0;

    public $updated = 0;

    public $imports = 0;

    public $attached = 0;

    public function show()
    {
        return view('users.import_eol');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xls,xlsx'
        ]);

        $file = $request->file('file');

        if (request('fake_date')) {
            $workingDate = new Carbon(request('fake_date'));
        } else {
            $workingDate = Carbon::now();
        }

        $prefix = request('find_user_prefix');

        $usersImport = new EolUsersImport($workingDate, $prefix);
        Excel::import($usersImport, $file);

        return redirect()
            ->route('users.import_eol')
            ->with(
                'notice',
                'Import successful! '
                . $usersImport->getImportsCount()
                . ' added, of which '
                . $usersImport->getAttachedCount()
                . ' attached to a group. '
                . $usersImport->getDuplicatesCount()
                . ' duplicates were found, of which '
                . $usersImport->getUpdatedCount()
                . ' have been updated'
            );
    }
}
