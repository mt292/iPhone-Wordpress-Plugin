/**
 * iPhone Simulator JavaScript
 * Handles all interactions and tutorial system
 */

(function($) {
    'use strict';

    class iPhoneSimulator {
        constructor(container) {
            this.container = $(container);
            this.app = this.container.data('app');
            this.lesson = this.container.data('lesson');
            this.tutorialEnabled = this.container.data('tutorial') === 'true' || this.container.data('tutorial') === true;
            this.currentStep = 0;
            this.tutorialSteps = [];
            
            this.init();
        }

        init() {
            this.setupElements();
            this.bindEvents();
            
            if (this.tutorialEnabled) {
                this.initTutorial();
            }
            
            // Auto-open app if specified
            if (this.app && this.app !== 'home') {
                setTimeout(() => {
                    if (this.tutorialEnabled) {
                        this.showTutorialOverlay();
                    } else {
                        this.openApp(this.app);
                    }
                }, 500);
            }
        }

        setupElements() {
            // Main screens
            this.$homeScreen = this.container.find('#homeScreen');
            this.$facetimeApp = this.container.find('#facetimeApp');
            this.$incomingCallScreen = this.container.find('#incomingCallScreen');
            
            // FaceTime screens
            this.$contactSelection = this.container.find('#contactSelection');
            this.$callingScreen = this.container.find('#callingScreen');
            this.$videoCallScreen = this.container.find('#videoCallScreen');
            
            // Tutorial
            this.$tutorialOverlay = this.container.find('#tutorialOverlay');
            
            // Dynamic Island
            this.$dynamicIsland = this.container.find('.dynamic-island');
        }

        bindEvents() {
            const self = this;
            
            // App icons click
            this.container.on('click', '.app-icon-wrapper', function() {
                const app = $(this).data('app');
                self.openApp(app);
            });
            
            // Back button
            this.container.on('click', '.app-back-button', function() {
                self.goHome();
            });
            
            // Contact call buttons - Updated for new card layout
            this.container.on('click', '.contact-card, .contact-video-btn', function(e) {
                e.stopPropagation();
                const $card = $(this).hasClass('contact-card') ? $(this) : $(this).closest('.contact-card');
                const contactName = $card.find('.contact-card-name').text();
                const contactAvatar = $card.find('.contact-card-avatar').text();
                const contactGradient = $card.attr('style');
                self.startCall(contactName, contactAvatar, contactGradient);
            });
            
            // Old contact list support (backwards compatibility)
            this.container.on('click', '.contact-call-button, .contact-item', function(e) {
                if (!$(e.target).hasClass('contact-call-button')) {
                    // Only trigger if clicking the button or the item itself
                    if ($(this).hasClass('contact-item')) {
                        const contactName = $(this).find('.contact-name').text();
                        const contactAvatar = $(this).find('.contact-avatar').text();
                        const contactGradient = $(this).find('.contact-avatar').attr('style');
                        self.startCall(contactName, contactAvatar, contactGradient);
                    }
                } else {
                    const $item = $(this).closest('.contact-item');
                    const contactName = $item.find('.contact-name').text();
                    const contactAvatar = $item.find('.contact-avatar').text();
                    const contactGradient = $item.find('.contact-avatar').attr('style');
                    self.startCall(contactName, contactAvatar, contactGradient);
                }
            });
            
            // Call controls
            this.container.on('click', '#muteButton', function() {
                self.toggleMute();
            });
            
            this.container.on('click', '#videoButton', function() {
                self.toggleVideo();
            });
            
            this.container.on('click', '#speakerButton', function() {
                self.toggleSpeaker();
            });
            
            this.container.on('click', '#endCallButton, #endCallEarly', function() {
                self.endCall();
            });
            
            // Tutorial button
            this.container.on('click', '#tutorialButton', function() {
                self.nextTutorialStep();
            });
            
            // Incoming call buttons
            this.container.on('click', '#acceptIncomingCall', function() {
                self.acceptIncomingCall();
            });
            
            this.container.on('click', '#declineIncomingCall', function() {
                self.declineIncomingCall();
            });
            
            // Contact search
            this.container.on('input', '#contactSearch', function() {
                self.filterContacts($(this).val());
            });
        }

        openApp(app) {
            this.animateDynamicIsland();
            
            this.$homeScreen.removeClass('active').fadeOut(300);
            
            setTimeout(() => {
                switch(app) {
                    case 'facetime':
                        this.$facetimeApp.addClass('active').fadeIn(300);
                        break;
                    case 'messages':
                        this.container.find('#messagesApp').show().addClass('fade-in');
                        break;
                    case 'phone':
                        this.container.find('#phoneApp').show().addClass('fade-in');
                        break;
                    default:
                        // Other apps - do nothing, just go back home
                        this.goHome();
                }
            }, 300);
        }

        goHome() {
            // Hide all apps and screens
            this.$facetimeApp.removeClass('active').fadeOut(300);
            this.$incomingCallScreen.removeClass('active').fadeOut(300);
            this.container.find('#messagesApp, #phoneApp').hide();
            
            // Reset FaceTime screens
            this.$contactSelection.addClass('active').show();
            this.$callingScreen.removeClass('active').hide();
            this.$videoCallScreen.removeClass('active').hide();
            
            // Show home screen
            setTimeout(() => {
                this.$homeScreen.addClass('active').fadeIn(300);
            }, 300);
        }
        
        showIncomingCall() {
            this.$homeScreen.removeClass('active');
            this.$incomingCallScreen.addClass('active').fadeIn(300);
            this.animateDynamicIsland(true);
        }
        
        acceptIncomingCall() {
            // Hide incoming call screen
            this.$incomingCallScreen.removeClass('active').fadeOut(300);
            
            // Go directly to video call screen
            setTimeout(() => {
                this.$videoCallScreen.addClass('active').fadeIn(300);
                
                // Set up caller info for Martin Topp
                this.container.find('#remoteAvatar').text('M');
                this.container.find('#remoteAvatar').attr('style', 'background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);');
                this.container.find('#callerBadgeName').text('Martin Topp');
                this.container.find('.caller-badge-avatar').text('M');
                this.container.find('.caller-badge-avatar').attr('style', 'background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);');
            }, 300);
        }
        
        declineIncomingCall() {
            this.$incomingCallScreen.removeClass('active').fadeOut(300);
            setTimeout(() => {
                this.$homeScreen.addClass('active').fadeIn(300);
            }, 300);
        }

        startCall(contactName, contactAvatar, gradient) {
            // Update caller info
            this.container.find('#callerName').text(contactName);
            this.container.find('#callerAvatar').text(contactAvatar);
            if (gradient) {
                this.container.find('#callerAvatar').attr('style', gradient);
            }
            this.container.find('#callStatus').text('Calling...');
            
            // Show calling screen
            this.$contactSelection.removeClass('active').fadeOut(300);
            setTimeout(() => {
                this.$callingScreen.addClass('active').fadeIn(300);
                this.animateDynamicIsland(true);
                
                // Auto-answer after 2 seconds
                setTimeout(() => {
                    this.answerCall(contactName, contactAvatar, gradient);
                }, 2000);
            }, 300);
        }

        answerCall(contactName, contactAvatar, gradient) {
            // Update status
            this.container.find('#callStatus').text('Connecting...');
            
            setTimeout(() => {
                // Update remote video info
                this.container.find('#remoteAvatar').text(contactAvatar);
                if (gradient) {
                    this.container.find('#remoteAvatar').attr('style', gradient);
                }
                
                // Update caller badge in video call
                this.container.find('#callerBadgeName').text(contactName);
                this.container.find('.caller-badge-avatar').text(contactAvatar);
                if (gradient) {
                    this.container.find('.caller-badge-avatar').attr('style', gradient);
                }
                
                // Show video call screen
                this.$callingScreen.removeClass('active').fadeOut(300);
                setTimeout(() => {
                    this.$videoCallScreen.addClass('active').fadeIn(300);
                }, 300);
            }, 1000);
        }

        toggleMute() {
            const $button = this.container.find('#muteButton');
            $button.toggleClass('active');
            
            if ($button.hasClass('active')) {
                this.showNotification('Microphone muted');
            } else {
                this.showNotification('Microphone on');
            }
        }

        toggleVideo() {
            const $button = this.container.find('#videoButton');
            const $localVideo = this.container.find('#localVideo, .local-video-pip');
            const $overlay = $localVideo.find('.video-hidden-overlay');
            
            $button.toggleClass('active');
            
            if ($button.hasClass('active')) {
                $overlay.show();
                this.showNotification('Camera off');
            } else {
                $overlay.hide();
                this.showNotification('Camera on');
            }
        }

        toggleSpeaker() {
            const $button = this.container.find('#speakerButton');
            $button.toggleClass('active');
            
            if ($button.hasClass('active')) {
                this.showNotification('Speaker on');
            } else {
                this.showNotification('Speaker off');
            }
        }

        endCall() {
            this.$videoCallScreen.removeClass('active').fadeOut(300);
            this.animateDynamicIsland();
            
            // Reset controls
            this.container.find('#muteButton').removeClass('active');
            this.container.find('#videoButton').removeClass('active');
            this.container.find('#speakerButton').removeClass('active');
            this.container.find('.local-video-pip .video-hidden-overlay').hide();
            
            setTimeout(() => {
                if (this.tutorialEnabled && this.currentStep < this.tutorialSteps.length - 1) {
                    // Show next tutorial step
                    this.nextTutorialStep();
                } else {
                    // Go back to home screen
                    this.goHome();
                }
            }, 300);
        }

        animateDynamicIsland(expand = false) {
            if (expand) {
                this.$dynamicIsland.addClass('expanded');
                setTimeout(() => {
                    this.$dynamicIsland.removeClass('expanded');
                }, 2000);
            } else {
                this.$dynamicIsland.addClass('expanded');
                setTimeout(() => {
                    this.$dynamicIsland.removeClass('expanded');
                }, 1000);
            }
        }

        showNotification(message) {
            // Create temporary notification
            const $notification = $('<div class="iphone-notification">')
                .text(message)
                .css({
                    position: 'absolute',
                    top: '60px',
                    left: '50%',
                    transform: 'translateX(-50%)',
                    background: 'rgba(44, 44, 46, 0.95)',
                    color: '#fff',
                    padding: '12px 20px',
                    borderRadius: '10px',
                    fontSize: '14px',
                    zIndex: '10000',
                    boxShadow: '0 4px 16px rgba(0, 0, 0, 0.3)',
                    opacity: '0',
                    transition: 'opacity 0.3s ease'
                });
            
            this.container.find('.iphone-screen').append($notification);
            
            setTimeout(() => $notification.css('opacity', '1'), 10);
            setTimeout(() => {
                $notification.css('opacity', '0');
                setTimeout(() => $notification.remove(), 300);
            }, 2000);
        }

        filterContacts(query) {
            const $contacts = this.container.find('.contact-item');
            
            if (!query) {
                $contacts.show();
                return;
            }
            
            $contacts.each(function() {
                const name = $(this).find('.contact-name').text().toLowerCase();
                if (name.includes(query.toLowerCase())) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }

        // ===== TUTORIAL SYSTEM =====

        initTutorial() {
            // Define tutorial steps based on lesson
            if (this.lesson === 'call-martin') {
                this.tutorialSteps = [
                    {
                        title: 'Welcome to FaceTime',
                        description: 'Let\'s learn how to make a video call to Martin. We\'ll walk through each step together.',
                        action: () => {
                            // Show tutorial overlay first, then open app when user clicks Start
                        },
                        buttonText: 'Start Lesson'
                    },
                    {
                        title: 'Open FaceTime',
                        description: 'First, find and tap the FaceTime app icon on the home screen to open it.',
                        highlight: '.app-icon-wrapper[data-app="facetime"]',
                        action: () => {
                            // Highlight FaceTime app and wait for user to click it
                            const $facetimeIcon = this.container.find('.app-icon-wrapper[data-app="facetime"]');
                            $facetimeIcon.addClass('highlight-element');
                            
                            // Wait for user to open FaceTime
                            $facetimeIcon.one('click', () => {
                                $facetimeIcon.removeClass('highlight-element');
                                setTimeout(() => {
                                    this.nextTutorialStep();
                                }, 500);
                            });
                        },
                        buttonText: 'Show Me'
                    },
                    {
                        title: 'Find the Contact',
                        description: 'Look for Martin in your contacts list. Tap on Martin to select him.',
                        highlight: '.contact-card[data-contact="martin"]',
                        action: () => {
                            // Enable clicking on Martin
                            const $martin = this.container.find('.contact-card[data-contact="martin"]');
                            $martin.addClass('highlight-element');
                            
                            // Wait for user to click
                            $martin.one('click', () => {
                                $martin.removeClass('highlight-element');
                                setTimeout(() => {
                                    this.nextTutorialStep();
                                }, 2500); // Wait for call to connect
                            });
                        },
                        buttonText: 'Show Me'
                    },
                    {
                        title: 'Video Call Connected',
                        description: 'Great! Martin answered and you\'re now on a video call. Let\'s learn about the call controls.',
                        action: () => {
                            // Just show this message while on call
                        },
                        buttonText: 'Continue',
                        autoAdvance: 2500
                    },
                    {
                        title: 'Mute Your Microphone',
                        description: 'The microphone button lets you mute yourself during a call. Try tapping it now.',
                        highlight: '#muteButton',
                        action: () => {
                            const $muteBtn = this.container.find('#muteButton');
                            $muteBtn.addClass('highlight-element');
                            
                            $muteBtn.one('click', () => {
                                $muteBtn.removeClass('highlight-element');
                                setTimeout(() => {
                                    this.nextTutorialStep();
                                }, 1500);
                            });
                        },
                        buttonText: 'Show Me'
                    },
                    {
                        title: 'Hide Your Camera',
                        description: 'You can turn off your camera by tapping the video button. Give it a try!',
                        highlight: '#videoButton',
                        action: () => {
                            const $videoBtn = this.container.find('#videoButton');
                            $videoBtn.addClass('highlight-element');
                            
                            $videoBtn.one('click', () => {
                                $videoBtn.removeClass('highlight-element');
                                setTimeout(() => {
                                    this.nextTutorialStep();
                                }, 1500);
                            });
                        },
                        buttonText: 'Show Me'
                    },
                    {
                        title: 'Turn On Speaker',
                        description: 'The speaker button lets you use speakerphone during a call. Try tapping it now.',
                        highlight: '#speakerButton',
                        action: () => {
                            const $speakerBtn = this.container.find('#speakerButton');
                            $speakerBtn.addClass('highlight-element');
                            
                            $speakerBtn.one('click', () => {
                                $speakerBtn.removeClass('highlight-element');
                                setTimeout(() => {
                                    this.nextTutorialStep();
                                }, 1500);
                            });
                        },
                        buttonText: 'Show Me'
                    },
                    {
                        title: 'End the Call',
                        description: 'When you\'re done talking, tap the red button to end the call. Try it now!',
                        highlight: '#endCallButton',
                        action: () => {
                            const $endBtn = this.container.find('#endCallButton');
                            $endBtn.addClass('highlight-element');
                            
                            $endBtn.one('click', () => {
                                $endBtn.removeClass('highlight-element');
                                setTimeout(() => {
                                    this.nextTutorialStep();
                                }, 500);
                            });
                        },
                        buttonText: 'Show Me'
                    },
                    {
                        title: 'Great Job!',
                        description: 'You\'ve learned how to make a FaceTime call, mute your mic, hide your camera, use speaker, and end the call. Practice anytime!',
                        action: () => {
                            this.goHome();
                        },
                        buttonText: 'Finish Lesson'
                    }
                ];
            } else if (this.lesson === 'answer-call') {
                this.tutorialSteps = [
                    {
                        title: 'Incoming FaceTime Call',
                        description: 'Martin Topp is calling you! Let\'s learn how to answer a FaceTime call.',
                        action: () => {
                            // Show incoming call screen
                        },
                        buttonText: 'Start Lesson'
                    },
                    {
                        title: 'Answer the Call',
                        description: 'When someone calls you, you\'ll see their name and two buttons. Tap the green Accept button to answer the call.',
                        highlight: '#acceptIncomingCall',
                        action: () => {
                            // Show incoming call screen
                            this.showIncomingCall();
                            
                            // Highlight accept button
                            setTimeout(() => {
                                const $acceptBtn = this.container.find('#acceptIncomingCall');
                                $acceptBtn.addClass('highlight-element');
                                
                                // Wait for user to click accept
                                $acceptBtn.one('click', () => {
                                    $acceptBtn.removeClass('highlight-element');
                                    setTimeout(() => {
                                        this.nextTutorialStep();
                                    }, 1000);
                                });
                            }, 500);
                        },
                        buttonText: 'Show Me'
                    },
                    {
                        title: 'You\'re Connected!',
                        description: 'Great! You\'re now on a video call with Martin. You can see them on the full screen, and yourself in the small window.',
                        action: () => {
                            // Just show message
                        },
                        buttonText: 'Continue'
                    },
                    {
                        title: 'Mute Your Microphone',
                        description: 'During a call, you can mute yourself by tapping the microphone button. Try it now.',
                        highlight: '#muteButton',
                        action: () => {
                            const $muteBtn = this.container.find('#muteButton');
                            $muteBtn.addClass('highlight-element');
                            
                            $muteBtn.one('click', () => {
                                $muteBtn.removeClass('highlight-element');
                                setTimeout(() => {
                                    this.nextTutorialStep();
                                }, 1500);
                            });
                        },
                        buttonText: 'Show Me'
                    },
                    {
                        title: 'End the Call',
                        description: 'When you\'re finished, tap the red button at the bottom to end the call.',
                        highlight: '#endCallButton',
                        action: () => {
                            const $endBtn = this.container.find('#endCallButton');
                            $endBtn.addClass('highlight-element');
                            
                            $endBtn.one('click', () => {
                                $endBtn.removeClass('highlight-element');
                                setTimeout(() => {
                                    this.nextTutorialStep();
                                }, 500);
                            });
                        },
                        buttonText: 'Show Me'
                    },
                    {
                        title: 'Perfect!',
                        description: 'You now know how to answer incoming FaceTime calls! You can practice anytime.',
                        action: () => {
                            this.goHome();
                        },
                        buttonText: 'Finish Lesson'
                    }
                ];
            }
        }

        showTutorialOverlay() {
            const step = this.tutorialSteps[this.currentStep];
            
            // Update tutorial content
            this.container.find('#tutorialStep').text(`STEP ${this.currentStep + 1} OF ${this.tutorialSteps.length}`);
            this.container.find('#tutorialTitle').text(step.title);
            this.container.find('#tutorialDescription').text(step.description);
            this.container.find('#tutorialButton').text(step.buttonText);
            
            // Show overlay
            this.$tutorialOverlay.addClass('active');
            
            // Auto-advance if specified
            if (step.autoAdvance) {
                setTimeout(() => {
                    this.nextTutorialStep();
                }, step.autoAdvance);
            }
        }

        hideTutorialOverlay() {
            this.$tutorialOverlay.removeClass('active');
        }

        nextTutorialStep() {
            this.hideTutorialOverlay();
            
            const step = this.tutorialSteps[this.currentStep];
            
            // Execute step action
            if (step.action) {
                setTimeout(() => {
                    step.action();
                }, 300);
            }
            
            // Move to next step
            this.currentStep++;
            
            // Show next tutorial if available and not waiting for user action
            if (this.currentStep < this.tutorialSteps.length && !step.highlight) {
                setTimeout(() => {
                    this.showTutorialOverlay();
                }, step.autoAdvance || 800);
            }
        }
    }

    // Initialize all simulators on page
    $(document).ready(function() {
        $('.iphone-simulator-container').each(function() {
            new iPhoneSimulator(this);
        });
    });

})(jQuery);
