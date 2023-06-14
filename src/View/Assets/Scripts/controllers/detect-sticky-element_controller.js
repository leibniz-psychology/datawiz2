import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    /**
     * See https://stackoverflow.com/a/57991537
     */
    connect() {
        const observer = new IntersectionObserver(
            ([e]) =>
                e.target.classList.toggle("WizNavBar_isSticky", e.intersectionRatio < 1),
            { threshold: [1] }
        );
        observer.observe(this.element);
    }

}