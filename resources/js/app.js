import './bootstrap';
import './cookie-consent';
import './cms-page-reveal';

import 'flowbite'

import Toastify from 'toastify-js'
import 'toastify-js/src/toastify.css';

// Import Toastify JS
window.Toastify = Toastify;

/** Remove stray Flowbite drawer backdrops that can block link clicks after the drawer closes */
function removeStaleDrawerBackdrops() {
    document.querySelectorAll('[drawer-backdrop], [data-drawer-backdrop]').forEach((el) => el.remove());
}

document.addEventListener('DOMContentLoaded', removeStaleDrawerBackdrops);
document.addEventListener('click', removeStaleDrawerBackdrops, true);