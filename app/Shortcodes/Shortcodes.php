<?php

namespace WilokeListgoShortcode\Shortcodes;

class Shortcodes
{
	public $aTagsAllowable = '<i><ul><li><h1><h2><h3><h4><h5><h6><a><strong><ol><blockquote><code><ins><img>';
	public $gallery_types  = [];

	public function __construct()
	{
		add_shortcode('wiloke_list_features', [$this, 'renderListFeatures']);
		add_shortcode('wiloke_accordion', [$this, 'renderAccordionShortcode']);
		add_shortcode('wiloke_price_table', [$this, 'renderPriceTable']);
		add_shortcode('embed_video', [$this, 'renderEmbedVideo']);
		add_shortcode('accordions', [$this, 'renderAccordions']);
		add_shortcode('accordion', [$this, 'renderAccordionItem']);
		add_shortcode('list_features', [$this, 'listFeaturesShortcode']);
		add_shortcode('list_item', [$this, 'listItemShortcode']);
		add_action('wp_enqueue_scripts', [$this, 'enqueueScripts']);
	}

	public function renderAccordionShortcode($aAtts)
	{
		$aAtts = shortcode_atts(
			[
				'id'            => '',
				'data-settings' => '',
				'data-title'    => '',
				'class'
			],
			$aAtts
		);

		if (empty($aAtts['data-settings'])) {
			return '';
		}

		$aItems = json_decode(urldecode(base64_decode($aAtts['data-settings'])), true);
		ob_start();
		?>
		<?php if (!empty($aAtts['data-title'])) : ?>
        <h3><?php echo esc_html($aAtts['data-title']); ?></h3>
	<?php endif; ?>
        <div id="<?php echo esc_attr($aAtts['id']); ?>"
             class="wil_accordion wil_accordion--1 wiloke-accordion-new-version">
			<?php
			$i = 0;
			foreach ($aItems as $aItem) :
				$active = $i == 0 ? 'active' : 'notactive';
				?>
                <h3 class="wil_accordion__header <?php echo esc_attr($active); ?>"><a
                            href="#<?php echo esc_attr($aAtts['id'] .
								$i); ?>"><?php echo esc_html($aItem['title']); ?></a></h3>
                <div id="<?php echo esc_attr($aAtts['id'] . $i); ?>"
                     class="wil_accordion__content <?php echo esc_attr($active); ?>"><?php echo wpautop($aItem['description']); ?></div>
				<?php $i++; endforeach; ?>
        </div>
		<?php
		return ob_get_clean();
	}


	public function listItemShortcode($aAtts)
	{
		$aAtts = shortcode_atts(
			[
				'status'  => 'checked',
				'content' => 'Wifi'
			],
			$aAtts
		);
		$status = $aAtts['status'] === 'unchecked' ? 'disable' : 'enable';
		ob_start();
		?>
        <li class="<?php echo esc_attr($status); ?>"><i
                    class="icon_box-checked"></i> <?php \Wiloke::ksesHTML($aAtts['content']); ?></li>
		<?php
		return ob_get_clean();
	}

	public function listFeaturesShortcode($atts, $content)
	{
		$content = strip_tags($content, '<i><a><strong>');
		return '<ul class="wil-icon-list">' . do_shortcode($content) . '</ul>';
	}


	public function renderAccordions($aAtts, $content)
	{
		$content = strip_tags($content, $this->aTagsAllowable);
		return '<div class="wil_accordion wil_accordion--1">' . do_shortcode($content) . '</div>';
	}

	public function renderAccordionItem($aAtts)
	{
		$aAtts = shortcode_atts(
			[
				'default_expanded' => 'no',
				'question'         => 'How to keep balance in my life?',
				'answer'           => 'Life is like riding a bicycle. To keep your balance you must keep moving.'
			],
			$aAtts
		);
		$active = $aAtts['default_expanded'] === 'no' ? 'notactive' : 'active';
		$id = uniqid('wiloke_');
		ob_start();
		?>
        <h3 class="wil_accordion__header <?php echo esc_attr($active); ?>"><a
                    href="#<?php echo esc_attr($id); ?>"><?php echo esc_html($aAtts['question']); ?></a></h3>
        <div id="<?php echo esc_attr($id); ?>"
             class="wil_accordion__content <?php echo esc_attr($active); ?>"><?php echo wpautop($aAtts['answer']); ?></div>
		<?php
		return ob_get_clean();
	}

	public function renderEmbedVideo($aAtts, $content)
	{
		$aAtts = shortcode_atts(
			[
				'customClass' => ''
			],
			$aAtts
		);

		if (empty($content) || !is_single()) {
			return false;
		}
		$cssClass = 'embed-responsive embed-responsive-16by9';
		$cssClass .= $aAtts['customClass'];

		if (strpos($content, 'youtube') !== false && strpos($content, 'embed') === false) {
			$aParseVideo = explode('watch?v=', $content);
			$getYoutubeID = $aParseVideo[1];

			$getYoutubeID = preg_replace_callback('/\&amp;t=(.*)/', function ($match) {
				return '';
			}, $getYoutubeID);
			$content = 'https://www.youtube.com/embed/' . $getYoutubeID;
		}

		ob_start();
		?>
        <div class="<?php echo esc_attr($cssClass); ?>">
            <iframe class="embed-responsive-item" src="<?php echo esc_url($content); ?>" width="420" height="315"
                    frameborder="0" allowfullscreen></iframe>
        </div>
		<?php
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}

	public function enqueueScripts()
	{
		wp_enqueue_style('listgo-style', WILOKE_LISTGO_SHORTCODES . 'assets/css/style.css', []);
	}

	public function renderPriceTable($aAtts)
	{
		$aAtts = shortcode_atts(
			[
				'id'            => '',
				'data-settings' => '',
				'data-title'    => '',
				'class'
			],
			$aAtts
		);


		if (empty($aAtts['data-settings'])) {
			return '';
		}

		$aItems = json_decode(urldecode(base64_decode($aAtts['data-settings'])), true);

		ob_start();
		?>
        <div id="<?php echo esc_attr($aAtts['id']); ?>" class="listgo-menu-price-wrapper wiloke-menu-price-new-version">
			<?php if (!empty($aAtts['data-title'])) : ?>
                <h3><?php echo esc_html($aAtts['data-title']); ?></h3>
			<?php endif; ?>
            <ul class="wil-menus">
				<?php foreach ($aItems as $aItem) : ?>
                    <li>
						<?php if (!empty($aItem['name'])) : ?>
                            <h4 class="wil-menus__title"><?php echo esc_html($aItem['name']); ?></h4>
						<?php endif; ?>
						<?php if (!empty($aItem['price'])) : ?>
                            <span class="wil-menus__price"><?php echo esc_html($aItem['price']); ?></span>
						<?php endif; ?>
						<?php if (!empty($aItem['description'])) : ?>
                            <p class="wil-menus__description"><?php \Wiloke::ksesHTML($aItem['description']); ?></p>
						<?php endif; ?>
                    </li>
				<?php endforeach; ?>
            </ul>
        </div>
		<?php
		return ob_get_clean();
	}

	public function renderListFeatures($aAtts)
	{
		$aAtts = shortcode_atts(
			[
				'id'            => '',
				'data-settings' => '',
				'data-title'    => '',
				'class'
			],
			$aAtts
		);

		if (empty($aAtts['data-settings'])) {
			return '';
		}

		$aItems = json_decode(urldecode(base64_decode($aAtts['data-settings'])), true);
		ob_start();
		?>
		<?php if (!empty($aAtts['data-title'])) : ?>
        <h3><?php echo esc_html($aAtts['data-title']); ?></h3>
	<?php endif; ?>
        <ul id="<?php echo esc_attr($aAtts['id']); ?>" class="wil-icon-list wiloke-list-features-new-version">
			<?php
			foreach ($aItems as $aItem) :
				$active = !empty($aItem['unavailable']) ? 'disable' : 'enable';
				?>
                <li class="<?php echo esc_attr($active); ?>"><i
                            class="icon_box-checked"></i> <?php \Wiloke::ksesHTML($aItem['name']); ?></li>
			<?php endforeach; ?>
        </ul>
		<?php
		return ob_get_clean();
	}
}
