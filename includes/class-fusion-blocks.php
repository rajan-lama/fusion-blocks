<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://prosystheme.com
 * @since      1.0.0
 *
 * @package    fusion_blocks
 * @subpackage fusion_blocks/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    fusion_blocks
 * @subpackage fusion_blocks/includes
 * @author     Prosys Theme <prosysthemes@gmail.com>
 */
class fusion_blocks {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      fusion_blocks_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
     * Default role access
     *
     * @var array   Array of default role access
     */
	public static $default_roles_access = array('administrator', 'editor', 'author');
	
	 /**
     * Default active all blocks for new profile
     *
     * @var string  All blocks
     */
    public static $default_active_blocks = 'all';

    /**
     * Default custom styles
     *
     * @var array   Default custom styles for first install
     */
    public static $default_custom_styles = array(
        0 => array(
            'id' => 1,
            'title' => 'Blue message',
            'name' => 'blue-message',
            'identifyColor' => '#3399ff',
            'css' => 'background: none repeat scroll 0 0 #3399ff;
color: #ffffff;
text-shadow: none;
font-size: 14px;
line-height: 24px;
padding: 10px;'
        ),
        1 => array(
            'id' => 2,
            'title' => 'Green message',
            'name' => 'green-message',
            'identifyColor' => '#8cc14c',
            'css' => 'background: none repeat scroll 0 0 #8cc14c;
color: #ffffff;
text-shadow: none;
font-size: 14px;
line-height: 24px;
padding: 10px;'
        ),
        2 => array(
            'id' => 3,
            'title' => 'Orange message',
            'name' => 'orange-message',
            'identifyColor' => '#faa732',
            'css' => 'background: none repeat scroll 0 0 #faa732;
color: #ffffff;
text-shadow: none;
font-size: 14px;
line-height: 24px;
padding: 10px;'
        ),
        3 => array(
            'id' => 4,
            'title' => 'Red message',
            'name' => 'red-message',
            'identifyColor' => '#da4d31',
            'css' => 'background: none repeat scroll 0 0 #da4d31;
color: #ffffff;
text-shadow: none;
font-size: 14px;
line-height: 24px;
padding: 10px;'
        ),
        4 => array(
            'id' => 5,
            'title' => 'Grey message',
            'name' => 'grey-message',
            'identifyColor' => '#53555c',
            'css' => 'background: none repeat scroll 0 0 #53555c;
color: #ffffff;
text-shadow: none;
font-size: 14px;
line-height: 24px;
padding: 10px;'
        ),
        5 => array(
            'id' => 6,
            'title' => 'Left block',
            'name' => 'left-block',
            'identifyColor' => '#ff00ff',
            'css' => 'background: none repeat scroll 0 0px, radial-gradient(ellipse at center center, #ffffff 0%, #f2f2f2 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);
color: #8b8e97;
padding: 10px;
margin: 10px;
float: left;'
        ),
        6 => array(
            'id' => 7,
            'title' => 'Right block',
            'name' => 'right-block',
            'identifyColor' => '#00ddff',
            'css' => 'background: none repeat scroll 0 0px, radial-gradient(ellipse at center center, #ffffff 0%, #f2f2f2 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);
color: #8b8e97;
padding: 10px;
margin: 10px;
float: right;'
        ),
        7 => array(
            'id' => 8,
            'title' => 'Blockquotes',
            'name' => 'blockquotes',
            'identifyColor' => '#cccccc',
            'css' => 'background: none;
border-left: 5px solid #f1f1f1;
color: #8B8E97;
font-size: 14px;
font-style: italic;
line-height: 22px;
padding-left: 15px;
padding: 10px;
width: 60%;
float: left;'
        )
    );

    /**
     * Store original editor settings value, before we modify it to allow/hide blocks based on profiles
     *
     * @var string Original settings
     */
    protected static $original_block_editor_settings;

