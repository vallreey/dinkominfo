<?php
    namespace Config;
    
    use CodeIgniter\Config\BaseConfig;
    use App\Models\GeneralModel;
    
    class MyConfig extends BaseConfig
    {
        public $ada_site_name = 'Site name';
        public $settings = array();

        public function __construct ()
        {
            parent::__construct();
            $main = new GeneralModel();

            // Load all settings from db to variable settings
            $tempSettings = $main->getResultData('settings');
            foreach ($tempSettings as $s) $this->settings[$s['name']] = $s['value'];
            
            // Define revision and archive dir 
            $this->settings["revisionDir"] = $this->settings["dataDir"] . 'revisionDir/';
            $this->settings["archiveDir"] = $this->settings["dataDir"] . 'archiveDir/';
        }
    }