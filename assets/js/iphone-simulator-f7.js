/**
 * iPhone Simulator with Framework7
 * Interactive tutorial system for teaching seniors how to use FaceTime
 */

(function($) {
    'use strict';

    class iPhoneSimulatorF7 {
        constructor(container) {
            this.container = container;
            this.$container = $(container);
            this.app = null;
            this.mainView = null;
            this.config = {
                app: this.$container.data('app') || 'facetime',
                lesson: this.$container.data('lesson') || '',
                tutorial: this.$container.data('tutorial') === 'true',
                apps: this.$container.data('apps') || 'facetime,messages,phone,safari'
            };
            this.currentLesson = null;
            this.init();
        }

        init() {
            // Initialize Framework7 (minimal setup, we'll handle navigation manually)
            this.app = new Framework7({
                el: '#app',
                name: 'iPhone Simulator',
                theme: 'ios',
                view: {
                    pushState: false,
                    animate: false
                }
            });

            // Get main view
            this.mainView = this.app.views.create('.view-main');

            // Store references to page elements
            this.$homePage = $('.page[data-name="home"]');
            this.$faceTimePage = null;
            this.$videoCallPage = null;

            this.attachEventListeners();
            
            // Start tutorial if enabled
            if (this.config.tutorial && this.config.lesson) {
                setTimeout(() => this.startTutorial(this.config.lesson), 1000);
            }
            
            // Auto-open app if specified
            if (this.config.app && this.config.app !== 'home') {
                setTimeout(() => this.openApp(this.config.app), 500);
            }
        }

        attachEventListeners() {
            const self = this;
            
            // App icon clicks - use event delegation on container
            this.$container.on('click', '.app-icon', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const app = $(this).data('app');
                if (app) {
                    console.log('Opening app:', app);
                    self.openApp(app);
                }
            });

            // Tutorial button
            $(document).on('click', '#tutorialButton', () => this.nextTutorialStep());

            // Incoming call actions
            $(document).on('click', '#acceptCall', () => this.acceptIncomingCall());
            $(document).on('click', '#declineCall', () => this.declineIncomingCall());
        }

        openApp(appName) {
            if (appName === 'facetime') {
                this.showFaceTimePage();
            } else {
                // Show placeholder for other apps
                this.app.dialog.alert('Coming soon...', appName.charAt(0).toUpperCase() + appName.slice(1));
            }
        }

        showFaceTimePage() {
            // Hide home page
            this.$homePage.hide();
            
            // Create FaceTime page if it doesn't exist
            if (!this.$faceTimePage) {
                const template = document.getElementById('facetime-page-template').innerHTML;
                this.mainView.$el.append(template);
                this.$faceTimePage = $('.page[data-name="facetime"]');
                this.onFaceTimePageInit();
            } else {
                this.$faceTimePage.show();
            }
        }

        goHome() {
            // Hide all app pages
            if (this.$faceTimePage) this.$faceTimePage.hide();
            if (this.$videoCallPage) this.$videoCallPage.hide();
            
            // Show home page
            this.$homePage.show();
        }

        onFaceTimePageInit() {
            const self = this;
            
            // Attach back button handler
            this.$faceTimePage.find('.link.back').off('click').on('click', function(e) {
                e.preventDefault();
                self.goHome();
            });
            
            // Attach contact card click handlers
            this.$faceTimePage.find('.contact-card').off('click').on('click', function() {
                const contact = $(this).data('contact');
                self.startVideoCall(contact);
            });

            // Check if we need to show tutorial for call-martin lesson
            if (this.currentLesson === 'call-martin' && this.lessonStep === 1) {
                this.highlightElement('.contact-card[data-contact="martin"]');
            }
        }

        onVideoCallPageInit(contact) {
            const self = this;
            const $videoPage = this.$videoCallPage;

            // Video control buttons
            let videoEnabled = true;
            let audioEnabled = true;

            $videoPage.find('#videoButton').off('click').on('click', function() {
                videoEnabled = !videoEnabled;
                $(this).toggleClass('active');
                if (!videoEnabled) {
                    $videoPage.find('#localVideo').addClass('video-off').html('<div style="font-size: 24px;">Camera Off</div>');
                } else {
                    $videoPage.find('#localVideo').removeClass('video-off').html('<div style="font-size: 32px;">📹</div>');
                }
            });

            $videoPage.find('#muteButton').off('click').on('click', function() {
                audioEnabled = !audioEnabled;
                $(this).toggleClass('active');
            });

            $videoPage.find('#moreButton').off('click').on('click', function() {
                self.app.dialog.alert('Additional options coming soon...', 'More Options');
            });

            $videoPage.find('#endCallButton').off('click').on('click', () => this.endCall());

            // Tutorial check
            if (this.currentLesson === 'call-martin' && this.lessonStep === 2) {
                setTimeout(() => {
                    this.showTutorial(
                        'Great!',
                        'You\'re now on a FaceTime call. You can see the person you\'re talking to on the screen.',
                        'Finish'
                    );
                }, 1000);
            }
        }

        startVideoCall(contact) {
            // Hide FaceTime page
            if (this.$faceTimePage) this.$faceTimePage.hide();
            
            // Create video call page if it doesn't exist
            if (!this.$videoCallPage) {
                const template = document.getElementById('video-call-template').innerHTML;
                this.mainView.$el.append(template);
                this.$videoCallPage = $('.page[data-name="video-call"]');
            } else {
                this.$videoCallPage.show();
            }
            
            this.currentContact = contact;
            this.onVideoCallPageInit(contact);
        }

        endCall() {
            // Hide video call page
            if (this.$videoCallPage) this.$videoCallPage.hide();
            
            // Show home page
            this.goHome();
        }

        // Tutorial System
        startTutorial(lessonName) {
            this.currentLesson = lessonName;
            this.lessonStep = 0;

            const lessons = {
                'call-martin': {
                    title: 'How to Make a FaceTime Call',
                    steps: [
                        {
                            text: 'Let\'s learn how to make a FaceTime video call. First, we need to open the FaceTime app. Look for the green camera icon on your home screen.',
                            action: 'highlight',
                            element: '.app-icon[data-app="facetime"]'
                        },
                        {
                            text: 'Now tap on Martin\'s contact card to start a video call with him.',
                            action: 'highlight',
                            element: '.contact-card[data-contact="martin"]'
                        },
                        {
                            text: 'Great! You\'re now on a FaceTime call. You can see the person you\'re talking to on the screen.',
                            action: 'complete'
                        }
                    ]
                },
                'answer-call': {
                    title: 'How to Answer a FaceTime Call',
                    steps: [
                        {
                            text: 'When someone calls you on FaceTime, you\'ll see their name and photo on the screen. Let\'s practice answering a call from Martin.',
                            action: 'show-incoming'
                        },
                        {
                            text: 'To answer the call, tap the green phone icon button. To decline, tap the red phone icon.',
                            action: 'highlight',
                            element: '#acceptCall'
                        },
                        {
                            text: 'Perfect! You answered the call. Now you can see and talk to the person calling you.',
                            action: 'complete'
                        }
                    ]
                }
            };

            if (lessons[lessonName]) {
                this.lesson = lessons[lessonName];
                this.nextTutorialStep();
            }
        }

        nextTutorialStep() {
            if (!this.lesson) return;

            this.clearHighlights();
            this.hideTutorial();

            this.lessonStep++;
            if (this.lessonStep > this.lesson.steps.length) {
                this.completeTutorial();
                return;
            }

            const step = this.lesson.steps[this.lessonStep - 1];

            if (step.action === 'show-incoming') {
                this.showIncomingCall();
                setTimeout(() => {
                    this.showTutorial(
                        this.lesson.title,
                        step.text,
                        'Next'
                    );
                }, 500);
            } else if (step.action === 'highlight' && step.element) {
                this.showTutorial(
                    this.lesson.title,
                    step.text,
                    'Got it'
                );
                setTimeout(() => {
                    this.highlightElement(step.element);
                }, 300);
            } else if (step.action === 'complete') {
                this.showTutorial(
                    'Tutorial Complete!',
                    step.text,
                    'Finish'
                );
            } else {
                this.showTutorial(
                    this.lesson.title,
                    step.text,
                    'Next'
                );
            }
        }

        showTutorial(title, text, buttonText = 'Continue') {
            $('#tutorialTitle').text(title);
            $('#tutorialText').text(text);
            $('#tutorialButton').text(buttonText);
            $('#tutorialOverlay').fadeIn(300);
        }

        hideTutorial() {
            $('#tutorialOverlay').fadeOut(300);
        }

        highlightElement(selector) {
            const $element = $(selector);
            if ($element.length) {
                $element.addClass('highlight-element');
            }
        }

        clearHighlights() {
            $('.highlight-element').removeClass('highlight-element');
        }

        completeTutorial() {
            this.clearHighlights();
            this.hideTutorial();
            this.currentLesson = null;
            this.lessonStep = 0;
        }

        showIncomingCall() {
            $('#incomingCallScreen').fadeIn(300);
        }

        hideIncomingCall() {
            $('#incomingCallScreen').fadeOut(300);
        }

        acceptIncomingCall() {
            this.hideIncomingCall();
            this.startVideoCall('martin');
            if (this.currentLesson === 'answer-call') {
                this.nextTutorialStep();
            }
        }

        declineIncomingCall() {
            this.hideIncomingCall();
            if (this.currentLesson === 'answer-call') {
                this.showTutorial(
                    'Try Again',
                    'Let\'s try answering the call this time. Tap the green phone icon to accept.',
                    'OK'
                );
                setTimeout(() => {
                    this.showIncomingCall();
                }, 1000);
            }
        }
    }

    // Initialize when document is ready
    $(document).ready(function() {
        $('.iphone-simulator-container').each(function() {
            new iPhoneSimulatorF7(this);
        });
    });

})(jQuery);
