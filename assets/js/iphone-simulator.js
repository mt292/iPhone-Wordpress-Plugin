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
            
            // Contact call buttons
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
            
            this.container.on('click', '#endCallButton, #endCallEarly', function() {
                self.endCall();
            });
            
            // Tutorial button
            this.container.on('click', '#tutorialButton', function() {
                self.nextTutorialStep();
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
                        // Other apps - show placeholder
                        alert('This app is coming soon!');
                        this.goHome();
                }
            }, 300);
        }

        goHome() {
            // Hide all apps
            this.$facetimeApp.removeClass('active').fadeOut(300);
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
                $button.html('🔇');
                this.showNotification('Microphone muted');
            } else {
                $button.html('🎤');
                this.showNotification('Microphone on');
            }
        }

        toggleVideo() {
            const $button = this.container.find('#videoButton');
            const $localVideo = this.container.find('#localVideo');
            
            $button.toggleClass('active');
            $localVideo.toggleClass('hidden');
            
            if ($button.hasClass('active')) {
                $button.html('📷');
                this.showNotification('Camera hidden');
            } else {
                $button.html('📹');
                this.showNotification('Camera on');
            }
        }

        endCall() {
            this.$videoCallScreen.removeClass('active').fadeOut(300);
            this.animateDynamicIsland();
            
            // Reset controls
            this.container.find('#muteButton').removeClass('active').html('🎤');
            this.container.find('#videoButton').removeClass('active').html('📹');
            this.container.find('#localVideo').removeClass('hidden');
            
            setTimeout(() => {
                if (this.tutorialEnabled && this.currentStep < this.tutorialSteps.length - 1) {
                    // Show next tutorial step
                    this.nextTutorialStep();
                } else {
                    // Go back to contact selection
                    this.$contactSelection.addClass('active').fadeIn(300);
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
                            this.openApp('facetime');
                        },
                        buttonText: 'Start Lesson'
                    },
                    {
                        title: 'Find the Contact',
                        description: 'Look for Martin in your contacts list. Tap on Martin to select him.',
                        highlight: '.contact-item[data-contact="martin"]',
                        action: () => {
                            // Enable clicking on Martin
                            const $martin = this.container.find('.contact-item[data-contact="martin"]');
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
                        title: 'Call is Connecting',
                        description: 'Martin is answering the call. In a moment, you\'ll see the video screen with controls.',
                        action: () => {
                            // Just wait for call to connect
                        },
                        buttonText: 'Continue',
                        autoAdvance: 3000
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
                        title: 'Great Job! 🎉',
                        description: 'You\'ve learned how to make a FaceTime call, mute your mic, hide your camera, and end the call. Practice anytime!',
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
