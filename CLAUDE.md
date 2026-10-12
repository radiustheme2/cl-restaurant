# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

**CL Restaurant**: a RadiusTheme WordPress theme (`style.css` header, text domain `clrestaurant`) built on top of the
**Classified Listing** plugin (`Rtcl`, and optionally `RtclPro`). Every translatable string uses `'clrestaurant'`.
Translations are `languages/{locale}.mo`, and the template is `languages/clrestaurant.pot`.

## Companion plugin: CL Restaurant Core

The theme's companion plugin is a separate git repo in the sibling directory `../cl-restaurant-core`. Its entry file is
`../cl-restaurant-core/cl-restaurant-core.php` (class `CL_Restaurant_Core`, text domain `cl-restaurant-core`). The
two repos may be on different branches, so before using a symbol from the other repo, check that it exists on that
repo's checked-out branch, and guard the call.

- **Constants:** `CL_RESTAURANT_CORE` (the plugin version; the theme's `plugin_update_notices()` in `functions.php`
  warns when it is below 2.2.0), `CL_RESTAURANT_CORE_BASE_DIR` and `_BASE_URL`, `CL_RESTAURANT_CORE_SCRIPT_VER`
  (`time()` under `WP_DEBUG`), and `CL_RESTAURANT_CORE_THEME_PREFIX` = `'cl_restaurant'`.
- **Post types, post meta and widgets** (`inc/post-types.php`, `inc/rt-posts.php`, `inc/post-meta.php`, `widgets/`)
  load on `after_setup_theme` only if `RT_FRAMEWORK_VERSION` is defined, which neither repo does. `inc/post-meta.php`
  registers the `{prefix}_layout_settings` meta box (`cl_restaurant_layout_settings`) through `RT_Postmeta`, and the
  theme's `Layouts` class reads that meta.
- **Elementor widgets** (`elementor/`) load only if `class_exists('CLR_Restaurant_Main')`, the theme class in
  `functions.php`, and Elementor has loaded. Renaming that theme class breaks the plugin.
- **Shared hooks:** both sides name `cl_restaurant_theme_init`, but the plugin never hooks it; the theme fires it
  inside `CLR_Restaurant_Main::includes()`. The plugin also handles `rdtheme_social_share` (`inc/social-share.php`).
- **Demo importer** (`demo-importer/`, `inc/demo-importer.php`) works with the theme's `sample-data/`, and the
  optimization module (`optimization/`) loads only on PHP > 7.4.
- The plugin enqueues its own `assets/css/cl-restaurant-core.css` and `assets/js/cl-restaurant-core.js` on both the
  front end and the admin.

## Commands

The build uses Laravel Mix (`webpack.mix.js`). There is no PHP test suite and no PHP linter config.

```bash
npm run dev          # compile src/sass → assets/css/{main,admin}.css + RTL bundle assets/css-rtl/clrestaurant-rtl.css
npm run watch        # same, in watch mode
npm run production   # minified build, assets/css/minified/main.css, assets/css-rtl/clrestaurant-rtl.min.css, and regenerates languages/clrestaurant.pot
npm run package      # build + copy the shippable files into build/cl-restaurant/
npm run zip          # package + build/cl-restaurant.<style.css Version>.zip
npm run lint:css     # wp-scripts lint-style
npm run lint:js      # wp-scripts lint-js
```

When you add a new top-level theme file or folder, also add it to the `includes` list in `webpack.mix.js`. If you skip
this, the file is left out of the packaged zip.

## Gotchas

- **`assets/css/` and `assets/js/` are gitignored**, yet `assets/js/*.js` (`main.js`, `food-menu.js`, `form.js`,
  `customizer.js`, `clrestaurant-admin.js`) are hand-written source with no `src/js` counterpart. Static CSS such as
  `animate.css`, `fontello.css` and `rt-animation.css` is also only in `assets/css/`. Edits there are not tracked by
  git, so tell the user when you change them. Only SCSS lives in `src/sass` (`main.scss`, `admin.scss`, `rtl.scss`).
