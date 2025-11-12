<!-- iPhone Simulator Template with Framework7 -->
<div class="iphone-simulator-container" 
     data-app="<?php echo esc_attr($atts['app']); ?>"
     data-lesson="<?php echo esc_attr($atts['lesson']); ?>"
     data-tutorial="<?php echo esc_attr($atts['tutorial']); ?>"
     data-apps="<?php echo esc_attr($atts['apps']); ?>">
    
    <div class="iphone-device">
        <!-- Dynamic Island -->
        <div class="dynamic-island"></div>
        
        <!-- Framework7 App Root -->
        <div id="app" class="framework7-root">
            <!-- Main View -->
            <div class="view view-main view-init" data-url="/">
                <!-- Home Page -->
                <div class="page" data-name="home">
                    <!-- Status Bar (iOS style) -->
                    <div class="statusbar"></div>
                    
                    <!-- Page Content -->
                    <div class="page-content view-home">
                        <!-- App Grid -->
                        <div class="app-grid">
                            <?php
                            $apps_array = explode(',', $atts['apps']);
                            $app_configs = array(
                                'facetime' => array('name' => 'FaceTime', 'gradient' => 'linear-gradient(135deg, #00d084 0%, #00b370 100%)'),
                                'messages' => array('name' => 'Messages', 'gradient' => 'linear-gradient(135deg, #00d300 0%, #00b300 100%)'),
                                'phone' => array('name' => 'Phone', 'gradient' => 'linear-gradient(135deg, #00d084 0%, #00b370 100%)'),
                                'safari' => array('name' => 'Safari', 'gradient' => 'linear-gradient(135deg, #007aff 0%, #0051d5 100%)'),
                            );
                            
                            foreach ($apps_array as $app) {
                                $app = trim($app);
                                if (isset($app_configs[$app])) {
                                    $config = $app_configs[$app];
                                    ?>
                                    <a href="/<?php echo esc_attr($app); ?>/" class="app-icon" data-app="<?php echo esc_attr($app); ?>">
                                        <div class="app-icon-image" style="background: <?php echo esc_attr($config['gradient']); ?>">
                                            <?php if (file_exists(plugin_dir_path(__DIR__) . 'assets/images/' . $app . '.svg')): ?>
                                                <img src="<?php echo esc_url(plugin_dir_url(__DIR__) . 'assets/images/' . $app . '.svg'); ?>" alt="<?php echo esc_attr($config['name']); ?>">
                                            <?php elseif (file_exists(plugin_dir_path(__DIR__) . 'assets/images/' . $app . '.png')): ?>
                                                <img src="<?php echo esc_url(plugin_dir_url(__DIR__) . 'assets/images/' . $app . '.png'); ?>" alt="<?php echo esc_attr($config['name']); ?>">
                                            <?php endif; ?>
                                        </div>
                                        <div class="app-icon-label"><?php echo esc_html($config['name']); ?></div>
                                    </a>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                        
                        <!-- Dock -->
                        <div class="dock">
                            <a href="/phone/" class="app-icon" data-app="phone">
                                <div class="app-icon-image" style="background: linear-gradient(135deg, #00d084 0%, #00b370 100%)">
                                    <img src="<?php echo esc_url(plugin_dir_url(__DIR__) . 'assets/images/phone.png'); ?>" alt="Phone">
                                </div>
                            </a>
                            <a href="/messages/" class="app-icon" data-app="messages">
                                <div class="app-icon-image" style="background: linear-gradient(135deg, #00d300 0%, #00b300 100%)">
                                    <img src="<?php echo esc_url(plugin_dir_url(__DIR__) . 'assets/images/messages.svg'); ?>" alt="Messages">
                                </div>
                            </a>
                            <a href="/safari/" class="app-icon" data-app="safari">
                                <div class="app-icon-image" style="background: linear-gradient(135deg, #007aff 0%, #0051d5 100%)">
                                    <img src="<?php echo esc_url(plugin_dir_url(__DIR__) . 'assets/images/safari.svg'); ?>" alt="Safari">
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FaceTime Page Template -->
<template id="facetime-page-template">
    <div class="page" data-name="facetime">
        <div class="navbar">
            <div class="navbar-bg"></div>
            <div class="navbar-inner">
                <div class="left">
                    <a href="#" class="link back">
                        <i class="icon icon-back"></i>
                    </a>
                </div>
                <div class="title">FaceTime</div>
            </div>
        </div>
        <div class="page-content" style="background: linear-gradient(180deg, #1c1c1e 0%, #000 50%);">
            <!-- Contact Grid -->
            <div class="contact-grid">
                <div class="contact-card" data-contact="martin">
                    <div class="contact-avatar" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">M</div>
                    <div class="contact-name">Martin T</div>
                    <div class="contact-action">
                        <i class="f7-icons">videocam_fill</i>
                        <span>FaceTime</span>
                    </div>
                </div>
                <div class="contact-card" data-contact="david">
                    <div class="contact-avatar" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">D</div>
                    <div class="contact-name">David L</div>
                    <div class="contact-action">
                        <i class="f7-icons">videocam_fill</i>
                        <span>FaceTime</span>
                    </div>
                </div>
                <div class="contact-card" data-contact="maggie">
                    <div class="contact-avatar" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">M</div>
                    <div class="contact-name">Maggie T</div>
                    <div class="contact-action">
                        <i class="f7-icons">videocam_fill</i>
                        <span>FaceTime</span>
                    </div>
                </div>
                <div class="contact-card" data-contact="avery">
                    <div class="contact-avatar" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">A</div>
                    <div class="contact-name">Avery H</div>
                    <div class="contact-action">
                        <i class="f7-icons">videocam_fill</i>
                        <span>FaceTime</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<!-- Video Call Page Template -->
<template id="video-call-template">
    <div class="page" data-name="video-call">
        <div class="page-content video-call-screen">
            <!-- Remote Video -->
            <div class="remote-video" id="remoteVideo">
                <div style="font-size: 48px;">👤</div>
            </div>
            
            <!-- Local Video PIP -->
            <div class="local-video-pip" id="localVideo">
                <div style="font-size: 32px;">📹</div>
            </div>
            
            <!-- Toolbar with video controls -->
            <div class="toolbar toolbar-bottom toolbar-video-controls">
                <div class="toolbar-inner">
                    <div class="video-control-buttons">
                        <button class="video-control-btn btn-white" id="videoButton">
                            <i class="f7-icons">video_fill</i>
                        </button>
                        <button class="video-control-btn btn-white" id="muteButton">
                            <i class="f7-icons">mic_fill</i>
                        </button>
                        <button class="video-control-btn btn-gray" id="moreButton">
                            <i class="f7-icons">ellipsis</i>
                        </button>
                        <button class="video-control-btn btn-red" id="endCallButton">
                            <i class="f7-icons">phone_down_fill</i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<!-- Incoming Call Overlay -->
<div class="incoming-call-screen" id="incomingCallScreen" style="display: none;">
    <div class="caller-info">
        <div class="caller-avatar">M</div>
        <div class="caller-name">Martin Topp</div>
        <div class="call-type">FaceTime Video</div>
    </div>
    <div class="call-actions">
        <div class="call-action-btn" id="declineCall">
            <div class="call-action-icon decline">
                <i class="f7-icons">phone_down_fill</i>
            </div>
            <div class="call-action-label">Decline</div>
        </div>
        <div class="call-action-btn" id="acceptCall">
            <div class="call-action-icon accept">
                <i class="f7-icons">phone_fill</i>
            </div>
            <div class="call-action-label">Accept</div>
        </div>
    </div>
</div>

<!-- Tutorial Overlay -->
<div class="tutorial-overlay" id="tutorialOverlay" style="display: none;">
    <div class="tutorial-content">
        <h2 class="tutorial-title" id="tutorialTitle"></h2>
        <p class="tutorial-text" id="tutorialText"></p>
        <button class="tutorial-button" id="tutorialButton">Continue</button>
    </div>
</div>
