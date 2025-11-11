<?php
/**
 * Admin Settings Page
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="wrap">
    <h1>
        <span class="dashicons dashicons-smartphone" style="font-size: 32px; width: 32px; height: 32px;"></span>
        iPhone Simulator Settings
    </h1>
    
    <div style="background: #fff; padding: 20px; margin: 20px 0; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <h2>Welcome to iPhone Simulator for Digital Literacy!</h2>
        <p style="font-size: 16px; line-height: 1.6;">
            This plugin helps you teach seniors digital literacy through interactive, realistic iPhone simulations.
            You can add the simulator to any page using a shortcode or through Elementor.
        </p>
    </div>
    
    <div class="iphone-sim-admin-grid" style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin: 20px 0;">
        <div>
            <div style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <h2>How to Use</h2>
                
                <h3>Using Shortcode</h3>
                <p>Add the simulator to any page or post with this shortcode:</p>
                <code style="display: block; background: #f5f5f5; padding: 15px; border-radius: 4px; margin: 10px 0; font-size: 14px;">
                    [iphone_simulator app="facetime" lesson="call-martin" tutorial="true" apps="facetime,messages,phone,facebook,twitter,whatsapp"]
                </code>
                
                <h4>Shortcode Parameters:</h4>
                <ul style="line-height: 1.8;">
                    <li><strong>app</strong> - Starting app: <code>home</code>, <code>facetime</code>, <code>messages</code>, <code>phone</code>, <code>facebook</code>, <code>twitter</code>, <code>whatsapp</code></li>
                    <li><strong>lesson</strong> - Tutorial type: <code>call-martin</code> (more coming soon)</li>
                    <li><strong>tutorial</strong> - Enable tutorial: <code>true</code> or <code>false</code></li>
                    <li><strong>apps</strong> - Available apps (comma-separated)</li>
                </ul>
                
                <h3 style="margin-top: 30px;">Using with Elementor</h3>
                <ol style="line-height: 1.8;">
                    <li>Edit any page with Elementor</li>
                    <li>Search for "iPhone Simulator" in the widgets panel</li>
                    <li>Drag the widget to your page</li>
                    <li>Configure settings in the left panel</li>
                    <li>Preview and publish!</li>
                </ol>
            </div>
            
            <div style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-top: 20px;">
                <h2>Plugin Settings</h2>
                
                <form method="post" action="options.php">
                    <?php
                    settings_fields('iphone_simulator_settings');
                    do_settings_sections('iphone_simulator_settings');
                    ?>
                    
                    <table class="form-table">
                        <tr>
                            <th scope="row">
                                <label for="iphone_sim_default_apps">Default Apps</label>
                            </th>
                            <td>
                                <select name="iphone_sim_default_apps" id="iphone_sim_default_apps" multiple style="width: 100%; height: 120px;">
                                    <?php
                                    $default_apps = get_option('iphone_sim_default_apps', 'facetime,messages,phone,facebook,twitter,whatsapp');
                                    $selected_apps = explode(',', $default_apps);
                                    $all_apps = array(
                                        'facetime' => 'FaceTime',
                                        'messages' => 'Messages',
                                        'phone' => 'Phone',
                                        'facebook' => 'Facebook',
                                        'twitter' => 'Twitter',
                                        'whatsapp' => 'WhatsApp'
                                    );
                                    
                                    foreach ($all_apps as $key => $label) {
                                        $selected = in_array($key, $selected_apps) ? 'selected' : '';
                                        echo '<option value="' . esc_attr($key) . '" ' . $selected . '>' . esc_html($label) . '</option>';
                                    }
                                    ?>
                                </select>
                                <p class="description">Select which apps should be available by default</p>
                            </td>
                        </tr>
                        
                        <tr>
                            <th scope="row">
                                <label for="iphone_sim_tutorial_speed">Tutorial Speed</label>
                            </th>
                            <td>
                                <select name="iphone_sim_tutorial_speed" id="iphone_sim_tutorial_speed">
                                    <?php
                                    $tutorial_speed = get_option('iphone_sim_tutorial_speed', 'normal');
                                    ?>
                                    <option value="slow" <?php selected($tutorial_speed, 'slow'); ?>>Slow (Best for beginners)</option>
                                    <option value="normal" <?php selected($tutorial_speed, 'normal'); ?>>Normal</option>
                                    <option value="fast" <?php selected($tutorial_speed, 'fast'); ?>>Fast</option>
                                </select>
                                <p class="description">How fast tutorial transitions should occur</p>
                            </td>
                        </tr>
                        
                        <tr>
                            <th scope="row">
                                <label for="iphone_sim_avatar_style">Avatar Style</label>
                            </th>
                            <td>
                                <select name="iphone_sim_avatar_style" id="iphone_sim_avatar_style">
                                    <?php
                                    $avatar_style = get_option('iphone_sim_avatar_style', 'memoji');
                                    ?>
                                    <option value="memoji" <?php selected($avatar_style, 'memoji'); ?>>Memoji Style (Emoji)</option>
                                    <option value="initials" <?php selected($avatar_style, 'initials'); ?>>Initials Only</option>
                                    <option value="gradient" <?php selected($avatar_style, 'gradient'); ?>>Gradient Circles</option>
                                </select>
                                <p class="description">Visual style for contact avatars</p>
                            </td>
                        </tr>
                    </table>
                    
                    <?php submit_button('Save Settings'); ?>
                </form>
            </div>
        </div>
        
        <div>
            <div style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <h2>Quick Start</h2>
                <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; padding: 15px; border-radius: 6px; margin-bottom: 15px;">
                    <h3 style="margin: 0 0 10px 0; color: #fff;">Example Page</h3>
                    <p style="margin: 0; font-size: 14px;">Try this shortcode on a test page:</p>
                    <code style="display: block; background: rgba(255,255,255,0.2); padding: 10px; border-radius: 4px; margin-top: 10px; word-break: break-all; color: #fff;">
                        [iphone_simulator]
                    </code>
                </div>
                
                <h3>Features</h3>
                <ul style="line-height: 1.8;">
                    <li>Realistic iOS 18 design</li>
                    <li>Dynamic Island animation</li>
                    <li>Interactive FaceTime calls</li>
                    <li>Step-by-step tutorials</li>
                    <li>Mute/Camera controls</li>
                    <li>Fully responsive</li>
                    <li>Elementor integration</li>
                </ul>
                
                <h3 style="margin-top: 25px;">Available Lessons</h3>
                <div style="border-left: 3px solid #30d158; padding-left: 12px; margin: 10px 0;">
                    <strong>FaceTime: Call Martin</strong>
                    <p style="margin: 5px 0; font-size: 13px; color: #666;">Learn to make video calls, mute mic, hide camera, and end calls</p>
                </div>
                
                <div style="border-left: 3px solid #ccc; padding-left: 12px; margin: 10px 0;">
                    <strong>More Lessons Coming Soon!</strong>
                    <p style="margin: 5px 0; font-size: 13px; color: #666;">Messages, Phone, Facebook, and more</p>
                </div>
            </div>
            
            <div style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-top: 20px;">
                <h3>Tips for Educators</h3>
                <ul style="line-height: 1.8; font-size: 14px;">
                    <li>Start with tutorial mode enabled</li>
                    <li>Let students practice multiple times</li>
                    <li>Use on large screens for clarity</li>
                    <li>Combine with verbal instruction</li>
                    <li>Celebrate their progress!</li>
                </ul>
            </div>
            
            <div style="background: #f0f9ff; border: 2px solid #3b82f6; padding: 20px; border-radius: 8px; margin-top: 20px;">
                <h3 style="margin-top: 0; color: #1e40af;">Support & Updates</h3>
                <p style="font-size: 14px; line-height: 1.6; color: #1e3a8a;">
                    Need help or have suggestions? Visit our GitHub repository for documentation, updates, and support.
                </p>
                <a href="https://github.com/mt292/iPhone-Wordpress-Plugin" target="_blank" style="display: inline-block; background: #3b82f6; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 6px; margin-top: 10px;">
                    View on GitHub
                </a>
                <p style="font-size: 12px; color: #64748b; margin-top: 20px; padding-top: 15px; border-top: 1px solid #e2e8f0;">
                    Developed by <strong>Martin Topp</strong> | <a href="https://mtsaga.net" target="_blank" style="color: #3b82f6;">mtsaga.net</a>
                </p>
            </div>
        </div>
    </div>
</div>

<style>
    .iphone-sim-admin-grid code {
        font-family: 'Courier New', monospace;
    }
    
    .iphone-sim-admin-grid h2 {
        margin-top: 0;
        padding-bottom: 10px;
        border-bottom: 2px solid #f0f0f0;
    }
    
    .iphone-sim-admin-grid h3 {
        margin-top: 20px;
        color: #333;
    }
    
    @media (max-width: 1024px) {
        .iphone-sim-admin-grid {
            grid-template-columns: 1fr !important;
        }
    }
</style>
