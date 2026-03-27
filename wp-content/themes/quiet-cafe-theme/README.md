# The Quiet Café — WordPress Theme

**Version:** 1.0.0  
**Requires WordPress:** 6.0+  
**Requires PHP:** 8.0+  
**License:** GPLv2 or later

\---

## 📁 Theme File Structure

```
quiet-cafe-theme/
├── style.css                    ← Required: Theme header + all CSS
├── functions.php                ← Theme setup, CPTs, Customizer, AJAX
├── header.php                   ← Site header \& navigation
├── footer.php                   ← Site footer
├── front-page.php               ← Custom homepage (hero, about, etc.)
├── index.php                    ← Blog / archive fallback
├── single.php                   ← Single post template
├── page.php                     ← Default page template
├── screenshot.png               ← Theme screenshot (1200×900px recommended)
├── template-parts/
│   ├── menu-section.php         ← Tabbed menu (Coffee / Food / Drinks)
│   ├── gallery-strip.php        ← 5-column image gallery
│   ├── reservations-form.php    ← Reservation form (AJAX or CF7)
│   ├── location-info.php        ← Map + address details
│   └── contact-section.php      ← Contact cards + social links
└── assets/
    ├── css/                     ← (optional extra CSS partials)
    └── js/
        └── main.js              ← Vanilla JS: nav, tabs, reveal, AJAX
```

\---

## &#x20;Installation

1. **Upload the theme folder** to `/wp-content/themes/quiet-cafe-theme/`
2. In WordPress Admin go to **Appearance → Themes** and activate **The Quiet Café**
3. Go to **Settings → Reading** and set *Front page displays* to **A static page**, then select or create a blank page as your front page
4. Go to **Appearance → Menus** — create a **Primary Navigation** menu and assign it to the *Primary Navigation* location

\---

## &#x20;Customizer Settings

Navigate to **Appearance → Customize → The Quiet Café** to edit:

|Section|Settings|
|-|-|
|**Hero Section**|Eyebrow text, headline, subtitle, CTA button labels, 3 stats|
|**About Section**|Pull quote text|
|**Location \& Contact**|Address, phone, email, Google Maps embed URL, social media URLs|

> \*\*Google Maps embed:\*\* In Google Maps, click \*\*Share → Embed a map\*\*, copy only the `src="..."` URL value, and paste it into Customizer → Location → \*Google Maps Embed URL\*.

\---

## &#x20;Managing Menu Items

The theme includes a custom **Menu Items** post type:

1. In WP Admin, go to **Menu Items → Add New**
2. Enter the item name as the **Title**
3. Write a short description in the **content editor**
4. Set the **price** and **emoji** in the *Menu Item Details* meta box
5. Assign it to a **Menu Category** (Coffee, Food, or Drinks) in the sidebar
6. **Publish**

> If no Menu Items are published, the section shows beautiful static fallback data automatically.

\---

## &#x20;Reservations

Reservations are saved as a custom post type in **WP Admin → Reservations** and an email notification is sent to the site admin email.

### Optional: Contact Form 7 Integration

1. Install and activate the **Contact Form 7** plugin
2. Create a reservation form
3. In **Appearance → Customize → The Quiet Café → Location \& Contact**, enter the CF7 form ID
4. The theme will use your CF7 form automatically

\---

## &#x20;Accessibility

* Semantic HTML5 landmarks (`<header>`, `<main>`, `<nav>`, `<section>`, `<footer>`)
* Skip-to-content link
* ARIA roles and labels throughout
* `aria-expanded` on mobile toggle
* `aria-selected` on menu tabs
* Arrow key navigation for tab list
* Focus-visible styles on all interactive elements
* High contrast colour ratios (WCAG AA compliant)

\---

## &#x20;Compatible Plugins

|Plugin|Usage|
|-|-|
|**Contact Form 7**|Replacement reservation form|
|**Yoast SEO / RankMath**|Full SEO support|
|**WooCommerce**|Can add online ordering (advanced)|
|**Elementor / Gutenberg**|Works for inner pages|
|**WP Super Cache / W3TC**|Full caching support|

\---

## Colour Palette

|Name|Hex|
|-|-|
|Espresso|`#1C0F0A`|
|Amber|`#C8641A`|
|Warm Red|`#B03A2E`|
|Gold|`#D4A247`|
|Sage|`#5C6B4A`|
|Cream|`#FAF6EE`|
|Light Amber|`#F3DDB8`|

\---

## &#x20;License

The Quiet Café WordPress Theme is licensed under the [GNU General Public License v2](https://www.gnu.org/licenses/gpl-2.0.html) or later.

