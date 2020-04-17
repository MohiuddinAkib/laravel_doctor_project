<?php

namespace App\Console\Commands;

use App\User;
use App\DoctorCategory;
use Illuminate\Auth\Events\Registered;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;

class CreateDoctor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'doctor:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a doctor';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $bar = $this->output->createProgressBar(13);
        $bar->start();
        $name = $this->ask('What is doctor\'s name?');
        $bar->advance();
        $email = $this->ask('What is doctor\'s email?');
        $bar->advance();
        $mobile = $this->ask('What is doctor\'s mobile?');
        $bar->advance();
        $address = $this->getDoctorAddress($bar);
        $bar->advance();
        $genderMap = [
            'male' => 0,
            'female' => 1
        ];
        $gender = $this->choice('What is doctor\'s gender?', ['male', 'female']);
        $gender = $genderMap[$gender];
        $bar->advance();
        $password = $this->secret('What is doctor\'s password?');
        $bar->advance();
        $category_id = $this->getDoctorCategory();
        $bar->advance();
        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'mobile' => $mobile,
            'address' => $address,
            'gender' => $gender,
            'category_id' => $category_id,
        ], [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string',
            'mobile' => 'required|string|between:11,14',
            'address.street' => 'required|string',
            'address.city' => 'required|string',
            'address.zip' => 'required|numeric',
            'gender' => 'required|numeric',
            'category_id' => 'required|numeric|exists:App\DoctorCategory,id',
        ]);

        if ($validator->fails()) {
            $this->warn(' Doctor was not created.');

            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
        } else {
            $validated = $validator->validated();
            $newDoctor = User::create(
                Arr::only($validated, [
                    'name',
                    'email',
                    'password'
                ])
            );
            $bar->advance();
            $newDoctor->profile()->create(
                Arr::except($validated, [
                    'name',
                    'email',
                    'password'
                ])
            );
            $bar->advance();
            event(new Registered($newDoctor));
            $bar->advance();
            $doctorRole = Role::firstOrCreate(['name' => 'doctor']);
            $newDoctor->assignRole($doctorRole);
            $bar->advance();
            $bar->finish();
            $this->info(" Doctor created successfully.\n");
        }
    }

    private function getDoctorAddress($bar)
    {
        $street = $this->ask('What is doctor\'s street?');
        $bar->advance();
        $city = $this->ask('What is doctor\'s city?');
        $bar->advance();
        $zip = $this->ask('What is doctor\'s zip?');

        return [
            'street' => $street,
            'city' => $city,
            'zip' => $zip,
        ];
    }

    private function getDoctorCategory()
    {
        $categories = DoctorCategory::all(['name', 'id']);
        $categoryNames = $categories->map(function ($data) {
            return $data['name'];
        })->toArray();
        $category = $this->choice('What is doctor\'s category?', $categoryNames);
        return $categories->where('name', $category)->first()->id;
    }
}