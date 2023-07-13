import { Controller } from '@hotwired/stimulus';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */


export default class extends Controller {
  static targets = ['eyeIcon', 'inputPassword']
  isVisible = false;
  toggle() {
    this.isVisible = !this.isVisible;
    this.updateWidget();
  }

  updateWidget() {
    if (this.isVisible) {
      this.eyeIconTarget.className = 'fa-solid fa-eye text-secondary';
      this.inputPasswordTarget.setAttribute('type', 'text');
    }
    else {
      this.eyeIconTarget.className = 'fa-regular fa-eye-slash text-secondary';
      this.inputPasswordTarget.setAttribute('type', 'password');
    }
  }
}
