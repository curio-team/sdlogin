<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UploadCsvRequest;
use Excel;
use App\User;
use App\Group;

class ImportController extends Controller
{
    public $duplicates = 0;
    public $imports = 0;

    public function show()
    {
        return view('users.import');
    }

    public function upload(UploadCsvRequest $request)
    {
        $file = $request->file('csv');

        Excel::load($file, function($reader)  {

            $results = $reader->select(['userid', 'loginid', 'achternaam', 'tussen', 'voornaam', 'grep_groepscode', 'afdeling', 'logincode'])->get();


            foreach ($results as $result)
            {
                
                if($result->afdeling == 'ICO RC')
                {
                    $id = $result->logincode;
                    $user = User::find($id);
                    if($user == null)
                    {
                        $naam = $result->voornaam;
                        if(!empty($result->tussen))
                        {
                            $naam .= ' ' . $result->tussen;
                        }
                        $naam .= ' ' . $result->achternaam;
                        
                        $user = new User;
                        $user->id = $id;
                        $user->name = $this->stripAccents($naam) . "\n";
                        $user->email = $id . '@edu.rocwb.nl';
                        $user->type = 'student';
                        $user->password = bcrypt('welkom');
                        $user->save();

                        $group = Group::findOnlyCurrent($result->grep_groepscode);
                        if($group != null)
                        {
                            $user->groups()->attach($group);
                        }

                        $this->imports++;
                    }
                    else
                    {
                        $group = Group::findOnlyCurrent($result->grep_groepscode);
                        if($group != null)
                        {
                            $user->groups()->attach($group);
                        }

                        $this->duplicates++;
                    }
                }
            }

        });
        
        return redirect('/users')->with('notice', 'Import successful: ' . $this->imports . ' added, ' . $this->duplicates . ' duplicates were found.');
    }

    private function stripAccents($string){
        $unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ü' => 'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
        return strtr( $string, $unwanted_array );
        return strtr($string,'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ','aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
    }
}