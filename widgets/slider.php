 <?php

class ElementorCommerce_Slider_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'elementorcommerce-slider';
	}

	public function get_title() {
		return __( 'Elementor Commerce Slider', 'plugin-name' );
	}

	public function get_icon() {
		return 'fa fa-code';
	}

	public function get_categories() {
		return [ 'general' ];
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'plugin-name' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'slide_title', [
				'label' => __( 'Title', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Slide Title' , 'plugin-domain' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'slide_content', [
				'label' => __( 'Content', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => __( 'Slide Content' , 'plugin-domain' ),
				'show_label' => true,
			]
		);

		$repeater->add_control(
			'slide_decription',
			[
				'label' => __( 'Slide Decription', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'show_label' => true,
			]
		);

		$repeater->add_control(
			'slide_image',
			[
				'label' => __( 'Image', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'show_label' => true,
			]
		);


		$this->add_control(
			'slides',
			[
				'label' => __( 'Slide', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'list_title' => __( 'Slider #1', 'plugin-domain' ),
						'list_content' => __( 'Content', 'plugin-domain' ),
					],
				]
			]
		);

		$this->add_control(
			'auto_play',
			[
				'label' => __( 'Auto Play', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'your-plugin' ),
				'label_off' => __( 'Off', 'your-plugin' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->end_controls_section();



	}

	
	protected function render() {

		$settings = $this->get_settings_for_display();

		if($settings['slides']){
			$dynamic_id = rand(487643,435345);	
			if(count($settings['slides']) > 1){
			    echo '<script>
			    jQuery(document).ready(function($){
			        $("#slides-'.$dynamic_id.'").slick({
			            autoplay: ' . ( 'yes' === $settings['auto_play'] ? 'true' : 'false') . ',
			            autoplaySpeed: 2000,
			        });
			    });
			    </script>';
			}
			echo '<div id="slides-'.$dynamic_id.'" class="slides">';
			foreach ($settings['slides'] as $slide) {
				echo '<div class="single-slide-item" style="background-image:url('.wp_get_attachment_image_url($slide['slide_image']['id'],'large').')">
					<div class="row">
						<div class="col my-auto">
							'.wpautop($slide['slide_content']).'
						</div>
					</div>
					<div class="slide-info">
						<h4>'.$slide['slide_title'].'</h4>
						'.$slide['slide_decription'].'
					</div>
				</div>';				
			}
			echo '</div>';
		}		
	}
}