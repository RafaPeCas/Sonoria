<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Address;
use App\Models\Album;
use App\Models\Genre;
use App\Models\Invoice;
use App\Models\PayMethod;
use App\Models\Permission;
use App\Models\Playlist;
use App\Models\Role;
use App\Models\Search;
use App\Models\Song;
use App\Models\Subscription;
use App\Models\UserReproduction;
use App\Models\UserSong;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Seed users
        User::factory(10)->create()->each(function ($user) {
            // Seed addresses for each user
            $user->update(['email_verified_at' => now()]);
            $user->addresses()->save(Address::factory()->make());

            // Seed albums for each user
            $user->albums()->save(Album::factory()->make());

            // Seed payment method for each user
            $user->paymentMethod()->save(PayMethod::factory()->make());

            // Seed subscription for each user
            $user->subscription()->save(Subscription::factory()->make());

            // Seed invoices for each user
            $user->invoices()->save(Invoice::factory()->make());

            // Seed searches for each user
            $user->searches()->save(Search::factory()->make());

            // Seed playlists for each user
            $user->playlists()->save(Playlist::factory()->make());

            // Seed roles for each user
            $user->roles()->save(Role::factory()->make());

            // Seed reproductions for each user
            $user->reproductions()->save(UserReproduction::factory()->make());

            $user->songs()->save(UserSong::factory()->make());

        });

        // Seed genres
        Genre::factory(5)->create();

        // Seed permissions
        Permission::factory(5)->create();

        // Seed songs
        Song::factory(20)->create()->each(function ($song) {
            // Attach random genres to each song
            $song->genres()->attach(rand(1, 5));

            // Attach random playlists to each song
            $song->playlists()->attach(rand(1, 10));
        });

        // Seed playlists
        Playlist::factory(10)->create()->each(function ($playlist) {
            // Attach random songs to each playlist
            $playlist->songs()->attach(rand(1, 20));
        });

        // Seed roles
        Role::factory(5)->create()->each(function ($role) {
            // Attach random permissions to each role
            $role->permissions()->attach(rand(1, 5));
        });
    }
}
