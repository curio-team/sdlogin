<?php

namespace Tests\Unit;

use App\Imports\EolUsersImport;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

class ImportEolUsersTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function user_can_import_users(): void
    {
        $usersInImport = [
            [ 'id' => 123456, 'name' => 'Lorem de Vries' ],
            [ 'id' => 123457, 'name' => 'Ipsum van Oorschot' ],
            [ 'id' => 123458, 'name' => 'Dolor van Eerder' ],
            [ 'id' => 123459, 'name' => 'Sit van Gils' ],
            [ 'id' => 123460, 'name' => 'Amet Amilla' ],
            [ 'id' => 123461, 'name' => 'Consectetur Heeren' ],
            [ 'id' => 123462, 'name' => 'Adipiscing Jacobs' ],
            [ 'id' => 123463, 'name' => 'Elit Lucazi' ],
            [ 'id' => 123464, 'name' => 'Mauris Kalau' ],
            [ 'id' => 123465, 'name' => 'Hendrerit van Ommen' ],
            [ 'id' => 123466, 'name' => 'Interdum Engels' ],
            [ 'id' => 123467, 'name' => 'Tortot Lely' ],
            [ 'id' => 123468, 'name' => 'Interdum Lutte' ],
            [ 'id' => 123469, 'name' => 'Pharetra Schoenmakers' ],
            [ 'id' => 123470, 'name' => 'Nunc Zwijnen' ],
        ];

        // Before the tests these users should not be in the database
        foreach ($usersInImport as $user) {
            $this->assertDatabaseMissing('users', [
                'id' => 'i' . $user['id'],
                'name' => $user['name'],
                'email' => 'D' . $user['id'] . '@edu.rocwb.nl',
                'type' => 'student',
            ]);
        }

        $workingDate = '2021-09-01';
        $prefix = 'D';

        $usersImport = new EolUsersImport($workingDate, $prefix);
        Excel::import($usersImport, __DIR__ . '/Fixtures/fake-klassenlijst.xlsx');

        // Import should have added the users to the database
        foreach ($usersInImport as $user) {
            $this->assertDatabaseHas('users', [
                'id' => 'i' . $user['id'],
                'name' => $user['name'],
                'email' => 'D' . $user['id'] . '@edu.rocwb.nl',
                'type' => 'student',
            ]);
        }
    }
}
