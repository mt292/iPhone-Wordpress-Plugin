# Installation Guide

## Quick Start (5 Minutes)

This guide will help you install and set up the iPhone Simulator plugin on your WordPress site.

## Prerequisites

Before you begin, make sure you have:

- ✅ WordPress 5.0 or higher
- ✅ PHP 7.4 or higher
- ✅ Admin access to your WordPress site
- ✅ (Optional) Elementor page builder installed

## Installation Methods

### Method 1: Direct Upload (Recommended for Beginners)

1. **Download the Plugin**
   - Download the plugin files as a ZIP from GitHub
   - Keep the ZIP file on your computer

2. **Access WordPress Admin**
   - Log in to your WordPress admin panel
   - Navigate to `Plugins` → `Add New`

3. **Upload Plugin**
   - Click the `Upload Plugin` button at the top
   - Click `Choose File` and select the ZIP file
   - Click `Install Now`

4. **Activate**
   - Once installed, click `Activate Plugin`
   - You should see a success message

5. **Verify Installation**
   - Look for "iPhone Simulator" in your WordPress admin menu
   - Click it to access the settings page

### Method 2: FTP/Manual Installation (Advanced Users)

1. **Download and Extract**
   - Download the plugin files
   - Extract the ZIP file to your computer

2. **Upload via FTP**
   - Connect to your server via FTP
   - Navigate to `/wp-content/plugins/`
   - Upload the entire `iphone-simulator` folder

3. **Activate**
   - Go to WordPress Admin → Plugins
   - Find "iPhone Simulator for Digital Literacy"
   - Click `Activate`

### Method 3: Direct from GitHub (Developers)

```bash
cd /path/to/wordpress/wp-content/plugins/
git clone https://github.com/mt292/iPhone-Wordpress-Plugin.git iphone-simulator
```

Then activate via WordPress Admin → Plugins.

## First-Time Setup

### Step 1: Configure Basic Settings

1. Go to `WordPress Admin` → `iPhone Simulator`
2. Review the default settings:
   - **Default Apps**: Choose which apps appear on the home screen
   - **Tutorial Speed**: Set to "Slow" for beginners
   - **Avatar Style**: Choose your preferred contact avatar style
3. Click `Save Settings`

### Step 2: Create Your First Test Page

#### Option A: Using Shortcode (Any Theme)

1. Go to `Pages` → `Add New`
2. Give it a title like "iPhone Tutorial Test"
3. In the content editor, add:
   ```
   [iphone_simulator]
   ```
4. Click `Publish`
5. View the page to see your iPhone simulator!

#### Option B: Using Elementor (If Installed)

1. Create a new page or edit an existing one
2. Click `Edit with Elementor`
3. In the left panel, search for "iPhone Simulator"
4. Drag the widget onto your page
5. Configure the settings in the left panel:
   - **Starting App**: `facetime`
   - **Lesson Type**: `call-martin`
   - **Enable Tutorial**: Toggle ON
   - **Available Apps**: Select the apps you want
6. Click `Update` to save

### Step 3: Test the Tutorial

1. Visit your test page
2. You should see a beautiful iPhone simulator
3. Click "Start Lesson" when the tutorial appears
4. Follow the steps to complete the FaceTime tutorial

## Common Use Cases

### For a Digital Literacy Course

```
[iphone_simulator app="facetime" lesson="call-martin" tutorial="true"]
```

Add this shortcode to your course pages to provide interactive lessons.

### For a Practice Page (No Tutorial)

```
[iphone_simulator tutorial="false"]
```

Let users practice freely without guided steps.

### For Specific Apps Only

```
[iphone_simulator apps="facetime,messages,phone"]
```

Show only the apps relevant to your lesson.

## Troubleshooting

### Plugin Won't Activate

**Issue**: Error message when activating
**Solution**: 
- Check your PHP version (must be 7.4+)
- Check your WordPress version (must be 5.0+)
- Deactivate conflicting plugins temporarily

### Simulator Not Showing

