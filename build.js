const fse = require('fs-extra');
const util = require("util");
const rimRaf = util.promisify(require("rimraf"));
const chalk = require('chalk');
const replaceXml = require('./build/replaceXml.js');
const crypto = require('crypto');
const lineReader = util.promisify(require('line-reader').eachLine);
const path = require('path');

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

async function cleanOut (cleanOuts) {
	for (const file of cleanOuts)
	{
		await rimRaf(file).then(
			answer => console.log(chalk.redBright(`rimrafed: "${file}".`))
		).catch(error => console.error('Error ' + error));
	}
}

// Check if file or folder exists.
async function getExists (path)
{
  try {
    await fse.access(path)
    return true
  } catch {
    return false
  }
}

// Find version string in file.
async function findVersion (file, thisRegex, limit)
{
	if (!limit)
	{
		limit = 20;
	}

	let foundVersion = '';
	let count = 0;
	console.log(chalk.magentaBright(
		`Search version string. First ${limit} lines of "${file}".`));

	await lineReader(file, function(line)
	{
		count++;

		if (count >= limit)
		{
			console.log(chalk.redBright(`No version found.`));
			return false;
		}

		if (thisRegex.test(line))
		{
			foundVersion = line.match(thisRegex)[1];
			console.log(chalk.yellowBright(
				`Version "${foundVersion}" found.`));
			return false;
		}
	}).then(function (err) {
		if (err) throw err;
	});
	return foundVersion;
}

// Digest sha256, sha384 or sha512.
async function getChecksum(path, Digest)
{
  return new Promise(function (resolve, reject)
	{
    const hash = crypto.createHash(Digest);
    const input = fse.createReadStream(path);

    input.on('error', reject);
    input.on('data', function (chunk)
		{
      hash.update(chunk);
    });

    input.on('close', function ()
		{
      resolve(hash.digest('hex'));
    });
  });
}

(async function exec()
{
	// ### Check self compiled bootstrap.bundle.js. START.
	const targetPath = `./src/js/plg_system_bs3ghsvs/bootstrap`;
	let bsBundleFile = path.join(targetPath, bsBundleFileBase);

	if (await getExists(bsBundleFile))
	{
		foundVersion = await findVersion(bsBundleFile, bsBundleRegExp);

		if (foundVersion === ghsvsBootstrapBundleVersion)
		{
			versionSub = ghsvsBootstrapBundleVersion;
			console.log(chalk.greenBright(
				`Version successfully compared! Nothing to copy later.`));
		}
		else
		{
			console.log(chalk.redBright(
				`Version NOT successfully compared! I search on.`));
		}
	}

	// Not found. Let's see in git-kram/bootstrap/
	if (!versionSub)
	{
		var sourcePath = path.join(
			'/mnt/z/git-kram/bootstrap',
			'dist', 'js'
		);
		bsBundleFile = path.join(sourcePath, bsBundleFileBase);

		if (await getExists(bsBundleFile))
		{
			foundVersion = await findVersion(bsBundleFile, bsBundleRegExp);

			if (foundVersion === ghsvsBootstrapBundleVersion)
			{
				versionSub = ghsvsBootstrapBundleVersion;
				console.log(chalk.greenBright(
					`Version compared successfully! Will copy files now.`));
				await fse.copy(
					`${sourcePath}`,
					`${targetPath}`
				).then(
					answer => console.log(chalk.yellowBright(
						`Copied self compiled bootstrap.bundle JS to ${targetPath}.`))
				);
			}
			else
			{
				console.log(chalk.redBright(
					`Version NOT successfully compared! I'm cancelling the program!`));
			}
		}
	}

	if (!versionSub)
	{
		console.log(chalk.bgRed(chalk.whiteBright(
			`I'm cancelling the program! Check setting "ghsvsBootstrapBundleVersion" in package.json and if self compiled bootstrap.bundle.js with same version exists in ${sourcePath} or ${targetPath}. See README.`)));
		process.exit(0);
	}
	// ### Check self compiled bootstrap.bundle.js. END.

	let cleanOuts = [
		`./package`,
		`./dist`,
	];

	await cleanOut(cleanOuts);
	console.log(chalk.cyanBright(`Be patient! Some copy actions!`));

	await fse.copy("./src", "./package").then(
		answer => console.log(chalk.yellowBright(
			`Copied ./src/* to ./package.`))
	);

	await fse.mkdir("./dist").then(
		answer => console.log(chalk.greenBright(
			`Created ./dist.`))
	);

	const zipFilename = `${name}-${version}_${versionSub}.zip`;

	await replaceXml.main(Manifest, zipFilename);
	await fse.copy(`${Manifest}`, `./dist/${manifestFileName}`).then(
		answer => console.log(chalk.yellowBright(
			`Copied ${manifestFileName} to ./dist.`))
	);

	// Create zip file and detect checksum then.
	const zipFilePath = `./dist/${zipFilename}`;

	const zip = new (require('adm-zip'))();
	zip.addLocalFolder("package", false);
	await zip.writeZip(`${zipFilePath}`);
	console.log(chalk.cyanBright(chalk.bgRed(
		`./dist/${zipFilename} written.`)));

	const Digest = 'sha256'; //sha384, sha512
	const checksum = await getChecksum(zipFilePath, Digest)
  .then(
		hash => {
			const tag = `<${Digest}>${hash}</${Digest}>`;
			console.log(chalk.greenBright(`Checksum tag is: ${tag}`));
			return tag;
		}
	)
	.catch(error => {
		console.log(error);
		console.log(chalk.redBright(`Error while checksum creation. I won't set one!`));
		return '';
	});

	let xmlFile = 'update.xml';
	await fse.copy(`./${xmlFile}`, `./dist/${xmlFile}`).then(
		answer => console.log(chalk.yellowBright(
			`Copied ${xmlFile} to ./dist.`))
	);
	await replaceXml.main(`${__dirname}/dist/${xmlFile}`, zipFilename, checksum);

	xmlFile = 'changelog.xml';
	await fse.copy(`./${xmlFile}`, `./dist/${xmlFile}`).then(
		answer => console.log(chalk.yellowBright(
			`Copied ${xmlFile} to ./dist.`))
	);
	await replaceXml.main(`${__dirname}/dist/${xmlFile}`, zipFilename, checksum);

	xmlFile = 'release.txt';
	await fse.copy(`./${xmlFile}`, `./dist/${xmlFile}`).then(
		answer => console.log(chalk.yellowBright(
			`Copied ${xmlFile} to ./dist.`))
	);
	await replaceXml.main(`${__dirname}/dist/${xmlFile}`, zipFilename, checksum);


	cleanOuts = [
		`./package`,
	];
	await cleanOut(cleanOuts).then(
		answer => console.log(chalk.cyanBright(chalk.bgRed(
			`Finished. Good bye!`)))
	);

})();
