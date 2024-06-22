import Swal from 'sweetalert2';

export var popUp = {
    message: function(data){
        var popUp = Swal.fire({
            title: data.title,
            text: data.text,
            icon: data.icon,
            confirmButtonText: AppGlobal.buttons.accept,
            confirmButtonColor: '#5369f8'
        })

        return popUp;
    },
    confirm: function(data){
        if(data.showCancelButton == undefined){
            data.showCancelButton = true;
        }

        var popUp = Swal.fire({
            title: data.title,
            text: data.text,
            icon: data.icon,
            showCancelButton: data.showCancelButton,
            confirmButtonColor: '#5369f8',
            cancelButtonColor: '#ff5c75',
            confirmButtonText: AppGlobal.buttons.yes,
            cancelButtonText: AppGlobal.buttons.no,
            // reverseButtons: true
        }).then(function(result){
            return result.value;
        })

        return popUp;
    },
    toast: function(data) {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.addEventListener('mouseenter', Swal.stopTimer)
              toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        
        var popUp = Toast.fire({
            icon: data.icon,
            title: data.title
        })

        return popUp;
    }
    
}

export function generateUrl(route, parameters, cache) {
    if (parameters == null | parameters == undefined) {
        parameters = {};
    }

    if (!cache) {
        parameters['_dc'] = generateId();
    }
    
    return Routing.generate(route, parameters);
}

function s4() {
    return Math.floor((1 + Math.random()) * 0x10000)
            .toString(16)
            .substring(1);
}

export function generateId() {
    var separator = "_";
    return s4() + s4() + separator + s4() + separator + s4() + separator +
            s4()
            + separator + s4() + s4() + s4();
}

export function getFormData(event,id) {
    const form = document.getElementById(id);
    const currentData = new FormData(form);
    const formData = new FormData();
    
    // Button
    if (event.submitter && event.submitter.getAttribute("name")) {
        currentData.append(event.submitter.getAttribute("name"), event.submitter.getAttribute("value"));
    }
    
    for (let [key, value] of currentData) {
        var element = $('[name="'+key+'"]');
        var input = document.getElementById(element.attr("id"));
        if (input && input.classList.contains('number-format')) {
            value = element.maskMoney("unmasked")[0];
        }

        if (input && input.classList.contains('mask-phone-number')) {
            var mask = IMask(input, {
                mask: maskPhoneNumber
            });
            mask.value = value;
            value = mask.unmaskedValue;
        }
        
        formData.append(key,value);
    }

    return formData;
}