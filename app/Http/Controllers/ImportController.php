<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ImportController extends Controller
{
    public function show()
    {
        return view('users.import');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'import' => 'required|string',
        ]);

        $importJson = $request->import;

        if (request('fake_date')) {
            $workingDate = new Carbon(request('fake_date'));
        } else {
            $workingDate = Carbon::now();
        }

        $prefix = request('find_user_prefix');

        [
            $importCount,
            $importAttachCount,
        ] = $this->import($importJson, $workingDate, $prefix);

        return redirect()
            ->route('users.import')
            ->with(
                'notice',
                'Import successful! '
                    . $importCount
                    . ' added, of which '
                    . $importAttachCount
                    . ' attached to a group. '
            );
    }

    public static function stripAccents($string)
    {
        $unwanted = [
            'Š' => 'S',
            'š' => 's',
            'Ž' => 'Z',
            'ž' => 'z',
            'À' => 'A',
            'Á' => 'A',
            'Â' => 'A',
            'Ã' => 'A',
            'Ä' => 'A',
            'Å' => 'A',
            'Æ' => 'A',
            'Ç' => 'C',
            'È' => 'E',
            'É' => 'E',
            'Ê' => 'E',
            'Ë' => 'E',
            'Ì' => 'I',
            'Í' => 'I',
            'Î' => 'I',
            'Ï' => 'I',
            'Ñ' => 'N',
            'Ò' => 'O',
            'Ó' => 'O',
            'Ô' => 'O',
            'Õ' => 'O',
            'Ö' => 'O',
            'Ø' => 'O',
            'Ù' => 'U',
            'Ú' => 'U',
            'Û' => 'U',
            'Ü' => 'U',
            'Ý' => 'Y',
            'Þ' => 'B',
            'ß' => 'Ss',
            'à' => 'a',
            'á' => 'a',
            'â' => 'a',
            'ã' => 'a',
            'ä' => 'a',
            'å' => 'a',
            'æ' => 'a',
            'ç' => 'c',
            'è' => 'e',
            'é' => 'e',
            'ê' => 'e',
            'ë' => 'e',
            'ì' => 'i',
            'í' => 'i',
            'î' => 'i',
            'ï' => 'i',
            'ð' => 'o',
            'ñ' => 'n',
            'ò' => 'o',
            'ó' => 'o',
            'ô' => 'o',
            'õ' => 'o',
            'ö' => 'o',
            'ø' => 'o',
            'ù' => 'u',
            'ú' => 'u',
            'û' => 'u',
            'ü' => 'u',
            'ý' => 'y',
            'þ' => 'b',
            'ÿ' => 'y'
        ];

        return strtr($string, $unwanted);
    }

    public static function import($importJson, $workingDate, $prefix)
    {
        $import = json_decode($importJson, true);

        $importCount = 0;
        $importAttachCount = 0;

        foreach ($import as $importUser) {
            $importCount++;

            $id = 'i' . $importUser['code'];
            $user = User::firstOrNew(['id' => $id]);
            $user->id = $id;
            $user->name = self::stripAccents($importUser['name']);
            $user->email = $prefix . $importUser['code'] . '@edu.rocwb.nl';
            $user->type = 'student';
            $user->password = bcrypt(bin2hex(random_bytes(10)));
            $user->save();

            foreach ($importUser['groups'] as $group) {
                // $group = Group::firstOrNew(['name' => $group['name']]);
                // We don't automatically create groups
                $group = Group::where('name', $group['name'])->first();

                if (!$group) {
                    continue;
                }

                $group->users()->syncWithoutDetaching($user->id);

                $importAttachCount++;
            }
        }

        return [
            $importCount,
            $importAttachCount,
        ];
    }
}
