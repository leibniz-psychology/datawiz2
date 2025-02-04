import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = [ "modalOverlay" ]
    static values = {
        url: String,
        onSubmit: String,
    }

    openModal(event) {
        if (event != null) {
            event.preventDefault();
            event.stopImmediatePropagation();
        }

        this.modalOverlayTarget.classList.remove("hidden");
        this.modalOverlayTarget.classList.remove("Modal-Inactive");
        this.modalOverlayTarget.classList.add("Modal-Active");
    }

    closeModal(event = null) {
        if (event != null) {
            event.preventDefault();
            event.stopImmediatePropagation();
        }

        this.modalOverlayTarget.classList.remove("Modal-Active");
        this.modalOverlayTarget.classList.add("Modal-Inactive");
        setTimeout(() => {
            this.modalOverlayTarget.classList.add("hidden");
        }, 300);
    }

    submit(event) {
        if (event != null) {
            event.preventDefault();
            event.stopImmediatePropagation();
        }

        const url = this.urlValue;

        if (this.onSubmitValue === "navigateToUrl") {
            this.navigateToUrl(url);
        } else {
            this.postToUrl(url);
        }

        this.closeModal(event);
    }

    navigateToUrl(url) {
        window.location.href = url;
    }

    async postToUrl(url) {
        try {
            await fetch(url, { method: 'POST' });
            location.reload();
        } catch (error) {
            console.log(error);
        }
    }

}