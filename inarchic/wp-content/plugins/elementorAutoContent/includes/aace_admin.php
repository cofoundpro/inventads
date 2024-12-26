<?php

if (!defined('ABSPATH'))
    exit;

class aace_admin {

    /**
     * The single instance
     * @var    object
     * @access  private
     * @since    1.0.0
     */
    private static $_instance = null;

    /**
     * The main plugin object.
     * @var    object
     * @access  public
     * @since    1.0.0
     */
    public $parent = null;

    /**
     * Prefix for plugin settings.
     * @var     string
     * @access  public
     * Delete
     * @since   1.0.0
     */
    public $base = '';

    /**
     * Available settings for plugin.
     * @var     array
     * @access  public
     * @since   1.0.0
     */
    public $settings = array();

    public function __construct($parent) {
        $this->parent = $parent;
        $this->dir = dirname($this->parent->file);
        add_action('admin_menu', array($this, 'add_menu_item'));       
		add_action( 'admin_init', array($this, 'register_settings') );
        add_action('admin_print_styles', array($this, 'load_admin_styles'));

    }

  

    public function load_admin_styles() {
      
        if ((isset($_GET['page']) && $_GET['page'] == 'aace_menu')) {         
		    wp_enqueue_style( $this->parent->_token, esc_url($this->parent->assets_url) . 'css/aace_admin.min.css', array(), $this->parent->_version, 'all' );
        }
    }

    /**
     * Add menu to admin
     * @return void
     */
    public function add_menu_item() {
        add_submenu_page( 'options-general.php','A.I Autocontent','A.I Autocontent','manage_options','aace_menu', array($this, 'render_settings_page'));
    }
    function register_settings() {
		add_option( 'aace_openAiApiKey', '');
		add_option( 'aace_temperature', 0.7);
		add_option( 'aace_maxTokens', 2048);
		add_option( 'aace_frequencyPenality', 0);
		add_option( 'aace_presencePenality', 0);
		add_option( 'aace_language', 'English');
		
		
		register_setting( 'aace_options_group', 'aace_openAiApiKey');
		register_setting( 'aace_options_group', 'aace_temperature');
		register_setting( 'aace_options_group', 'aace_maxTokens');
		register_setting( 'aace_options_group', 'aace_frequencyPenality');
		register_setting( 'aace_options_group', 'aace_presencePenality');
		register_setting( 'aace_options_group', 'aace_language');
	 }

