<?php
/**
 * Elementor Widget for iPhone Simulator
 */

if (!defined('ABSPATH')) {
    exit;
}

class iPhone_Simulator_Elementor_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'iphone_simulator';
    }

    public function get_title() {
        return 'iPhone Simulator';
    }

    public function get_icon() {
        return 'eicon-device-mobile';
    }

    public function get_categories() {
        return ['general'];
    }

    public function get_keywords() {
        return ['iphone', 'simulator', 'tutorial', 'digital', 'literacy', 'facetime', 'mobile'];
    }

    protected function register_controls() {
        
        // Content Section
        $this->start_controls_section(
            'content_section',
            [
                'label' => 'Simulator Settings',
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'app',
            [
                'label' => 'Starting App',
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'facetime',
                'options' => [
                    'home' => 'Home Screen',
                    'facetime' => 'FaceTime',
                    'messages' => 'Messages',
                    'phone' => 'Phone',
                    'facebook' => 'Facebook',
                    'twitter' => 'Twitter',
                    'whatsapp' => 'WhatsApp',
                ],
                'description' => 'Which app should open when the simulator loads?',
            ]
        );

        $this->add_control(
            'lesson',
            [
                'label' => 'Lesson Type',
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'call-martin',
                'options' => [
                    'call-martin' => 'FaceTime: Call Martin',
                    'send-message' => 'Messages: Send Message (Coming Soon)',
                    'make-call' => 'Phone: Make Call (Coming Soon)',
                    'post-facebook' => 'Facebook: Make Post (Coming Soon)',
                ],
                'description' => 'Select which tutorial lesson to display',
            ]
        );

        $this->add_control(
            'tutorial',
            [
                'label' => 'Enable Tutorial',
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => 'Yes',
                'label_off' => 'No',
                'return_value' => 'true',
                'default' => 'true',
                'description' => 'Show step-by-step tutorial guidance',
            ]
        );

        $this->add_control(
            'apps',
            [
                'label' => 'Available Apps',
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'default' => ['facetime', 'messages', 'phone', 'facebook', 'twitter', 'whatsapp'],
                'options' => [
                    'facetime' => 'FaceTime',
                    'messages' => 'Messages',
                    'phone' => 'Phone',
                    'facebook' => 'Facebook',
                    'twitter' => 'Twitter',
                    'whatsapp' => 'WhatsApp',
                ],
                'description' => 'Which apps should appear on the home screen?',
            ]
        );

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'style_section',
            [
                'label' => 'Style',
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'container_background',
            [
                'label' => 'Container Background',
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .iphone-simulator-container' => 'background: {{VALUE}}',
                ],
                'description' => 'Background color for the simulator container',
            ]
        );

        $this->add_responsive_control(
            'container_padding',
            [
                'label' => 'Container Padding',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .iphone-simulator-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'scale',
            [
                'label' => 'iPhone Scale',
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0.5,
                        'max' => 1.5,
                        'step' => 0.05,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0.95,
                ],
                'selectors' => [
                    '{{WRAPPER}} .iphone-device' => 'transform: scale({{SIZE}});',
                ],
            ]
        );

        $this->end_controls_section();

        // Advanced Section
        $this->start_controls_section(
            'advanced_section',
            [
                'label' => 'Advanced',
                'tab' => \Elementor\Controls_Manager::TAB_ADVANCED,
            ]
        );

        $this->add_control(
            'custom_css_class',
            [
                'label' => 'Custom CSS Class',
                'type' => \Elementor\Controls_Manager::TEXT,
                'description' => 'Add a custom CSS class to the simulator container',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        
        // Convert apps array to comma-separated string
        $apps = is_array($settings['apps']) ? implode(',', $settings['apps']) : $settings['apps'];
        
        // Prepare attributes
        $atts = [
            'app' => $settings['app'],
            'lesson' => $settings['lesson'],
            'tutorial' => $settings['tutorial'],
            'apps' => $apps,
        ];
        
        // Add custom CSS class if provided
        $css_class = !empty($settings['custom_css_class']) ? ' ' . esc_attr($settings['custom_css_class']) : '';
        
        // Render the simulator
        echo '<div class="elementor-iphone-simulator' . $css_class . '">';
        echo iPhone_Simulator_Plugin::get_instance()->render_iphone_simulator($atts);
        echo '</div>';
    }

    protected function content_template() {
        ?>
        <#
        var apps = settings.apps;
        if (Array.isArray(apps)) {
            apps = apps.join(',');
        }
        
        var cssClass = settings.custom_css_class ? ' ' + settings.custom_css_class : '';
        #>
        
        <div class="elementor-iphone-simulator{{{ cssClass }}}">
            <div class="iphone-simulator-container" 
                 data-app="{{ settings.app }}"
                 data-lesson="{{ settings.lesson }}"
                 data-tutorial="{{ settings.tutorial }}"
                 data-apps="{{ apps }}">
                
                <div class="iphone-device">
                    <div class="dynamic-island"></div>
                    
                    <div class="iphone-screen">
                        <div class="status-bar">
                            <div class="status-time">9:41</div>
                            <div class="status-icons">
                                <span class="status-icon">📶</span>
                                <span class="status-icon">📡</span>
                                <span class="status-icon">🔋</span>
                            </div>
                        </div>
                        
                        <div class="app-content">
                            <div class="home-screen active">
                                <div class="home-screen-wallpaper"></div>
                                <div class="app-grid">
                                    <!-- Apps will be rendered here -->
                                    <div style="color: #fff; text-align: center; padding: 20px; grid-column: 1 / -1;">
                                        <p>Preview: iPhone Simulator</p>
                                        <small>Apps configured: {{ apps }}</small>
                                    </div>
                                </div>
                                <div class="home-indicator"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
