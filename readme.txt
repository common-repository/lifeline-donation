=== Lifeline Donation ===
Contributors: wptech
Donate link: https://webinane.com/
Tags: giving, donation, charity, ngo, nonprofit, non profit
Requires at least: 5.6
Tested up to: 5.8
Stable tag: 1.2.6
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html


== Description ==

The FIRST and BEST of its kind, Lifeline Donations plugin supports automated recurring donations and reaches out to donors in their own tongue, currency, and preferred payment method/s.
It is a free, open-source, and extendable WordPress donations plugin for NGOs, charities, and nonprofits to accept and boost fundraising from any part of the world.
Using shortcodes, widgets, and banners, you can place it anywhere on your website, be it the header, featured area, sidebar, or any section. You can also show it as “causes,” “buttons,” and “donations.”

Its extendable, developer-friendly framework allows you to easily create add-ons, in addition to the already [supported extensions](https://www.webinane.com/plugins).

Several built-in useful hooks also allow you to easily create customized donation systems, appointments, reservations, and hotel bookings, etc.
[Click here for a live demo](https://plugins.webinane.com/lifeline-donation/).

Lifeline Donations plugin also has a built-in eCommerce system, so you can run an online shopping facility on your charity website to raise extra funds.

== Key Features ==
- FREE recurring donations facility – no plugin required
- Start fundraising right away with the built-in PayPal Standard gateway (FREE)
- FREE currency selector included – No plugin required
- Fully compatible with the [world’s top 15+ payment gateway extensions](https://www.webinane.com/plugins)
- Complete built-in donations management system – Checkout, Donations History, Two-way prompt communication, etc.
- Several awesome styles for donation forms
- Place the “Donate Now” button anywhere on the webpage
- Pre-integrated with the [best charity WordPress themes](https://themeforest.net/item/lifeline-2-an-ultimate-nonprofit-wordpress-theme-for-charity-fundraising-and-ngo-organizations/16660958)
- 10+ Gutenberg Blocks
- 10+ WP Bakery Shortcodes
- 5+ Elementor Widgets
- 6+ Donation Widgets for WordPress
- 3+ Donation Popup Styles
- Compatible with Bootstrap 4
- Fully responsive framework
- Lightweight for faster loading
- Translation support – translate into any language
- Safe and secure

== Special Features == 
- Several developer hooks to quickly and conveniently build extensions/add-ons.
- Fully compatible with Elementor, Gutenberg, and WP Bakery page builders.
- Auto adjusts anywhere on posts, pages, sidebars, etc.
- Show top donations in the sidebar.
- 6 customizable shortcodes with a donation-friendly layout.

=== Having issues ===
You can post issues to [https://gitlab.com/webinane/webinane-commerce/-/issues](https://gitlab.com/webinane/webinane-commerce/-/issues)

== Installation ==

This section describes how to install the plugin and get it working.

Note: "Webinane Commerce" plugin is required for "Lifeline Donation" to work.
e.g.

1. Upload `lifeline-donation.zip` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Go to "WP Commerce" menu to set some basic configuration

Here is demo link [http://plugins.webinane.com/webinane-donation/donation-shortcodes-for-vc/](http://plugins.webinane.com/webinane-donation/donation-shortcodes-for-vc/)
== Frequently Asked Questions ==

== Screenshots ==

1. General Settings page.  
2. Orders page  
3. In Admin orders, Add new item popup  
4. Frontend user checkout page.  
5. Frontend user Account page. 

== Changelog ==
= Version 1.2.6 =
- Fixed: Paypal recurring payment issues.
- Fixed: Popup option to hide custom amount box.

= Version 1.2.5.2 =
- Fixed: database table creation on plugin activation.

= Version 1.2.5.1 =
- Fixed: issue with loading wp commence.

= Version 1.2.5 =
- Fixed: issue with recurring buttons not visible on the Popup
- Fixed: issues with My Account page
- Fixed: issues with Lifeline Donation > Donations > Edit
- Added: New field structure in Metaboxes

= Version 1.2.4 =
- Fixed: Corrected the key for recurring payment enable.
- Updated: Webinane Commerce.

= Version 1.2.3 =
- Fixed: Donation success page, label replaced with Donation.
- Fixed: Admin donations donor address issue.
- Fixed: Admin donations, Donation detail issue is fixed.

= Version 1.2.2 =
- Added: Added email templates settings
- Fixed: Various issues.

= Version 1.2.1 =
- Fixed: Donation form title and Text.
- Added: Donation template 3 options in shortcode.
- Fixed: Changed the configuration with new OOP Field structure
- Fixed: Donation template2, added css classes to fix the styling issues

= Version 1.2.0.4 =
- Fixed: Fixed country field issue.

= Version 1.2.0.3 =
- Fixed: Fixed old settings database upgradation.

= Version 1.2.0.2 =
- Fixed: Issue with saving data in Payment Gateways tab
- Fixed: Issue with Offline gateway editor html.
- Fixed: Issues with Payment gateways labels and handling request.

= Version 1.2.0.1 =
- Updated: Webinane Commerce
- Fixed: Admin settings fields configuration.
- Added: Permalinks settings for Projects and Causes.

= Version 1.2.0 =
- Added: New design for admin settings.
- Fixed: Donation popup issues.

= Version 1.1.2.1 =
- Fixed: undefined variable $section

= Version 1.1.2.1 =
- Fixed: Permission callback php notice on register rest  route.
- Fixed: get_screen_id() issue with demo import merline.

= Version 1.1.2 =
- Fixed: Issue with popup loader. wpcm_data varible issue is fixed.

= Version 1.1.0 =
- Added: Dashboard charts and stats.
- Added: option on general donation, to select donate to all projects/charities or select multiple as per user choice
- Fixed: styling issues all donation templates.
- Added: webinane-commerce directly into plugin for user convenience
- Added: widget to list donors
- Added: shortcode to list Donations publicly or list donations of specific donor publicly.
- Fixed: mics. issues

= Version 1.0.9 =
- Updated: The recurring payment cycle options.
- Fixed: Placed recurring payment start date with cycle dropdown.
- Fixed: Donation tempalate shortocde style 2 and and 3.
- Added: WP Commerce Dashboard Charts and statistics.
- Added: Option to collect general donation, user will choose project or cause from Popup.

= Version 1.0.8 =
- Fixed: Currency symbol change on donation modal 3

= Version 1.0.7 =
- Fixed: Fixed the issue with donation modal and form submission

= Version 1.0.6 =
- Fixed: Vue.compile issues with donation modal 2 and 3

= Version 1.0.5 =
- Fixed: Donation form validation
- Fixed: donation success page issues
- Fixed: Email template issues.
- Improved: The popup rending, now be possible using vuejs component <donation-button>

= 1.0.3 =
* Fixed issues with post_data sanization. Uses recurrsive posted data senitization.

= 1.0.2 =
* Removed Image resizing lib everywhere in VC Shortcodes and Widgets
* Fixed: PSR2 Coding Sniffers with some files.
* Fixed: Dropdown Option for donation popup that if user want to hide
* Fixed: Hide recurring option if user disabled it from settings.

== More about Lifeline Donation ==

Lifeline Donation requires [WP Commerce](http://wordpress.org/plugins/webinane-commerce) to be worked perfectly. 

From admin settings user can enable donation button to be visible in header as a last menu item. Admin also setup target amount needed for specific cause or project.

Also it comes with an Elementor widget (Donation Button) which you can place anywhere on the website to collect donations. Here is demo link [Visit the Demo](http://plugins.webinane.com/webinane-donation/donation-shortcodes-for-vc/)

=== Compatible Charity/Nonprofit WordPress Themes ===

- [Lifeline 2](https://themeforest.net/item/lifeline-2-an-ultimate-nonprofit-wordpress-theme-for-charity-fundraising-and-ngo-organizations/16660958)
- [Actavista](https://themeforest.net/item/actavista-a-responsive-wordpress-theme-for-politicians-and-political-organizations/23221878)
- [Deeds2](https://themeforest.net/item/deeds2-religion-and-church-wordpress-theme/24756421)

=== WPBakery Shortcodes ===

- Donation Button (You can add button anywhere on the website)
- Campaigns (4 Different Styles)
- Donation Parallax (6 Different Styles)

=== WP Widgets ===

- Donor of the Month
- Recent Donations
- Top Donors
- Urgent Campaigns
- Urgent Causes
- Urgent Projects

=== Supported Donation Processing Gateways ===

1- PayPal Standard (Included)
2- [PayPal Pro](https://www.webinane.com/plugins/paypal-pro) - Serves 200+ countries/territories and [25+ currencies](https://www.paypal.com/en/webapps/mpp/country-worldwide)
3- [Stripe](https://www.webinane.com/plugins/stripe) - Available for charities in 39+ countries. Supports 135+ currencies
4- [Braintree](https://www.webinane.com/plugins/braintree) - Works in 45+ countries/ regions with access to 260+ million PayPal users
5- [Amazon Pay](https://www.webinane.com/plugins/amazon-pay) - Accept voice-based donations from Amazon customers worldwide
6- [Authorize.net](https://www.webinane.com/plugins/authorize.net) - For charities based in the US, the UK, Europe, Canada, Australia, etc.
7- [2Checkout](https://www.webinane.com/plugins/2checkout) - Present in 230+ countries/territories with 45+ payment methods
8- [PayStack](https://www.webinane.com/pluigns/paystack) - Africa’s economical payment gateway for worldwide donation collection
9- [PayUMoney](https://www.webinane.com/plugins/payu) - India’s fast and simple gateway for 250+ donation processing options
10- [PayMaster](https://www.webinane.com/plugins/paymaster24) - Collect funds from 240 countries/territories
11- [Yandex](https://www.webinane.com/plugins/yandex) - For Russia and CIS countries to collect donations from across the world
12- [Bluepay](https://www.webinane.com/plugins/bluepay) – Especially for Canada and the US to collect funds from home and abroad
13- [Conekta](https://www.webinane.com/plugins/conekta) – Mexico’s favorite payment gateway
14- [Quickpay](https://www.webinane.com/plugins/quickpay) – Europeans’ preferred payment method with 20+ payment options
15- [Cardcom](https://www.webinane.com/plugins) - Israel’s popular gateway to receive funds from anywhere in the world
