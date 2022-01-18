<?php

namespace App\Console\Commands;

use App\Models\Brand;
use Illuminate\Console\Command;

class InstallBrandCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'brand:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install all brands';

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
     * @return int
     */
    public function handle()
    {
        $brands = [
            'WEYON',
            'SONY',
            'SAMSUNG',
            'LG',
            'PANASONIC',
            'SHARP',
            'VIZIO',
            'HISENSE',
            'PHILIPS',
            'TCL',
            'TOSHIBA',
            'JVC',
            'HITACHI',
            'XIAOMI',
            'SANYO',
            'POLYTRON',
            'COOCAA',
            'CHANGCHONG',
            'AKARI',
            'HUAWEI',
            'EDENWOOD',
            'INSIGNIA',
            'JVC',
            'MEDISON',
            'METZ',
            'ONEPLUS',
            'RCA',
            'SHARK',
            'SCEPTRE',
            'TELEFUNKEN',
            'THOMSON',
            'VESTEL',
            'VIZIO',
            'ENGEL',
            'NEVIR',
            'REALME',
            'OPPO',
            'ASUS',
            'CHANGHONG'
        ];

        foreach ($brands as $brand) {
            Brand::firstOrCreate([
                'name'  => $brand
            ]);
        }

        echo 'updated data brand' . '\n';
        return 0;
    }
}
