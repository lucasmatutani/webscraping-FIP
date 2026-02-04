class CarValueService {
    static async fetchCarValue(modelId, year) {
        try {
            const response = await fetch(`/api/value?model_id=${modelId}&year=${year}`);
            return await response.json();
        } catch (error) {
            console.error("Erro na busca:", error);
            throw error;
        }
    }
}

class FormManager {
    constructor() {
        this.form = document.getElementById("searchForm");
        this.modelSelect = document.getElementById("modelSelect");
        this.yearSelect = document.getElementById("yearSelect");
        if (this.form) {
            this.init();
        }
    }

    init() {
        this.form.addEventListener("submit", (event) => this.handleSubmit(event));
    }

    handleSubmit(event) {
        const modelId = this.modelSelect?.value;
        const year = this.yearSelect?.value;

        if (!modelId || !year) {
            event.preventDefault();
            alert("Por favor, selecione uma marca, modelo e ano.");
        }
    }
}


class App {
    static init() {
        this.formManager = new FormManager();
    }
}

// Inicialização
window.onload = () => App.init();

window.App = App;