import { Controller } from '@hotwired/stimulus';

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

    async postToUrl(url, value) {
        try {
            const data = await fetch(url, { method: 'POST', body: value });
            console.log(data);
            location.reload();
        } catch (error) {
            throw new Error("text-edit-controller: Could not save text: " + error);
        }
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