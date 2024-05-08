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
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {

        $user = new User();
        $user->name = 'admin';
        $user->email = 'admin@admin.com';
        $user->password = Hash::make('admin');
        $user->gender = 'male'; 
        $user->birth = '1990-01-01'; 
        $user->last_song = null; 
        $user->save();

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



        collect([
            'pop', 'rock', 'rap', 'hip-hop', 'alternative', 'indie', 'jazz', 'blues', 'country',
            'electronic', 'dance', 'folk', 'reggae', 'soul', 'classical', 'metal', 'punk', 'disco',
            'funk', 'techno', 'house', 'rhythm and blues (R&B)', 'latin', 'ska', 'grunge', 'ambient',
            'experimental', 'world', 'reggaeton', 'trap', 'EDM (Electronic Dance Music)', 'new wave',
            'classical crossover', 'chill-out', 'hard rock', 'baroque', 'emo', 'garage rock',
            'symphonic metal', 'dubstep', 'pop punk', 'psychedelic rock', 'fusion', 'bluegrass',
            'orchestral', 'acoustic', 'progressive rock', 'salsa', 'bossa nova', 'ballad', 'post-punk',
            'trip hop', 'glam rock', 'heavy metal', 'shoegaze', 'power pop', 'dream pop', 'rock and roll',
            'synth-pop', 'grindcore', 'thrash metal', 'death metal', 'house', 'electro-pop', 'folktronica',
            'lo-fi', 'big band', 'ambient house', 'trap', 'cowpunk', 'post-rock', 'zydeco', 'dub', 'skiffle',
            'motown', 'gothic rock', 'rockabilly', 'tejano', 'jangly pop', 'neoclassical', 'surf rock',
            'electronica', 'minimalism', 'downtempo', 'industrial', 'power metal', 'neofolk', 'cajun',
            'tango', 'ukulele', 'soul jazz', 'future bass', 'glitch', 'drum and bass', 'acid jazz',
            'electro swing', 'grime', 'hardstyle', 'minimal techno', 'ambient techno', 'trip rock',
            'honky-tonk', 'chiptune', 'bhangra', 'motown soul', 'speed metal', 'post-punk revival',
            'jam band', 'zydeco', 'bubblegum pop', 'smooth jazz', 'acid house', 'rocksteady', 'moombahton',
            'brass band'
        ])->each(function ($genreName) {
            Genre::factory()->create(['name' => $genreName]);
        });

        // Seed permissions
        Permission::factory(5)->create();

        // Seed songs
        Song::factory(20)->create()->each(function ($song) {
            // Attach random genres to each song
            $song->genres()->attach(rand(1, 50));

            // Attach random playlists to each song
            $song->playlists()->attach(rand(1, 10));
        });

        // Seed playlists
        Playlist::factory(10)->create()->each(function ($playlist) {
            // Attach random songs to each playlist
            $playlist->songs()->attach(rand(1, 20));
        });

        collect([
            'artist', 'user', 'admin'
        ])->each(function ($roleName) {
            Role::factory()->create(['name' => $roleName]);
        });


    }
}
