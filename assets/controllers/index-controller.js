// A Stimulus JavaScript controller file
// https://stimulus.hotwired.dev
// @see templates/security/login.html.twig
// More info on Symfony UX https://ux.symfony.com

import { Controller } from '@hotwired/stimulus';
import { popUp, generateUrl } from '../js/main';

/*
 * The following line makes this controller "lazy": it won't be downloaded until needed
 * See https://github.com/symfony/stimulus-bridge#lazy-controllers
 */
/* stimulusFetch: 'lazy' */
export default class extends Controller {
    onRemove(event) {
        popUp.confirm({
            title: AppGlobal.messages.confirm_remove_title,
            text: AppGlobal.messages.confirm_remove_message,
            icon: 'warning'
        }).then(function (result) {
            if (result) {
                const url = generateUrl(event.params.route,event.params.routeparameters);
                window.location.href = url;
            }
        });
    }
}
