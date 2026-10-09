<?php

namespace Webkul\Myfatoorah\Console\Commands;

use Illuminate\Console\Command;
use Webkul\Myfatoorah\Providers\MyfatoorahServiceProvider;

class InstallMyfatoorah extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'myfatoorah:install
        { --force : Overwrite any previously published MyFatoorah assets. }
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the MyFatoorah payment gateway: publish its assets, link the storage directory and clear the caches.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->warn('Step: Publishing MyFatoorah assets...');
        $this->publishAssets();

        $this->warn('Step: Linking storage directory...');
        $this->linkStorage();

        $this->warn('Step: Clearing cached bootstrap files...');
        $this->call('optimize:clear');

        $this->components->info('MyFatoorah payment gateway installed successfully.');

        $this->components->bulletList([
            'Configure the gateway at Configure → Sales → Payment Methods → MyFatoorah.',
            'Get the API Key and account country from MyFatoorah\'s Integration Settings.',
            'Point MyFatoorah\'s webhook URL to '.route('myfatoorah.webhook').', then save the signing secret it gives you there.',
        ]);

        return self::SUCCESS;
    }

    /**
     * Publish the payment method logo to the public disk.
     */
    protected function publishAssets(): void
    {
        $this->call('vendor:publish', array_filter([
            '--provider' => MyfatoorahServiceProvider::class,
            '--tag' => 'public',
            '--force' => $this->option('force'),
        ]));
    }

    /**
     * Link the storage directory so the published logo is publicly reachable.
     */
    protected function linkStorage(): void
    {
        if (file_exists(public_path('storage'))) {
            $this->components->info('The [public/storage] link already exists.');

            return;
        }

        $this->call('storage:link');
    }
}
