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

    public static function stripAccents($string)
    {
        $unwanted = [
            'Š' => 'S', 'š' => 's', 'Ž' => 'Z', 'ž' => 'z', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E',
            'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U',
            'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c',
            'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o',
            'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ý' => 'y', 'þ' => 'b', 'ÿ' => 'y'
        ];

        return strtr($string, $unwanted);
    }
}