- RTL CSS is generated: compiled `main.css` → rtlcss → combined with `rtl.scss` output. Write RTL-only overrides in
  `src/sass/rtl.scss` and never edit `assets/css-rtl/clrestaurant-rtl*.css` directly.
- `*.txt` is gitignored, so the repo has no tracked `readme.txt` changelog.
- `RT_DEBUG` set to true skips loading the license and updater code in `lib/updater/`.

## Architecture

**Bootstrap:** `functions.php` loads `lib/` (updater, TGM), then `inc/init.php`. That file loads the Composer
autoloader (PSR-4 `RadiusTheme\CLRestaurant\` → `inc/`) and instantiates the singletons: `Constants`, `TGM_Config`,
`Options`, `General`, `Scripts`, `Layouts`, the Customizer `Init` (only when `WP_Customize_Control` exists), and
`Listing_Functions` and `Shortcode` (only when `class_exists('Rtcl')`). There is no `composer.json`, only the
committed `vendor/`. New classes autoload as long as the namespace matches their path under `inc/`.

**Options flow (the core pattern):**
1. `inc/Customizer/Default_Data.php` holds every theme_mod key and its default.
2. `inc/Customizer/Settings/*.php` classes extend `Customizer`, call `populated_default_data()`, and register controls
   on `customize_register`. Custom controls live in `inc/Customizer/Controls/`, and sanitizers are the global
   `rttheme_*_sanitization` functions in `inc/Customizer/sanitization.php`.
3. `Options::set_options()` (on `after_setup_theme` and `customize_preview_init`) merges the theme_mods over the
   defaults into `Options::$options[...]`.
4. On `template_redirect`, `Layouts::layout_settings()` resolves per-request values (`Options::$layout`,
   `$header_style`, `$footer_style`, `$has_banner`, padding, etc.). It reads them from the per-post
   `cl_restaurant_layout_settings` meta (where `'default'` falls back to the Customizer), with `{prefix}_*` keys per
   context: page, single_post, listing archive/single, search and error.

A new option therefore needs a default in `Default_Data`, a control in a `Settings` class, and, if it varies per page,
handling in `Layouts`. Templates read the resolved static props, not `get_theme_mod()`.

**Dynamic CSS:** `Scripts` requires `dynamic-styles/dynamic-style.php`, which uses the color, typography and menu
partials to emit inline CSS from `Options::$options` (typography options are JSON strings that get `json_decode`d).
Google Fonts URLs are built in `Scripts::fonts_url()`.

**Templates:**
- `header.php` and `footer.php` pick `template-parts/header/header-{n}.php` and `template-parts/footer/footer-{n}.php`
  from the resolved style options.
- `classified-listing/` overrides Classified Listing plugin templates by mirroring the plugin's template paths.
  `review-schema/` does the same for the Review Schema plugin.
- `classified-listing/custom/` and `classified-listing/store/custom/` hold theme-only partials, loaded through
  `Helper::get_custom_listing_template()` and `Helper::get_custom_store_template()`. These pass `$args` through
  `extract()`.
- `inc/Listing_Functions.php` re-wires Classified Listing output: it `remove_action`s the plugin's `TemplateHooks` and
  `StoreHooks` callbacks and adds theme callbacks on `rtcl_*` hooks. It also handles the food-menu custom field, the
  category color term meta and the store loop. When you change listing markup, check here before editing a template.
- `inc/Helper.php` is the static utility hub (asset URL helpers like `get_css` and `get_js`, layout classes,
  pagination, color helpers). It mixes in `inc/Traits/*`.

**Plugin dependencies:** Classified Listing classes (`Rtcl\...`, `RtclPro\...`, store addon) are used directly, and
`Helper` imports `RtclPro\Helpers\Fns`. Guard any new use with `class_exists`/`method_exists`, because Pro and the
add-ons are optional.
