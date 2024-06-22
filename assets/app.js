/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

import { startStimulusApp } from '@symfony/stimulus-bridge';

// Registers Stimulus controllers from controllers.json and in the controllers/ directory
export const app = startStimulusApp(require.context(
    '@symfony/stimulus-bridge/lazy-controller-loader!./controllers',
    true,
    /\.[jt]sx?$/
));

// jQuery
const $ = require('jquery');
global.$ = global.jQuery = $;
// CSS Cork
import '../public/bundles/baseadmin/theme/cork/bootstrap/css/bootstrap.css';
import '../public/bundles/baseadmin/theme/cork/assets/css/loader.css';
import '../public/bundles/baseadmin/theme/cork/assets/css/plugins.css';
// JS Cork
import '../public/bundles/baseadmin/theme/cork/jquery/jquery-3.1.1.min.js';
// import '../public/bundles/baseadmin/theme/cork/bootstrap/js/popper.min.js';
// import '../public/bundles/baseadmin/theme/cork/bootstrap/js/bootstrap.min.js';
import '../public/bundles/baseadmin/theme/cork/plugins/perfect-scrollbar/perfect-scrollbar.min.js';
import '../public/bundles/baseadmin/theme/cork/assets/js/loader.js';
import '../public/bundles/baseadmin/theme/cork/assets/js/app.js';
// Images
import './images/logo.png';
import './images/logo-ico-90x90.png';
import './images/favicon.ico';
import './images/avatar.png';