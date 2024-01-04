# laravel-udemy


### Project #1: Task List
routing 

blade directive

template inheritance

DB with docker

model & migration

model factory & seeder

form 

tailwindcss

### Project #3: Events Management App (REST API)
create database & migrate
```
php artisan migrate
```

create db model with migration file
```
php artisan make:model Attendee -m
php artisan make:model Event -m
```

generate controller
```
php artisan make:controller Api/AttendeeController --api
php artisan make:controller Api/EventController --api
```

create database model on migration file @ database/migrations/[model].php
```php
public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(User::class);
            $table->string('name');
            $table->text('description');

            $table->dateTime('start_time');
            $table->dateTime('end_time');

            $table->timestamps();
        });
    }
```

add relationship to model
```php
class Event extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function attendees(): HasMany
    {
        return $this->hasMany(Attendee::class);
    }
}
```

api routing @ routes/api.php
```php
Route::apiResources('events', EventController::class)
```

seeding data with custom seeder
```
php artisan make:factory EventFactory -model=Event
php artisan make:seeder EventSeeder
```

- EventFactory.php
```php
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->sentence(3),
            'description' => fake()->text,
            'start_time' => fake()->dateTimeBetween('now', '+1 month'),
            'end_time' => fake()->dateTimeBetween('+1 month', '+2 months'),
        ];
    }
}

```

- EventSeeder.php
```php
class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        
        for ($i=0; $i < 200; $i++) { 
            $user = $users->random();
            Event::factory()->create([
                'user_id' => $user->id
            ]);
        }
    }
}
```

- DatabaseSeeder.php
```php
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(1000)->create();

        $this->call(EventSeeder::class);

        $this->call(AttendeeSeeder::class);
    }
}
```

seeding 
```
php artisan migrate:refresh --seed
```