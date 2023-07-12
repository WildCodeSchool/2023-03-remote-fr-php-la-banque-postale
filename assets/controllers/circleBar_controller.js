import { Controller } from '@hotwired/stimulus';
const ProgressBar = require("progressbar.js");

export default class extends Controller {
    connect() {
        const bar = new ProgressBar.SemiCircle(this.element, {
            strokeWidth: 6,
            color: '#FFF',
            trailColor: '#FFF',
            trailWidth: 1,
            easing: 'easeInOut',
            duration: 1400,
            svgStyle: null,
            text: {
                value: '',
                alignToBottom: false
            },
            from: { color: '#FFF' },
            to: { color: '#3CB043' },
            // Set default step function for all animate calls
            step: (state, bar) => {
                bar.path.setAttribute('stroke', state.color);
                var value = Math.round(this.element.getAttribute('data-value'));
                if (value === 0) {
                    bar.setText('');
                } else {
                    bar.setText(value + ' %');
                }

                bar.text.style.color = state.color;
            }
        });
        bar.text.style.textAlign = 'center';
        bar.text.style.fontFamily = '"Raleway", Helvetica, sans-serif';
        bar.text.style.fontSize = '2rem';

        bar.animate(this.element.getAttribute('data-value') / 100);  // Number from 0.0 to 1.0
    }
}
