import {Notyf} from "notyf";
import 'notyf/notyf.min.css';


export class Toast {
    constructor(){
        this.notyf = new Notyf({
            duration: 3000,
            position: { x: 'right', y: 'top'},
            types: [
                {
                    type: 'warning',
                    background: 'orange',
                    icon: {
                        className: 'material-icons',
                        tagName: 'i',
                        text: 'warning'
                    }
                },
                {
                    type: 'error',
                    background: 'indianred',
                    duration: 3000,
                    dismissible: true,
                    icon: false,
                }
            ]
        });
    }

    clear() {
        this.notyf.dismissAll();
    }

    success(message) {
        this.notyf.dismissAll();
        this.notyf.success(message);
        // if you don't want to have audio, remove below lines
        // otherwise adjust path
        // const audio = new Audio('/path/to/your/success.mp3');
        // audio.play();
    }

    error(message) {
        this.notyf.dismissAll();
        this.notyf.error(message);
        // if you don't want to have audio, remove below lines
        // otherwise adjust path
        // const audio = new Audio('/path/to/your/error.mp3
    }
    errors(errors) {
        this.notyf.dismissAll();
        Object.values(errors).forEach((value) => {
            this.notyf.error({
                message: value,
            });
        });
        // if you don't want to have audio, remove below lines
        // otherwise adjust path
        // const audio = new Audio('/path/to/your/error.mp3');
        // audio.play();
    }
}