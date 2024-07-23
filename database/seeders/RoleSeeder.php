<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Roles
        $admin = Role::create(['name' => 'Administrator']);
        $author = Role::create(['name' => 'Author']);
        $user = Role::create(['name' => 'User']);

        //Permisos
        Permission::create(['name' => 'admin.index', 'description' => 'Consult Dashboard'])->syncRoles([$admin, $author, $user]);

        //Permisos categorías
        Permission::create(['name' => 'categories.index', 'description' => 'Consult categories'])->syncRoles([$admin, $author]);
        Permission::create(['name' => 'categories.create', 'description' => 'Create categories'])->assignRole($admin);
        Permission::create(['name' => 'categories.edit', 'description' => 'Edit categories'])->assignRole($admin);
        Permission::create(['name' => 'categories.destroy', 'description' => 'Delete categories'])->assignRole($admin);

        //Permisos artículos
        Permission::create(['name' => 'articles.index', 'description' => 'Consult articles'])->syncRoles([$admin, $author]);
        Permission::create(['name' => 'articles.create', 'description' => 'Create articles'])->syncRoles([$admin, $author]);
        Permission::create(['name' => 'articles.edit', 'description' => 'Edit articles'])->syncRoles([$admin, $author]);
        Permission::create(['name' => 'articles.destroy', 'description' => 'Delete articles'])->syncRoles([$admin, $author]);

        //Permisos tournaments
        Permission::create(['name' => 'tournaments.index', 'description' => 'Consult tournaments'])->syncRoles([$admin, $author]);
        Permission::create(['name' => 'tournaments.create', 'description' => 'Create tournaments'])->syncRoles($admin);
        Permission::create(['name' => 'tournaments.edit', 'description' => 'Edit tournaments'])->syncRoles($admin);
        Permission::create(['name' => 'tournaments.destroy', 'description' => 'Delete tournaments'])->syncRoles($admin);

        //Permisos teams
        Permission::create(['name' => 'teams.index', 'description' => 'Consult teams'])->syncRoles([$admin, $author]);
        Permission::create(['name' => 'teams.create', 'description' => 'Create teams'])->assignRole($admin);
        Permission::create(['name' => 'teams.edit', 'description' => 'Edit teams'])->assignRole($admin);
        Permission::create(['name' => 'teams.destroy', 'description' => 'Delete teams'])->assignRole($admin);

        
        //Permisos tournament_teams
        Permission::create(['name' => 'tournamentTeam.index', 'description' => 'Consult teams on tournament'])->syncRoles([$admin, $author]);
        Permission::create(['name' => 'tournamentTeam.create', 'description' => 'Create teams on tournament'])->syncRoles($admin);
        Permission::create(['name' => 'tournamentTeam.edit', 'description' => 'Edit teams on tournament'])->syncRoles($admin);
        Permission::create(['name' => 'tournamentTeam.destroy', 'description' => 'Delete teams on tournament'])->syncRoles($admin);


        //Permisos games
        Permission::create(['name' => 'games.index', 'description' => 'Consult games'])->syncRoles([$admin, $author]);
        Permission::create(['name' => 'games.create', 'description' => 'Create games'])->syncRoles($admin);
        Permission::create(['name' => 'games.edit', 'description' => 'Edit games'])->syncRoles($admin);
        Permission::create(['name' => 'games.destroy', 'description' => 'Delete games'])->syncRoles($admin);

        //Permisos players
        Permission::create(['name' => 'players.index', 'description' => 'Consult players'])->syncRoles([$admin, $author]);
        Permission::create(['name' => 'players.create', 'description' => 'Create players'])->syncRoles($admin);
        Permission::create(['name' => 'players.edit', 'description' => 'Edit players'])->syncRoles($admin);
        Permission::create(['name' => 'players.destroy', 'description' => 'Delete players'])->syncRoles($admin);

        //Permisos stats players
        Permission::create(['name' => 'stats_player.create', 'description' => 'Create stats player'])->syncRoles($admin);
        Permission::create(['name' => 'stats_player.edit', 'description' => 'Edit stats player'])->syncRoles($admin);

        //Permisos comentarios
        Permission::create(['name' => 'comments.index', 'description' => 'Consult comments'])->syncRoles([$admin, $author, $user]);
        Permission::create(['name' => 'comments.destroy', 'description' => 'Delete comments'])->syncRoles([$admin, $author, $user]);

        //Usuarios
        Permission::create(['name' => 'users.index', 'description' => 'Consult users'])->assignRole($admin);
        Permission::create(['name' => 'users.edit', 'description' => 'Edit users'])->assignRole($admin);
        Permission::create(['name' => 'users.destroy', 'description' => 'Delete users'])->assignRole($admin);

        
        //Roles
        Permission::create(['name' => 'roles.index', 'description' => 'Consult roles'])->assignRole($admin);
        Permission::create(['name' => 'roles.create', 'description' => 'Create roles'])->assignRole($admin);
        Permission::create(['name' => 'roles.edit', 'description' => 'Edit roles'])->assignRole($admin);
        Permission::create(['name' => 'roles.destroy', 'description' => 'Delete roles'])->assignRole($admin);
    }
}
