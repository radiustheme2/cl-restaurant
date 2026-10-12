const mix = require("laravel-mix");
const fs = require("fs-extra");
const path = require("path");
const cliColor = require("cli-color");
const emojic = require("emojic");
const wpPot = require("wp-pot");
const archiver = require("archiver");
const min = mix.inProduction() ? ".min" : ""; // Minified files in production

const package_path = path.resolve(__dirname);
const package_slug = path.basename(path.resolve(package_path));
const temDirectory = package_path + '/build';

require('@tinypixelco/laravel-mix-wp-blocks');

mix.autoload({
	jquery: ['$', 'window.jQuery', 'jQuery'],
});

// Minify normal CSS files
mix.sass('src/sass/main.scss', 'assets/css')
	.sass('src/sass/admin.scss', 'assets/css')
	.sass('src/sass/rtl.scss', 'build/temp/')  // Excluded from minification
	.sourceMaps(true, 'source-map')
	.options({
		terser: {
			extractComments: false
		},
		processCssUrls: false
	})
	// PostCSS processing for RTL
	.postCss('assets/css/main.css', 'build/temp/main.css', [
		require('rtlcss'),
	])
	// Combine the processed styles
	.combine([
		'build/temp/main.css',
		'build/temp/rtl.css',
	], `assets/css-rtl/clrestaurant-rtl${min}.css`);

if (mix.inProduction()) {
	// Minify CSS files in production mode
	mix.styles([
		'assets/css/main.css',
		'assets/css/admin.css'
	], 'assets/css/minified/main.css')
		.minify('assets/css/minified/main.css'); // This ensures CSS is minified
}

if (mix.inProduction()) {
	let languages = path.resolve("languages");
	fs.ensureDir(languages, function (err) {
		if (err) return console.error(err); // if file or folder does not exist
		wpPot({
			package: "CLRestaurant Theme",
			bugReport: "",
			src: "**/*.php",
			domain: "clrestaurant",
			domain: "clrestaurant",
			destFile: "languages/clrestaurant.pot",
		});
	});
}

// Make package
if (process.env.npm_config_package) {
	mix.then(function () {
		const copyTo = path.resolve(`${temDirectory}/${package_slug}`);
		// Select all files to include in the build package
		let includes = [
			"assets",
			"classified-listing",
			"dynamic-styles",
			"inc",
			"languages",
			"lib",
			"plugin-bundle",
			"review-schema",
			"sample-data",
			"template-parts",
			"templates",
			"vendor",
			"404.php",
			"comments.php",
			"footer.php",
			"functions.php",
			"header.php",
			"index.php",
			"page.php",
			"screenshot.png",
			"search.php",
			"sidebar.php",
			"sidebar-listing.php",
			"single.php",
			"style.css",
			"wpml-config.xml",
		];
		fs.ensureDir(copyTo, function (err) {
			if (err) return console.error(err);
			includes.map((include) => {
				fs.copy(
					`${package_path}/${include}`,
					`${copyTo}/${include}`,
					{ filter: (src) => !src.endsWith('.map') },
					function (err) {
						if (err) return console.error(err);
						console.log(
							cliColor.white(`=> ${emojic.smiley}  ${include} copied...`)
						);
					}
				);
			});
			console.log(
				cliColor.white(`=> ${emojic.whiteCheckMark}  Build directory created`)
			);
		});
	});

	return;
}

if (process.env.npm_config_zip) {
	async function getVersion() {
		let data;
		try {
			data = await fs.readFile(package_path + `/style.css`, "utf-8");
		} catch (err) {
			console.error(err);
		}
		const lines = data.split(/\r?\n/);
		let version = "";
		for (let i = 0; i < lines.length; i++) {
			if (lines[i].includes("* Version:") || lines[i].includes("Version:")) {
				version = lines[i]
					.replace("Version:", "")
					.trim();
				break;
			}
		}
		return version;
	}

	const version_get = getVersion();
	version_get.then(function (version) {
		const destinationPath = `${temDirectory}/${package_slug}.${version}.zip`;
		const output = fs.createWriteStream(destinationPath);
		const archive = archiver("zip", {zlib: {level: 9}});
		output.on("close", function () {
			console.log(archive.pointer() + " total bytes");
			console.log(
				"Archive has been finalized and the output file descriptor has closed."
			);
			fs.removeSync(`${temDirectory}/${package_slug}`);
		});
		output.on("end", function () {
			console.log("Data has been drained");
		});
		archive.on("error", function (err) {
			throw err;
		});

		archive.pipe(output);
		archive.directory(`${temDirectory}/${package_slug}`, package_slug);
		archive.finalize();
	});
}
