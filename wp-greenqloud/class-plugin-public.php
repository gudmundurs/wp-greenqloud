<?php
class GreenQloudWordPressPluginPublic {
    var $options;
    var $s3;
	var $meta;

	function GreenQloudWordPressPluginPublic() {
		$this->options = array();
		if (file_exists(dirname(__FILE__).'/config.php')) {
			require_once(dirname(__FILE__).'/config.php');
			if ($TanTanWordPressS3Config) $this->options = $TanTanWordPressS3Config;
		}
		add_action('plugins_loaded', array(&$this, 'addhooks'));
	}
    function addhooks() {
		add_filter('wp_get_attachment_url', array(&$this, 'wp_get_attachment_url'), 9, 2);
	}
	function wp_get_attachment_url($url, $postID) {
        if (!$this->options) $this->options = get_option('greenqloud_wordpress_s3');
        
        if ($this->options['wp-uploads'] && ($amazon = get_post_meta($postID, 'greenqloudS3_info', true))) {
            $accessDomain = $this->options['virtual-host'] ? $amazon['bucket'] : $amazon['bucket'].'.s.greenqloud.com';
            return 'http://'.$accessDomain.'/'.$amazon['keys'][0];
        } else {
            return $url;
        }
    }
}
?>