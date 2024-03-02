<?php

namespace App\Imports;

use App\Http\Controllers\ImportController;
use App\Models\Group;
use App\Models\User;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EolUsersImport implements ToModel, SkipsEmptyRows, WithHeadingRow
{
    /**
     * Counters for the import
     */
    protected int $duplicates = 0;

    protected int $updated = 0;

    protected int $imports = 0;

    protected int $attached = 0;

    public function __construct(
        protected string $date,
        protected string $findUserPrefix = 'i',
    ) {
        $this->duplicates = 0;
        $this->updated = 0;
    }

    /**
     * Offset for the heading row
     */
    public function headingRow(): int
    {
        return 2;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $id = $row['studentcode'];
        $groupName = $row['groep'];

        $user = User::find($this->findUserPrefix . $id);
        $group = Group::findOnlyCurrent($groupName, $this->date);

        // If the user exists in the system, update the group
        if ($user) {
            if ($group !== null) {
                $history = $user->groupHistory()->pluck('id');
                $history->push($group->id);
                $result = $user->groups()->sync($history);

                if (count($result['attached']) || count($result['detached']) || count($result['updated'])) {
                    $this->updated++;
                }
            }

            $this->duplicates++;

            return;
        }

        // Add the user if they don't exist in the system yet
        $name = $row['naam'] . ' ';

        if ($row['tussenvoegsel']) {
            $name .= $row['tussenvoegsel'] . ' ';
        }

        $name .= $row['achternaam'];

        $user = new User();
        $user->id = 'i' . $id;
        $user->name = ImportController::stripAccents($name);
        $user->email = 'D' . $id . '@edu.rocwb.nl';
        $user->type = 'student';
        $user->password = bcrypt(bin2hex(random_bytes(10)));
        $user->save();

        if ($group != null) {
            $user->groups()->attach($group);
            $this->attached++;
        }

        $this->imports++;

        return $user;
    }

    public function getDuplicatesCount(): int
    {
        return $this->duplicates;
    }

    public function getUpdatedCount(): int
    {
        return $this->updated;
    }

    public function getImportsCount(): int
    {
        return $this->imports;
    }

    public function getAttachedCount(): int
    {
        return $this->attached;
    }
}
