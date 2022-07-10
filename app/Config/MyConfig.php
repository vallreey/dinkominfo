<?php
    namespace Config;
    
    use CodeIgniter\Config\BaseConfig;
    use App\Models\GeneralModel;
    
    class MyConfig extends BaseConfig
    {
        public $ada_site_name = 'Site name';
        private $settings;

        public function __construct ()
        {
            parent::__construct();
            $main = new GeneralModel();

            $this->settings = $main->getResultData('settings');
        }

        public function setting($name){
            foreach ($this->settings as $s) if($s['name'] == $name) return $s['value'];
            return "";
        }
    }