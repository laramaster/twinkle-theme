<?php

namespace Twinkle\Themes;

use Illuminate\Console\Command;

class ThemeGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'theme:create { name }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Theme create for twinkle package';

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
        $theme_domain = $this->argument('name');

        if (!file_exists(base_path().'/twinkle/Themes/'.$theme_domain)) {
            mkdir(base_path().'/twinkle/Themes/'.$theme_domain,0777,true);
            $theme_name = $this->ask('What is theme Name?');
            $theme_author = $this->ask('What is theme author name?');
            $theme_version = $this->ask('What is theme version?');
            $this->theme($theme_domain,$theme_name,$theme_author,$theme_version);
            $this->routes($theme_domain);
            $this->controller($theme_domain);
            $this->view($theme_domain);


            $additionalArray = array(
                "Theme Name" => $theme_name,
                "Thumbnail" => "thumbnail.png",
                "Author" => $theme_author,
                "Version" => $theme_version,
                "License" => "GNU General Public License v2 or later",
                "Text Domain" => $theme_domain,
                "status" => "deactive"
            );

            //open or read json data
            $data_results = file_get_contents( base_path().'/twinkle/Themes/theme.json');
            $tempArray = json_decode($data_results);

            //append additional json to json file
            $tempArray[] = $additionalArray ;
        
            file_put_contents(base_path().'/twinkle/Themes/theme.json', json_encode($tempArray,JSON_PRETTY_PRINT));  



            $this->info("theme created successfully.");
        }else{
            $this->info("Theme already exists!");
        }
    }

    protected function getStub($type)
    { 
        return file_get_contents(base_path("twinkle/Themes/stub/$type.stub"));
    }

    protected function theme($theme_domain,$theme_name,$theme_author,$theme_version)
    {
        $theme_generate = str_replace(
            [

                '{{ThemeDomain}}',
                '{{ThemeName}}',
                '{{ThemeAuthor}}',
                '{{ThemeVersion}}'
            ],
            [

                $theme_domain,
                $theme_name,
                $theme_author,
                $theme_version
            ],
            $this->getStub('single_theme')
        );


        file_put_contents(base_path().'/twinkle/Themes/'.$theme_domain.'/single_theme.json', $theme_generate);
    }


    protected function routes($theme_domain)
    {
        $modelTemplate = str_replace(
            ['{{ThemeDomain}}'],
            [$theme_domain],
            $this->getStub('web')
        );
        mkdir(base_path().'/twinkle/Themes/'.$theme_domain.'/routes',0777,true);

        file_put_contents(base_path().'/twinkle/Themes/'.$theme_domain.'/routes/web.php', $modelTemplate);
    }

    protected function controller($theme_domain)
    {
        $modelTemplate = str_replace(
            ['{{ThemeDomain}}'],
            [$theme_domain],
            $this->getStub('controller')
        );
        mkdir(base_path().'/twinkle/Themes/'.$theme_domain.'/app/http/controllers',0777,true);
        mkdir(base_path().'/twinkle/Themes/'.$theme_domain.'/migrations',0777,true);

        file_put_contents(base_path().'/twinkle/Themes/'.$theme_domain.'/app/http/controllers/WelcomeController.php', $modelTemplate);
    }

    protected function view($theme_domain)
    {
        mkdir(base_path().'/twinkle/Themes/'.$theme_domain.'/views/welcome',0777,true);
        $view = $this->getStub('view');
        file_put_contents(base_path().'/twinkle/Themes/'.$theme_domain.'/views/welcome/home.blade.php', $view);
    }
}
