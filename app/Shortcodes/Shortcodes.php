<?php
namespace WilokeListgoShortcode\Shortcodes;

class Shortcodes{
    public $aTagsAllowable = '<i><ul><li><h1><h2><h3><h4><h5><h6><a><strong><ol><blockquote><code><ins><img>';
    public $gallery_types = array();

	public function __construct() {
		add_shortcode('wiloke_list_features', array($this, 'renderListFeatures'));
	}

	public function renderListFeatures($aAtts){
		$aAtts = shortcode_atts(
			array(
				'id' => '',
				'data-settings' => '',
				'data-title' => '',
				'class'
			),
			$aAtts
		);

		if ( empty($aAtts['data-settings']) ){
			return '';
		}

		$aItems = json_decode(urldecode(base64_decode($aAtts['data-settings'])), true);
		ob_start();
		?>
        <?php if ( !empty($aAtts['data-title']) ) : ?>
        <h3><?php echo esc_html($aAtts['data-title']); ?></h3>
        <?php endif; ?>
        <ul id="<?php echo esc_attr($aAtts['id']); ?>" class="wil-icon-list wiloke-list-features-new-version">
			<?php
			foreach ( $aItems as $aItem ) :
				$active = !empty($aItem['unavailable']) ? 'disable' : 'enable';
            ?>
                <li class="<?php echo esc_attr($active); ?>"><i class="icon_box-checked"></i> <?php \Wiloke::ksesHTML($aItem['name']); ?></li>
            <?php endforeach; ?>
        </ul>
		<?php
		return ob_get_clean();
    }
}