**Issue**: Shortcode appears as text
**Solution**:
- Make sure the plugin is activated
- Clear your browser cache
- Try viewing in an incognito/private window

### Styling Looks Broken

**Issue**: iPhone looks distorted or unstyled
**Solution**:
- Clear WordPress cache (if using a cache plugin)
- Clear your browser cache (Ctrl+Shift+Delete)
- Disable other plugins that might conflict with CSS
- Try a different theme temporarily

### Elementor Widget Not Appearing

**Issue**: Can't find the widget in Elementor
**Solution**:
- Make sure Elementor is installed and activated
- Refresh the Elementor editor (Ctrl+Shift+R)
- Try regenerating Elementor's cache (Elementor → Tools → Regenerate CSS)

### JavaScript Not Working

**Issue**: Clicking buttons doesn't work
**Solution**:
- Check browser console for errors (F12)
- Make sure jQuery is loaded (included with WordPress by default)
- Disable JavaScript minification/optimization plugins temporarily
- Check if another plugin is causing conflicts

## Updating the Plugin

### Automatic Updates (Future)

Once added to the WordPress.org repository, updates will be automatic via WordPress Admin.

### Manual Updates

1. **Backup First**: Always backup your site before updating
2. **Deactivate**: Go to Plugins and deactivate the old version
3. **Delete**: Delete the old plugin files
4. **Install New**: Follow installation steps above with the new version
5. **Activate**: Reactivate the plugin

**Note**: Your settings will be preserved during updates.

## Advanced Configuration

### Custom CSS Classes

Add custom styling to specific instances:

```
[iphone_simulator custom_css_class="my-custom-iphone"]
```

Then add CSS in your theme:

```css
.my-custom-iphone .iphone-device {
    transform: scale(1.2);
}
```

### Multiple Instances on One Page

You can add multiple simulators to one page:

```
[iphone_simulator app="facetime" lesson="call-martin"]

<h2>Now Try Messages</h2>

[iphone_simulator app="messages" lesson="send-message"]
```

## Server Requirements

### Minimum Requirements
- PHP: 7.4 or higher
- WordPress: 5.0 or higher
- Memory: 64MB (128MB recommended)
- Disk Space: 2MB

### Recommended Environment
- PHP: 8.0 or higher
- WordPress: Latest version
- Memory: 256MB or higher
- HTTPS enabled

## Security Notes

- ✅ Plugin follows WordPress security standards
- ✅ All user inputs are sanitized and escaped
- ✅ Nonce verification for AJAX requests
- ✅ No data is stored in the database (privacy-friendly)
- ✅ No external API calls or tracking

## Performance Tips

1. **Use a Caching Plugin**: WP Super Cache or W3 Total Cache
2. **Optimize Images**: Although this plugin uses CSS/emoji, optimize your site's images
3. **Use a CDN**: For faster asset delivery
4. **Enable Gzip Compression**: On your server
5. **Keep WordPress Updated**: Latest version is fastest

## Getting Help

If you run into issues:

1. **Check this guide first** - Most common issues are covered
2. **Review the main README** - Additional documentation
3. **Check WordPress admin settings** - iPhone Simulator page
4. **Enable debugging**:
   ```php
   define('WP_DEBUG', true);
   define('WP_DEBUG_LOG', true);
   ```
5. **Open a GitHub issue** - Include error messages and WordPress version

## Next Steps

Once installed and working:

1. ✅ Explore all the tutorial steps
2. ✅ Customize the settings to your needs
3. ✅ Create practice pages for your students
4. ✅ Gather feedback from users
5. ✅ Check back for new lessons and features

## Video Tutorials (Coming Soon)

We're working on video tutorials to help you:
- Install the plugin
- Create your first lesson page
- Customize the appearance
- Integrate with your course structure

---

**Congratulations! You're ready to teach digital literacy! 🎉**

Need help? Open an issue on [GitHub](https://github.com/mt292/iPhone-Wordpress-Plugin/issues).
