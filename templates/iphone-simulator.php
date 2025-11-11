<!-- iPhone Simulator Template -->
<div class="iphone-simulator-container" 
     data-app="<?php echo esc_attr($atts['app']); ?>"
     data-lesson="<?php echo esc_attr($atts['lesson']); ?>"
     data-tutorial="<?php echo esc_attr($atts['tutorial']); ?>"
     data-apps="<?php echo esc_attr($atts['apps']); ?>">
    
    <div class="iphone-device">
        <!-- Dynamic Island -->
        <div class="dynamic-island"></div>
        
        <!-- Screen -->
        <div class="iphone-screen">
            <!-- Status Bar -->
            <div class="status-bar">
                <div class="status-time"><?php echo date('g:i'); ?></div>
                <div class="status-icons">
                    <span class="status-icon status-signal"></span>
                    <span class="status-icon status-wifi"></span>
                    <span class="status-icon status-battery"></span>
                </div>
            </div>
            
            <!-- App Content Area -->
            <div class="app-content">
                <!-- Home Screen -->
                <div class="home-screen active" id="homeScreen">
                    <div class="home-screen-wallpaper"></div>
                    
                    <div class="app-grid">
                        <?php
                        $apps_array = explode(',', $atts['apps']);
                        $app_configs = array(
                            'facetime' => array('name' => 'FaceTime', 'icon' => ''),
                            'messages' => array('name' => 'Messages', 'icon' => ''),
                            'phone' => array('name' => 'Phone', 'icon' => ''),
                            'facebook' => array('name' => 'Facebook', 'icon' => 'f'),
                            'twitter' => array('name' => 'Twitter', 'icon' => '𝕏'),
                            'whatsapp' => array('name' => 'WhatsApp', 'icon' => '')
                        );
                        
                        foreach ($apps_array as $app) {
                            $app = trim($app);
                            if (isset($app_configs[$app])) {
                                $config = $app_configs[$app];
                                echo '<div class="app-icon-wrapper" data-app="' . esc_attr($app) . '">';
                                echo '<div class="app-icon ' . esc_attr($app) . '">';
                                echo esc_html($config['icon']);
                                echo '</div>';
                                echo '<div class="app-name">' . esc_html($config['name']) . '</div>';
                                echo '</div>';
                            }
                        }
                        ?>
                    </div>
                    
                    <!-- Dock -->
                    <div class="dock">
                        <div class="app-icon safari" style="background: linear-gradient(135deg, #007AFF 0%, #0051D5 100%); color: white;"></div>
                        <div class="app-icon mail" style="background: linear-gradient(135deg, #007AFF 0%, #0051D5 100%); color: white;"></div>
                        <div class="app-icon music" style="background: linear-gradient(135deg, #FF2D55 0%, #D70015 100%); color: white;"></div>
                    </div>
                    
                    <!-- Home Indicator -->
                    <div class="home-indicator"></div>
                </div>
                
                <!-- FaceTime App -->
                <div class="facetime-app" id="facetimeApp">
                    <button class="app-back-button" id="backButton">‹</button>
                    
                    <!-- Contact Selection Screen -->
                    <div class="contact-selection active" id="contactSelection">
                        <div class="facetime-header">
                            <h2>FaceTime</h2>
                            <p class="facetime-subtitle">Video & Audio Calls</p>
                        </div>
                        
                        <input type="text" 
                               class="contact-search" 
                               placeholder="Search contacts..."
                               id="contactSearch">
                        
                        <div class="contact-list" id="contactList">
                                                        <div class="contact-item" data-contact="martin">
                                <div class="contact-avatar">M</div>
                                <div class="contact-name">Martin Smith</div>
                                <button class="contact-call-button"></button>
                            </div>
                            
                            <div class="contact-item" data-contact="sarah">
                                <div class="contact-avatar">S</div>
                                <div class="contact-name">Sarah Johnson</div>
                                <button class="contact-call-button"></button>
                            </div>
                            
                            <div class="contact-item" data-contact="david">
                                <div class="contact-avatar">D</div>
                                <div class="contact-name">David Lee</div>
                                <button class="contact-call-button"></button>
                            </div>
                            
                            <div class="contact-item" data-contact="emma">
                                <div class="contact-avatar">E</div>
                                <div class="contact-name">Emma Davis</div>
                                <button class="contact-call-button"></button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Calling Screen -->
                    <div class="calling-screen" id="callingScreen">
                        <div class="caller-info">
                            <div class="caller-avatar-large" id="callerAvatar">M</div>
                            <h2 class="caller-name" id="callerName">Martin</h2>
                            <p class="call-status" id="callStatus">Calling...</p>
                        </div>
                        
                        <div class="call-controls">
                            <button class="control-button end-call" id="endCallEarly">✖</button>
                        </div>
                    </div>
                    
                    <!-- Video Call Screen -->
                    <div class="video-call-screen" id="videoCallScreen">
                        <div class="remote-video">
                            <div class="remote-avatar" id="remoteAvatar">M</div>
                        </div>
                        
                        <div class="local-video" id="localVideo">
                            <div class="video-hidden-overlay">Camera Off</div>
                        </div>
                        
                        <div class="call-controls">
                            <button class="control-button mute" id="muteButton" title="Mute/Unmute">
                            </button>
                            <button class="control-button end-call" id="endCallButton" title="End Call">
                                ✖
                            </button>
                            <button class="control-button video" id="videoButton" title="Hide/Show Camera">
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Messages App (Placeholder for future) -->
                <div class="messages-app" id="messagesApp" style="display: none;">
                    <button class="app-back-button" id="messagesBackButton">‹</button>
                    <div style="color: #fff; text-align: center; padding: 100px 20px;">
                        <h2>Messages</h2>
                        <p style="color: #8e8e93;">Coming soon...</p>
                    </div>
                </div>
                
                <!-- Phone App (Placeholder for future) -->
                <div class="phone-app" id="phoneApp" style="display: none;">
                    <button class="app-back-button" id="phoneBackButton">‹</button>
                    <div style="color: #fff; text-align: center; padding: 100px 20px;">
                        <h2>Phone</h2>
                        <p style="color: #8e8e93;">Coming soon...</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Tutorial Overlay -->
        <div class="tutorial-overlay" id="tutorialOverlay">
            <div class="tutorial-content">
                <p class="tutorial-step" id="tutorialStep">STEP 1 OF 5</p>
                <h3 class="tutorial-title" id="tutorialTitle">Welcome to FaceTime</h3>
                <p class="tutorial-description" id="tutorialDescription">
                    Let's learn how to make a video call to Martin. We'll walk through each step together.
                </p>
                <button class="tutorial-button" id="tutorialButton">Start Lesson</button>
            </div>
        </div>
    </div>
</div>
