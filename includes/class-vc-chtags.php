<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/Pando-Studio/containers-html-tags-selector
 * @since      1.0.0
 *
 * @package    Vc_Chtags
 * @subpackage Vc_Chtags/includes
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
 * @package    Vc_Chtags
 * @subpackage Vc_Chtags/includes
 * @author     Pando Studio <yacine@pando-studio.com>
 */
class Vc_Chtags
{

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Vc_Chtags_Loader    $loader    Maintains and registers all hooks for the plugin.
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
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct()
	{
		if (defined('VC_CHTAGS_VERSION')) {
			$this->version = VC_CHTAGS_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'vc-chtags';
		$this->plugin_path = 'vc-chtags/vc-chtags.php';
		$this->dependency_plugin_name = 'WPBakery Page Builder';
		$this->dependency_plugin_path = 'js_composer/js_composer.php';

		$this->load_dependencies();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Vc_Chtags_Loader. Orchestrates the hooks of the plugin.
	 * - Vc_Chtags_Admin. Defines all hooks for the admin area.
	 * - Vc_Chtags_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies()
	{

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-vc-chtags-loader.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-vc-chtags-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-vc-chtags-public.php';

		$this->loader = new Vc_Chtags_Loader();
		/**
		 * If the dependency plugin is loaded, continue running the current plugin
		 */
		if ($this->is_dependency_plugin_active($this->plugin_name, $this->plugin_path, $this->dependency_plugin_name, $this->dependency_plugin_path, 'vc-chtags')) {
			$this->load_custom_vc();
		}
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks()
	{

		$plugin_admin = new Vc_Chtags_Admin($this->get_plugin_name(), $this->get_version());

		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks()
	{

		$plugin_public = new Vc_Chtags_Public($this->get_plugin_name(), $this->get_version());

		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run()
	{
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name()
	{
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Vc_Chtags_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader()
	{
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version()
	{
		return $this->version;
	}

	/**
	 * Verify if a plugin is active, if not deactivate the actual plugin an show an error
	 * 
	 * @since     1.0.0
	 * @param     string     $my_plugin_name            The plugin name trying to activate. The name of this plugin
	 * @param     string     $my_plugin_path            Path of the current plugin.
	 * @param     string     $dependency_plugin_name    The dependency plugin name.
	 * @param     string     $dependency_plugin_path    Path of the plugin to verify with the format 'dependency_plugin/dependency_plugin.php'
	 * @param     string     $textdomain                Text domain to looking the localization (the translated strings)
	 * @param     string     $version_to_check          Optional, verify certain version of the dependent plugin
	 * @return    boolean                               Returns true if the dependcy plugin is loaded, if not return false
	 */
	function is_dependency_plugin_active($my_plugin_name, $my_plugin_path, $dependency_plugin_name, $dependency_plugin_path, $textdomain = '', $version_to_check = null)
	{
		# Needed to the function "deactivate_plugins" works
		include_once(ABSPATH . 'wp-admin/includes/plugin.php');

		if (!is_plugin_active($dependency_plugin_path)) {
			# Deactivate the current plugin
			deactivate_plugins($my_plugin_path);

			# Show an error alert on the admin area
			add_action('admin_notices', function () use ($my_plugin_name, $dependency_plugin_name) {
?>
				<div class="updated error">
					<p>
						<?php
						echo ('The plugin <strong>' . $my_plugin_name . '</strong> needs the plugin <strong>' . $dependency_plugin_name . '</strong> active');
						echo '<br>';
						echo '<strong>' . $my_plugin_name . ' has been deactivated</strong>'
						?>
					</p>
				</div>
<?php
				if (isset($_GET['activate']))
					unset($_GET['activate']);
			});
			return false;
		} else {
			if (isset($_GET['activate']))
				unset($_GET['activate']);
			return true;
		}
	}

	/**
	 * Create an array with the name of vc templates
	 * 
	 * @since     1.0.0
	 * @return    object    Return array of the vc templates
	 */
	public function chtags_wpbakery_element_list()
	{
		$element_list = array(
			'vc_row_inner',
			'vc_column_inner',
			'vc_column',
			'vc_row',
		);

		return $element_list;
	}

	/**
	 * Create html tags list for seo.
	 * 
	 * @since     1.0.0
	 * @return    array    The list of html tags
	 */
	public function chtags_html_element_list()
	{

		$html_tags = array(
			"div"   => 'div',
			"header"   => 'header',
			"nav"   => 'nav',
			"main"   => 'main',
			"footer"   => 'footer',
			"section"   => 'section',
			"article"   => 'article',
			"aside"   => 'aside',
			"details"   => 'details',
			"summary"   => 'summary',
			"figure"   => 'figure',
			"figcaption"   => 'figcaption',
			"time"   => 'time',
			"mark"   => 'mark',
			"small"   => 'small'
		);

		return $html_tags;
	}


	/**
	 * Load the new parameters for the custom input
	 * 
	 * @since     1.0.0
	 */
	public function load_custom_vc()
	{
		$plugin_admin = new Vc_Chtags_Admin($this->get_plugin_name(), $this->get_version());

		vc_add_param('vc_column', array(
			"type"       => "dropdown",
			"heading"    => "HTML Tag",
			"param_name" => "html_tag_column",
			"value"      => $this->chtags_html_element_list(),
			"description" => __("This will wrap the current container with the selected html tag.", "vc_chtags"),
			'weight' => 1
		));

		vc_add_param('vc_row', array(
			"type"       => "dropdown",
			"heading"    => "HTML Tag",
			"param_name" => "html_tag_row",
			"value"      => $this->chtags_html_element_list(),
			"description" => __("This will wrap the current container with the selected html tag.", "vc_chtags"),
			'weight' => 1
		));

		vc_add_param('vc_row_inner', array(
			"type"       => "dropdown",
			"heading"    => "HTML Tag",
			"param_name" => "html_tag_row_inner",
			"value"      => $this->chtags_html_element_list(),
			"description" => __("This will wrap the current container with the selected html tag.", "vc_chtags"),
			'weight' => 1
		));

		vc_add_param('vc_column_inner', array(
			"type"       => "dropdown",
			"heading"    => "HTML Tag",
			"param_name" => "html_tag_column_inner",
			"value"      => $this->chtags_html_element_list(),
			"description" => __("This will wrap the current container with the selected html tag.", "vc_chtags"),
			'weight' => 1
		));

		$this->set_new_vc_path();
	}

	/**
	 * To override directory of templates files
	 * 
	 * @since    1.0.0
	 */
	public function set_new_vc_path()
	{
		vc_set_shortcodes_templates_dir(WP_PLUGIN_DIR . '/vc-chtags/includes/vc_templates');
	}
}
