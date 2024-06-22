import { popUp, generateUrl } from './main.js';

export function onFlash(type, message) {
    popUp.toast({
        icon: type,
        title: message
    });
}

window.onFlash = onFlash;