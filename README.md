# iPhone Simulator for Digital Literacy - WordPress Plugin

![Version](https://img.shields.io/badge/version-1.0.0-blue.svg)
![WordPress](https://img.shields.io/badge/WordPress-5.0%2B-blue.svg)
![PHP](https://img.shields.io/badge/PHP-7.4%2B-purple.svg)
![License](https://img.shields.io/badge/license-GPL%20v2-green.svg)

An interactive iPhone simulator WordPress plugin designed to teach seniors digital literacy through realistic, hands-on tutorials.

## 🎯 Features

- **🎨 Realistic iOS 18 Design** - Beautiful iPhone interface with Dynamic Island, rounded corners, and authentic iOS styling
- **📱 Interactive Apps** - Fully functional simulations of FaceTime, Messages, Phone, Facebook, Twitter, and WhatsApp
- **👨‍🏫 Step-by-Step Tutorials** - Guided lessons that walk users through each action
- **🎮 Full Interactivity** - Click, tap, and interact just like a real iPhone
- **⚙️ Elementor Integration** - Easy drag-and-drop widget for page builders
- **📝 Shortcode Support** - Use anywhere with simple shortcodes
- **📱 Responsive Design** - Works on all screen sizes
- **♿ Senior-Friendly** - Large buttons, clear instructions, and patient pacing

## 📱 Demo

The plugin simulates a realistic iPhone with the following features:

- **FaceTime App**: Complete video calling experience
  - Contact selection
  - Calling states with animations
  - Video controls (mute mic, hide camera)
  - End call functionality
  
- **Interactive Tutorial System**: 
  - Highlights specific buttons to press
  - Step-by-step guidance
  - Progress tracking
  - Celebration on completion

## 🚀 Installation

### Method 1: Upload via WordPress Admin

1. Download the plugin zip file
2. Go to WordPress Admin → Plugins → Add New
3. Click "Upload Plugin"
4. Choose the zip file and click "Install Now"
5. Activate the plugin

### Method 2: Manual Installation

1. Download and extract the plugin files
2. Upload the `iphone-simulator` folder to `/wp-content/plugins/`
3. Go to WordPress Admin → Plugins
4. Activate "iPhone Simulator for Digital Literacy"

## 📖 Usage

### Using Shortcode

Add the simulator to any page or post:

```
[iphone_simulator]
```

#### Shortcode Parameters

```
[iphone_simulator 
    app="facetime" 
    lesson="call-martin" 
    tutorial="true" 
    apps="facetime,messages,phone,facebook,twitter,whatsapp"]
```

**Parameters:**

- `app` - Starting app when simulator loads
  - Options: `home`, `facetime`, `messages`, `phone`, `facebook`, `twitter`, `whatsapp`
  - Default: `facetime`

- `lesson` - Tutorial type to display
  - Options: `call-martin`, `answer-call`
  - Default: `call-martin`

- `tutorial` - Enable tutorial mode
  - Options: `true`, `false`
  - Default: `true`

- `apps` - Comma-separated list of apps to show
  - Default: `facetime,messages,phone,facebook,twitter,whatsapp`

### Using with Elementor

1. Edit any page with Elementor
2. Search for "iPhone Simulator" in the widgets panel
3. Drag the widget to your page
4. Configure settings in the left panel:
   - Starting App
   - Lesson Type
   - Enable Tutorial
   - Available Apps
   - Container styling
5. Preview and publish!

### Settings Page

Go to **WordPress Admin → iPhone Simulator** to configure:

- Default apps to display
- Tutorial speed (slow/normal/fast)
- Avatar style preferences

## 🎓 Available Lessons

### FaceTime: Call Martin (`lesson="call-martin"`)
A complete tutorial teaching users how to:
1. Open the FaceTime app
2. Select a contact (Martin)
3. Start the video call
4. Mute/unmute the microphone
5. Hide/show the camera
6. Use speaker mode
7. End the call

### FaceTime: Answer Call (`lesson="answer-call"`)
A tutorial teaching users how to:
1. Recognize an incoming FaceTime call from Martin Topp
2. Accept the call using the green button
3. Understand the video call interface
4. Mute/unmute during a call
5. End the call properly
6. End the call

### Coming Soon
- Messages: Send a text message
- Phone: Make a phone call
- Facebook: Create a post
- WhatsApp: Send a message
- Twitter: Compose a tweet

## 🛠️ Technical Details

### File Structure

```
iphone-simulator/
├── iphone-simulator.php          # Main plugin file
├── assets/
│   ├── css/
│   │   └── iphone-simulator.css  # All styles
│   └── js/
│       └── iphone-simulator.js   # Interactive functionality
├── templates/
│   └── iphone-simulator.php      # HTML template
├── includes/
│   └── elementor-widget.php      # Elementor integration
├── admin/
│   └── settings-page.php         # Admin settings
└── README.md                      # Documentation
```

### Requirements

- **WordPress**: 5.0 or higher
- **PHP**: 7.4 or higher
- **jQuery**: Included with WordPress
- **Elementor**: Optional (for widget functionality)

### Browser Support

- ✅ Chrome (latest)
- ✅ Firefox (latest)
- ✅ Safari (latest)
- ✅ Edge (latest)
- ⚠️ IE11 (limited support)

## 🎨 Customization

### Custom CSS

Add custom styles using your theme's CSS or a custom CSS plugin:

```css
/* Change container background */
.iphone-simulator-container {
    background: linear-gradient(135deg, #your-color 0%, #your-color-2 100%);
}

/* Adjust iPhone scale */
.iphone-device {
    transform: scale(0.8);
}

/* Customize tutorial overlay */
.tutorial-content {
    background: rgba(44, 44, 46, 0.98);
}
```

### Extending Functionality

Developers can extend the plugin by:

1. **Adding New Apps**: Modify the template and JavaScript
2. **Creating New Lessons**: Add tutorial steps in the JS file
3. **Custom Styling**: Override CSS classes
4. **Hooks & Filters**: Use WordPress actions (coming in v1.1)

## 🤝 Contributing

Contributions are welcome! Please feel free to submit issues and pull requests.

### Development Setup

1. Clone the repository
2. Make your changes
3. Test thoroughly on a WordPress installation
4. Submit a pull request

### Coding Standards

- Follow WordPress Coding Standards
- Comment your code
- Test on multiple browsers
- Ensure mobile responsiveness

## 📝 Changelog

### Version 1.0.0 (2025-11-11)
- Initial release
- FaceTime app simulation
- Interactive tutorial system
- Elementor widget integration
- Shortcode support
- Admin settings page
- iOS 18 design with Dynamic Island

## 🐛 Known Issues

- Messages, Phone, and social media apps show "Coming Soon" placeholder
- Tutorial system currently only supports FaceTime lessons
- Camera feed is simulated (no actual video)

## 🔮 Roadmap

- [ ] Additional app simulations (Messages, Phone, etc.)
- [ ] More tutorial lessons
- [ ] Custom avatar uploads
- [ ] Multiple language support
- [ ] Accessibility improvements (screen reader support)
- [ ] Advanced customization options
- [ ] Export/import lesson configurations

## 📄 License

This plugin is licensed under the GPL v2 or later.

```
Copyright (C) 2025 MT

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
```

## 👨‍💻 Author

**Martin Topp**
- Website: [mtsaga.net](https://mtsaga.net)
- GitHub: [@mt292](https://github.com/mt292)

## 🙏 Acknowledgments

- Inspired by the need to teach digital literacy to seniors
- iOS design elements based on Apple's iOS 18
- Built with ❤️ for educators and learners

## 💬 Support

For support, questions, or feature requests:
- Open an issue on [GitHub](https://github.com/mt292/iPhone-Wordpress-Plugin/issues)
- Check the documentation
- Review the settings page in WordPress Admin

---

Made with 💚 to help seniors learn technology