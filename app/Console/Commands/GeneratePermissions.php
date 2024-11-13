<?php

namespace App\Console\Commands;

use App\PermissionsType;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;

class GeneratePermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'roles:generate-permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach (PermissionsType::cases() as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission->value],
                []
            );
            echo $permission->name . ' - ' . $permission->value . PHP_EOL;
        }
    }
}
