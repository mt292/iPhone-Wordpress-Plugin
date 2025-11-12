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
                            'safari' => array('name' => 'Safari', 'icon' => ''),
                            'facebook' => array('name' => 'Facebook', 'icon' => ''),
                            'twitter' => array('name' => 'Twitter', 'icon' => ''),
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
                        <div class="app-icon-wrapper" data-app="phone">
                            <div class="app-icon phone"></div>
                        </div>
                        <div class="app-icon-wrapper" data-app="messages">
                            <div class="app-icon messages"></div>
                        </div>
                        <div class="app-icon-wrapper" data-app="safari">
                            <div class="app-icon safari"></div>
                        </div>
                    </div>
                    
                    <!-- Home Indicator -->
                    <div class="home-indicator"></div>
                </div>
                
                <!-- Incoming Call Screen -->
                <div class="incoming-call-screen" id="incomingCallScreen">
                    <div class="incoming-call-overlay">
                        <div class="incoming-call-header">
                            <span class="incoming-call-label">FaceTime Video</span>
                            <h2 class="incoming-caller-name">Martin Topp</h2>
                        </div>
                        
                        <div class="incoming-caller-avatar-large">
                            <div class="caller-avatar-circle" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">M</div>
                        </div>
                        
                        <div class="incoming-call-actions">
                            <div class="incoming-action-buttons">
                                <button class="incoming-btn decline-btn" id="declineIncomingCall">
                                    <div class="btn-icon decline-icon"></div>
                                    <span class="btn-label">Decline</span>
                                </button>
                                <button class="incoming-btn accept-btn" id="acceptIncomingCall">
                                    <div class="btn-icon accept-icon"></div>
                                    <span class="btn-label">Accept</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- FaceTime App -->
                <div class="facetime-app" id="facetimeApp">
                    <button class="app-back-button" id="backButton">‹</button>
                    
                    <!-- Contact Selection Screen -->
                    <div class="contact-selection active" id="contactSelection">
                        <div class="facetime-header">
                            <button class="facetime-edit-btn">Edit</button>
                            <h2>FaceTime</h2>
                            <button class="facetime-menu-btn">☰</button>
                        </div>
                        
                        <div class="contact-grid" id="contactGrid">
                            <div class="contact-card" data-contact="martin" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <div class="contact-card-name">Martin</div>
                                <div class="contact-card-avatar">M</div>
                                <div class="contact-card-status">
                                    <span class="video-icon">▶</span> Video<br>Yesterday
                                </div>
                                <button class="contact-video-btn"></button>
                            </div>
                            
                            <div class="contact-card" data-contact="david" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                                <div class="contact-card-name">Antonio</div>
                                <div class="contact-card-avatar">D</div>
                                <div class="contact-card-status">
                                    <span class="video-icon">▶</span> Video<br>Yesterday
                                </div>
                                <button class="contact-video-btn"></button>
                            </div>
                            
                            <div class="contact-card" data-contact="maggie" style="background: linear-gradient(135deg, #ff6b6b 0%, #c92a2a 100%);">
                                <div class="contact-card-name">Danny</div>
                                <div class="contact-card-avatar">M</div>
                                <div class="contact-card-status">
                                    <span class="video-icon">▶</span> 00:09<br>Yesterday
                                </div>
                                <button class="contact-video-btn"></button>
                            </div>
                            
                            <div class="contact-card" data-contact="avery" style="background: linear-gradient(135deg, #feca57 0%, #ee5a24 100%);">
                                <div class="contact-card-name">Brian</div>
                                <div class="contact-card-avatar">A</div>
                                <div class="contact-card-status">
                                    <span class="video-icon">▶</span> Video<br>Yesterday
                                </div>
                                <button class="contact-video-btn"></button>
                            </div>
                            
                            <div class="contact-card" data-contact="alicia" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                                <div class="contact-card-name">Alicia</div>
                                <div class="contact-card-avatar">AL</div>
                                <div class="contact-card-status">
                                    <span class="video-icon">▶</span> Video<br>Yesterday
                                </div>
                                <button class="contact-video-btn"></button>
                            </div>
                            
                            <div class="contact-card" data-contact="alejandra" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                                <div class="contact-card-name">Alejandra</div>
                                <div class="contact-card-avatar">AJ</div>
                                <div class="contact-card-status">
                                    <span class="video-icon">▶</span> Video<br>Yesterday
                                </div>
                                <button class="contact-video-btn"></button>
                            </div>
                        </div>
                        
                        <!-- New Call Button -->
                        <button class="new-call-btn-bottom">
                            <span class="video-camera-icon"></span> NEW CALL
                        </button>
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
                        <!-- Full screen remote video -->
                        <div class="remote-video-fullscreen">
                            <div class="remote-avatar" id="remoteAvatar">M</div>
                        </div>
                        
                        <!-- Top bar with caller info -->
                        <div class="video-call-header">
                            <div class="caller-badge">
                                <div class="caller-badge-avatar">M</div>
                                <span class="caller-badge-name" id="callerBadgeName">Charlie</span>
                            </div>
                            <button class="video-expand-btn">⚪</button>
                        </div>
                        
                        <!-- Local video (picture-in-picture) -->
                        <div class="local-video-pip" id="localVideo">
                            <div class="video-hidden-overlay">Camera Off</div>
                            <button class="pip-camera-toggle">📷</button>
                        </div>
                        
                        <!-- Vertical control buttons on right side -->
                        <div class="video-call-controls">
                            <button class="video-control-btn video-btn" id="videoButton" title="Hide/Show Camera">
                                <svg width="24" height="20" viewBox="0 0 24 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0 4C0 1.79086 1.79086 0 4 0H13C15.2091 0 17 1.79086 17 4V16C17 18.2091 15.2091 20 13 20H4C1.79086 20 0 18.2091 0 16V4Z" fill="#1c1c1e"/>
                                    <path d="M17 6L23 2V18L17 14V6Z" fill="#1c1c1e"/>
                                </svg>
                            </button>
                            <button class="video-control-btn mute-btn" id="muteButton" title="Mute/Unmute">
                                <svg width="18" height="24" viewBox="0 0 18 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9 0C6.79086 0 5 1.79086 5 4V12C5 14.2091 6.79086 16 9 16C11.2091 16 13 14.2091 13 12V4C13 1.79086 11.2091 0 9 0Z" fill="#1c1c1e"/>
                                    <path d="M3 10V12C3 15.866 6.13401 19 10 19V22H8V24H10H12V22H10V19C13.866 19 17 15.866 17 12V10H15V12C15 14.7614 12.7614 17 10 17C7.23858 17 5 14.7614 5 12V10H3Z" fill="#1c1c1e"/>
                                </svg>
                            </button>
                            <button class="video-control-btn more-btn" id="moreButton" title="More Options">•••</button>
                            <button class="video-control-btn end-btn" id="endCallButton" title="End Call">✕</button>
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
