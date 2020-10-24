<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;
use App\User;
use App\Group;
use Carbon\Carbon;

define("VNAAM", 0);
define("TV",    2);
define("ANAAM", 3);
define("CODE",  4);
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
        Excel::load($file, function($reader)  {
            $reader->noHeading();
            $reader->skipRows(2);
            $reader->skipColumns(1);

            $working_date = Carbon::now();
            if(request('fake_date')) $working_date = new Carbon(request('fake_date'));

            $results = $reader->get();
            foreach ($results as $row)
            {
                //Fix group
                $groep = $row[GROEP];
                if(strstr($groep, ",")) //If a comma occurs in "groep"...
                {
                    $groepen = explode(",", $groep);
                    foreach($groepen as $g)
                    {
                        if(substr($g, 0, 4) == "RIO4") $groep = $g;
                    }
                }

                $id = $row[CODE];
                $user = User::find($find_user . $id);
                if($user == null)
                {
                    //Fix name
                    $naam = $row[VNAAM];
                    if(!empty($row[TV])) $naam .= ' ' . $row[TV];
                    $naam .= ' ' . $row[ANAAM];
                
                    //Create user
                    $user = new User;
                    $user->id = "i" . $id;
                    $user->name = $this->stripAccents($naam);
                    $user->email = "D" . $id . "@edu.rocwb.nl";
                    $user->type = "student";
                    $user->password = bcrypt(bin2hex(random_bytes(10)));
                    $user->save();

                    $group = Group::findOnlyCurrent($groep, $working_date);
                    if($group != null)
                    {
                        $user->groups()->attach($group);
                        $this->attached++;
                    }

                    $this->imports++;
                }
                else
                {
                    $group = Group::findOnlyCurrent($groep, $working_date);
                    if($group != null)
                    {
                        $history = $user->groupHistory()->pluck('id');
                        $history->push($group->id);
                        $result = $user->groups()->sync($history);

                        if(count($result['attached']) || count($result['detached']) || count($result['updated']))
                        {
                            $this->updated++;
                        }
                    }

                    $this->duplicates++;
                }

            }

        }, "UTF-8");
        
        return redirect('/users/import/eol')->with('notice', 'Import successful! ' . $this->imports . ' added, of which ' . $this->attached . ' attached to a group. ' . $this->duplicates . ' duplicates were found, of which ' . $this->updated . ' have been updated');
    }

    private function stripAccents($string){
        $unwanted_array = array( 'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ü' => 'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', 'ğ' => 'g' );
        return strtr( $string, $unwanted_array );
    }
}