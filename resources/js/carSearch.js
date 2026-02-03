const MONTHS = [
    'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
    'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
];


class DateService {
    static getCurrentMonthYear() {
        const currentDate = new Date();
        const month = MONTHS[currentDate.getMonth()];
        const year = currentDate.getFullYear();
        return `${month} / ${year}`;
    }

    static getCurrentDate() {
        return new Date().toLocaleDateString();
    }
}


class SearchToggleManager {
    constructor() {
        this.commonSearchSection = document.getElementById('commonSearchSection');
        this.codeSearchSection = document.getElementById('codeSearchSection');
        this.init();
    }

    init() {
        this.setupEventListeners();
    }

    setupEventListeners() {
        document.querySelectorAll('.btnCommonSearch').forEach(button => {
            button.addEventListener('click', () => this.toggleSection('btnCommonSearch', this.commonSearchSection, this.codeSearchSection));
        });

        document.querySelectorAll('.btnCodeSearch').forEach(button => {
            button.addEventListener('click', () => this.toggleSection('btnCodeSearch', this.codeSearchSection, this.commonSearchSection));
        });
    }

    toggleSection(activeButtonClass, showSection, hideSection) {
        hideSection.style.display = 'none';
        showSection.style.display = '';
        
        document.querySelectorAll('.btnCommonSearch, .btnCodeSearch')
            .forEach(btn => btn.classList.remove('active'));
        
        document.querySelectorAll(`.${activeButtonClass}`)
            .forEach(btn => btn.classList.add('active'));
    }
}


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


class ResultDisplayManager {
    constructor() {
        this.resultSection = document.getElementById("result-section");
        this.elements = {
            referenceMonth: document.getElementById("reference_month"),
            fipeCode: document.getElementById("fipe_code"),
            brand: document.getElementById("brand-result"),
            model: document.getElementById("model-result"),
            year: document.getElementById("year-result"),
            today: document.getElementById("today"),
            carValue: document.getElementById("car_value")
        };
    }

    displayResults(data) {
        if (!data) {
            alert("Nenhum valor encontrado para essa combinação.");
            return;
        }

        this.updateElements(data);
        this.showAndScrollToResults();
    }

    updateElements(data) {
        this.elements.referenceMonth.textContent = data.reference_month || "N/A";
        this.elements.fipeCode.textContent = data.fipe_code || "N/A";
        this.elements.brand.textContent = data.brand || "N/A";
        this.elements.model.textContent = data.model || "N/A";
        this.elements.year.textContent = data.year || "N/A";
        this.elements.today.textContent = DateService.getCurrentDate();
        this.elements.carValue.textContent = data.value ? `R$ ${data.value}` : "N/A";
    }

    showAndScrollToResults() {
        this.resultSection.style.display = "flex";
        this.resultSection.scrollIntoView({ behavior: "smooth" });
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
        this.setCurrentDate();
        if (document.getElementById('codeSearchSection')) {
            this.searchToggleManager = new SearchToggleManager();
        }
        this.formManager = new FormManager();
    }

    static setCurrentDate() {
        const currentDate = DateService.getCurrentMonthYear();
        const elCommon = document.getElementById('currentDateCommon');
        const elCode = document.getElementById('currentDateCode');
        if (elCommon) elCommon.textContent = currentDate;
        if (elCode) elCode.textContent = currentDate;
    }
}

// Inicialização
window.onload = () => App.init();

window.App = App;