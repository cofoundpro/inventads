<?php

if (!defined('ABSPATH'))
    exit;

class aace_core {

    /**
     * The single instance
     * @var    object
     * @access  private
     * @since    1.0.0
     */
    private static $_instance = null;

    /**
     * Settings class object
     * @var     object
     * @access  public
     * @since   1.0.0
     */
    public $settings = null;

    /**
     * The version number.
     * @var     string
     * @access  public
     * @since   1.0.0
     */
    public $_version;

    /**
     * The token.
     * @var     string
     * @access  public
     * @since   1.0.0
     */
    public $_token;

    /**
     * The main plugin file.
     * @var     string
     * @access  public
     * @since   1.0.0
     */
    public $file;

    /**
     * The main plugin directory.
     * @var     string
     * @access  public
     * @since   1.0.0
     */
    public $dir;

    /**
     * The plugin assets directory.
     * @var     string
     * @access  public
     * @since   1.0.0
     */
    public $assets_dir;

    /**
     * The plugin assets URL.
     * @var     string
     * @access  public
     * @since   1.0.0
     */
    public $assets_url;

    /**
     * Suffix for Javascripts.
     * @var     string
     * @access  public
     * @since   1.0.0
     */
    public $templates_url;

    /**
     * Suffix for Javascripts.
     * @var     string
     * @access  public
     * @since   1.0.0
     */
    public $script_suffix;

    /**
     * For menu instance
     * @var     string
     * @access  public
     * @since   1.0.0
     */
    public $menu;

    /**
     * For template
     * @var     string
     * @access  public
     * @since   1.0.0
     */
    public $plugin_slug;

    /**
     * Constructor function.
     * @access  public
     * @since   1.0.0
     * @return  void
     */
    public function __construct($file = '', $version = '1.0.0') {
        $this->_version = $version;
        $this->_token = 'aace';
        $this->file = $file;
        $this->dir = dirname($this->file);
        $this->assets_dir = trailingslashit($this->dir) . 'assets';
        $this->assets_url = esc_url(trailingslashit(plugins_url('/assets/', $this->file)));
       
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'), 10, 1);
        add_action('plugins_loaded', array($this, 'init_localization'));        
        add_action('wp_ajax_nopriv_aace_generateText', array($this, 'ajax_generateText'));
        add_action('wp_ajax_aace_generateText', array($this, 'ajax_generateText'));

        add_action( 'elementor/element/before_section_end', function( $element, $section_id, $args ) {
			

			if($element->get_name() == 'text-editor' && $section_id == 'section_editor'){
				$element->add_control(
					'aace_divider', [
						'type' => \Elementor\Controls_Manager::DIVIDER,
					]
					);

					$element->add_control(
						'aace_heading', [
							'label' => esc_html__( 'Auto content', 'aace' ),
							'type' => \Elementor\Controls_Manager::HEADING,
						]
						);

				$element->add_control(
					'aace_prompt', [
						'label' => esc_html__( 'Wanted content', 'aace' ),
						'label_block'=>true,
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => '',
						'description' => esc_html__( 'Describe the content you want to generate', 'aace' ),
					]
					);

					$element->add_control(
						'aace_seo',
						[
							'label' => __( 'Keywords', 'aace' ),
							'type' => \Elementor\Controls_Manager::TEXT,
							'text' => esc_html__( 'Generate', 'aace' ),
							'label_block'=>true,
							'event' => 'aace:autocontent:generate',
							'description' => esc_html__( 'Facultative keywords separated by commas', 'aace' ),		
							
						]
					);

				$element->add_control(
					'aace_generate',
					[
						'label' =>'',
						'show_label'=>false,
						'button_type'=>'default',
						'separator' => 'before',
						'type' => \Elementor\Controls_Manager::BUTTON,
						'text' => esc_html__( 'Generate', 'aace' ),
						'event' => 'aace:autocontent:generate'						
						
					]
				);

				
			}
		
		}, 10, 3 );

    }
    public function enqueue_scripts() {
		wp_enqueue_script( $this->_token. '_frontend', esc_url($this->assets_url) . 'js/aace_frontend.min.js', array( 'jquery' ), $this->_version, false );
		$js_data = array(
			'homeUrl' => get_site_url(),
			'ajaxurl' => admin_url('admin-ajax.php')
		);				
		wp_localize_script($this->_token . '_frontend', 'aace_data', $js_data);
	}

    /*
     * Plugin init localization
     */
    public function init_localization() {
        $moFiles = scandir(trailingslashit($this->dir) . 'languages/');
        foreach ($moFiles as $moFile) {
            if (strlen($moFile) > 3 && substr($moFile, -3) == '.mo' && strpos($moFile, get_locale()) > -1) {
                load_textdomain('aace', trailingslashit($this->dir) . 'languages/' . $moFile);
            }
        }
    }
    public function ajax_generateText(){
		
        if (current_user_can('manage_options')) {
		if(isset($_POST['prompt'])&&isset($_POST['keywords'])){
			$prompt = sanitize_text_field($_POST['prompt']);
			$keywords = sanitize_text_field($_POST['keywords']);

			$rep = '';

			$open_ai_key = get_option('aace_openAiApiKey');
			if($open_ai_key == ''){
				$rep = "error:".esc_html__( "The OpenAI API key isn't filled in the plugin settings. Go to Settings -> A.I Autocontent to fill it.", 'aace' );
			} else {
			
				$temperature = get_option('aace_temperature');
				$prompt = 'Write a long paragraph about this subject: '.$prompt;
				if($keywords != ''){
					$prompt.= '. Keywords to place: '.$keywords.'.\n';
				}
				$prompt.= 'Write in this language: '.get_option('aace_language').'.\n';

				try {
					$response = Requests::post( 'https://api.openai.com/v1/chat/completions', array(
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $open_ai_key
                    ), json_encode( array(
                        "model" => "gpt-4o",
                        "messages" => array(
                            array("role" => "system", "content" => "You are a text generator. You generate texts based on the user's prompt. You don't use any other information than the prompt."),
                            array("role" => "user", "content" => $prompt)
                        ),
                        "n" => 1,
                        "max_tokens" => intval(get_option('aace_maxTokens')),
                        "temperature" => floatval(get_option('aace_temperature')),
                        'frequency_penalty' => floatval(get_option('aace_frequencyPenality')),
                        'presence_penalty' => floatval(get_option('aace_presencePenality'))
                    ) ));

                    $body = json_decode($response->body);
                    $rep = $body->choices[0]->message->content;
                    		
					
				} catch (\Throwable $th) {
					//throw $th;
						$rep = "error:".$th->getMessage();
				}catch(Exception $e) {
					$rep = "error:".$e->getMessage();
				  }

		}
		echo $rep;
			die();

		}
	}
	} 

    /**
     * Log the plugin version number.
     * @access  public
     * @since   1.0.0
     * @return  void
     */
    private function _log_version_number() {
        update_option($this->_token . '_version', $this->_version);
    }

    /**
     * Main wutb_Core Instance
     *
     *
     * @since 1.0.0
     * @static
     * @see wutb_Core()
     * @return Main wutb_Core instance
     */
    public static function instance($file = '', $version = '1.0.0') {
        if (is_null(self::$_instance)) {
            self::$_instance = new self($file, $version);
        }
        return self::$_instance;
    }

// End instance()

    /**
     * Cloning is forbidden.
     *
     * @since 1.0.0
     */
    public function __clone() {
        
    }

// End __clone()

    /**
     * Unserializing instances of this class is forbidden.
     *
     * @since 1.0.0
     */
    public function __wakeup() {
        
    }

}

?>