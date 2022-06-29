const path = require('path');

/* Configure START */
const pathBuildKram = path.resolve("../buildKramGhsvs");
const updateXml = `${pathBuildKram}/build/update.xml`;
const changelogXml = `${pathBuildKram}/build/changelog.xml`;
const releaseTxt = `${pathBuildKram}/build/release.txt`;
/* Configure END */

const replaceXml = require(`${pathBuildKram}/build/replaceXml.js`);
const helper = require(`${pathBuildKram}/build/helper.js`);

const pc = require(`${pathBuildKram}/node_modules/picocolors`);
const fse = require(`${pathBuildKram}/node_modules/fs-extra`);

let replaceXmlOptions = {};
let zipOptions = {};
let from = "";
let to = "";

const {
	name,
	version,

	// An additional checker to avoid stupid copying of bootstrap.bundle
	ghsvsBootstrapBundleVersion
} = require("./package.json");

const manifestFileName = `templateDetails.xml`;
const Manifest = `${__dirname}/package/${manifestFileName}`;

// The base folder/file to check for matching version bootstrapBundleVersion from package.json.
const bsBundleFileBase = `_ghsvsBootstrapBundleVersion_/index.umd.js`;

// The string to search in that file(s).
const bsBundleRegExp = new RegExp(
	/\* Bootstrap \(v(\d+\.\d+\.\d+)\): index\.umd\.js/
);

let foundVersion = '';

// Clearify also  in zip filename if something failed.
let versionSub = 0;

(async function exec()
{

	// ### Check self compiled bootstrap.bundle.js. START.
	const targetPath = `./src/js/plg_system_bs3ghsvs/bootstrap`;
	const origPath = path.join('../bootstrap', 'dist', 'js');

	let bsBundleFile = path.join(targetPath, bsBundleFileBase);

	if (await helper.getExists(bsBundleFile))
	{
		foundVersion = await helper.findVersionSubRegex(
			path.resolve(bsBundleFile), bsBundleRegExp);

		if (foundVersion === ghsvsBootstrapBundleVersion)
		{
			versionSub = ghsvsBootstrapBundleVersion;
			console.log(pc.green(pc.bold(
				`BootstrapBundleVersion ${versionSub} successfully compared! Nothing to copy later.`)));
		}
		else
		{
			console.log(pc.red(pc.bold(
				`BootstrapBundleVersion ${ghsvsBootstrapBundleVersion} NOT successfully compared! I search on.`)));
		}
	}
	else
	{
		console.log(pc.red(pc.bold(
			`bsBundleFile ${bsBundleFile} does NOT exist. I'll try the original.`)));
	}

	// Not found. Let's see in git-kram/bootstrap/
	if (!versionSub)
	{
		bsBundleFile = path.join(origPath, bsBundleFileBase);

		if (await helper.getExists(bsBundleFile))
		{
			foundVersion = await helper.findVersionSubRegex(
				path.resolve(bsBundleFile), bsBundleRegExp);

			if (foundVersion === ghsvsBootstrapBundleVersion)
			{
				versionSub = ghsvsBootstrapBundleVersion;
				console.log(pc.green(pc.bold(
					`BootstrapBundleVersion ${versionSub} successfully compared! Copy files now.`)));

				await fse.copy(
					`${origPath}`,
					`${targetPath}`
				).then(
					answer => console.log(pc.yellow(pc.bold(
						`Copied self compiled bootstrap.bundle JS to template's *override* folder ${targetPath}.`)))
				);
			}
			else
			{
				console.log(pc.red(pc.bold(
					`BootstrapBundleVersion ${ghsvsBootstrapBundleVersion} NOT successfully compared! I'm cancelling the program!`)));
			}
		}
	}

	if (!versionSub)
	{
		console.log(pc.bgRed(pc.white(pc.bold(
			`Cancelling! Check setting "ghsvsBootstrapBundleVersion" in package.json and if self compiled bootstrap.bundle.js with same version exists in ${origPath} or ${targetPath}. See README.`))));
		process.exit(0);
	}
	// ### Check self compiled bootstrap.bundle.js. END.

	let cleanOuts = [
		`./package`,
		`./dist`,
	];
	await helper.cleanOut(cleanOuts);

	from = './src'
	to = './package'
	await helper.copy(from, to)

	await helper.mkdir('./dist');

	const zipFilename = `${name}-${version}_${versionSub}.zip`;

	replaceXmlOptions = {
		"xmlFile": Manifest,
		"zipFilename": zipFilename,
		"checksum": "",
		"dirname": __dirname
	};

	await replaceXml.main(replaceXmlOptions);
	await fse.copy(`${Manifest}`, `./dist/${manifestFileName}`).then(
		answer => console.log(pc.yellow(pc.bold(
			`Copied "${manifestFileName}" to "./dist".`)))
	);


	// Create zip file and detect checksum then.
	const zipFilePath = path.resolve(`./dist/${zipFilename}`);

	zipOptions = {
		"source": path.resolve("package"),
		"target": zipFilePath
	};
	await helper.zip(zipOptions)

	const Digest = 'sha256'; //sha384, sha512
	const checksum = await helper.getChecksum(zipFilePath, Digest)
  .then(
		hash => {
			const tag = `<${Digest}>${hash}</${Digest}>`;
			console.log(pc.green(pc.bold(`Checksum tag is: ${tag}`)));
			return tag;
		}
	)
	.catch(error => {
		console.log(error);
		console.log(pc.red(pc.bold(
			`Error while checksum creation. I won't set one!`)));
		return '';
	});

	replaceXmlOptions.checksum = checksum;

	// Bei diesen werden zuerst Vorlagen nach dist/ kopiert und dort erst "replaced".
	for (const file of [updateXml, changelogXml, releaseTxt])
	{
		from = file;
		to = `./dist/${path.win32.basename(file)}`;
		await fse.copy(from, to
		).then(
			answer => console.log(
				pc.yellow(pc.bold(`Copied "${from}" to "${to}".`))
			)
		);

		replaceXmlOptions.xmlFile = path.resolve(to);
		await replaceXml.main(replaceXmlOptions);
	}

	cleanOuts = [
		`./package`
	];
	await helper.cleanOut(cleanOuts).then(
		answer => console.log(
			pc.cyan(pc.bold(pc.bgRed(`Finished. Good bye!`)))
		)
	);
})();
