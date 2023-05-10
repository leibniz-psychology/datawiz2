import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = [ "list" ]
    static values = {
        counter: Number,
        widgetPrototype: String,
    }

    addItemToCollection() {
        const list = this.listTarget;
        let newWidget = this.widgetPrototypeValue;
        newWidget = newWidget.replace(/__name__/g, (++this.counterValue).toString());
        list.append(this.buildListElem(list, newWidget));
    }

    removeItemFromCollection(event) {
        const list = this.listTarget;
        let parentLi = event.currentTarget.closest("li");
        if (list.children.length > 1) {
            parentLi.remove();
        } else {
            let input = parentLi.querySelectorAll(
                'input[type="text"], input[type="email"], textarea'
            );
            if (input !== undefined && input !== null) {
                input.forEach((i) => {
                    i.value = "";
                });
            }
        }
    }

    buildListElem(list, newWidget) {
        let newElem = document.createElement("template");
        newElem.innerHTML = newWidget;
        return newElem.content.firstElementChild;
    }

}