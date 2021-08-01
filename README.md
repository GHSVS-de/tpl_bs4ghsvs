# My personal build procedure (WSL 1, Debian, Win 10)
## Special step !!!!!Build reduced `bootstrap.bundle` JS!!!!!!
- To copy later on into target `./src/js/plg_system_bs3ghsvs/bootstrap`
- GitHub Desktop: Fork https://github.com/twbs/bootstrap
- `cd /mnt/z/git-kram/bootstrap/`
- npm install
- Delete folders `git-kram/bootstrap/dist/` and `git-kram/bootstrap/js/dist/`
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
- Copy all files to target from `git-kram/bootstrap/dist/js/`

## Next step: Build package
- Prepare/adapt `./package.json`.
- `cd /mnt/z/git-kram/tpl_bs4ghsvs`

## node/npm updates/installation
- `npm run g-npm-update-check` or (faster) `ncu`
- `npm run g-ncu-override-json` (if needed) or (faster) `ncu -u`
- `npm install` (if needed)

- `node build.js`

### For Joomla update server
- Create new release with new tag.
- Get download link for new `dist/plg_blahaba_blubber...zip` **from newly created tag branch** and add to release description.
- Extracts(!) of the update and changelog XML for update and changelog servers are in `./dist` as well. Check for necessary additions! Then copy/paste.
