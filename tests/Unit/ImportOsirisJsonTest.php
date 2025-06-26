<?php

namespace Tests\Unit;

use App\Http\Controllers\ImportController;
use App\Models\Group;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ImportOsirisJsonTest extends TestCase
{
    use RefreshDatabase;

    private static function getUsersInImport(): array
    {
        return [
            [
                'code' => 123456,
                'name' => 'Lorem de Vries',
                'groups' => [
                    ['name' => 'TTSDB-SD4O24A', 'type' => 'Klasgroep'],
                    ['name' => 'TTSDB-LGNAT-A', 'type' => 'Lesgroep'],
                ]
            ],
            [
                'code' => 123457,
                'name' => 'Ipsum van Oorschot',
                'groups' => [
                    ['name' => 'TTSDB-SD4O24A', 'type' => 'Klasgroep'],
                    ['name' => 'TTSDB-LGNAT-A', 'type' => 'Lesgroep'],
                ]
            ],
            [
                'code' => 123458,
                'name' => 'Dolor van Eerder',
                'groups' => [
                    ['name' => 'TTSDB-SD4O24B', 'type' => 'Klasgroep'],
                    ['name' => 'TTSDB-LGWEB-A', 'type' => 'Lesgroep'],
                ]
            ],
            [
                'code' => 123459,
                'name' => 'Sit van Gils',
                'groups' => [
                    ['name' => 'TTSDB-SD4O24B', 'type' => 'Klasgroep'],
                    ['name' => 'TTSDB-LGWEB-A', 'type' => 'Lesgroep'],
                ]
            ],
            [
                'code' => 123460,
                'name' => 'Amet Amilla',
                'groups' => [
                    ['name' => 'TTSDB-SD4O24C', 'type' => 'Klasgroep'],
                    ['name' => 'TTSDB-LGWEB-B', 'type' => 'Lesgroep'],
                ]
            ],
            [
                'code' => 123461,
                'name' => 'Consectetur Heeren',
                'groups' => [
                    ['name' => 'TTSDB-SD4O24C', 'type' => 'Klasgroep'],
                    ['name' => 'TTSDB-LGWEB-B', 'type' => 'Lesgroep'],
                ]
            ],
            [
                'code' => 123462,
                'name' => 'Adipiscing Jacobs',
                'groups' => [
                    ['name' => 'TTSDB-SD4O24D', 'type' => 'Klasgroep'],
                    ['name' => 'TTSDB-LGNAT-B', 'type' => 'Lesgroep'],
                ]
            ],
            [
                'code' => 123463,
                'name' => 'Elit Lucazi',
                'groups' => [
                    ['name' => 'TTSDB-SD4O24D', 'type' => 'Klasgroep'],
                    ['name' => 'TTSDB-LGNAT-B', 'type' => 'Lesgroep'],
                ]
            ],
            [
                'code' => 123464,
                'name' => 'Mauris Kalau',
                'groups' => [
                    ['name' => 'TTSDB-SD4O24E', 'type' => 'Klasgroep'],
                    ['name' => 'TTSDB-LGWEB-C', 'type' => 'Lesgroep'],
                ]
            ],
            [
                'code' => 123465,
                'name' => 'Hendrerit van Ommen',
                'groups' => [
                    ['name' => 'TTSDB-SD4O24E', 'type' => 'Klasgroep'],
                    ['name' => 'TTSDB-LGWEB-C', 'type' => 'Lesgroep'],
                ]
            ],
            [
                'code' => 123466,
                'name' => 'Interdum Engels',
                'groups' => [
                    ['name' => 'TTSDB-SD4O24F', 'type' => 'Klasgroep'],
                    ['name' => 'TTSDB-LGNAT-C', 'type' => 'Lesgroep'],
                ]
            ],
            [
                'code' => 123467,
                'name' => 'Tortot Lely',
                'groups' => [
                    ['name' => 'TTSDB-SD4O24F', 'type' => 'Klasgroep'],
                    ['name' => 'TTSDB-LGNAT-C', 'type' => 'Lesgroep'],
                ]
            ],
            [
                'code' => 123468,
                'name' => 'Interdum Lutte',
                'groups' => [
                    ['name' => 'TTSDB-SD4O24G', 'type' => 'Klasgroep'],
                    ['name' => 'TTSDB-LGWEB-D', 'type' => 'Lesgroep'],
                ]
            ],
            [
                'code' => 123469,
                'name' => 'Pharetra Schoenmakers',
                'groups' => [
                    ['name' => 'TTSDB-SD4O24G', 'type' => 'Klasgroep'],
                    ['name' => 'TTSDB-LGWEB-D', 'type' => 'Lesgroep'],
                ]
            ],
            [
                'code' => 123470,
                'name' => 'Nunc Zwijnen',
                'groups' => [
                    ['name' => 'TTSDB-SD4O24H', 'type' => 'Klasgroep'],
                    ['name' => 'TTSDB-LGNAT-D', 'type' => 'Lesgroep'],
                ],
            ],
        ];
    }

    /**
     * @test
     */
    public function user_can_import_users_without_groups(): void
    {
        $usersInImport = self::getUsersInImport();
        $importJson = json_encode($usersInImport, JSON_PRETTY_PRINT);

        // Before the tests these users should not be in the database
        foreach ($usersInImport as $user) {
            $this->assertDatabaseMissing('users', [
                'id' => 'i' . $user['code'],
                'name' => $user['name'],
                'email' => 'D' . $user['code'] . '@edu.rocwb.nl',
                'type' => 'student',
            ]);
        }

        $workingDate = '2021-09-01';
        $prefix = 'D';

        [
            $importAddedCount,
            $importAttachCount,
        ] = ImportController::import($importJson, $workingDate, $prefix);

        $this->assertEquals(count($usersInImport), $importAddedCount);
        $this->assertEquals(0, $importAttachCount);

        // Import should have added the users to the database
        foreach ($usersInImport as $user) {
            $this->assertDatabaseHas('users', [
                'id' => 'i' . $user['code'],
                'name' => $user['name'],
                'email' => 'D' . $user['code'] . '@edu.rocwb.nl',
                'type' => 'student',
            ]);
        }
    }

    /**
     * @test
     */
    public function user_can_import_users_with_groups(): void
    {
        $usersInImport = self::getUsersInImport();
        $importJson = json_encode($usersInImport, JSON_PRETTY_PRINT);

        $allUserGroups = collect($usersInImport)
            ->map(fn($user) => $user['groups'])
            ->flatten(1)
            ->unique('name')
            ->values()
            ->toArray();

        foreach ($allUserGroups as $group) {
            $group = Group::firstOrNew(['name' => $group['name']]);
            $group->name = $group['name'];

            if (strtolower($group['type']) == 'klasgroep') {
                $group->type = 'class';
            } else {
                $group->type = 'group';
            }

            $group->date_start = '2021-09-01';
            $group->date_end = '2022-07-01';
            $group->save();
        }

        $totalGroupCount = 0;

        // Before the tests these users should not be in the database
        foreach ($usersInImport as $user) {
            $this->assertDatabaseMissing('users', [
                'id' => 'i' . $user['code'],
                'name' => $user['name'],
                'email' => 'D' . $user['code'] . '@edu.rocwb.nl',
                'type' => 'student',
            ]);

            $totalGroupCount += count($user['groups']);
        }

        $workingDate = '2021-09-01';

        [
            $importAddedCount,
            $importAttachCount,
        ] = ImportController::import($importJson, $workingDate, 'D');

        $this->assertEquals(count($usersInImport), $importAddedCount);
        $this->assertEquals($totalGroupCount, $importAttachCount);

        // Import should have added the users to the database
        foreach ($usersInImport as $user) {
            $this->assertDatabaseHas('users', [
                'id' => 'i' . $user['code'],
                'name' => $user['name'],
                'email' => 'D' . $user['code'] . '@edu.rocwb.nl',
                'type' => 'student',
            ]);

            // User should be in a group of same name
            foreach ($user['groups'] as $group) {
                $this->assertDatabaseHas('group_user', [
                    'group_id' => Group::where('name', $group['name'])->first()->id,
                    'user_id' => 'i' . $user['code'],
                ]);
            }
        }
    }
}