    /**
     * Activated profile to get activated blocks array
     *
     * @var null    ID profiles
     */
    protected $active_profile = null;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'fusion_blocks_VERSION' ) ) {
			$this->version = fusion_blocks_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'prosys-power-block';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

		//add_action('init', array($this, 'registerPostMeta'));
        //add_action('admin_init', array($this, 'registerStylesScripts'));
        //add_action('wp_enqueue_scripts', array($this, 'registerStylesScriptsFrontend'));
        //add_action('enqueue_block_assets', array($this, 'addEditorAndFrontendStyles'), 9999);
        //add_action('plugins_loaded', array($this, 'advgbBlockLoader'));
        //add_action('rest_api_init', array($this, 'registerRestAPI'));
        //add_action('admin_print_scripts', array($this, 'disableAllAdminNotices')); // Disable all admin notice for page belong to plugin
        //add_action('wp_login_failed', array($this, 'handleLoginFailed'));
        //add_filter('safe_style_css', array($this, 'addAllowedInlineStyles'), 10, 1);
        //add_filter('wp_kses_allowed_html', array($this, 'addAllowedTags'), 1);

        // Front-end ajax
        //add_action('wp_ajax_advgb_contact_form_save', array($this, 'saveContactFormData'));
        //add_action('wp_ajax_nopriv_advgb_contact_form_save', array($this, 'saveContactFormData'));
        //add_action('wp_ajax_advgb_newsletter_save', array($this, 'saveNewsletterData'));
        //add_action('wp_ajax_nopriv_advgb_newsletter_save', array($this, 'saveNewsletterData'));
        //add_action('wp_ajax_advgb_lores_validate', array($this, 'validateLoresForm'));
        //add_action('wp_ajax_nopriv_advgb_lores_validate', array($this, 'validateLoresForm'));

        if (is_admin()) {
            //add_action('admin_init', array($this, 'registerAdvgbProfile'));
            //add_action('admin_footer', array($this, 'initBlocksList'));
            //add_action('admin_footer', array($this, 'addIconSelectionPopupWrapper'));
            //add_action('admin_menu', array($this, 'registerMainMenu'));
            //add_action('admin_menu', array($this, 'registerBlockConfigPage'));
            //add_action('load-toplevel_page_advgb_main', array($this, 'saveAdvgbData'));
            add_filter('block_editor_settings', array($this, 'replaceEditorSettings'), 9999);
            add_action('enqueue_block_editor_assets', array($this, 'addEditorAssets'), 9999);
            //add_filter('mce_external_plugins', array($this, 'addTinyMceExternal'));
            //add_filter('mce_buttons_2', array($this, 'addTinyMceButtons'));
            add_filter('block_categories', array($this, 'addProsysPowerBlocksCategory'));

            // Ajax
            //add_action('wp_ajax_advgb_update_blocks_list', array($this, 'updateBlocksList'));
            //add_action('wp_ajax_advgb_get_users', array($this, 'getUsers'));
            //add_action('wp_ajax_advgb_custom_styles_ajax', array($this, 'customStylesAjax'));
            //add_action('wp_ajax_advgb_delete_profiles', array($this, 'deleteProfiles'));
            //add_action('wp_ajax_advgb_block_config_save', array($this, 'saveBlockConfig'));
        } else {
            // Front-end
            //add_filter('render_block_data', array($this, 'contentPreRender'));
            //add_filter('the_content', array($this, 'addFrontendContentAssets'), 9);
        }
	}

	/**
     * Disable all admin notices in our page
     *
     * @return void
     */
    public function disableAllAdminNotices()
    {
        global $wp_filter;
        // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- No action, nonce is not required
        if ((!empty($_GET['page']) && in_array($_GET['page'], array('advgb_main')))) {
            if (is_user_admin()) {
                if (isset($wp_filter['user_admin_notices'])) {
                    unset($wp_filter['user_admin_notices']);
                }
            } elseif (isset($wp_filter['admin_notices'])) {
                unset($wp_filter['admin_notices']);
            }
            if (isset($wp_filter['all_admin_notices'])) {
                unset($wp_filter['all_admin_notices']);
            }
        }
    }

	
	 /**
     * Replaces if needed editor settings to allow/hide blocks
     *
     * @param array $settings Editor settings
     *
     * @return array
     */
    public function replaceEditorSettings($settings)
    {
        self::$original_block_editor_settings = $settings;

        $advgb_blocks_vars = array();
        $advgb_blocks_vars['blocks'] = $this->getUserBlocksForGutenberg();

        /*if (is_array($settings['allowedBlockTypes'])) {
            // Remove blocks from the list that are not allowed
            // Note that we do not add missing blocks, because another plugin may have used the hook to remove some of them
            foreach ($settings['allowedBlockTypes'] as $key => $type) {
                if (in_array($type, $advgb_blocks_vars['blocks']['inactive_blocks'])) {
                    unset($settings['allowedBlockTypes'][$key]);
                }
            }
        } elseif ($settings['allowedBlockTypes'] === true) {
            // All was allowed, only return what the profile allows

            if (count($advgb_blocks_vars['blocks']['active_blocks']) || count($advgb_blocks_vars['blocks']['inactive_blocks'])) {
                $settings['allowedBlockTypes'] = $advgb_blocks_vars['blocks']['active_blocks'];
            }
        }
*/
        $current_screen = get_current_screen();
        if (method_exists($current_screen, 'is_block_editor') && $current_screen->is_block_editor()
            && (!defined('GUTENBERG_VERSION') || (defined('GUTENBERG_VERSION') && version_compare(GUTENBERG_VERSION, '5.3.0', '>=')))) {
            // WP 5 and Gutenberg 5.3.0 fires enqueue_block_editor_assets before block_editor_settings, Gutenberg plugin do the contrary
            // Gutenberg WP5 core feature is used and we are in the block editor page, we must enqueue our assets after retrieving editor settings
            $this->addEditorAssets(true);
        }

        return $settings;
    }

	/**
     * Enqueue styles and scripts for gutenberg
     *
     * @param boolean $force_loading Should force loading assets
     *
     * @return void
     */
    public function addEditorAssets($force_loading = false)
    {
        $current_screen = get_current_screen();
        if (!$force_loading && method_exists($current_screen, 'is_block_editor') && $current_screen->is_block_editor()
            && (!defined('GUTENBERG_VERSION') || (defined('GUTENBERG_VERSION') && version_compare(GUTENBERG_VERSION, '5.3.0', '>=')))) {
            // This function will be called manually in the block_editor_settings filter
            // WP 5 and Gutenberg 5.3.0 fires enqueue_block_editor_assets before block_editor_settings, Gutenberg plugin do the contrary
            return;
        }

       /* wp_enqueue_script(
            'advgb_blocks',
            plugins_url('assets/blocks/blocks.js', dirname(__FILE__)),
            array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-data', 'wp-editor', 'wp-plugins' ),
            ADVANCED_GUTENBERG_VERSION,
            true
        );*/

        // Include needed JS libraries
        wp_enqueue_script('jquery-ui-tabs');
        wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_script('slick_js');

        // Include needed CSS styles
        wp_enqueue_style('material_icon_font');
        wp_enqueue_style('material_icon_font_custom');
        wp_enqueue_style('slick_style');
        wp_enqueue_style('slick_theme_style');

        $advgb_blocks_vars = array();
        $advgb_blocks_vars['blocks'] = $this->getUserBlocksForGutenberg();

        global $post;
        if ($post) {
            $advgb_blocks_vars['post_id'] = $post->ID;
            $advgb_blocks_vars['post_type'] = $post->post_type;
        }

        $advgb_blocks_vars['original_settings'] = self::$original_block_editor_settings;
        $advgb_blocks_vars['ajaxurl'] = admin_url('admin-ajax.php');
        $advgb_blocks_vars['nonce'] = wp_create_nonce('advgb_update_blocks_list');
        wp_localize_script('advgb_blocks', 'advgb_blocks_vars', $advgb_blocks_vars);

        // Set variable needed by blocks editor
        $avatarHolder       = plugins_url('assets/blocks/testimonial/avatar-placeholder.png', ADVANCED_GUTENBERG_PLUGIN);
        $default_thumb      = plugins_url('assets/blocks/recent-posts/recent-post-default.png', ADVANCED_GUTENBERG_PLUGIN);
        $image_holder       = plugins_url('assets/blocks/advimage/imageholder.svg', ADVANCED_GUTENBERG_PLUGIN);
        $login_logo         = plugins_url('assets/blocks/login-form/login.svg', ADVANCED_GUTENBERG_PLUGIN);
        $reg_logo           = plugins_url('assets/blocks/login-form/reg.svg', ADVANCED_GUTENBERG_PLUGIN);
        $saved_settings     = get_option('advgb_settings');
        $custom_styles_data = get_option('advgb_custom_styles');
        $recaptcha_config   = get_option('advgb_recaptcha_config');
        $recaptcha_config   = $recaptcha_config !== false ? $recaptcha_config : array('recaptcha_enable' => 0);
        $blocks_icon_color  = isset($saved_settings['blocks_icon_color']) ? $saved_settings['blocks_icon_color'] : '';
        $rp_default_thumb   = isset($saved_settings['rp_default_thumb']) ? $saved_settings['rp_default_thumb'] : array('url' => $default_thumb, 'id' => 0);
        $icons              = array();
       // $icons['material']  = file_get_contents(plugin_dir_path(__DIR__) . 'assets/css/fonts/codepoints.json');
        $icons['material']  = json_decode($icons['material'], true);

        wp_localize_script('wp-blocks', 'advgbBlocks', array(
            'color' => $blocks_icon_color,
            'post_thumb' => $rp_default_thumb['url'],
            'default_thumb' => $default_thumb,
            'image_holder' => $image_holder,
            'avatarHolder' => $avatarHolder,
            'login_logo' => $login_logo,
            'reg_logo' => $reg_logo,
            'home_url' => home_url(),
            'config_url' => admin_url('admin.php?page=advgb_main'),
            'customStyles' => !$custom_styles_data ? array() : $custom_styles_data,
            'captchaEnabled' => $recaptcha_config['recaptcha_enable'],
            'pluginUrl' => plugins_url('', ADVANCED_GUTENBERG_PLUGIN),
            'iconList' => $icons,
            'registerEnabled' => get_option('users_can_register'),
        ));

        // Setup default config data for blocks
        $blocks_config_saved = get_option('advgb_blocks_default_config');
        $blocks_config_saved = $blocks_config_saved !== false ? $blocks_config_saved : array();
        wp_localize_script('wp-blocks', 'advgbDefaultConfig', $blocks_config_saved);
	}
	
	
    /**
     * Enqueue styles for gutenberg editor and front-end
     *
     * @return mixed
     */
    public function addEditorAndFrontendStyles()
    {
        $custom_styles_url = wp_get_upload_dir();
        $custom_styles_url = $custom_styles_url['baseurl'] . '/advgb/';
        wp_enqueue_style(
            'advgb_custom_styles',
            $custom_styles_url . 'custom_styles.css'
        );
        wp_enqueue_style('dashicons');

        if (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG === true) {
            wp_enqueue_style(
                'advgb_blocks_styles',
                plugins_url('assets/css/blocks_styles/blocks.css', dirname(__FILE__))
            );
        } else {
            wp_enqueue_style(
                'advgb_blocks_styles_min',
                plugins_url('assets/css/blocks_styles/blocks.min.css', dirname(__FILE__))
            );
        }

        wp_enqueue_script(
            'advgb_blocks_frontend_scripts',
            plugins_url('assets/blocks/frontend.js', dirname(__FILE__))
        );

        if (!function_exists('advgbAddScriptAttributes')) {
            /**
             * Add attributes to script tag
             *
             * @param string $tag    Script tag
             * @param string $handle Handle name
             *
             * @return mixed
             */
            function advgbAddScriptAttributes($tag, $handle)
            {
                if ('advgb_map_api' === $handle) {
                    return str_replace(' src', ' defer src', $tag);
                } elseif ('advgb_recaptcha_js' === $handle) {
                    return str_replace(' src', ' async defer src', $tag);
                }
                return $tag;
            }
        }
        add_filter('script_loader_tag', 'advgbAddScriptAttributes', 10, 2);

        $saved_settings = get_option('advgb_settings');
        if (isset($saved_settings['google_api_key']) && !empty($saved_settings['google_api_key'])) {
            wp_enqueue_script(
                'advgb_map_api',
                'https://maps.googleapis.com/maps/api/js?key='. $saved_settings['google_api_key']
            );
        }

        $recaptcha_config = get_option('advgb_recaptcha_config');
        if (!is_admin() && isset($recaptcha_config['recaptcha_enable']) && $recaptcha_config['recaptcha_enable']) {
            $lang = $recaptcha_config['recaptcha_language'] ? '&hl='.$recaptcha_config['recaptcha_language'] : '';
            wp_enqueue_script(
                'advgb_recaptcha_js',
                'https://www.google.com/recaptcha/api.js?onload=advgbRecaptchaInit&render=explicit' . $lang
            );

            if (isset($recaptcha_config['recaptcha_site_key']) && $recaptcha_config['recaptcha_site_key']) {
                wp_enqueue_script(
                    'advgb_recaptcha_init_js',
                    plugins_url('assets/js/recaptcha.js', dirname(__FILE__))
                );

                wp_localize_script('advgb_recaptcha_init_js', 'advgbGRC', array(
                    'site_key' => $recaptcha_config['recaptcha_site_key'],
                    'theme' => $recaptcha_config['recaptcha_theme'],
                ));
            }
        }
	}
	
	/**
     * Update the blocks list for first time install
     *
     * @return void
     */
    public function initBlocksList()
    {
        if (get_option('advgb_blocks_list') === false
            || (defined('GUTENBERG_VERSION') && version_compare(get_option('advgb_gutenberg_version'), GUTENBERG_VERSION, '<'))) {
            $advgb_nonce = wp_create_nonce('advgb_update_blocks_list');
            wp_enqueue_script('wp-blocks');
            wp_enqueue_script('wp-element');
            wp_enqueue_script('wp-data');
            wp_enqueue_script('wp-components');
            wp_enqueue_script('wp-block-library');
            wp_enqueue_script('wp-editor');
            do_action('enqueue_block_editor_assets');
            wp_enqueue_script(
                'advgb_update_list',
                plugins_url('assets/js/update-block-list.js', dirname(__FILE__)),
                array('jquery'),
                ADVANCED_GUTENBERG_VERSION
            );

            $blockCategories = array();
            if (function_exists('gutenberg_get_block_categories')) {
                $blockCategories = gutenberg_get_block_categories(get_post());
            } elseif (function_exists('get_block_categories')) {
                $blockCategories = get_block_categories(get_post());
            }

            wp_add_inline_script(
                'wp-blocks',
                sprintf('wp.blocks.setCategories( %s );', wp_json_encode($blockCategories)),
                'after'
            );

            wp_localize_script('advgb_update_list', 'updateListNonce', array('nonce' => $advgb_nonce));
        }
    }

	
    /**
     * Load block that required server side render
     *
     * @return void
     */
    public function advgbBlockLoader()
    {
        // Block Recent Posts
        require_once(plugin_dir_path(dirname(__FILE__)) . 'assets/blocks/recent-posts/block.php');
    }

    /**
     * Register REST API
     *
     * @return void
     */
    public function registerRestAPI()
    {
        // Add author info
        register_rest_field(
            'post',
            'author_meta',
            array(
                'get_callback' => array($this, 'getAuthorInfo'),
                'update_callback' => null,
                'schema' => null,
            )
        );

        // Add post featured img
        register_rest_field(
            'post',
            'featured_img',
            array(
                'get_callback' => array($this, 'getFeaturedImg'),
                'update_callback' => null,
                'schema' => null,
            )
        );

        // Register router to get data for Woo Products block
        if (class_exists('WC_REST_Products_Controller')) {
            include_once(plugin_dir_path(dirname(__FILE__)) . 'assets/blocks/woo-products/controller.php');
            $controller = new AdvgbProductsController();
            $controller->register_routes();
        }
	}
	
	
    /**
     * Get post author info for REST API
     *
     * @param array $object API Object
     *
     * @return mixed
     */
    public function getAuthorInfo($object)
    {
        // Get the author name
        $author['display_name'] = get_the_author_meta('display_name', $object['author']);

        // Get the author link
        $author['author_link'] = get_author_posts_url($object['author']);

        // Return the author data
        return $author;
    }

    /**
     * Get featured image link for REST API
     *
     * @param array $object API Object
     *
     * @return mixed
     */
    public function getFeaturedImg($object)
    {
        $featured_img = wp_get_attachment_image_src(
            $object['featured_media'],
            'medium',
            false
        );

        return $featured_img[0];
    }

    /**
     * Ajax to update blocks list
     *
     * @return mixed
     */
    public function updateBlocksList()
    {
        if (!current_user_can('activate_plugins')) {
            wp_send_json('', 400);
        }

        if (!wp_verify_nonce($_POST['nonce'], 'advgb_update_blocks_list')
            && !wp_verify_nonce($_POST['nonce'], 'advgb_nonce')
        ) {
            wp_send_json('', 400);
        }

        /**
         * Remove slashes on svg icon
         *
         * @param array $block Block to remove slashes
         *
         * @return mixed
         */
        function removeSlashes(array $block)
        {
            $block['icon'] = htmlentities(stripslashes($block['icon']), ENT_QUOTES);
            return $block;
        }

        if (is_array($_POST['blocksList'])) {
            $blocksList  = array_map('removeSlashes', $_POST['blocksList']);
        } else {
            $blocksList  = json_decode(stripslashes($_POST['blocksList']));
        }

        $savedBlocksList = get_option('advgb_blocks_list');
        if (!is_array($savedBlocksList)) {
            $savedBlocksList = array();
        }

        $blocksListName = array();
        $savedBlocksListName = array();

        foreach ($blocksList as &$block) {
            // Convert object to array
            $block = (array)$block;
            $blocksListName[] = $block['name'];
        }

        foreach ($savedBlocksList as $block) {
            // Convert object to array
            $block = (array)$block;
            $savedBlocksListName[] = $block['name'];
        }

        // Check if we have new blocks installed
        $newBlocks = array_diff($blocksListName, $savedBlocksListName);
        if (count($newBlocks)) {
            update_option('advgb_blocks_list', $blocksList);
        }

        // Check that profile blocks are up to date
        $args     = array(
            'fields'    => 'ids',
            'post_type' => 'advgb_profiles',
            'publish'   => true
        );

        $postIDs = get_posts($args);

        foreach ($postIDs as $postID) {
            $allBlocksMeta = get_post_meta($postID, 'blocks', true);
            if (is_array($allBlocksMeta) && is_array($allBlocksMeta['active_blocks']) && is_array($allBlocksMeta['inactive_blocks'])) {
                $allProfileBlocks = array_merge($allBlocksMeta['active_blocks'], $allBlocksMeta['inactive_blocks']);

                $newAllowedBlocks = array_diff($blocksListName, $allProfileBlocks);
                $newAllowedBlocks = array_unique($newAllowedBlocks);

                if ($newAllowedBlocks) {
                    $allBlocksMeta['active_blocks'] = array_merge($allBlocksMeta['active_blocks'], $newAllowedBlocks);
                    update_post_meta($postID, 'blocks', $allBlocksMeta);
                }
            }
        }

        if ((defined('GUTENBERG_VERSION')
            && version_compare(get_option('advgb_gutenberg_version'), GUTENBERG_VERSION, '<'))
        ) {
            update_option('advgb_gutenberg_version', GUTENBERG_VERSION);
        }


        wp_send_json(array(
            'blocks_list' => $blocksList
        ), 200);
    }

    /**
     * Ajax to get list of users
     *
     * @return boolean,void     Return false if failure, echo json on success
     */
    public function getUsers()
    {
        // Check users permissions
        if (! current_user_can('create_advgb_profiles')) {
            wp_send_json(__('No permission!', 'advanced-gutenberg'), 403);
            return false;
        }

        // phpcs:disable WordPress.Security.NonceVerification.Recommended -- View request, no action
        $usersearch     = isset($_REQUEST['search']) ? wp_unslash(trim($_REQUEST['search'])) : '';
        $role           = isset($_REQUEST['role']) ? $_REQUEST['role'] : '';
        $users_per_page = 20;
        $pagenum        = 1;
        if ($role === 'none') {
            $args_all = array(
                'include' => wp_get_users_with_no_role(),
                'search'  => $usersearch,
                'fields'  => 'all_with_meta'
            );
        } else {
            $args_all = array(
                'role'   => $role,
                'search' => $usersearch,
                'fields' => 'all_with_meta'
            );
        }
        if ($args_all['search'] !== '') {
            $args_all['search'] = '*' . $args_all['search'] . '*';
        }

        $total_users = count(get_users($args_all));
        $total_pages = (int)ceil($total_users / $users_per_page);
        if (isset($_REQUEST['paged'])) {
            if ($_REQUEST['paged'] === 'first') {
                $pagenum = 1;
            } elseif ($_REQUEST['paged'] === 'last') {
                $pagenum = (int)$total_pages;
            } else {
                $pagenum = (int)$_REQUEST['paged'];
            }
        }
        // phpcs:enable
        $paged = max(1, $pagenum);

        if ($role === 'none') {
            $args = array(
                'number'  => $users_per_page,
                'offset'  => ($paged - 1) * $users_per_page,
                'include' => wp_get_users_with_no_role(),
                'search'  => $usersearch,
                'fields'  => 'all_with_meta'
            );
        } else {
            $args = array(
                'number' => $users_per_page,
                'offset' => ($paged - 1) * $users_per_page,
                'role'   => $role,
                'search' => $usersearch,
                'fields' => 'all_with_meta'
            );
        }

        if ($args['search'] !== '') {
            $args['search'] = '*' . $args['search'] . '*';
        }

        // Query the user IDs for this page
        $wp_user_search = get_users($args);

        $users_list = '';
        $pages_list = '';

        if (count($wp_user_search)) {
            foreach ($wp_user_search as $userid => $user_object) {
                $users_list .= '<tr>';
                $users_list .= '<td class="select-box">';
                $users_list .= '<input class="ju-checkbox" type="checkbox" name="advgb-users[]" value="' . $userid . '" />';
                $users_list .= '</td>';
                $users_list .= '<td class="name column-name">';
                $users_list .= '<span>' . $user_object->display_name . '</span>';
                $users_list .= '</td>';
                $users_list .= '<td class="username column-username">';
                $users_list .= '<strong>' . $user_object->user_login . '</strong>';
                $users_list .= '</td>';
                $users_list .= '<td class="email column-email">' . $user_object->user_email . '</td>';

                $role_list = array();
                global $wp_roles;
                foreach ($user_object->roles as $role) {
                    if (isset($wp_roles->role_names[ $role ])) {
                        $role_list[ $role ] = translate_user_role($wp_roles->role_names[ $role ]);
                    }
                }

                if (empty($role_list)) {
                    $role_list['none'] = _x('None', 'no user roles', 'advanced-gutenberg');
                }
                $roles_list = implode(', ', $role_list);

                $users_list .= '<td class="role column-role">' . $roles_list . '</td>';
                $users_list .= '</tr>';
            }
        } else {
            $users_list .= '<tr><td colspan="5"> ';
            $users_list .= __('No users found.', 'advanced-gutenberg');
            $users_list .= '</td></tr>';
        }

        $doneLeft = false;
        $doneRight = false;
        $skipLeft = false;
        $skipRight = false;
        if ($total_pages > 1) {
            for ($i = 1; $i <= $total_pages; $i ++) {
                if ($i < $pagenum - 2) {
                    $skipLeft = true;
                } elseif ($i > $pagenum + 2) {
                    $skipRight = true;
                } else {
                    $skipLeft  = false;
                    $skipRight = false;
                }
                if ($i === 1) {
                    if ($pagenum === 1) {
                        $pages_list .= '<i class="dashicons dashicons-controls-skipback" id="first-page"></i>';
                    } else {
                        $pages_list .= '<a class="dashicons dashicons-controls-skipback" id="first-page" ';
                        $pages_list .= 'title="' . __('First page', 'advanced-gutenberg') . '"></a>';
                    }
                }
                if (! $skipLeft && ! $skipRight) {
                    if ($i === $pagenum) {
                        $pages_list .= '<strong>' . $i . '</strong>';
                    } else {
                        $pages_list .= '<a class="switch-page">' . $i . '</a>';
                    }
                } elseif ($skipLeft) {
                    if (! $doneLeft) {
                        $pages_list .= '<span>...</span>';
                        $doneLeft   = true;
                    }
                } elseif ($skipRight) {
                    if (! $doneRight) {
                        $pages_list .= '<span>...</span>';
                        $doneRight  = true;
                    }
                }

                if ($i === $total_pages) {
                    if ($pagenum === $total_pages) {
                        $pages_list .= '<i class="dashicons dashicons-controls-skipforward" id="last-page"></i>';
                    } else {
                        $pages_list .= '<a class="dashicons dashicons-controls-skipforward" id="last-page" ';
                        $pages_list .= 'title="' . __('Last page', 'advanced-gutenberg') . '"></a>';
                    }
                }
            }
        }
        $response = array('users_list' => $users_list, 'pages_list' => $pages_list);
        wp_send_json($response);
    }

    /**
     * Ajax for custom styles
     *
     * @return boolean,void     Return false if failure, echo json on success
     */
    public function customStylesAjax()
    {
        // Check users permissions
        if (!current_user_can('activate_plugins')) {
            wp_send_json(__('No permission!', 'advanced-gutenberg'), 403);
            return false;
        }
        $regex = '/^[a-zA-Z0-9_\-]+$/';
        $regexWithSpaces = '/^[\p{L}\p{N}_\- ]+$/u';

        if (!wp_verify_nonce($_POST['nonce'], 'advgb_settings_nonce')) {
            wp_send_json(__('Invalid nonce token!', 'advanced-gutenberg'), 400);
        }

        $check_exist = get_option('advgb_custom_styles');
        if ($check_exist === false) {
            update_option('advgb_custom_styles', $this::$default_custom_styles);
        }

        $custom_style_data = get_option('advgb_custom_styles');
        $task = isset($_POST['task']) ? $_POST['task'] : '';
        if ($task === '') {
            return false;
        } elseif ($task === 'new') {
            $new_style_id = end($custom_style_data);
            $new_style_id = $new_style_id['id'] + 1;
            $new_style_array = array(
                'id' => $new_style_id,
                'title' => __('New class', 'advanced-gutenberg'),
                'name' => __('new-class', 'advanced-gutenberg'),
                'css' => '',
                'identifyColor' => '#000000'
            );
            array_push($custom_style_data, $new_style_array);
            update_option('advgb_custom_styles', $custom_style_data);
            wp_send_json($new_style_array);
        } elseif ($task === 'delete') {
            $custom_style_data_delete = get_option('advgb_custom_styles');
            $style_id = (int)$_POST['id'];
            $new_style_deleted_array = array();
            $done = false;
            foreach ($custom_style_data_delete as $data) {
                if ($data['id'] === $style_id) {
                    $done = true;
                    continue;
                }
                array_push($new_style_deleted_array, $data);
            }
            update_option('advgb_custom_styles', $new_style_deleted_array);
            if ($done) {
                wp_send_json(array('id' => $style_id), 200);
            }
        } elseif ($task === 'copy') {
            $data_saved = get_option('advgb_custom_styles');
            $style_id = (int)$_POST['id'];
            $new_style_copied_array = get_option('advgb_custom_styles');
            $copied_styles = array();
            $new_id = end($new_style_copied_array);
            foreach ($data_saved as $data) {
                if ($data['id'] === $style_id) {
                    $copied_styles = array(
                        'id' => $new_id['id'] + 1,
                        'title' => sanitize_text_field($data['title']),
                        'name' => sanitize_text_field($data['name']),
                        'css' => $data['css'],
                        'identifyColor' => $data['identifyColor'],
                    );

                    array_push($new_style_copied_array, $copied_styles);
                }
            }
            update_option('advgb_custom_styles', $new_style_copied_array);
            wp_send_json($copied_styles);
        } elseif ($task === 'preview') {
            $style_id = (int)$_POST['id'];
            $data_saved = get_option('advgb_custom_styles');
            $get_style_array = array();
            foreach ($data_saved as $data) {
                if ($data['id'] === $style_id) {
                    foreach ($data as $key => $value) {
                        $data[$key] = esc_html($value);
                    }
                    $get_style_array = $data;
                }
            }
            if (!empty($get_style_array)) {
                wp_send_json($get_style_array);
            } else {
                wp_send_json(false, 404);
            }
        } elseif ($task === 'style_save') {
            $style_id = (int)$_POST['id'];
            $new_classname = sanitize_text_field($_POST['name']);
            $new_identify_color = sanitize_text_field($_POST['mycolor']);
            $new_css = $_POST['mycss'];
            // Validate new name
            if (!preg_match($regex, $new_classname)) {
                wp_send_json('Invalid characters, please enter another!', 403);
                return false;
            }
            $data_saved = get_option('advgb_custom_styles');
            $new_data_array = array();
            foreach ($data_saved as $data) {
                if ($data['id'] === $style_id) {
                    $data['name'] = $new_classname;
                    $data['css'] = $new_css;
                    $data['identifyColor'] = $new_identify_color;
                }
                array_push($new_data_array, $data);
            }
            update_option('advgb_custom_styles', $new_data_array);
        } elseif ($task === 'edit') {
            $new_title = sanitize_text_field($_POST['title']);
            $style_id = (int)$_POST['id'];
            if (!preg_match($regexWithSpaces, $new_title)) {
                wp_send_json('Invalid characters, please enter another!', 403);
                return false;
            }
            $data_saved = get_option('advgb_custom_styles');
            $new_data_array = array();
            foreach ($data_saved as $data) {
                if ($data['id'] === $style_id) {
                    $data['title'] = $new_title;
                }
                array_push($new_data_array, $data);
            }
            update_option('advgb_custom_styles', $new_data_array);
            wp_send_json(array('title' => $new_title), 200);
        } else {
            wp_send_json(null, 404);
        }
    }

    /**
     * Ajax for delete profiles
     *
     * @return boolean,void     Return false if failure, echo json on success
     */
    public function deleteProfiles()
    {
        // Check users permissions
        if (!current_user_can('delete_pages')) {
            wp_send_json(__('No permission!', 'advanced-gutenberg'), 403);
            return false;
        }

        if (!wp_verify_nonce($_POST['pNonce'], 'advgb_profiles_nonce')) {
            wp_send_json(__('Fail to verify nonce!', 'advanced-gutenberg'), 400);
            return false;
        };

        $profiles_to_delete = $_POST['ids'];
        if (count($profiles_to_delete)) {
            $deleted = array();
            foreach ($profiles_to_delete as $profile) {
                if (wp_delete_post($profile)) {
                    array_push($deleted, $profile);
                }
            }

            wp_send_json(array('deleted' => $deleted), 200);
        }
    }

    /**
     * Ajax for saving block default config
     *
     * @return boolean,void     Return false if failure, echo json on success
     */
    public function saveBlockConfig()
    {
        // Check users permissions
        if (!current_user_can('activate_plugins')) {
            wp_send_json(__('No permission!', 'advanced-gutenberg'), 403);
            return false;
        }

        if (!wp_verify_nonce($_POST['nonce'], 'advgb_block_config_nonce')) {
            wp_send_json(__('Invalid nonce token!', 'advanced-gutenberg'), 400);
        }

        $blocks_config_saved = get_option('advgb_blocks_default_config');
        if ($blocks_config_saved === false) {
            $blocks_config_saved = array();
        }

        $blockType = sanitize_text_field($_POST['blockType']);
        $settings = $_POST['settings'];

        foreach ($settings as $key => $setting) {
            foreach ($setting as $k => $option) {
                $option = sanitize_text_field($option);
                if (is_numeric($option)) {
                    if ($k !== 'lat' && $k !== 'lng') {
                        $option = floatval($option);
                    }
                }

                $settings[$key][$k] = $option;
            }
        }

        // Modify settings for social links blocks config
        if ($blockType === 'advgb-social-links') {
            $items = array();
            $settings[$blockType]['items'] = array();

            foreach ($settings[$blockType] as $k => $option) {
                if (strpos($k, '.')) {
                    $item = explode('.', $k);
                    $items[$item[0]][$item[1]] = $option;
                }
            }

            foreach ($items as $item) {
                array_push($settings[$blockType]['items'], $item);
            }
        }

        $blocks_config_saved[$blockType] = $settings[$blockType];

        update_option('advgb_blocks_default_config', $blocks_config_saved);
        wp_send_json(true, 200);
    }

    /**
     * Ajax for saving contact form data
     *
     * @return boolean,void     Return false if failure, echo json on success
     */
    public function saveContactFormData()
    {
        // phpcs:disable -- WordPress.Security.NonceVerification.Recommended - frontend form, no nonce
        if (!isset($_POST['action'])) {
            wp_send_json(__('Bad Request!', 'advanced-gutenberg'), 400);
            return false;
        }

        if (isset($_POST['captcha'])) {
            $recaptcha_config  = get_option('advgb_recaptcha_config');
            if (!isset($recaptcha_config['recaptcha_secret_key']) || !isset($recaptcha_config['recaptcha_site_key'])) {
                wp_send_json(__('Server error. Try again later!', 'advanced-gutenberg'), 500);
            }

            $captcha = $_POST['captcha'];
            $secret_key = $recaptcha_config['recaptcha_secret_key'];
            $verify = wp_remote_get("https://www.google.com/recaptcha/api/siteverify?secret={$secret_key}&response={$captcha}");

            if (!is_array($verify) || !isset($verify['body'])) {
                wp_send_json(__('Cannot validate captcha', 'advanced-gutenberg'), 400);
            }

            $verified = json_decode($verify['body']);
            if (!$verified->success) {
                wp_send_json(__('Captcha validation error', 'advanced-gutenberg'), 400);
            }
        }

        $contacts_saved = get_option('advgb_contacts_saved');
        if (!$contacts_saved) $contacts_saved = array();

        $contact_data = array(
            'date'  => sanitize_text_field($_POST['submit_date']),
            'name'  => sanitize_text_field($_POST['contact_name']),
            'email' => sanitize_email($_POST['contact_email']),
            'msg'   => sanitize_textarea_field($_POST['contact_msg']),
        );

        array_push($contacts_saved, $contact_data);

        $saved = update_option('advgb_contacts_saved', $contacts_saved);
        if ($saved) {
            $saved_settings = get_option('advgb_email_sender');
            $website_title  = get_option('blogname');
            $admin_email    = get_option('admin_email');
            $sender_name    = isset($saved_settings['contact_form_sender_name']) && $saved_settings['contact_form_sender_name'] ? $saved_settings['contact_form_sender_name'] : $website_title;
            $sender_email   = isset($saved_settings['contact_form_sender_email']) && $saved_settings['contact_form_sender_email'] ? $saved_settings['contact_form_sender_email'] : $admin_email;
            $email_title    = isset($saved_settings['contact_form_email_title']) && $saved_settings['contact_form_email_title'] ? $saved_settings['contact_form_email_title'] : __('Website Contact', 'advanced-gutenberg');
            $email_receiver = isset($saved_settings['contact_form_email_receiver']) && $saved_settings['contact_form_email_receiver'] ? $saved_settings['contact_form_email_receiver'] : $admin_email;
            $email_header[] = 'Content-Type: text/html; charset=UTF-8';
            $email_header[] = 'From: '.$sender_name.' <'.$sender_email.'>';
            $msg = '<html><body>';
            $msg .= '<h2>'. __('You have received a contact from your website.', 'advanced-gutenberg') .'</h2>';
            $msg .= '<ul>';
            $msg .= '<li><strong>'. __('Name', 'advanced-gutenberg') .': </strong>'. $contact_data['name'] .'</li>';
            $msg .= '<li><strong>'. __('Email', 'advanced-gutenberg') .': </strong>'. $contact_data['email'] .'</li>';
            $msg .= '<li><strong>'. __('Date', 'advanced-gutenberg') .': </strong>'. $contact_data['date'] .'</li>';
            $msg .= '<li><strong>'. __('Message', 'advanced-gutenberg') .': </strong>'. $contact_data['msg'] .'</li>';
            $msg .= '</ul>';
            $msg .= '</body></html>';

            wp_mail($email_receiver, $email_title, $msg, $email_header);
            wp_send_json($contact_data, 200);
        } else {
            wp_send_json(__('Error while sending form. Try again!', 'advanced-gutenberg'), 500);
        }
        // phpcs:enable
    }

    /**
     * Ajax for saving newsletter form data
     *
     * @return boolean,void     Return false if failure, echo json on success
     */
    public function saveNewsletterData()
    {
        // phpcs:disable -- WordPress.Security.NonceVerification.Recommended - frontend form, no nonce
        if (!isset($_POST['action'])) {
            wp_send_json(__('Bad Request!', 'advanced-gutenberg'), 400);
            return false;
        }

        if (isset($_POST['captcha'])) {
            $recaptcha_config  = get_option('advgb_recaptcha_config');
            if (!isset($recaptcha_config['recaptcha_secret_key']) || !isset($recaptcha_config['recaptcha_site_key'])) {
                wp_send_json(__('Server error. Try again later!', 'advanced-gutenberg'), 500);
            }

            $captcha = $_POST['captcha'];
            $secret_key = $recaptcha_config['recaptcha_secret_key'];
            $verify = wp_remote_get("https://www.google.com/recaptcha/api/siteverify?secret={$secret_key}&response={$captcha}");

            if (!is_array($verify) || !isset($verify['body'])) {
                wp_send_json(__('Cannot validate captcha', 'advanced-gutenberg'), 400);
            }

            $verified = json_decode($verify['body']);
            if (!$verified->success) {
                wp_send_json(__('Captcha validation error', 'advanced-gutenberg'), 400);
            }
        }

        $newsletter_saved = get_option('advgb_newsletter_saved');
        if (!$newsletter_saved) $newsletter_saved = array();

        $newsletter_data = array(
            'date'  => sanitize_text_field($_POST['submit_date']),
            'fname' => sanitize_text_field($_POST['f_name']),
            'lname' => sanitize_text_field($_POST['l_name']),
            'email' => sanitize_email($_POST['email']),
        );

        array_push($newsletter_saved, $newsletter_data);

        update_option('advgb_newsletter_saved', $newsletter_saved);
        wp_send_json($newsletter_data, 200);
        // phpcs:enable
    }

    /**
     * Ajax for validating login/register form captcha
     *
     * @return boolean,void     Return false if failure, echo json on success
     */
    public function validateLoresForm()
    {
        // phpcs:disable -- WordPress.Security.NonceVerification.Recommended - frontend form, no nonce
        if (!isset($_POST['action'])) {
            wp_send_json(__('Bad Request!', 'advanced-gutenberg'), 400);
            return false;
        }

        if (isset($_POST['captcha'])) {
            $recaptcha_config  = get_option('advgb_recaptcha_config');
            if (!isset($recaptcha_config['recaptcha_secret_key']) || !isset($recaptcha_config['recaptcha_site_key'])) {
                wp_send_json(__('Server error. Try again later!', 'advanced-gutenberg'), 500);
            }

            $captcha = $_POST['captcha'];
            $secret_key = $recaptcha_config['recaptcha_secret_key'];
            $verify = wp_remote_get("https://www.google.com/recaptcha/api/siteverify?secret={$secret_key}&response={$captcha}");

            if (!is_array($verify) || !isset($verify['body'])) {
                wp_send_json(__('Cannot validate captcha', 'advanced-gutenberg'), 400);
            }

            $verified = json_decode($verify['body']);
            if (!$verified->success) {
                wp_send_json(__('Captcha validation error', 'advanced-gutenberg'), 400);
            }

            wp_send_json(__('Captcha validated', 'advanced-gutenberg'), 200);
        }

        wp_send_json(__('Captcha is empty', 'advanced-gutenberg'), 400);
        // phpcs:enable
    }

    /**
     * Handle failed login from our login form and redirect to that login page
     *
     * @return void
     */
    public function handleLoginFailed()
    {
        $referrer = $_SERVER['HTTP_REFERER'];
        $from_advgb = isset($_POST['advgb_login_form']); // phpcs:ignore WordPress.Security.NonceVerification.Missing -- redirect
        if (!empty($referrer) && $from_advgb) {
            $redirect = add_query_arg('login', 'failed', $referrer);
            wp_safe_redirect($redirect);
            exit;
        }
    }

    /**
     * Register back-end styles and script for later use
     *
     * @return void
     */
    public function registerStylesScripts()
    {
        if (!wp_doing_ajax()) {
            // Register CSS
            wp_register_style(
                'ju_framework_styles',
                plugins_url('assets/css/style.css', dirname(__FILE__))
            );
            wp_register_style(
                'ju_framework_styles_min',
                plugins_url('assets/css/style.min.css', dirname(__FILE__))
            );
            wp_register_style(
                'advgb_main_style',
                plugins_url('assets/css/main.css', dirname(__FILE__))
            );
            wp_register_style(
                'advgb_profile_style',
                plugins_url('assets/css/profile.css', dirname(__FILE__))
            );
            wp_register_style(
                'advgb_settings_style',
                plugins_url('assets/css/settings.css', dirname(__FILE__))
            );
            wp_register_style(
                'advgb_qtip_style',
                plugins_url('assets/css/jquery.qtip.css', dirname(__FILE__))
            );
            wp_register_style(
                'advgb_quirk',
                plugins_url('assets/css/quirk.css', dirname(__FILE__))
            );
            wp_register_style(
                'codemirror_css',
                plugins_url('assets/js/codemirror/lib/codemirror.css', dirname(__FILE__))
            );
            wp_register_style(
                'codemirror_hint_style',
                plugins_url('assets/js/codemirror/addon/hint/show-hint.css', dirname(__FILE__))
            );
            wp_register_style(
                'minicolors_css',
                plugins_url('assets/css/jquery.minicolors.css', dirname(__FILE__))
            );
            wp_register_style(
                'waves_styles',
                plugins_url('assets/css/waves.min.css', dirname(__FILE__))
            );
            wp_register_style(
                'material_icon_font',
                plugins_url('assets/css/fonts/material-icons.min.css', dirname(__FILE__))
            );
            wp_register_style(
                'material_icon_font_custom',
                plugins_url('assets/css/fonts/material-icons-custom.min.css', dirname(__FILE__))
            );
            wp_register_style(
                'slick_style',
                plugins_url('assets/css/slick.css', dirname(__FILE__))
            );
            wp_register_style(
                'slick_theme_style',
                plugins_url('assets/css/slick-theme.css', dirname(__FILE__))
            );

            // Register JS
            wp_register_script(
                'advgb_main_js',
                plugins_url('assets/js/main.js', dirname(__FILE__)),
                array(),
                ADVANCED_GUTENBERG_VERSION
            );
            wp_register_script(
                'advgb_update_list',
                plugins_url('assets/js/update-block-list.js', dirname(__FILE__)),
                array('jquery'),
                ADVANCED_GUTENBERG_VERSION
            );
            wp_register_script(
                'advgb_profile_js',
                plugins_url('assets/js/profile.js', dirname(__FILE__)),
                array(),
                ADVANCED_GUTENBERG_VERSION
            );
            wp_register_script(
                'advgb_settings_js',
                plugins_url('assets/js/settings.js', dirname(__FILE__)),
                array(),
                ADVANCED_GUTENBERG_VERSION
            );
            wp_register_script(
                'velocity_js',
                plugins_url('assets/js/velocity.min.js', dirname(__FILE__)),
                array(),
                ADVANCED_GUTENBERG_VERSION
            );
            wp_register_script(
                'waves_js',
                plugins_url('assets/js/waves.min.js', dirname(__FILE__)),
                array(),
                ADVANCED_GUTENBERG_VERSION
            );
            wp_register_script(
                'tabs_js',
                plugins_url('assets/js/tabs.js', dirname(__FILE__)),
                array(),
                ADVANCED_GUTENBERG_VERSION
            );
            wp_register_script(
                'qtip_js',
                plugins_url('assets/js/jquery.qtip.min.js', dirname(__FILE__)),
                array(),
                ADVANCED_GUTENBERG_VERSION
            );
            wp_register_script(
                'advgb_codemirror_js',
                plugins_url('assets/js/codemirror/lib/codemirror.js', dirname(__FILE__)),
                array(),
                ADVANCED_GUTENBERG_VERSION
            );
            wp_register_script(
                'codemirror_hint',
                plugins_url('assets/js/codemirror/addon/hint/show-hint.js', dirname(__FILE__)),
                array(),
                ADVANCED_GUTENBERG_VERSION
            );
            wp_register_script(
                'codemirror_mode_css',
                plugins_url('assets/js/codemirror/mode/css/css.js', dirname(__FILE__)),
                array(),
                ADVANCED_GUTENBERG_VERSION
            );
            wp_register_script(
                'codemirror_hint_css',
                plugins_url('assets/js/codemirror/addon/hint/css-hint.js', dirname(__FILE__)),
                array(),
                ADVANCED_GUTENBERG_VERSION
            );
            wp_register_script(
                'less_js',
                plugins_url('assets/js/less.js', dirname(__FILE__)),
                array(),
                ADVANCED_GUTENBERG_VERSION
            );
            wp_register_script(
                'minicolors_js',
                plugins_url('assets/js/jquery.minicolors.min.js', dirname(__FILE__)),
                array(),
                ADVANCED_GUTENBERG_VERSION
            );
            wp_register_script(
                'slick_js',
                plugins_url('assets/js/slick.min.js', dirname(__FILE__)),
                array('jquery')
            );
            $saved_settings = get_option('advgb_settings');
            if (isset($saved_settings['editor_width']) && $saved_settings['editor_width']) {
                wp_add_inline_style(
                    'dashicons',
                    '#editor div.editor-writing-flow {max-width: ' . $saved_settings['editor_width'] . '%}'
                );
            }

            if (!isset($saved_settings['enable_columns_visual_guide'])
                || (isset($saved_settings['enable_columns_visual_guide']) && $saved_settings['enable_columns_visual_guide'])
            ) {
                wp_add_inline_style(
                    'dashicons',
                    '.advgb-columns>.editor-inner-blocks>.editor-block-list__layout>.wp-block:not(.is-selected)>.editor-block-list__block-edit:before{border:1px dashed #ddd;}'
                );
            }
        }
    }

    /**
     * Register front-end styles and script for later use
     *
     * @return void
     */
    public function registerStylesScriptsFrontend()
    {
        wp_register_style(
            'colorbox_style',
            plugins_url('assets/css/colorbox.css', dirname(__FILE__)),
            array(),
            ADVANCED_GUTENBERG_VERSION
        );
        wp_register_style(
            'slick_style',
            plugins_url('assets/css/slick.css', dirname(__FILE__))
        );
        wp_register_style(
            'slick_theme_style',
            plugins_url('assets/css/slick-theme.css', dirname(__FILE__))
        );
        wp_register_style(
            'material_icon_font',
            plugins_url('assets/css/fonts/material-icons.min.css', dirname(__FILE__))
        );
        wp_register_style(
            'material_icon_font_custom',
            plugins_url('assets/css/fonts/material-icons-custom.min.css', dirname(__FILE__))
        );
        wp_register_style(
            'advgb_bulma_styles',
            plugins_url('assets/css/bulma.min.css', dirname(__FILE__))
        );

        wp_register_script(
            'colorbox_js',
            plugins_url('assets/js/jquery.colorbox.min.js', dirname(__FILE__)),
            array('jquery'),
            ADVANCED_GUTENBERG_VERSION
        );
        wp_register_script(
            'slick_js',
            plugins_url('assets/js/slick.min.js', dirname(__FILE__)),
            array('jquery')
        );

        $saved_settings = get_option('advgb_settings');
        if (isset($saved_settings['enable_blocks_spacing']) && $saved_settings['enable_blocks_spacing']) {
            $blocks_spacing = isset($saved_settings['blocks_spacing']) ? $saved_settings['blocks_spacing'] : 0;

            wp_add_inline_style(
                'dashicons',
                '.entry-content > * {margin-bottom: ' . $blocks_spacing . 'px}'
            );
        }
    }

    /**
     * Register main menu
     *
     * @return void
     */
    public function registerMainMenu()
    {
        add_menu_page(
            __('Advanced Gutenberg', 'advanced-gutenberg'),
            __('Adv. Gutenberg', 'advanced-gutenberg'),
            'manage_options',
            'advgb_main',
            array($this, 'advgbMainView'),
            'dashicons-layout'
        );
    }

    /**
     * Load main view
     *
     * @return void
     */
    public function advgbMainView()
    {
        wp_enqueue_style('roboto_font', 'https://fonts.googleapis.com/css?family=Roboto');
        wp_enqueue_style('material_icon_font');
        wp_enqueue_style('material_icon_font_custom');
        wp_enqueue_style('advgb_quirk');
        wp_enqueue_style('waves_styles');
        if (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG === true) {
            wp_enqueue_style('ju_framework_styles');
        } else {
            wp_enqueue_style('ju_framework_styles_min');
        }
        wp_enqueue_style('advgb_main_style');

        wp_enqueue_script('waves_js');
        wp_enqueue_script('velocity_js');
        wp_enqueue_script('tabs_js');
        wp_enqueue_script('advgb_main_js');

        $this->loadView('main-view');
    }

    /**
     * Register meta data to use on editor sidebar
     *
     * @return void
     */
    public function registerPostMeta()
    {
        register_post_meta(
            '',
            'advgb_blocks_editor_width',
            array(
                'show_in_rest'  => true,
                'single'        => true,
                'type'          => 'string',
            )
        );

        register_post_meta(
            '',
            'advgb_blocks_columns_visual_guide',
            array(
                'show_in_rest'  => true,
                'single'        => true,
                'type'          => 'string',
            )
        );
    }

    /**
     * Register profiles custom post type
     *
     * @return void
     */
    public function registerAdvgbProfile()
    {
        $labels = array(
            'name'               => __('Advanced Gutenberg Profiles', 'advanced-gutenberg'),  // Profile title
            'singular_name'      => __('Advanced Gutenberg Profiles', 'advanced-gutenberg'),
            'add_new'            => __('New Profile', 'advanced-gutenberg'),                  // New profile menu title
            'add_new_item'       => __('Add New Profile', 'advanced-gutenberg'),              // New profile title
            'edit_item'          => __('Edit Profile', 'advanced-gutenberg'),                 // Edit profile title
            'all_items'          => __('Profiles', 'advanced-gutenberg'),                     // All profiles menu title
            'view_item'          => __('View Profile', 'advanced-gutenberg'),
            'search_items'       => __('Search Profiles', 'advanced-gutenberg'),              // Search button title
            'not_found'          => __('No profiles found', 'advanced-gutenberg'),
            'not_found_in_trash' => __('No profiles found in trash', 'advanced-gutenberg'),
            'parent_item_colon'  => '',
            'menu_name'          => __('Profiles', 'advanced-gutenberg')
        );
        register_post_type('advgb_profiles', array(
            'labels'       => $labels,
            'public'       => false,
            'show_ui'      => false,
            'supports'     => array('title', 'author'),
            'capabilities' => array(
                'edit_posts'          => 'edit_advgb_profiles',
                'edit_others_posts'   => 'edit_others_advgb_profiles',
                'publish_posts'       => 'publish_advgb_profiles',
                'read'                => 'read_advgb_profile',
                'read_private_posts'  => 'read_private_advgb_profiles',
                'delete_posts'        => 'delete_advgb_profiles',
                'delete_others_posts' => 'delete_others_advgb_profiles',
                'create_posts'        => 'create_advgb_profiles',
            ),
            'map_meta_cap' => true
        ));
    }

    /**
     * Save data function
     *
     * @return boolean True on success, False on failure
     */
    public function saveAdvgbData()
    {
        if (isset($_GET['view']) && $_GET['view'] === 'profile' && !isset($_GET['id'])) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- redirect only
            wp_safe_redirect(admin_url('admin.php?page=advgb_main&view=profiles'));
        }

        if (isset($_POST['advgb_profile_save'])) { // phpcs:ignore WordPress.Security.NonceVerification.Missing -- we check nonce below
            $this->saveAdvgbProfile();
        } elseif (isset($_POST['save_settings']) || isset($_POST['save_custom_styles'])) { // phpcs:ignore WordPress.Security.NonceVerification.Missing -- we check nonce below
            $this->saveSettings();
        } elseif (isset($_POST['save_email_config'])) { // phpcs:ignore WordPress.Security.NonceVerification.Missing -- we check nonce below
            $this->saveEmailSettings();
        } elseif (isset($_POST['save_recaptcha_config'])) { // phpcs:ignore WordPress.Security.NonceVerification.Missing -- we check nonce below
            $this->saveCaptchaSettings();
        } elseif (isset($_POST['block_data_export'])) { // phpcs:ignore WordPress.Security.NonceVerification.Missing -- we check nonce below
            $this->downloadBlockFormData();
        }

        return false;
    }

    /**
     * Save config settings
     *
     * @return boolean True on success, False on failure
     */
    public function saveSettings()
    {
        if (isset($_POST['save_settings'])) {
            if (!wp_verify_nonce($_POST['advgb_settings_nonce_field'], 'advgb_settings_nonce')) {
                return false;
            }

            $save_config = array();
            if (isset($_POST['gallery_lightbox'])) {
                $save_config['gallery_lightbox'] = 1;
            } else {
                $save_config['gallery_lightbox'] = 0;
            }

            if (isset($_POST['gallery_lightbox_caption'])) {
                $save_config['gallery_lightbox_caption'] = 1;
            } else {
                $save_config['gallery_lightbox_caption'] = 0;
            }

            if (isset($_POST['enable_blocks_spacing'])) {
                $save_config['enable_blocks_spacing'] = 1;
            } else {
                $save_config['enable_blocks_spacing'] = 0;
            }

            if (isset($_POST['disable_wpautop'])) {
                $save_config['disable_wpautop'] = 1;
            } else {
                $save_config['disable_wpautop'] = 0;
            }

            if (isset($_POST['enable_columns_visual_guide'])) {
                $save_config['enable_columns_visual_guide'] = 1;
            } else {
                $save_config['enable_columns_visual_guide'] = 0;
            }

            $save_config['google_api_key'] = $_POST['google_api_key'];
            $save_config['blocks_spacing'] = $_POST['blocks_spacing'];
            $save_config['blocks_icon_color'] = $_POST['blocks_icon_color'];
            $save_config['editor_width'] = $_POST['editor_width'];
            $save_config['rp_default_thumb'] = array(
                'url' => $_POST['post_default_thumb'],
                'id'  => $_POST['post_default_thumb_id']
            );

            update_option('advgb_settings', $save_config);

            if (isset($_REQUEST['_wp_http_referer'])) {
                wp_safe_redirect(admin_url('admin.php?page=advgb_main&save_settings=success'));
                exit;
            }
        }

        if (isset($_POST['save_custom_styles'])) {
            if (!wp_verify_nonce($_POST['advgb_cstyles_nonce_field'], 'advgb_cstyles_nonce')) {
                return false;
            }
            // Save Custom Styles to a css file
            $get_custom_styles = get_option('advgb_custom_styles');
            if ($get_custom_styles !== false) {
                $this->writeCustomStyles($get_custom_styles);
            }

            if (isset($_REQUEST['_wp_http_referer'])) {
                wp_safe_redirect(admin_url('admin.php?page=advgb_main&save_styles=success'));
                exit;
            }
        }

        return true;
    }

    /**
     * Write custom styles to a CSS file
     *
     * @param array $styles_array Array of styles
     *
     * @return boolean True on success, False on failure
     */
    public function writeCustomStyles(array $styles_array)
    {
        WP_Filesystem();
        global $wp_filesystem;

        $custom_styles_dir = wp_upload_dir();
        $custom_styles_dir = $custom_styles_dir['basedir'] . '/advgb/';
        $css_file = $custom_styles_dir . 'custom_styles.css';

        if (!$wp_filesystem->exists($custom_styles_dir)) {
            $wp_filesystem->mkdir($custom_styles_dir);
        }

        $content = '';
        foreach ($styles_array as $styles) {
            $content .= '.gutenberg #editor .' .$styles['name'] . ', .' . $styles['name'] . " {\n";
            $content .= $styles['css'] . "\n} \n";
        }

        if (!$wp_filesystem->put_contents($css_file, $content)) {
            return false;
        }
        return true;
    }

    /**
     * Save profiles settings
     *
     * @return mixed
     */
    public function saveAdvgbProfile()
    {
        // Check nonce field exist
        if (!isset($_POST['advgb_nonce_field'])) {
            return false;
        }
        // Verify nonce
        if (!wp_verify_nonce($_POST['advgb_nonce_field'], 'advgb_nonce')) {
            return false;
        }

        $postID = $_POST['advgb_profile_id'];

        // Save profile settings
        if (current_user_can('publish_posts')) {
            // Get list of active blocks
            $active_blocks = array();
            $inactive_blocks = array();
            if (isset($_POST['active_blocks'])) {
                $blocks_list = json_decode(stripslashes($_POST['blocks_list']));
                $active_blocks = $_POST['active_blocks'];
                $inactive_blocks = array_values(array_diff($blocks_list, $active_blocks));
            }

            // Get users permission
            $users_access = array();
            $roles_access = array();
            if (isset($_POST['advgb-users-access-list'])) {
                $users_access = trim($_POST['advgb-users-access-list']);
                $users_access = explode(' ', $users_access);
            }
            if (isset($_POST['advgb-roles'])) {
                $roles_access = $_POST['advgb-roles'];
            }

            // Get new profile title
            $post_title = trim($_POST['advgb_profile_title']);

            // Save data
            if ($postID !== 'new') { // Update profile if have post ID
                if (!current_user_can('edit_post', $postID)) {
                    return false;
                }

                update_post_meta($postID, 'blocks', array('active_blocks'=>$active_blocks, 'inactive_blocks'=>$inactive_blocks));
                update_post_meta($postID, 'users_access', $users_access);
                update_post_meta($postID, 'roles_access', $roles_access);
                wp_update_post(array(
                    'ID' => $postID,
                    'post_title' => $post_title,
                ));
            } else { // Create new profile
                $postID = wp_insert_post(array(
                    'post_title'  => $post_title,
                    'post_type'   => 'advgb_profiles',
                    'post_status' => 'publish',
                    'meta_input'  => array(
                        'blocks' => array('active_blocks'=>$active_blocks, 'inactive_blocks'=>$inactive_blocks),
                        'roles_access'  => $roles_access,
                        'users_access'  => $users_access,
                    )
                ));
            }

            wp_safe_redirect(admin_url('admin.php?page=advgb_main&view=profile&id=' . $postID . '&save_profile=success'));
        }

        return $postID;
    }

    /**
     * Download block form data
     *
     * @return mixed
     */
    private function downloadBlockFormData()
    {
        // Verify nonce
        if (!wp_verify_nonce($_POST['advgb_export_data_nonce_field'], 'advgb_export_data_nonce')) {
            return false;
        }

        $postValue = $_POST['block_data_export'];
        $postValue = explode('.', $postValue);
        $dataExport = $postValue[0];
        $dataType = $postValue[1];
        $data = '';

        if ($dataExport === 'contact_form') {
            $dataSaved = get_option('advgb_contacts_saved');
            if (!$dataSaved) {
                return false;
            }

            switch ($dataType) {
                case 'csv':
                    $data .= '"#","Date","Name","Email","Message"' . PHP_EOL;
                    $tab = ',';
                    $int = 1;
                    foreach ($dataSaved as $dataVal) {
                        $data .= '"'.$int.'"'.$tab;
                        $data .= '"'.$dataVal['date'].'"'.$tab;
                        $data .= '"'.$dataVal['name'].'"'.$tab;
                        $data .= '"'.$dataVal['email'].'"'.$tab;
                        $data .= '"'.$dataVal['msg'].'"';
                        $data .= PHP_EOL;
                        $int++;
                    }
                    $data = trim($data);

                    header('Content-Type: text/csv; charset=utf-8');
                    header('Content-Disposition: attachment; filename=advgb_contact_form-'.date('m-d-Y').'.csv');
                    header('Pragma: no-cache');
                    header('Expires: 0');

                    echo $data; // phpcs:ignore -- WordPress.Security.EscapeOutput.OutputNotEscaped
                    exit;
                case 'json':
                    header('Content-Type: application/json; charset=utf-8');
                    header('Content-Disposition: attachment; filename=advgb_contact_form-'.date('m-d-Y').'.json');
                    header('Pragma: no-cache');
                    header('Expires: 0');

                    echo json_encode($dataSaved);
                    exit;
            }
        } elseif ($dataExport === 'newsletter') {
            $dataSaved = get_option('advgb_newsletter_saved');
            if (!$dataSaved) {
                return false;
            }

            switch ($dataType) {
                case 'csv':
                    $data .= '"#","Date","First Name","Last Name","Email",' . PHP_EOL;
                    $tab = ',';
                    $int = 1;
                    foreach ($dataSaved as $dataVal) {
                        $data .= '"'.$int.'"'.$tab;
                        $data .= '"'.$dataVal['date'].'"'.$tab;
                        $data .= '"'.$dataVal['fname'].'"'.$tab;
                        $data .= '"'.$dataVal['lname'].'"'.$tab;
                        $data .= '"'.$dataVal['email'].'"';
                        $data .= PHP_EOL;
                        $int++;
                    }
                    $data = trim($data);

                    header('Content-Type: text/csv; charset=utf-8');
                    header('Content-Disposition: attachment; filename=advgb_newsletter-'.date('m-d-Y').'.csv');
                    header('Pragma: no-cache');
                    header('Expires: 0');

                    echo $data; // phpcs:ignore -- WordPress.Security.EscapeOutput.OutputNotEscaped
                    exit;
                case 'json':
                    header('Content-Type: application/json; charset=utf-8');
                    header('Content-Disposition: attachment; filename=advgb_newsletter-'.date('m-d-Y').'.json');
                    header('Pragma: no-cache');
                    header('Expires: 0');

                    echo json_encode($dataSaved);
                    exit;
            }
        }

        return false;
    }

    /**
     * Save forms and email settings
     *
     * @return mixed
     */
    private function saveEmailSettings()
    {
        if (!isset($_POST['advgb_email_config_nonce_field'])) {
            return false;
        }

        if (!wp_verify_nonce($_POST['advgb_email_config_nonce_field'], 'advgb_email_config_nonce')) {
            return false;
        }

        $save_config = array();
        $save_config['contact_form_sender_name'] = $_POST['contact_form_sender_name'];
        $save_config['contact_form_sender_email'] = $_POST['contact_form_sender_email'];
        $save_config['contact_form_email_title'] = $_POST['contact_form_email_title'];
        $save_config['contact_form_email_receiver'] = $_POST['contact_form_email_receiver'];

        update_option('advgb_email_sender', $save_config);

        if (isset($_REQUEST['_wp_http_referer'])) {
            wp_safe_redirect(admin_url('admin.php?page=advgb_main&save_settings=success'));
            exit;
        }
    }

    /**
     * Save captcha settings
     *
     * @return mixed
     */
    private function saveCaptchaSettings()
    {
        if (!isset($_POST['advgb_captcha_nonce_field'])) {
            return false;
        }

        if (!wp_verify_nonce($_POST['advgb_captcha_nonce_field'], 'advgb_captcha_nonce')) {
            return false;
        }

        $save_config = array();
        if (isset($_POST['recaptcha_enable'])) {
            $save_config['recaptcha_enable'] = 1;
        } else {
            $save_config['recaptcha_enable'] = 0;
        }
        $save_config['recaptcha_site_key'] = $_POST['recaptcha_site_key'];
        $save_config['recaptcha_secret_key'] = $_POST['recaptcha_secret_key'];
        $save_config['recaptcha_language'] = $_POST['recaptcha_language'];
        $save_config['recaptcha_theme'] = $_POST['recaptcha_theme'];

        update_option('advgb_recaptcha_config', $save_config);

        if (isset($_REQUEST['_wp_http_referer'])) {
            wp_safe_redirect(admin_url('admin.php?page=advgb_main&save_settings=success'));
            exit;
        }
    }

    /**
     * Retrieve the active and inactive blocks for users regard to Advanced Gutenberg profiles
     *
     * @return array
     */
    public function getUserBlocksForGutenberg()
    {
        // Get user info
        $current_user      = wp_get_current_user();
        $current_user_id   = $current_user->ID;
        $current_user_role = $current_user->roles[0];

        // Check if we are in profile view
        if (isset($_GET['page']) && isset($_GET['view']) && $_GET['page'] === 'advgb_main' && $_GET['view'] === 'profile' ) { // phpcs:ignore -- WordPress.Security.NonceVerification.Recommended - view only
            $postID = $_GET['id']; // phpcs:ignore -- WordPress.Security.NonceVerification.Recommended - view only
            $blocks_saved  = get_post_meta($postID, 'blocks', true);
            if (!is_array($blocks_saved)) {
                return array('active_blocks'=>array(), 'inactive_blocks'=>array());
            }

            // Return allowed blocks
            return $blocks_saved;
        }

        // Get all GB-ADV active profiles
        global $wpdb;
        $profiles = $wpdb->get_results('SELECT * FROM '. $wpdb->prefix. 'posts
         WHERE post_type="advgb_profiles" AND post_status="publish" ORDER BY post_date_gmt DESC');

        if (!empty($profiles)) {
            foreach ($profiles as $profile) {
                $postID           = $profile->ID;
                $user_id_access   = get_post_meta($postID, 'users_access', true);
                $user_role_access = get_post_meta($postID, 'roles_access', true);

                // Check which profiles that current user has permission to use and take that ID
                // the ID of the profiles published most recently will be taken
                if (is_array($user_role_access) && is_array($user_id_access)) {
                    if (in_array($current_user_id, $user_id_access)
                        || in_array($current_user_role, $user_role_access)) {
                        // Populate the ID
                        $this->active_profile = $postID;
                        $blocks_saved  = get_post_meta($this->active_profile, 'blocks', true);

                        if (!is_array($blocks_saved)) {
                            return array('active_blocks'=>array(), 'inactive_blocks'=>array());
                        }

                        // Return allowed blocks
                        return $blocks_saved;
                    }
                }
            }
        }

        // If user is not in any block then allow all blocks
        $all_blocks = get_option('advgb_blocks_list');
        if (!is_array($all_blocks)) {
            $all_blocks = array();
        } else {
            foreach ($all_blocks as $block_key => $block_value) {
                $all_blocks[$block_key] = $all_blocks[$block_key]['name'];
            }
        }
        return array('active_blocks'=>$all_blocks, 'inactive_blocks'=>array());
    }

    /**
     * Register block config page
     *
     * @return void
     */
    public function registerBlockConfigPage()
    {
        $advgb_block = array(
            'accordions', 'button', 'image', 'list',
            'table', 'video', 'contact-form', 'container',
            'count-up','images-slider', 'map', 'newsletter',
            'recent-posts', 'social-links', 'summary', 'adv-tabs',
            'testimonial', 'woo-products', 'columns', 'column',
            'login-form', 'search-bar', 'icon', 'infobox'
        );

        foreach ($advgb_block as $block) {
            add_submenu_page(
                'admin.php?',
                __('Block Config', 'advanced-gutenberg'),
                __('Block Config', 'advanced-gutenberg'),
                'manage_options',
                'advgb-' . $block,
                array($this, 'loadBlockConfigView')
            );
        }
    }

    /**
     * Function to get and load the block config view
     *
     * @param string $block View to load
     *
     * @return void
     */
    public function loadBlockConfigView($block = '')
    {
        if (!$block) {
            $block = $_GET['page']; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- view only
        }

        wp_enqueue_style('roboto_font', 'https://fonts.googleapis.com/css?family=Roboto');
        wp_enqueue_style(
            'minicolors_css',
            plugins_url('assets/css/jquery.minicolors.css', ADVANCED_GUTENBERG_PLUGIN)
        );
        wp_enqueue_style(
            'ju_framework_styles_min',
            plugins_url('assets/css/style.min.css', ADVANCED_GUTENBERG_PLUGIN)
        );
        wp_enqueue_style(
            'block_config_css',
            plugins_url('assets/css/block-config.css', ADVANCED_GUTENBERG_PLUGIN)
        );
        $loadingImage = plugins_url('assets/images/loading.gif', ADVANCED_GUTENBERG_PLUGIN);
        wp_add_inline_style('block_config_css', '#advgb-loading-screen-image {background-image: url('. $loadingImage .')}');

        wp_enqueue_script(
            'minicolors_js',
            plugins_url('assets/js/jquery.minicolors.min.js', ADVANCED_GUTENBERG_PLUGIN),
            array(),
            ADVANCED_GUTENBERG_VERSION
        );
        wp_enqueue_script(
            'block_config_js',
            plugins_url('assets/js/block-config.js', ADVANCED_GUTENBERG_PLUGIN),
            array('jquery'),
            ADVANCED_GUTENBERG_VERSION
        );

        $blocks_settings_list = array(
            'advgb-accordions' => array(
                array(
                    'label'    => __('Accordion Settings', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title' => __('Bottom spacing', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'marginBottom',
                            'min'   => 0,
                            'max'   => 50,
                        ),
                        array(
                            'title' => __('Initial Collapsed', 'advanced-gutenberg'),
                            'type'  => 'checkbox',
                            'name'  => 'collapsedAll',
                        ),
                    )
                ),
                array(
                    'label'    => __('Header Settings', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title' => __('Background Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'headerBgColor',
                        ),
                        array(
                            'title' => __('Text Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'headerTextColor'
                        ),
                        array(
                            'title'   => __('Header Icon', 'advanced-gutenberg'),
                            'type'    => 'select',
                            'name'    => 'headerIcon',
                            'options' => array(
                                array(
                                    'label' => __('Plus', 'advanced-gutenberg'),
                                    'value' => 'plus',
                                ),
                                array(
                                    'label' => __('Plus Circle', 'advanced-gutenberg'),
                                    'value' => 'plusCircle',
                                ),
                                array(
                                    'label' => __('Plus Circle Outline', 'advanced-gutenberg'),
                                    'value' => 'plusCircleOutline',
                                ),
                                array(
                                    'label' => __('Plus Square Outline', 'advanced-gutenberg'),
                                    'value' => 'plusBox',
                                ),
                                array(
                                    'label' => __('Unfold Arrow', 'advanced-gutenberg'),
                                    'value' => 'unfold',
                                ),
                                array(
                                    'label' => __('Horizontal Dots', 'advanced-gutenberg'),
                                    'value' => 'threeDots',
                                ),
                                array(
                                    'label' => __('Arrow Down', 'advanced-gutenberg'),
                                    'value' => 'arrowDown',
                                ),
                            )
                        ),
                        array(
                            'title' => __('Header Icon Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'headerIconColor',
                        ),
                    ),
                ),
                array(
                    'label'    => __('Body Settings', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title' => __('Background Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'bodyBgColor',
                        ),
                        array(
                            'title' => __('Text Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'bodyTextColor',
                        ),
                    ),
                ),
                array(
                    'label'    => __('Border Settings', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title'   => __('Border Style', 'advanced-gutenberg'),
                            'type'    => 'select',
                            'name'    => 'borderStyle',
                            'options' => array(
                                array(
                                    'label' => __('Solid', 'advanced-gutenberg'),
                                    'value' => 'solid',
                                ),
                                array(
                                    'label' => __('Dashed', 'advanced-gutenberg'),
                                    'value' => 'dashed',
                                ),
                                array(
                                    'label' => __('Dotted', 'advanced-gutenberg'),
                                    'value' => 'dotted',
                                ),
                            )
                        ),
                        array(
                            'title' => __('Border Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'borderColor',
                        ),
                        array(
                            'title' => __('Border Width', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'borderWidth',
                            'min'   => 1,
                            'max'   => 10,
                        ),
                        array(
                            'title' => __('Border Radius', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'borderRadius',
                            'min'   => 0,
                            'max'   => 100,
                        ),
                    ),
                ),
            ),
            'advgb-button' => array(
                array(
                    'label'    => __('Text and Color', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title' => __('Text Size', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'textSize',
                            'min'   => 10,
                            'max'   => 100,
                        ),
                        array(
                            'title' => __('Text Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'textColor'
                        ),
                        array(
                            'title' => __('Background Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'bgColor',
                        ),
                    ),
                ),
                array(
                    'label'    => __('Border Settings', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title'   => __('Border Style', 'advanced-gutenberg'),
                            'type'    => 'select',
                            'name'    => 'borderStyle',
                            'options' => array(
                                array(
                                    'label' => __('Solid', 'advanced-gutenberg'),
                                    'value' => 'solid',
                                ),
                                array(
                                    'label' => __('Dashed', 'advanced-gutenberg'),
                                    'value' => 'dashed',
                                ),
                                array(
                                    'label' => __('Dotted', 'advanced-gutenberg'),
                                    'value' => 'dotted',
                                ),
                            )
                        ),
                        array(
                            'title' => __('Border Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'borderColor',
                        ),
                        array(
                            'title' => __('Border Width', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'borderWidth',
                            'min'   => 1,
                            'max'   => 10,
                        ),
                        array(
                            'title' => __('Border Radius', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'borderRadius',
                            'min'   => 0,
                            'max'   => 100,
                        ),
                    ),
                ),
                array(
                    'label'    => __('Margin Settings', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title' => __('Margin Top', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'marginTop',
                            'min'   => 0,
                            'max'   => 100,
                        ),
                        array(
                            'title' => __('Margin Right', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'marginRight',
                            'min'   => 0,
                            'max'   => 100,
                        ),
                        array(
                            'title' => __('Margin Bottom', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'marginBottom',
                            'min'   => 0,
                            'max'   => 100,
                        ),
                        array(
                            'title' => __('Margin Left', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'marginLeft',
                            'min'   => 0,
                            'max'   => 100,
                        ),
                    ),
                ),
                array(
                    'label'    => __('Padding Settings', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title' => __('Padding Top', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'paddingTop',
                            'min'   => 0,
                            'max'   => 100,
                        ),
                        array(
                            'title' => __('Padding Right', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'paddingRight',
                            'min'   => 0,
                            'max'   => 100,
                        ),
                        array(
                            'title' => __('Padding Bottom', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'paddingBottom',
                            'min'   => 0,
                            'max'   => 100,
                        ),
                        array(
                            'title' => __('Padding Left', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'paddingLeft',
                            'min'   => 0,
                            'max'   => 100,
                        ),
                    ),
                ),
                array(
                    'label'    => __('Hover Settings', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title' => __('Text Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'hoverTextColor'
                        ),
                        array(
                            'title' => __('Background Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'hoverBgColor',
                        ),
                        array(
                            'title' => __('Shadow Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'hoverShadowColor',
                        ),
                        array(
                            'title' => __('Shadow H Offset', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'hoverShadowH',
                            'min'   => -50,
                            'max'   => 50,
                        ),
                        array(
                            'title' => __('Shadow V Offset', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'hoverShadowV',
                            'min'   => -50,
                            'max'   => 50,
                        ),
                        array(
                            'title' => __('Shadow Blur', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'hoverShadowBlur',
                            'min'   => 0,
                            'max'   => 50,
                        ),
                        array(
                            'title' => __('Shadow Spread', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'hoverShadowSpread',
                            'min'   => 0,
                            'max'   => 50,
                        ),
                        array(
                            'title' => __('Transition Speed', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'transitionSpeed',
                            'min'   => 0,
                            'max'   => 3,
                        ),
                    ),
                ),
            ),
            'advgb-image' => array(
                array(
                    'label' =>  __('Click action', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title' => __('Action on click', 'advanced-gutenberg'),
                            'type'  => 'select',
                            'name'  => 'openOnClick',
                            'options' => array(
                                array(
                                    'label' => __('None', 'advanced-gutenberg'),
                                    'value' => 'none',
                                ),
                                array(
                                    'label' => __('Open image in a lightbox', 'advanced-gutenberg'),
                                    'value' => 'lightbox',
                                ),
                                array(
                                    'label' => __('Open custom URL', 'advanced-gutenberg'),
                                    'value' => 'url',
                                ),
                            ),
                        ),
                        array(
                            'title' => __('Open link in a new tab', 'advanced-gutenberg'),
                            'type'  => 'checkbox',
                            'name'  => 'linkInNewTab',
                        ),
                    )
                ),
                array(
                    'label'    => __('Image Size', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title' => __('Full width', 'advanced-gutenberg'),
                            'type'  => 'checkbox',
                            'name'  => 'fullWidth',
                        ),
                        array(
                            'title' => __('Height', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'height',
                            'min'   => 100,
                            'max'   => 1000,
                        ),
                        array(
                            'title' => __('Width', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'width',
                            'min'   => 200,
                            'max'   => 1300,
                        ),
                    ),
                ),
                array(
                    'label'    => __('Color', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title' => __('Title Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'titleColor',
                        ),
                        array(
                            'title' => __('Subtitle Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'subtitleColor',
                        ),
                        array(
                            'title' => __('Overlay Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'overlayColor',
                        ),
                    ),
                ),
                array(
                    'label'    => __('Text Alignment', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title' => __('Vertical Alignment', 'advanced-gutenberg'),
                            'type'  => 'select',
                            'name'  => 'vAlign',
                            'options' => array(
                                array(
                                    'label' => __('Top', 'advanced-gutenberg'),
                                    'value' => 'flex-start',
                                ),
                                array(
                                    'label' => __('Center', 'advanced-gutenberg'),
                                    'value' => 'center',
                                ),
                                array(
                                    'label' => __('Bottom', 'advanced-gutenberg'),
                                    'value' => 'flex-end',
                                ),
                            ),
                        ),
                        array(
                            'title' => __('Vertical Alignment', 'advanced-gutenberg'),
                            'type'  => 'select',
                            'name'  => 'hAlign',
                            'options' => array(
                                array(
                                    'label' => __('Left', 'advanced-gutenberg'),
                                    'value' => 'flex-start',
                                ),
                                array(
                                    'label' => __('Center', 'advanced-gutenberg'),
                                    'value' => 'center',
                                ),
                                array(
                                    'label' => __('Right', 'advanced-gutenberg'),
                                    'value' => 'flex-end',
                                ),
                            ),
                        ),
                    ),
                ),
            ),
            'advgb-list' => array(
                array(
                    'label'    => __('Text Settings', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title' => __('Text Size', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'textSize',
                            'min'   => 10,
                            'max'   => 100,
                        ),
                    ),
                ),
                array(
                    'label'    => __('Icon Settings', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title' => __('Icon style', 'advanced-gutenberg'),
                            'type'  => 'select',
                            'name'  => 'icon',
                            'options' => array(
                                array(
                                    'label' => __('None', 'advanced-gutenberg'),
                                    'value' => '',
                                ),
                                array(
                                    'label' => __('Pushpin', 'advanced-gutenberg'),
                                    'value' => 'admin-post',
                                ),
                                array(
                                    'label' => __('Configuration', 'advanced-gutenberg'),
                                    'value' => 'admin-generic',
                                ),
                                array(
                                    'label' => __('Flag', 'advanced-gutenberg'),
                                    'value' => 'flag',
                                ),
                                array(
                                    'label' => __('Star', 'advanced-gutenberg'),
                                    'value' => 'star-filled',
                                ),
                                array(
                                    'label' => __('Checkmark', 'advanced-gutenberg'),
                                    'value' => 'yes',
                                ),
                                array(
                                    'label' => __('Minus', 'advanced-gutenberg'),
                                    'value' => 'minus',
                                ),
                                array(
                                    'label' => __('Plus', 'advanced-gutenberg'),
                                    'value' => 'plus',
                                ),
                                array(
                                    'label' => __('Play', 'advanced-gutenberg'),
                                    'value' => 'controls-play',
                                ),
                                array(
                                    'label' => __('Arrow Right', 'advanced-gutenberg'),
                                    'value' => 'arrow-right-alt',
                                ),
                                array(
                                    'label' => __('X Cross', 'advanced-gutenberg'),
                                    'value' => 'dismiss',
                                ),
                                array(
                                    'label' => __('Warning', 'advanced-gutenberg'),
                                    'value' => 'warning',
                                ),
                                array(
                                    'label' => __('Help', 'advanced-gutenberg'),
                                    'value' => 'editor-help',
                                ),
                                array(
                                    'label' => __('Info', 'advanced-gutenberg'),
                                    'value' => 'info',
                                ),
                                array(
                                    'label' => __('Circle', 'advanced-gutenberg'),
                                    'value' => 'marker',
                                ),
                            ),
                        ),
                        array(
                            'title' => __('Icon color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'iconColor',
                        ),
                        array(
                            'title' => __('Icon Size', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'iconSize',
                            'min'   => 10,
                            'max'   => 100,
                        ),
                        array(
                            'title' => __('Line Height', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'lineHeight',
                            'min'   => 0,
                            'max'   => 100,
                        ),
                        array(
                            'title' => __('Margin', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'margin',
                            'min'   => 0,
                            'max'   => 100,
                        ),
                        array(
                            'title' => __('Padding', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'padding',
                            'min'   => 0,
                            'max'   => 100,
                        ),
                    ),
                ),
            ),
            'advgb-table' => array(
                array(
                    'label'    => __('Table Settings', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title' => __('Max width', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'maxWidth',
                            'min'   => 0,
                            'max'   => 1999,
                        ),
                    ),
                ),
            ),
            'advgb-video' => array(
                array(
                    'label'    => __('Video Settings', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title' => __('Open video in lightbox', 'advanced-gutenberg'),
                            'type'  => 'checkbox',
                            'name'  => 'openInLightbox',
                        ),
                        array(
                            'title' => __('Full width', 'advanced-gutenberg'),
                            'type'  => 'checkbox',
                            'name'  => 'videoFullWidth'
                        ),
                        array(
                            'title' => __('Video Width', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'videoWidth',
                            'min'   => 100,
                            'max'   => 1000,
                        ),
                        array(
                            'title' => __('Video Height', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'videoHeight',
                            'min'   => 300,
                            'max'   => 7000,
                        ),
                        array(
                            'title' => __('Overlay color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'overlayColor',
                        ),
                    ),
                ),
                array(
                    'label'    => __('Play Button Settings', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title'   => __('Button Icon', 'advanced-gutenberg'),
                            'type'    => 'select',
                            'name'    => 'playButtonIcon',
                            'options' => array(
                                array(
                                    'label' => __('Normal', 'advanced-gutenberg'),
                                    'value' => 'normal',
                                ),
                                array(
                                    'label' => __('Filled Circle', 'advanced-gutenberg'),
                                    'value' => 'circleFill',
                                ),
                                array(
                                    'label' => __('Outline Circle', 'advanced-gutenberg'),
                                    'value' => 'circleOutline',
                                ),
                                array(
                                    'label' => __('Video Camera', 'advanced-gutenberg'),
                                    'value' => 'videoCam',
                                ),
                                array(
                                    'label' => __('Filled Square', 'advanced-gutenberg'),
                                    'value' => 'squareCurved',
                                ),
                                array(
                                    'label' => __('Star Sticker', 'advanced-gutenberg'),
                                    'value' => 'starSticker',
                                ),
                            )
                        ),
                        array(
                            'title' => __('Button Size', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'playButtonSize',
                            'min'   => 40,
                            'max'   => 200,
                        ),
                        array(
                            'title' => __('Button Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'playButtonColor',
                        ),
                    ),
                ),
            ),
            'advgb-count-up' => array(
                array(
                    'label'    => __('General Settings', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title' => __('Number of columns', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'columns',
                            'min'   => 1,
                            'max'   => 3,
                        ),
                    ),
                ),
                array(
                    'label'    => __('Color Settings', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title' => __('Header Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'headerTextColor',
                        ),
                        array(
                            'title' => __('Count Up Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'countUpNumberColor',
                        ),
                        array(
                            'title' => __('Description Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'descTextColor',
                        ),
                    ),
                ),
                array(
                    'label'    => __('Count Up Settings', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title' => __('Count Up Number Size', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'countUpNumberSize',
                            'min'   => 10,
                            'max'   => 100,
                        ),
                    ),
                ),
            ),
            'advgb-map' => array(
                array(
                    'label'    => __('Location Settings', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'type'  => 'hidden',
                            'name'  => 'useLatLng',
                            'value' => 1,
                        ),
                        array(
                            'title' => __('Latitude', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'lat',
                            'min'   => 0,
                            'max'   => 999,
                        ),
                        array(
                            'title' => __('Longitude', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'lng',
                            'min'   => 0,
                            'max'   => 999,
                        ),
                    ),
                ),
                array(
                    'label'    => __('Map Settings', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title' => __('Zoom Level', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'zoom',
                            'min'   => 0,
                            'max'   => 25,
                        ),
                        array(
                            'title' => __('Height', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'height',
                            'min'   => 300,
                            'max'   => 1000,
                        ),
                        array(
                            'title' => __('Map style', 'advanced-gutenberg'),
                            'type'  => 'select',
                            'name'  => 'mapStyle',
                            'options' => array(
                                array('label' => __('Silver', 'advanced-gutenberg'), 'value' => 'silver'),
                                array('label' => __('Retro', 'advanced-gutenberg'), 'value' => 'retro'),
                                array('label' => __('Dark', 'advanced-gutenberg'), 'value' => 'dark'),
                                array('label' => __('Night', 'advanced-gutenberg'), 'value' => 'night'),
                                array('label' => __('Aubergine', 'advanced-gutenberg'), 'value' => 'aubergine'),
                                array('label' => __('Custom', 'advanced-gutenberg'), 'value' => 'custom'),
                            )
                        ),
                    ),
                ),
                array(
                    'label'    => __('Marker Settings', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title' => __('Marker Title', 'advanced-gutenberg'),
                            'type'  => 'text',
                            'name'  => 'markerTitle',
                        ),
                        array(
                            'title' => __('Marker Description', 'advanced-gutenberg'),
                            'type'  => 'text',
                            'name'  => 'markerDesc',
                        ),
                    ),
                ),
            ),
            'advgb-social-links' => array(
                array(
                    'label'    => __('Icon 1 Settings', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title' => __('Icon', 'advanced-gutenberg'),
                            'type'  => 'select',
                            'name'  => 'icon1.icon',
                            'options' => array(
                                array('label' => __('Blogger', 'advanced-gutenberg'), 'value' => 'blogger'),
                                array('label' => __('Facebook', 'advanced-gutenberg'), 'value' => 'facebook'),
                                array('label' => __('Flickr', 'advanced-gutenberg'), 'value' => 'flickr'),
                                array('label' => __('Google Plus', 'advanced-gutenberg'), 'value' => 'google'),
                                array('label' => __('Instagram', 'advanced-gutenberg'), 'value' => 'instagram'),
                                array('label' => __('LinkedIn', 'advanced-gutenberg'), 'value' => 'linkedin'),
                                array('label' => __('Email', 'advanced-gutenberg'), 'value' => 'mail'),
                                array('label' => __('Picasa', 'advanced-gutenberg'), 'value' => 'picasa'),
                                array('label' => __('Pinterest', 'advanced-gutenberg'), 'value' => 'pinterest'),
                                array('label' => __('Reddit', 'advanced-gutenberg'), 'value' => 'reddit'),
                                array('label' => __('Skype', 'advanced-gutenberg'), 'value' => 'skype'),
                                array('label' => __('Sound Cloud', 'advanced-gutenberg'), 'value' => 'soundcloud'),
                                array('label' => __('Tumblr', 'advanced-gutenberg'), 'value' => 'tumblr'),
                                array('label' => __('Twitter', 'advanced-gutenberg'), 'value' => 'twitter'),
                                array('label' => __('Vimeo', 'advanced-gutenberg'), 'value' => 'vimeo'),
                                array('label' => __('Youtube', 'advanced-gutenberg'), 'value' => 'youtube'),
                            )
                        ),
                        array(
                            'title' => __('Icon Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'icon1.iconColor',
                        ),
                        array(
                            'title' => __('Icon Link', 'advanced-gutenberg'),
                            'type'  => 'text',
                            'name'  => 'icon1.link',
                        ),
                    ),
                ),
                array(
                    'label'    => __('Icon 2 Settings', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title' => __('Icon', 'advanced-gutenberg'),
                            'type'  => 'select',
                            'name'  => 'icon2.icon',
                            'options' => array(
                                array('label' => __('Blogger', 'advanced-gutenberg'), 'value' => 'blogger'),
                                array('label' => __('Facebook', 'advanced-gutenberg'), 'value' => 'facebook'),
                                array('label' => __('Flickr', 'advanced-gutenberg'), 'value' => 'flickr'),
                                array('label' => __('Google Plus', 'advanced-gutenberg'), 'value' => 'google'),
                                array('label' => __('Instagram', 'advanced-gutenberg'), 'value' => 'instagram'),
                                array('label' => __('LinkedIn', 'advanced-gutenberg'), 'value' => 'linkedin'),
                                array('label' => __('Email', 'advanced-gutenberg'), 'value' => 'mail'),
                                array('label' => __('Picasa', 'advanced-gutenberg'), 'value' => 'picasa'),
                                array('label' => __('Pinterest', 'advanced-gutenberg'), 'value' => 'pinterest'),
                                array('label' => __('Reddit', 'advanced-gutenberg'), 'value' => 'reddit'),
                                array('label' => __('Skype', 'advanced-gutenberg'), 'value' => 'skype'),
                                array('label' => __('Sound Cloud', 'advanced-gutenberg'), 'value' => 'soundcloud'),
                                array('label' => __('Tumblr', 'advanced-gutenberg'), 'value' => 'tumblr'),
                                array('label' => __('Twitter', 'advanced-gutenberg'), 'value' => 'twitter'),
                                array('label' => __('Vimeo', 'advanced-gutenberg'), 'value' => 'vimeo'),
                                array('label' => __('Youtube', 'advanced-gutenberg'), 'value' => 'youtube'),
                            )
                        ),
                        array(
                            'title' => __('Icon Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'icon2.iconColor',
                        ),
                        array(
                            'title' => __('Icon Link', 'advanced-gutenberg'),
                            'type'  => 'text',
                            'name'  => 'icon2.link',
                        ),
                    ),
                ),
                array(
                    'label'    => __('Icon 3 Settings', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title' => __('Icon', 'advanced-gutenberg'),
                            'type'  => 'select',
                            'name'  => 'icon3.icon',
                            'options' => array(
                                array('label' => __('Blogger', 'advanced-gutenberg'), 'value' => 'blogger'),
                                array('label' => __('Facebook', 'advanced-gutenberg'), 'value' => 'facebook'),
                                array('label' => __('Flickr', 'advanced-gutenberg'), 'value' => 'flickr'),
                                array('label' => __('Google Plus', 'advanced-gutenberg'), 'value' => 'google'),
                                array('label' => __('Instagram', 'advanced-gutenberg'), 'value' => 'instagram'),
                                array('label' => __('LinkedIn', 'advanced-gutenberg'), 'value' => 'linkedin'),
                                array('label' => __('Email', 'advanced-gutenberg'), 'value' => 'mail'),
                                array('label' => __('Picasa', 'advanced-gutenberg'), 'value' => 'picasa'),
                                array('label' => __('Pinterest', 'advanced-gutenberg'), 'value' => 'pinterest'),
                                array('label' => __('Reddit', 'advanced-gutenberg'), 'value' => 'reddit'),
                                array('label' => __('Skype', 'advanced-gutenberg'), 'value' => 'skype'),
                                array('label' => __('Sound Cloud', 'advanced-gutenberg'), 'value' => 'soundcloud'),
                                array('label' => __('Tumblr', 'advanced-gutenberg'), 'value' => 'tumblr'),
                                array('label' => __('Twitter', 'advanced-gutenberg'), 'value' => 'twitter'),
                                array('label' => __('Vimeo', 'advanced-gutenberg'), 'value' => 'vimeo'),
                                array('label' => __('Youtube', 'advanced-gutenberg'), 'value' => 'youtube'),
                            )
                        ),
                        array(
                            'title' => __('Icon Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'icon3.iconColor',
                        ),
                        array(
                            'title' => __('Icon Link', 'advanced-gutenberg'),
                            'type'  => 'text',
                            'name'  => 'icon3.link',
                        ),
                    ),
                ),
                array(
                    'label'    => __('General Settings', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title' => __('Icon Alignment', 'advanced-gutenberg'),
                            'type'  => 'select',
                            'name'  => 'align',
                            'options' => array(
                                array('label' => __('Left', 'advanced-gutenberg'), 'value' => 'left'),
                                array('label' => __('Center', 'advanced-gutenberg'), 'value' => 'center'),
                                array('label' => __('Right', 'advanced-gutenberg'), 'value' => 'right'),
                            )
                        ),
                        array(
                            'title' => __('Icon Size', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'iconSize',
                            'min'   => 20,
                            'max'   => 60,
                        ),
                        array(
                            'title' => __('Icon Space', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'iconSpace',
                            'min'   => 0,
                            'max'   => 30,
                        ),
                    ),
                ),
            ),
            'advgb-summary' => array(
                array(
                    'label'    => __('General Settings', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title' => __('Load minimized', 'advanced-gutenberg'),
                            'type'  => 'checkbox',
                            'name'  => 'loadMinimized',
                        ),
                        array(
                            'title' => __('Summary header title', 'advanced-gutenberg'),
                            'type'  => 'text',
                            'name'  => 'headerTitle',
                        ),
                        array(
                            'title' => __('Anchor color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'anchorColor',
                        ),
                        array(
                            'title' => __('Summary Alignment', 'advanced-gutenberg'),
                            'type'  => 'select',
                            'name'  => 'align',
                            'options' => array(
                                array('label' => __('Left', 'advanced-gutenberg'), 'value' => 'left'),
                                array('label' => __('Center', 'advanced-gutenberg'), 'value' => 'center'),
                                array('label' => __('Right', 'advanced-gutenberg'), 'value' => 'right'),
                            )
                        ),
                    ),
                ),
            ),
            'advgb-adv-tabs' => array(
                array(
                    'label'    => __('Tab Settings', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title' => __('Tabs Style', 'advanced-gutenberg'),
                            'type' => 'select',
                            'name' => 'tabsStyle',
                            'options' => array(
                                array(
                                    'label' => __('Horizontal', 'advanced-gutenberg'),
                                    'value' => 'horz',
                                ),
                                array(
                                    'label' => __('Vertical', 'advanced-gutenberg'),
                                    'value' => 'vert',
                                ),
                            )
                        ),
                        array(
                            'title' => __('Background Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'headerBgColor',
                        ),
                        array(
                            'title' => __('Text Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'headerTextColor',
                        ),
                    ),
                ),
                array(
                    'label'    => __('Active Tab Settings', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title' => __('Background Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'activeTabBgColor',
                        ),
                        array(
                            'title' => __('Text Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'activeTabTextColor',
                        ),
                    ),
                ),
                array(
                    'label'    => __('Body Settings', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title' => __('Background Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'bodyBgColor',
                        ),
                        array(
                            'title' => __('Text Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'bodyTextColor',
                        ),
                    ),
                ),
                array(
                    'label'    => __('Border Settings', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title' => __('Border Style', 'advanced-gutenberg'),
                            'type'  => 'select',
                            'name'  => 'borderStyle',
                            'options' => array(
                                array('label' => __('Solid', 'advanced-gutenberg'), 'value' => 'solid'),
                                array('label' => __('Dashed', 'advanced-gutenberg'), 'value' => 'dashed'),
                                array('label' => __('Dotted', 'advanced-gutenberg'), 'value' => 'dotted'),
                            )
                        ),
                        array(
                            'title' => __('Border Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'borderColor',
                        ),
                        array(
                            'title' => __('Border Width', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'borderWidth',
                            'min'   => 1,
                            'max'   => 10,
                        ),
                        array(
                            'title' => __('Border Radius', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'borderRadius',
                            'min'   => 0,
                            'max'   => 100,
                        ),
                    ),
                ),
            ),
            'advgb-testimonial' => array(
                array(
                    'label'    => __('General Settings', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title' => __('Columns', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'columns',
                            'min'   => 1,
                            'max'   => 3,
                        ),
                    ),
                ),
                array(
                    'label'    => __('Avatar Settings', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title' => __('Background Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'avatarColor',
                        ),
                        array(
                            'title' => __('Border Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'avatarBorderColor',
                        ),
                        array(
                            'title' => __('Border Radius (%)', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'avatarBorderRadius',
                            'min'   => 0,
                            'max'   => 50,
                        ),
                        array(
                            'title' => __('Border Width', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'avatarBorderWidth',
                            'min'   => 0,
                            'max'   => 5,
                        ),
                        array(
                            'title' => __('Avatar Size', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'avatarSize',
                            'min'   => 50,
                            'max'   => 130,
                        ),
                    ),
                ),
                array(
                    'label'    => __('Text Settings', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title' => __('Name Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'nameColor',
                        ),
                        array(
                            'title' => __('Position Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'positionColor',
                        ),
                        array(
                            'title' => __('Description Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'descColor',
                        ),
                    ),
                ),
            ),
            'advgb-woo-products' => array(
                array(
                    'label'    => __('Layout Settings', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title' => __('Columns', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'columns',
                            'min'   => 1,
                            'max'   => 4,
                        ),
                        array(
                            'title' => __('Number of Products', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'numberOfProducts',
                            'min'   => 1,
                            'max'   => 48,
                        ),
                    ),
                ),
            ),
            'advgb-contact-form' => array(
                array(
                    'label'    => __('Text Label', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title' => __('Name placeholder', 'advanced-gutenberg'),
                            'type'  => 'text',
                            'name'  => 'nameLabel',
                        ),
                        array(
                            'title' => __('Email placeholder', 'advanced-gutenberg'),
                            'type'  => 'text',
                            'name'  => 'emailLabel',
                        ),
                        array(
                            'title' => __('Message placeholder', 'advanced-gutenberg'),
                            'type'  => 'text',
                            'name'  => 'msgLabel',
                        ),
                        array(
                            'title' => __('Submit label', 'advanced-gutenberg'),
                            'type'  => 'text',
                            'name'  => 'submitLabel',
                        ),
                        array(
                            'title' => __('Success text', 'advanced-gutenberg'),
                            'type'  => 'text',
                            'name'  => 'successLabel',
                        ),
                        array(
                            'title' => __('Error text', 'advanced-gutenberg'),
                            'type'  => 'text',
                            'name'  => 'alertLabel',
                        ),
                    ),
                ),
                array(
                    'label'    => __('Input Color', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title' => __('Background Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'bgColor',
                        ),
                        array(
                            'title' => __('Text Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'textColor',
                        ),
                    ),
                ),
                array(
                    'label'    => __('Border Settings', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title' => __('Border Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'borderColor',
                        ),
                        array(
                            'title'   => __('Border Style', 'advanced-gutenberg'),
                            'type'    => 'select',
                            'name'    => 'borderStyle',
                            'options' => array(
                                array(
                                    'label' => __('Solid', 'advanced-gutenberg'),
                                    'value' => 'solid',
                                ),
                                array(
                                    'label' => __('Dashed', 'advanced-gutenberg'),
                                    'value' => 'dashed',
                                ),
                                array(
                                    'label' => __('Dotted', 'advanced-gutenberg'),
                                    'value' => 'dotted',
                                ),
                            ),
                        ),
                        array(
                            'title' => __('Border Radius', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'borderRadius',
                            'min'   => 0,
                            'max'   => 100,
                        ),
                    ),
                ),
                array(
                    'label'    => __('Submit Button Settings', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title' => __('Border and Text Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'submitColor',
                        ),
                        array(
                            'title' => __('Background Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'submitBgColor',
                        ),
                        array(
                            'title' => __('Border Radius', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'submitRadius',
                            'min'   => 0,
                            'max'   => 100,
                        ),
                        array(
                            'title'   => __('Button Position', 'advanced-gutenberg'),
                            'type'    => 'select',
                            'name'    => 'submitPosition',
                            'options' => array(
                                array(
                                    'label' => __('Center', 'advanced-gutenberg'),
                                    'value' => 'center',
                                ),
                                array(
                                    'label' => __('Left', 'advanced-gutenberg'),
                                    'value' => 'left',
                                ),
                                array(
                                    'label' => __('Right', 'advanced-gutenberg'),
                                    'value' => 'right',
                                ),
                            ),
                        ),
                    ),
                ),
            ),
            'advgb-newsletter' => array(
                array(
                    'label'    => __('Form Settings', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title'   => __('Form style', 'advanced-gutenberg'),
                            'type'    => 'select',
                            'name'    => 'formStyle',
                            'options' => array(
                                array(
                                    'label' => __('Normal', 'advanced-gutenberg'),
                                    'value' => 'default',
                                ),
                                array(
                                    'label' => __('Alternative', 'advanced-gutenberg'),
                                    'value' => 'alt',
                                ),
                            ),
                        ),
                        array(
                            'title' => __('Form width', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'formWidth',
                            'min'   => 200,
                            'max'   => 1000,
                        ),
                    ),
                ),
                array(
                    'label'    => __('Text Label', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title' => __('First Name placeholder', 'advanced-gutenberg'),
                            'type'  => 'text',
                            'name'  => 'fnameLabel',
                        ),
                        array(
                            'title' => __('Last Name placeholder', 'advanced-gutenberg'),
                            'type'  => 'text',
                            'name'  => 'lnameLabel',
                        ),
                        array(
                            'title' => __('Email placeholder', 'advanced-gutenberg'),
                            'type'  => 'text',
                            'name'  => 'emailLabel',
                        ),
                        array(
                            'title' => __('Submit label', 'advanced-gutenberg'),
                            'type'  => 'text',
                            'name'  => 'submitLabel',
                        ),
                        array(
                            'title' => __('Success text', 'advanced-gutenberg'),
                            'type'  => 'text',
                            'name'  => 'successLabel',
                        ),
                        array(
                            'title' => __('Error text', 'advanced-gutenberg'),
                            'type'  => 'text',
                            'name'  => 'alertLabel',
                        ),
                    ),
                ),
                array(
                    'label'    => __('Input Color', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title' => __('Background Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'bgColor',
                        ),
                        array(
                            'title' => __('Text Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'textColor',
                        ),
                    ),
                ),
                array(
                    'label'    => __('Border Settings', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title' => __('Border Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'borderColor',
                        ),
                        array(
                            'title'   => __('Border Style', 'advanced-gutenberg'),
                            'type'    => 'select',
                            'name'    => 'borderStyle',
                            'options' => array(
                                array(
                                    'label' => __('Solid', 'advanced-gutenberg'),
                                    'value' => 'solid',
                                ),
                                array(
                                    'label' => __('Dashed', 'advanced-gutenberg'),
                                    'value' => 'dashed',
                                ),
                                array(
                                    'label' => __('Dotted', 'advanced-gutenberg'),
                                    'value' => 'dotted',
                                ),
                            ),
                        ),
                        array(
                            'title' => __('Border Radius', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'borderRadius',
                            'min'   => 0,
                            'max'   => 100,
                        ),
                    ),
                ),
                array(
                    'label'    => __('Submit Button Settings', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title' => __('Border and Text Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'submitColor',
                        ),
                        array(
                            'title' => __('Background Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'submitBgColor',
                        ),
                        array(
                            'title' => __('Border Radius', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'submitRadius',
                            'min'   => 0,
                            'max'   => 100,
                        ),
                    ),
                ),
            ),
            'advgb-images-slider' => array(
                array(
                    'label'    => __('Images Settings', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title'   => __('Action on click', 'advanced-gutenberg'),
                            'type'    => 'select',
                            'name'    => 'actionOnClick',
                            'options' => array(
                                array(
                                    'label' => __('Open image in lightbox', 'advanced-gutenberg'),
                                    'value' => 'lightbox',
                                ),
                                array(
                                    'label' => __('Open custom link', 'advanced-gutenberg'),
                                    'value' => 'link',
                                ),
                            ),
                        ),
                        array(
                            'title' => __('Full width', 'advanced-gutenberg'),
                            'type'  => 'checkbox',
                            'name'  => 'fullWidth',
                        ),
                        array(
                            'title' => __('Auto Height', 'advanced-gutenberg'),
                            'type'  => 'checkbox',
                            'name'  => 'autoHeight',
                        ),
                        array(
                            'title' => __('Width', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'width',
                            'min'   => 200,
                            'max'   => 1300,
                        ),
                        array(
                            'title' => __('Height', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'height',
                            'min'   => 100,
                            'max'   => 1000,
                        ),
                        array(
                            'title' => __('Always show overlay', 'advanced-gutenberg'),
                            'type'  => 'checkbox',
                            'name'  => 'alwaysShowOverlay',
                        ),
                    ),
                ),
                array(
                    'label'    => __('Color Settings', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title' => __('Hover Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'hoverColor',
                        ),
                        array(
                            'title' => __('Title Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'titleColor',
                        ),
                        array(
                            'title' => __('Text Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'textColor',
                        ),
                    ),
                ),
                array(
                    'label'    => __('Text Alignment', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title'   => __('Vertical Alignment', 'advanced-gutenberg'),
                            'type'    => 'select',
                            'name'    => 'vAlign',
                            'options' => array(
                                array(
                                    'label' => __('Top', 'advanced-gutenberg'),
                                    'value' => 'flex-start',
                                ),
                                array(
                                    'label' => __('Center', 'advanced-gutenberg'),
                                    'value' => 'center',
                                ),
                                array(
                                    'label' => __('Bottom', 'advanced-gutenberg'),
                                    'value' => 'flex-end',
                                ),
                            ),
                        ),
                        array(
                            'title'   => __('Horizontal Alignment', 'advanced-gutenberg'),
                            'type'    => 'select',
                            'name'    => 'hAlign',
                            'options' => array(
                                array(
                                    'label' => __('Left', 'advanced-gutenberg'),
                                    'value' => 'flex-start',
                                ),
                                array(
                                    'label' => __('Center', 'advanced-gutenberg'),
                                    'value' => 'center',
                                ),
                                array(
                                    'label' => __('Right', 'advanced-gutenberg'),
                                    'value' => 'flex-end',
                                ),
                            ),
                        ),
                    ),
                ),
            ),
            'advgb-columns' => array(
                array(
                    'label'    => __('Columns Settings', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title'   => __('Space between column', 'advanced-gutenberg'),
                            'type'    => 'select',
                            'name'    => 'gutter',
                            'options' => array(
                                array(
                                    'label' => __('None', 'advanced-gutenberg'),
                                    'value' => 0,
                                ),
                                array(
                                    'label' => __('10px', 'advanced-gutenberg'),
                                    'value' => 10,
                                ),
                                array(
                                    'label' => __('20px', 'advanced-gutenberg'),
                                    'value' => 20,
                                ),
                                array(
                                    'label' => __('30px', 'advanced-gutenberg'),
                                    'value' => 30,
                                ),
                                array(
                                    'label' => __('40px', 'advanced-gutenberg'),
                                    'value' => 40,
                                ),
                                array(
                                    'label' => __('50px', 'advanced-gutenberg'),
                                    'value' => 50,
                                ),
                                array(
                                    'label' => __('70px', 'advanced-gutenberg'),
                                    'value' => 70,
                                ),
                                array(
                                    'label' => __('90px', 'advanced-gutenberg'),
                                    'value' => 90,
                                ),
                            ),
                        ),
                        array(
                            'title'   => __('Vertical space when collapsed', 'advanced-gutenberg'),
                            'type'    => 'select',
                            'name'    => 'collapsedGutter',
                            'options' => array(
                                array(
                                    'label' => __('None', 'advanced-gutenberg'),
                                    'value' => 0,
                                ),
                                array(
                                    'label' => __('10px', 'advanced-gutenberg'),
                                    'value' => 10,
                                ),
                                array(
                                    'label' => __('20px', 'advanced-gutenberg'),
                                    'value' => 20,
                                ),
                                array(
                                    'label' => __('30px', 'advanced-gutenberg'),
                                    'value' => 30,
                                ),
                                array(
                                    'label' => __('40px', 'advanced-gutenberg'),
                                    'value' => 40,
                                ),
                                array(
                                    'label' => __('50px', 'advanced-gutenberg'),
                                    'value' => 50,
                                ),
                                array(
                                    'label' => __('70px', 'advanced-gutenberg'),
                                    'value' => 70,
                                ),
                                array(
                                    'label' => __('90px', 'advanced-gutenberg'),
                                    'value' => 90,
                                ),
                            ),
                        ),
                        array(
                            'title'   => __('Collapsed order RTL', 'advanced-gutenberg'),
                            'type'    => 'checkbox',
                            'name'    => 'collapsedRtl',
                        )
                    ),
                ),
                array(
                    'label'    => __('Row Settings', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title'   => __('Vertical Align', 'advanced-gutenberg'),
                            'type'    => 'select',
                            'name'    => 'vAlign',
                            'options' => array(
                                array(
                                    'label' => __('Top', 'advanced-gutenberg'),
                                    'value' => 'top',
                                ),
                                array(
                                    'label' => __('Middle', 'advanced-gutenberg'),
                                    'value' => 'middle',
                                ),
                                array(
                                    'label' => __('Bottom', 'advanced-gutenberg'),
                                    'value' => 'bottom',
                                ),
                                array(
                                    'label' => __('Full Height', 'advanced-gutenberg'),
                                    'value' => 'full',
                                ),
                            ),
                        ),
                        array(
                            'title'   => __('Columns Wrapped', 'advanced-gutenberg'),
                            'type'    => 'checkbox',
                            'name'    => 'columnsWrapped',
                        ),
                        array(
                            'title'   => __('Wrapper Tag', 'advanced-gutenberg'),
                            'type'    => 'select',
                            'name'    => 'wrapperTag',
                            'options' => array(
                                array(
                                    'label' => __('Div', 'advanced-gutenberg'),
                                    'value' => 'div',
                                ),
                                array(
                                    'label' => __('Header', 'advanced-gutenberg'),
                                    'value' => 'header',
                                ),
                                array(
                                    'label' => __('Section', 'advanced-gutenberg'),
                                    'value' => 'section',
                                ),
                                array(
                                    'label' => __('Main', 'advanced-gutenberg'),
                                    'value' => 'main',
                                ),
                                array(
                                    'label' => __('Article', 'advanced-gutenberg'),
                                    'value' => 'article',
                                ),
                                array(
                                    'label' => __('Aside', 'advanced-gutenberg'),
                                    'value' => 'aside',
                                ),
                                array(
                                    'label' => __('Footer', 'advanced-gutenberg'),
                                    'value' => 'footer',
                                ),
                            ),
                        ),
                        array(
                            'title' => __('Content Max Width', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'contentMaxWidth',
                            'min'   => 0,
                            'max'   => 2000,
                        ),
                        array(
                            'title' => __('Content Min Height', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'contentMinHeight',
                            'min'   => 0,
                            'max'   => 2000,
                        ),
                    ),
                ),
            ),
            'advgb-column' => array(
                array(
                    'label'    => __('Border Settings', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title'   => __('Border style', 'advanced-gutenberg'),
                            'type'    => 'select',
                            'name'    => 'borderStyle',
                            'options' => array(
                                array(
                                    'label' => __('None', 'advanced-gutenberg'),
                                    'value' => 'none',
                                ),
                                array(
                                    'label' => __('Solid', 'advanced-gutenberg'),
                                    'value' => 'solid',
                                ),
                                array(
                                    'label' => __('Dotted', 'advanced-gutenberg'),
                                    'value' => 'dotted',
                                ),
                                array(
                                    'label' => __('Dashed', 'advanced-gutenberg'),
                                    'value' => 'dashed',
                                ),
                            ),
                        ),
                        array(
                            'title' => __('Border Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'borderColor',
                        ),
                        array(
                            'title' => __('Border Width', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'borderWidth',
                            'min'   => 0,
                            'max'   => 20,
                        ),
                        array(
                            'title' => __('Border Radius', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'borderRadius',
                            'min'   => 0,
                            'max'   => 100,
                        ),
                    ),
                ),
                array(
                    'label'    => __('Column Settings', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title'   => __('Text alignment', 'advanced-gutenberg'),
                            'type'    => 'select',
                            'name'    => 'textAlign',
                            'options' => array(
                                array(
                                    'label' => __('Left', 'advanced-gutenberg'),
                                    'value' => 'left',
                                ),
                                array(
                                    'label' => __('Center', 'advanced-gutenberg'),
                                    'value' => 'center',
                                ),
                                array(
                                    'label' => __('Right', 'advanced-gutenberg'),
                                    'value' => 'right',
                                ),
                            ),
                        ),
                    ),
                )
            ),
            'advgb-icon' => array(
                array(
                    'label'    => __('General Settings', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title' => __('Number of icons', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'numberItem',
                            'min'   => 1,
                            'max'   => 10,
                        ),
                    ),
                ),

            ),
            'advgb-infobox' => array(
                array(
                    'label'    => __('Container Settings', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title' => __('Background Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'containerBackground',
                        ),
                        array(
                            'title' => __('Border Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'containerBorderBackground',
                        ),
                        array(
                            'title' => __('Border Width', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'containerBorderWidth',
                            'min'   => 0,
                            'max'   => 40,
                        ),
                        array(
                            'title' => __('Border Radius', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'containerBorderRadius',
                            'min'   => 0,
                            'max'   => 200,
                        ),
                        array(
                            'title' => __('Padding Top', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'containerPaddingTop',
                            'min'   => 0,
                            'max'   => 100,
                        ),
                        array(
                            'title' => __('Padding Bottom', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'containerPaddingBottom',
                            'min'   => 0,
                            'max'   => 100,
                        ),
                        array(
                            'title' => __('Padding Left', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'containerPaddingLeft',
                            'min'   => 0,
                            'max'   => 100,
                        ),
                        array(
                            'title' => __('Padding Right', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'containerPaddingRight',
                            'min'   => 0,
                            'max'   => 100,
                        ),
                    ),
                ),
                array(
                    'label'    => __('Icon Settings', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title' => __('Icon Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'iconColor',
                        ),
                        array(
                            'title' => __('Icon Size', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'iconSize',
                            'min'   => 1,
                            'max'   => 200,
                        ),
                        array(
                            'title' => __('Background Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'iconBackground',
                        ),
                        array(
                            'title' => __('Border Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'iconBorderBackground',
                        ),
                        array(
                            'title' => __('Border Width', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'iconBorderWidth',
                            'min'   => 0,
                            'max'   => 40,
                        ),
                        array(
                            'title' => __('Border Radius', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'iconBorderRadius',
                            'min'   => 0,
                            'max'   => 200,
                        ),
                        array(
                            'title' => __('Padding Top', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'iconPaddingTop',
                            'min'   => 0,
                            'max'   => 100,
                        ),
                        array(
                            'title' => __('Padding Bottom', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'iconPaddingBottom',
                            'min'   => 0,
                            'max'   => 100,
                        ),
                        array(
                            'title' => __('Padding Left', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'iconPaddingLeft',
                            'min'   => 0,
                            'max'   => 100,
                        ),
                        array(
                            'title' => __('Padding Right', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'iconPaddingRight',
                            'min'   => 0,
                            'max'   => 100,
                        ),
                        array(
                            'title' => __('Margin Top', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'iconMarginTop',
                            'min'   => 0,
                            'max'   => 100,
                        ),
                        array(
                            'title' => __('Margin Bottom', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'iconMarginBottom',
                            'min'   => 0,
                            'max'   => 100,
                        ),
                        array(
                            'title' => __('Margin Left', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'iconMarginLeft',
                            'min'   => 0,
                            'max'   => 100,
                        ),
                        array(
                            'title' => __('Margin Right', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'iconMarginRight',
                            'min'   => 0,
                            'max'   => 100,
                        ),
                    ),
                ),
                array(
                    'label'    => __('Title Settings', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title' => __('Title Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'titleColor',
                        ),
                        array(
                            'title' => __('Font Size (px)', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'titleSize',
                            'min'   => 1,
                            'max'   => 200,
                        ),
                        array(
                            'title' => __('Line Height (px)', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'titleLineHeight',
                            'min'   => 1,
                            'max'   => 200,
                        ),
                        array(
                            'title'   => __('HTML Tag', 'advanced-gutenberg'),
                            'type'    => 'select',
                            'name'    => 'titleHtmlTag',
                            'options' => array(
                                array(
                                    'label' => __('H1', 'advanced-gutenberg'),
                                    'value' => 'h1',
                                ),
                                array(
                                    'label' => __('H2', 'advanced-gutenberg'),
                                    'value' => 'h2',
                                ),
                                array(
                                    'label' => __('H3', 'advanced-gutenberg'),
                                    'value' => 'h3',
                                ),
                                array(
                                    'label' => __('H4', 'advanced-gutenberg'),
                                    'value' => 'h4',
                                ),
                                array(
                                    'label' => __('H5', 'advanced-gutenberg'),
                                    'value' => 'h5',
                                ),
                                array(
                                    'label' => __('H6', 'advanced-gutenberg'),
                                    'value' => 'h6',
                                ),
                            ),
                        ),
                        array(
                            'title' => __('Padding Top', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'titlePaddingTop',
                            'min'   => 0,
                            'max'   => 100,
                        ),
                        array(
                            'title' => __('Padding Bottom', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'titlePaddingBottom',
                            'min'   => 0,
                            'max'   => 100,
                        ),
                        array(
                            'title' => __('Padding Left', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'titlePaddingLeft',
                            'min'   => 0,
                            'max'   => 100,
                        ),
                        array(
                            'title' => __('Padding Right', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'titlePaddingRight',
                            'min'   => 0,
                            'max'   => 100,
                        ),
                        array(
                            'title' => __('Margin Top', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'titleMarginTop',
                            'min'   => 0,
                            'max'   => 100,
                        ),
                        array(
                            'title' => __('Margin Bottom', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'titleMarginBottom',
                            'min'   => 0,
                            'max'   => 100,
                        ),
                        array(
                            'title' => __('Margin Left', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'titleMarginLeft',
                            'min'   => 0,
                            'max'   => 100,
                        ),
                        array(
                            'title' => __('Margin Right', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'titleMarginRight',
                            'min'   => 0,
                            'max'   => 100,
                        ),
                    )
                ),
                array(
                    'label'    => __('Text Settings', 'advanced-gutenberg'),
                    'settings' => array(
                        array(
                            'title' => __('Color', 'advanced-gutenberg'),
                            'type'  => 'color',
                            'name'  => 'textColor',
                        ),
                        array(
                            'title' => __('Font Size (px)', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'textSize',
                            'min'   => 1,
                            'max'   => 200,
                        ),
                        array(
                            'title' => __('Line Height (px)', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'textLineHeight',
                            'min'   => 1,
                            'max'   => 200,
                        ),
                        array(
                            'title' => __('Padding Top', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'textPaddingTop',
                            'min'   => 0,
                            'max'   => 100,
                        ),
                        array(
                            'title' => __('Padding Bottom', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'textPaddingBottom',
                            'min'   => 0,
                            'max'   => 100,
                        ),
                        array(
                            'title' => __('Padding Left', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'textPaddingLeft',
                            'min'   => 0,
                            'max'   => 100,
                        ),
                        array(
                            'title' => __('Padding Right', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'textPaddingRight',
                            'min'   => 0,
                            'max'   => 100,
                        ),
                        array(
                            'title' => __('Margin Top', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'textMarginTop',
                            'min'   => 0,
                            'max'   => 100,
                        ),
                        array(
                            'title' => __('Margin Bottom', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'textMarginBottom',
                            'min'   => 0,
                            'max'   => 100,
                        ),
                        array(
                            'title' => __('Margin Left', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'textMarginLeft',
                            'min'   => 0,
                            'max'   => 100,
                        ),
                        array(
                            'title' => __('Margin Right', 'advanced-gutenberg'),
                            'type'  => 'number',
                            'name'  => 'textMarginRight',
                            'min'   => 0,
                            'max'   => 100,
                        ),
                    )
                ),
            ),
        );

        $advgb_blocks_default_config = get_option('advgb_blocks_default_config');
        $current_block = $block;

        if (!isset($blocks_settings_list[$current_block])) {
            wp_die(esc_html(__('Config for this block is currently unsupported. It will coming in the future release.', 'advanced-gutenberg')));
            return;
        }

        $current_block_settings = $blocks_settings_list[$current_block];
        $current_block_settings_value = array();

        if ($advgb_blocks_default_config !== false) {
            if (isset($advgb_blocks_default_config[$current_block])) {
                $current_block_settings_value = $advgb_blocks_default_config[$current_block];
            }
        }

        require_once(plugin_dir_path(__FILE__) . 'view/advanced-gutenberg-block-config.php');
    }

    /**
     * Function to get and load the view
     *
     * @param string $view View to load
     *
     * @return void
     */
    public function loadView($view)
    {
        include_once(plugin_dir_path(__FILE__) . 'view/advanced-gutenberg-' . $view . '.php');
    }

    /**
     * Function to load assets for post/page on front-end before gutenberg rendering
     *
     * @param array $block Block data
     *
     * @return array       New block data
     */
    public function contentPreRender($block)
    {
        // Search for needed blocks then add styles to it
        $style = $this->addBlocksStyles($block);
        array_push($block['innerContent'], $style);

        return $block;
    }


	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - fusion_blocks_Loader. Orchestrates the hooks of the plugin.
	 * - fusion_blocks_i18n. Defines internationalization functionality.
	 * - fusion_blocks_Admin. Defines all hooks for the admin area.
	 * - fusion_blocks_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-prosys-power-block-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-prosys-power-block-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-prosys-power-block-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-prosys-power-block-public.php';

		$this->loader = new fusion_blocks_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the fusion_blocks_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new fusion_blocks_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new fusion_blocks_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new fusion_blocks_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    fusion_blocks_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
     * Add blocks category
     *
     * @param array $categories List of current blocks categories
     *
     * @return array New array include our category
     */
    public function addProsysPowerBlocksCategory($categories)
    {
        return array_merge(
            $categories,
            array(
                array(
                    'slug' => 'ppb-category',
                    'title' => __('Prosys Power Blocks', 'advanced-gutenberg'),
                ),
            )
        );
    }
}
