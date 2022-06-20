# Be warned!
This is not a template that you install and then it runs smoothly. It needs a lot of background knowledge and regular reworking. Versions are not backwards compatible and stuff. It can break your website! It needs other extensions and stuff.

# Sei gewarnt!
Das ist kein Template, das man installiert und dann läuft es reibungslos. Es braucht reichlich Hintergrundwissen und regelmäßige Nacharbeit. Versionen sind nicht rückwärtskompatibel und Zeugs. Es kann deine Web-Seite zerstören! Es braucht weitere Erweiterungen und Zeugs.

----------------
# My personal build procedure (WSL 1, Debian, Win 10)

**@since > v2022.03.31: Build procedure uses local repo fork of https://github.com/GHSVS-de/buildKramGhsvs**

## New Bootstrap release? Special step (1)!!!!! Build reduced `bootstrap.bundle` JS!!!!!!
- - You should first build a new `plg_system_bs3ghsvs_bs5`. Makes the whole release procedure a little bit easier.

- Delete everything in `/mnt/z/git-kram/bootstrap/`
- - but don't delete `./.git`!
- - but don't delete `./node_modules`!
- Get from https://github.com/twbs/bootstrap correct version:
- - Select in tags dropdown the wished release.
- - Download ZIP and unzip into `/mnt/z/git-kram/bootstrap/`.
- Open Github Desktop and let it do it's work ("refresh with new files").
- `cd /mnt/z/git-kram/bootstrap/`
- `unlink package-lock.json`
- `rm -r dist/`
- `rm -r js/dist/`
- `npm install`
- Change file `git-kram/bootstrap/js/index.umd.js`
- Comment out unwanted parts. Each twice.

```
import Alert from './src/alert'
import Button from './src/button'
// import Carousel from './src/carousel'
import Collapse from './src/collapse'
import Dropdown from './src/dropdown'
import Modal from './src/modal'
// import Offcanvas from './src/offcanvas'
// import Popover from './src/popover'
// import ScrollSpy from './src/scrollspy'
// import Tab from './src/tab'
import Toast from './src/toast'
// import Tooltip from './src/tooltip'

export default {
  Alert,
  Button,
  // Carousel,
  Collapse,
  Dropdown,
  Modal,
  // Offcanvas,
  // Popover,
  // ScrollSpy,
  // Tab,
  Toast,
  // Tooltip
}
```

- Compile: `npm run js`

### !!!Don't forget then!!!
- Craete new folder `git-kram/bootstrap/dist/js/_ghsvsBootstrapBundleVersion_`.
- Copy `git-kram/bootstrap/js/index.umd.js` in this new folder.
- `tpl_bs4ghsvs` needs it like this for build prodedure!

## If a new Bootstrap release or changed scss-ghsvs/? Special step  (2) ! Compile SCSS to CSS!
- You should first build a new `plg_system_bs3ghsvs_bs5`. Makes the whole release procedure a little bit easier.
- Needs `/mnt/z/git-kram/media/plg_system_bs3ghsvs/scss/bootstrap` that will be populated during `plg_system_bs3ghsvs_bs5` build.
-
```
cd /mnt/z/git-kram/sass_compile_prefixghsvs;
node prepareProject.js p_tpl_bs4ghsvs;
sh run-p_tpl_bs4ghsvs.sh;
```

## Next step: Build package for this repository
- Prepare/adapt `./package.json`.
- Don't forget to adapt parameter `ghsvsBootstrapBundleVersion` !!!!

- `cd /mnt/z/git-kram/tpl_bs4ghsvs`

## node/npm updates/installation
- `npm run updateCheck` or (faster) `npm outdated`
- `npm run update` (if needed) or (faster) `npm update --save-dev`
- `npm install` (if needed)

- `node build.js`

## PHP Codestyle
If you think it's worth it.
- `cd /mnt/z/git-kram/php-cs-fixer-ghsvs`
- `npm run tpl_bs4ghsvsDry` (= dry test run).
- `npm run tpl_bs4ghsvs` (= cleans code).
- `cd /mnt/z/git-kram/tpl_bs4ghsvs` (back to this repo).

## Build installable ZIP package
- `node build.js`
- New, installable ZIP is in `./dist` afterwards.
- Version after `_` in filename is version of self compiled smaller bootstrap.bundle and so.
- All packed files for this ZIP can be seen in `./package`. **But only if you disable deletion of this folder at the end of `build.js`**.s

### For Joomla update and changelog server
- Create new release with new tag.
- - See release description in `dist/release.txt`.
- Extracts(!) of the update and changelog XML for update and changelog servers are in `./dist` as well. Copy/paste and necessary additions.
