// A Stimulus JavaScript controller file
// https://stimulus.hotwired.dev
// @see templates/security/login.html.twig
// More info on Symfony UX https://ux.symfony.com

import { Controller } from '@hotwired/stimulus';
import { generateUrl, popUp } from '../js/main';

/*
 * The following line makes this controller "lazy": it won't be downloaded until needed
 * See https://github.com/symfony/stimulus-bridge#lazy-controllers
 */
/* stimulusFetch: 'lazy' */
export default class extends Controller {
    
    connect() {
    }

    onGetConfirm(event) {
        let title = event.params.title;
        if (!title) {
            title = CoreBundleGlobal.action.confirm.default
        }

        popUp.confirm({
            title: title,
            icon: 'warning'
        }).then(function (result) {
            if (result) {
                // http
                //     .get(generateUrl(event.params.route,event.params.routeparameters))
                //     .then(function(response){})
            }
        });
    }

    onEventEmit(event) {

        // Load default data
        const eventname = event.params.eventname;
        const details = event.params.details

        // Register event
        const newEvent = new CustomEvent(eventname, {detail: details});

        // Emit event
        window.dispatchEvent(newEvent);
    }
}
