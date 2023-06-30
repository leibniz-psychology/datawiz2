import { Controller } from '@hotwired/stimulus';
import axios from 'axios';
export default class extends Controller {
    static targets = [ "displayArea", "inputArea", "input"]
    static values = {
        url: String,
        text: String,
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
        this.inputTarget.value = this.textValue;
    }

    postToUrl(url, value) {
        axios.post(url, value).then((data) => {
            console.log(data);
            location.reload();
        }).catch((error) => {
            throw new Error("text-edit-controller: Could not save text: " + error);
        });
    }

    toggleEditMode() {
        this.displayAreaTargets.forEach(item => {
            item.classList.toggle('hidden');
        });
        this.inputAreaTargets.forEach(item => {
            item.classList.toggle('hidden');
        });
    }
}