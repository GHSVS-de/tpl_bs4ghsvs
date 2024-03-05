# Be warned!
This is not a template that you install and then it runs smoothly. It needs a lot of background knowledge and regular reworking. Versions are not backwards compatible and stuff. It can break your website! It needs other extensions and stuff.

# Sei gewarnt!
Das ist kein Template, das man installiert und dann läuft es reibungslos. Es braucht reichlich Hintergrundwissen und regelmäßige Nacharbeit. Versionen sind nicht rückwärtskompatibel und Zeugs. Es kann deine Web-Seite zerstören! Es braucht weitere Erweiterungen und Zeugs.

----------------
# My personal build procedure (WSL 1 or 2, Debian, Win 10)

**@since > v2022.03.31: Build procedure uses local repo fork of https://github.com/GHSVS-de/buildKramGhsvs**

## New Bootstrap release that you want to use in this template?
- You should first build a new `pkg_file_assetghsvs` with new version.

### Special step (1). Build reduced `bootstrap.bundle` there.

### Compile SCSS to CSS. Also if changed scss-ghsvs/.
- Needs `/mnt/z/git-kram/media/assetghsvs/scss/bootstrap/xy` where `xy` is the wanted version in SCSS files of this template.
- Therefore adapt the paths there if needed. Example for version 5.2:

`@import "../../../media/assetghsvs/scss/bootstrap/52/root";`

```
cd /mnt/z/git-kram/sass_compile_prefixghsvs
node prepareProject.js p_tpl_bs4ghsvs
sh run-p_tpl_bs4ghsvs.sh
```

## Adapt "version" parameters
in `joomla.asset.json` if new versions (BS, JQuery ...) used.

## Next step: Build package for this repository
- Prepare/adapt `./package.json`.
  - Don't forget: Adapt parameter `bootstrapVersionsub`!
- `cd /mnt/z/git-kram/tpl_bs4ghsvs`

## node/npm updates/installation
- `npm run updateCheck` or (faster) `npm outdated`
- `npm run update` (if needed) or (faster) `npm update --save-dev`
- `npm install` (if needed)

## PHP Codestyle
If you think it's worth it.
- `cd /mnt/z/git-kram/php-cs-fixer-ghsvs`
- `npm run tpl_bs4ghsvsDry` (= dry test run).
- `npm run tpl_bs4ghsvs` (= cleans code).
- `cd /mnt/z/git-kram/tpl_bs4ghsvs` (back to this repo).

## Build installable ZIP package
- `node build.js`
- New, installable ZIP is in `./dist` afterwards.
- Version after `_` in filename is version of used Bootstrap (Bundle JS, SCSS).
- All packed files for this ZIP can be seen in `./package`. **But only if you disable deletion of this folder at the end of `build.js`**.s

### For Joomla update and changelog server
- Create new release with new tag.
  - See release description in `dist/release.txt`.
- Extracts(!) of the update and changelog XML for update and changelog servers are in `./dist` as well. Copy/paste and necessary additions.
