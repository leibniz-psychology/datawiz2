import { Controller } from '@hotwired/stimulus';
import axios from 'axios';
export default class extends Controller {
    static targets = [ "displayArea", "display", "inputArea", "input", "hideWhenEmpty", "showWhenEmpty"]
    static values = {
        url: String,
        text: String,
    }

    connect() {
        this.showElementsAccordingToText(this.textValue);
    }

    edit(event) {
        if (event != null) {
            event.preventDefault();
            event.stopImmediatePropagation();
        }

        this.toggleEditMode();
    }

    submit(event) {
        if (event != null) {
            event.preventDefault();
            event.stopImmediatePropagation();
        }

        const text = this.inputTarget.value
        this.postToUrl(this.urlValue, text);
        this.toggleEditMode();
    }

    cancel(event) {
        if (event != null) {
            event.preventDefault();
            event.stopImmediatePropagation();
        }

        this.toggleEditMode();
        this.inputTarget.value = this.displayTarget.innerHTML;
    }

    postToUrl(url, value) {
        axios.post(url, value).then((data) => {
            this.addTextToDisplay(value);
            this.showElementsAccordingToText(value);
            console.log(data);
        }).catch((error) => {
            throw new Error("text-edit-controller: Could not save text: " + error);
        });
    }

    toggleEditMode() {
        this.displayAreaTarget.classList.toggle('hidden');
        this.inputAreaTarget.classList.toggle('hidden');
    }

    addTextToDisplay(text) {
        if (text !== null && text !== undefined) {
            this.displayTarget.innerHTML = text;
        }
    }

    showElementsAccordingToText(text) {
        if (text.length === 0) {
            this.hideWhenEmptyTargets.forEach(item => {
                item.classList.add('hidden');
            });
            this.showWhenEmptyTargets.forEach(item => {
                item.classList.remove('hidden');
            });
            this.displayTarget.classList.add('hidden');
        } else {
            this.hideWhenEmptyTargets.forEach(item => {
                item.classList.remove('hidden');
            });
            this.showWhenEmptyTargets.forEach(item => {
                item.classList.add('hidden');
            });
            this.displayTarget.classList.remove('hidden');
        }
    }

}