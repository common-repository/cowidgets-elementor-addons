<?php
/**
 * Elementor Classes.
 *
 * @package CoWidgets
 */

namespace COWIDGETS\WidgetsManager\Widgets;

use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Core\Schemes\Color;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;   // Exit if accessed directly.
}

/**
 * Elementor Vjosa Slider
 *
 * Elementor widget for Kiri Slider.
 *
 * @since 1.0.0
 */
class Vjosa_Slider extends Widget_Base {

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'vjosa-slider';
	}
	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Vjosa Slider', 'cowidgets' );
	}
	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'ce-icon-vjosa-slider';
	}
	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'ce-content-widgets' ];
	}

	public function get_script_depends() {
		return [ 'ce-vjosa-slider' ];
	}

	/**
	 * Register Copyright controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() { //phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore
		$this->register_vjosa_slider_controls();
	}
	/**
	 * Register Copyright General Controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_vjosa_slider_controls() {
		\COWIDGETS_Helpers::slidesSelectionSection( $this );

        $this->start_controls_section(
			'section_slider_layout_other',
			[
				'label'     => __( 'Slider Layout', 'cowidgets' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
			]
		);
        $this->add_control(
            'slider_layout',
            [
                'label' => __( 'Slider Layout', 'cowidgets' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'vertical_boxed',
                'multiple' => false,
                'options' => [
                    'vertical_boxed' => __('Vertical Boxed', 'cowidgets'),
                    'vertical_fullscreen' => __('Vertical Fullscreen', 'cowidgets'),
                ],
            ]
        );

        $this->end_controls_section();

		$this->start_controls_section(
			'section_content_other',
			[
				'label'     => __( 'See All Work Button', 'cowidgets' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'button_text',
			[
				'label' => __( 'Button text', 'cowidgets' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'see all works',
			]
		);

		$this->add_control(
			'button_link',
			[
				'label' => __( 'Button Link', 'cowidgets' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'cowidgets' ),
				'show_external' => true,
				'default' => [
					'url' => '#',
					'is_external' => true,
					'nofollow' => false,
				],
			]
		);

		$this->end_controls_section();
		

		$this->start_controls_section(
			'section_style_slider',
			[
				'label'     => __( 'Slider', 'cowidgets' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);
			$this->add_control(
				'slider_background_color',
				[
					'label'     => __( 'Background Color', 'cowidgets' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#000000',
					'selectors' => [
						'{{WRAPPER}} .ce-vjosa-slider' => 'background-color: {{VALUE}}',
					],
					
				]
			);

			$this->add_control(
				'image_overlay_color',
				[
					'label'     => __( 'Images Overlay Color', 'cowidgets' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => 'rgba(0,0,0,0.1)',
					'selectors' => [
						'{{WRAPPER}} .ce-vjosa-slider .slide-img:after' => 'background-color: {{VALUE}}',
					],
					
				]
			);
		
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'title_typography',
				'separator' => 'before',
				'selector'  => '{{WRAPPER}} .ce-vjosa-slider .slide-title a',
			]
		);
		
		$this->add_control(
            'text_color',
            [
                'label'     => __( 'Text Color', 'cowidgets' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
					'{{WRAPPER}} .ce-vjosa-slider' => 'color: {{VALUE}}',
                ],
                
            ]
		);
        
        

		$this->end_controls_section();
	}

	/**
	 * Render Copyright output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$slider_type = 'images';
		if( $settings['source_type'] == 'videos' )
			$slider_type = 'videos';

		?>
		<div class="ce-vjosa-slider" data-slider-type="<?php echo esc_attr( $slider_type ) ?>" data-slider-layout="<?php echo esc_attr( $settings['slider_layout'] ) ?>" data-actual-index="2">
			<!-- Additional required wrapper -->
            <div class="slider-wrapper">
    	
            <?php 

			$slides = \COWIDGETS_Helpers::getslidesSelection( $settings );
		
			?> 

            <div class="images-wrapper">
                
                <?php
                $nr = 0;
                if( !empty($slides) ): 
                    foreach($slides as $slide): 
                        

                        $extra_class = '';
                        $load_lazy = 'data-';
                        if( $nr == 2 ){
                            $extra_class = 'active';
                            $load_lazy = '';
						}
						$load_lazy = '';
                ?>
                    <div class="slide-img <?php echo esc_attr( $extra_class ) ?>">
						<?php if( $settings['source_type'] != 'videos' ): ?>
							<img loading="lazy" <?php echo esc_attr($load_lazy) ?>src="<?php echo esc_url( $slide['src'] ) ?>" alt="slide alt" />
							<a href="<?php echo esc_url( $slide['permalink'] ) ?>" class="image-link"></a>
							<div class="cl-load-vortex"></div>
						<?php endif; ?>

						<?php if( $settings['source_type'] == 'videos' ): ?>
						<video muted loop <?php if( $nr == 2 ) echo 'autoplay' ?>>
						 	<?php if( $slide['video_media'] && is_array( $slide['video_media'] ) ): ?>
							<source src="<?php echo esc_url( $slide['video_media']['url'] ) ?>" type="<?php echo esc_attr( get_post_mime_type( $slide['video_media']['id'] ) ) ?>">
							<?php endif; ?>
						</video>
						<?php endif; ?>
                    </div>
                    <?php $nr++; endforeach; ?>
                <?php endif; ?>

            </div>

            <div class="title-wrapper">
            <?php
            $nr = 0;
            if( !empty($slides) ): 
                foreach($slides as $slide): 

                    

                    $extra_class = '';
                    if( $nr == 2 )
                        $extra_class = 'active';
					
            ?>
				<?php if( $settings['source_type'] != 'videos' ): ?>
                <div class="slide-title <?php echo esc_attr( $extra_class ) ?>" data-id="<?php echo esc_attr( $nr ) ?>"><a href="<?php echo esc_url( $slide['permalink'] ) ?>"><span><?php echo esc_html( $slide['title'] ) ?></span><svg width="56" height="56" viewBox="0 0 56 56" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M0.0625 50.3125L42.4375 7.9375H16V0.0625H55.9375V40H48.0625V13.5625L5.6875 55.9375L0.0625 50.3125Z" fill="white"/>
</svg>
</a></div>
				<?php endif; ?>
				
				<?php if( $settings['source_type'] == 'videos' ): ?>
                <div class="slide-title <?php echo esc_attr( $extra_class ) ?>" data-id="<?php echo esc_attr( $nr ) ?>"><a href="<?php echo esc_url( $slide['video_permalink']['url'] ) ?>"><span><?php echo esc_html( $slide['video_title'] ) ?></span><svg width="56" height="56" viewBox="0 0 56 56" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M0.0625 50.3125L42.4375 7.9375H16V0.0625H55.9375V40H48.0625V13.5625L5.6875 55.9375L0.0625 50.3125Z" fill="white"/>
</svg>
</a></div>
				<?php endif; ?>

                <?php $nr++; endforeach; ?>
            <?php endif; ?>

                </div>

        </div> 

        <div class="project-number">
            <span class="text"><?php esc_html_e('Project', 'remake'); ?></span>
            <span class="actual">3</span>
            <span class="total"> / <?php echo count( $slides ) ?></span>
        </div>


        <a href="<?php echo esc_url( $settings['button_link']['url'] ) ?>" class="all-works"><?php echo esc_html( $settings['button_text'] ) ?></a>
		
		
		</div>
		<?php
	}

	/**
	 * Render shortcode widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function content_template() {}

	/**
	 * Render shortcode output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * Remove this after Elementor v3.3.0
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _content_template() {
		$this->content_template();
	}
}