     public function render_settings_page(){		
		
		?>
		<div class="privacy-settings-header">
			<div class="privacy-settings-title-section">
			<h1><?php echo esc_html('AI Autocontent for Elementor','aace'); ?></h1>
			</div>

			<nav class="privacy-settings-tabs-wrapper hide-if-no-js" aria-label="Secondary menu">
				<a href="#" class="privacy-settings-tab active" aria-current="true">
				<?php echo esc_html('Settings','aace'); ?>		</a>

					<a href="https://beta.openai.com/account/usage" target="_blank" class="privacy-settings-tab">
						<?php echo esc_html('My OpenAI account','aace'); ?>
					</a>
			</nav>
		</div>

		<h2></h2>
		<hr class="wp-header-end">
		<form method="post" action="options.php" id="aace_settings">
  		<?php settings_fields( 'aace_options_group' ); ?>
		<table>
		<tr valign="top">
		<th scope="row"><label for="aace_openAiApiKey"><?php echo esc_html__('OpenAI API Key','aace') ?></label></th>
		<td>
			<input type="text" id="aace_openAiApiKey" name="aace_openAiApiKey" value="<?php echo get_option('aace_openAiApiKey'); ?>" />
			<p class="description">
				<a href="https://beta.openai.com/account/api-keys" target="_blank"><?php echo esc_html('Click here to create an API Key from OpenAI','aace'); ?></a>
			</p>
		</td>
		</tr>
		<tr valign="top">
		<th scope="row"><label for="aace_temperature"><?php echo esc_html__('Temperature','aace') ?></label></th>
		<td>
			<input type="number" id="aace_temperature" step="0.1" name="aace_temperature" value="<?php echo get_option('aace_temperature'); ?>" />
			<p class="description" >
				<?php echo esc_html('What sampling temperature to use. Higher values means the model will take more risks.','aace'); ?>
			</p>
		</td>
		</tr>
		<tr valign="top">
		<th scope="row"><label for="aace_maxTokens"><?php echo esc_html__('Max tokens','aace') ?></label></th>
		<td>
			<input type="number" id="aace_maxTokens" name="aace_maxTokens" value="<?php echo get_option('aace_maxTokens'); ?>" />
			<p class="description" >
			<?php echo esc_html("The maximum number of tokens to generate in the completion.",'aace'); ?>

			</p>
		</td>
		</tr>

		
		<tr valign="top">
		<th scope="row"><label for="aace_frequencyPenality"><?php echo esc_html__('Frequency penality','aace') ?></label></th>
		<td>
			<input type="number" id="aace_frequencyPenality" step="0.1" name="aace_frequencyPenality" value="<?php echo get_option('aace_frequencyPenality'); ?>" />
			<p class="description" >
			<?php echo esc_html("Number between -2.0 and 2.0. Positive values penalize new tokens based on their existing frequency in the text so far, decreasing the model's likelihood to repeat the same line verbatim.",'aace'); ?>

			</p>
		</td>
		</tr>

		
		
		<tr valign="top">
		<th scope="row"><label for="aace_presencePenality"><?php echo esc_html__('Presence penality','aace') ?></label></th>
		<td>
			<input type="number" id="aace_presencePenality" step="0.1" name="aace_presencePenality" value="<?php echo get_option('aace_presencePenality'); ?>" />
			<p class="description" >
			<?php echo esc_html("Number between -2.0 and 2.0. Positive values penalize new tokens based on whether they appear in the text so far, increasing the model's likelihood to talk about new topics.",'aace'); ?>

			</p>
		</td>
		</tr>

		<tr valign="top">
		<th scope="row"><label for="aace_language"><?php echo esc_html__('Language','aace') ?></label></th>
		<td>
			<select id="aace_language" name="aace_language" value="<?php echo get_option('aace_language'); ?>">
				<option value="English" <?php if(get_option('aace_language') == 'English'){echo 'selected';} ?>><?php echo esc_html__('English','aace') ?></option>
				<option value="French" <?php if(get_option('aace_language') == 'French'){echo 'selected';} ?>><?php echo esc_html__('French','aace') ?></option>
				<option value="German" <?php if(get_option('aace_language') == 'German'){echo 'selected';} ?>><?php echo esc_html__('German','aace') ?></option>
				<option value="Spanish" <?php if(get_option('aace_language') == 'Spanish'){echo 'selected';} ?>><?php echo esc_html__('Spanish','aace') ?></option>
				<option value="Italian" <?php if(get_option('aace_language') == 'Italian'){echo 'selected';} ?>><?php echo esc_html__('Italian','aace') ?></option>
				<option value="Dutch" <?php if(get_option('aace_language') == 'Dutch'){echo 'selected';} ?>><?php echo esc_html__('Dutch','aace') ?></option>
				<option value="Portuguese" <?php if(get_option('aace_language') == 'Portuguese'){echo 'selected';} ?>><?php echo esc_html__('Portuguese','aace') ?></option>
				<option value="Polish" <?php if(get_option('aace_language') == 'Polish'){echo 'selected';} ?>><?php echo esc_html__('Polish','aace') ?></option>
				<option value="Russian" <?php if(get_option('aace_language') == 'Russian'){echo 'selected';} ?>><?php echo esc_html__('Russian','aace') ?></option>
				<option value="Japanese" <?php if(get_option('aace_language') == 'Japanese'){echo 'selected';} ?>><?php echo esc_html__('Japanese','aace') ?></option>
				<option value="Chinese" <?php if(get_option('aace_language') == 'Chinese'){echo 'selected';} ?>><?php echo esc_html__('Chinese','aace') ?></option>
				<option value="Turkish" <?php if(get_option('aace_language') == 'Turkish'){echo 'selected';} ?>><?php echo esc_html__('Turkish','aace') ?></option>
				<option value="Arabic" <?php if(get_option('aace_language') == 'Arabic'){echo 'selected';} ?>><?php echo esc_html__('Arabic','aace') ?></option>
				<option value="Korean" <?php if(get_option('aace_language') == 'Korean'){echo 'selected';} ?>><?php echo esc_html__('Korean','aace') ?></option>
				<option value="Hindi" <?php if(get_option('aace_language') == 'Hindi'){echo 'selected';} ?>><?php echo esc_html__('Hindi','aace') ?></option>
				<option value="Indonesian" <?php if(get_option('aace_language') == 'Indonesian'){echo 'selected';} ?>><?php echo esc_html__('Indonesian','aace') ?></option>
				<option value="Swedish" <?php if(get_option('aace_language') == 'Swedish'){echo 'selected';} ?>><?php echo esc_html__('Swedish','aace') ?></option>
				<option value="Danish" <?php if(get_option('aace_language') == 'Danish'){echo 'selected';} ?>><?php echo esc_html__('Danish','aace') ?></option>
				<option value="Finnish" <?php if(get_option('aace_language') == 'Finnish'){echo 'selected';} ?>><?php echo esc_html__('Finnish','aace') ?></option>
				<option value="Norwegian" <?php if(get_option('aace_language') == 'Norwegian'){echo 'selected';} ?>><?php echo esc_html__('Norwegian','aace') ?></option>
				<option value="Romanian" <?php if(get_option('aace_language') == 'Romanian'){echo 'selected';} ?>><?php echo esc_html__('Romanian','aace') ?></option>
			</select>
			<p class="description" >
				<?php echo esc_html('The texts will be written in the chosen language.','aace'); ?>
			</p>
		</td>
		</tr>

		
		</table>
 			 <?php  submit_button(); ?>
		</form>
		<?php


	}


    /**
     * Main Instance
     *
     *
     * @since 1.0.0
     * @static
     * @return Main instance
     */
    public static function instance($parent) {
        if (is_null(self::$_instance)) {
            self::$_instance = new self($parent);
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
        _doing_it_wrong(__FUNCTION__, '', $this->parent->_version);
    }

// End __clone()

    /**
     * Unserializing instances of this class is forbidden.
     *
     * @since 1.0.0
     */
    public function __wakeup() {
        
    }

// End __wakeup()
}
