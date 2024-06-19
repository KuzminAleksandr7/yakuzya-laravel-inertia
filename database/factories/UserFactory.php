<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    private array $users = [];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $locale = 'uk_UA';
        $gender = collect(['male', 'female'])->random();
        $year = fake()->year();

        $firstname = fake($locale)->firstName($gender);
        $lastname = fake($locale)->lastName($gender);

        $mail = collect(['@gmail.com', '@abz.agency', '@yahoo.com', '@hotmail.com'])->random();
        $base_email = Str::lower(Str::transliterate("{$firstname}.{$lastname}{$year}{$mail}"));

        $unique_email = $base_email;
        while (isset($this->users[$unique_email])) {
            $year--;
            $unique_email = Str::lower(Str::transliterate("{$firstname}.{$lastname}{$year}{$mail}"));
        }

        $this->users[$unique_email] = [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $unique_email,
            'image' => null,


            'email_verified_at' => now(),
            'password' => Hash::make(Str::random()),
            'remember_token' => Str::random(10),
        ];

        // Можна було б зробити набагато простіше, але тоді б емейл не співпадав з ім'ям/прізвищем користувача(по ТЗ - дані максимальні до реальних)
        // В наслідок, перебирання масиву $this->users для уніфікації пошти витрачаєься багато прани
        //  return [
        //      'firstname' => $firstname,
        //      'lastname' => $lastname,
        //      'email' => fake($locale)->unique()->safeEmailDomain(),
        //      'image' => null,
        //      'email_verified_at' => now(),
        //      'password' => Hash::make(Str::random()),
        //      'remember_token' => Str::random(10),
        //  ];

        return $this->users[$unique_email];
    }
}
