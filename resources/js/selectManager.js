// selectManager.js

import Choices from 'choices.js';

class SelectService {
    static async fetchBrands() {
        try {
            const response = await fetch('/api/brands');
            return await response.json();
        } catch (error) {
            console.error("Erro ao carregar as marcas:", error);
            throw error;
        }
    }

    static async fetchModels(brandId) {
        try {
            const response = await fetch(`/api/models/${brandId}`);
            return await response.json();
        } catch (error) {
            console.error("Erro ao carregar os modelos:", error);
            throw error;
        }
    }

    static async fetchYears(modelId) {
        try {
            const response = await fetch(`/api/years/${modelId}`);
            return await response.json();
        } catch (error) {
            console.error("Erro ao carregar os anos:", error);
            throw error;
        }
    }
}

class SelectManager {
    constructor() {
        this.elements = {
            brand: document.getElementById('brandSelect'),
            model: document.getElementById('modelSelect'),
            year: document.getElementById('yearSelect')
        };

        this.choices = {
            brand: null,
            model: null,
            year: null
        };

        this.init();
    }

    init() {
        this.initializeChoices();
        this.setupEventListeners();
        this.loadInitialBrands();
    }

    initializeChoices() {
        const commonConfig = {
            searchEnabled: true,
            itemSelectText: '',
        };

        this.choices.brand = new Choices(this.elements.brand, {
            ...commonConfig,
            placeholderValue: 'Selecione ou digite a marca'
        });

        this.choices.model = new Choices(this.elements.model, {
            ...commonConfig,
            placeholderValue: 'Selecione ou digite o modelo'
        });

        this.choices.year = new Choices(this.elements.year, {
            ...commonConfig,
            placeholderValue: 'Selecione ou digite o ano'
        });
    }

    setupEventListeners() {
        this.elements.brand.addEventListener('change', (e) => this.handleBrandChange(e));
        this.elements.model.addEventListener('change', (e) => this.handleModelChange(e));
    }

    async loadInitialBrands() {
        try {
            const brands = await SelectService.fetchBrands();
            const brandChoices = brands.map(brand => ({
                value: brand.id,
                label: brand.name,
                selected: false
            }));
            
            this.choices.brand.setChoices(brandChoices, 'value', 'label', false);
        } catch (error) {
            this.handleError('Erro ao carregar marcas');
        }
    }

    async handleBrandChange(event) {
        const brandId = event.target.value;
        this.resetModelAndYear();

        if (!brandId) return;

        try {
            const models = await SelectService.fetchModels(brandId);
            const modelChoices = models.map(model => ({
                value: model.id,
                label: model.name
            }));

            this.choices.model.setChoices(modelChoices, 'value', 'label', false);
            this.elements.model.disabled = false;
        } catch (error) {
            this.handleError('Erro ao carregar modelos');
        }
    }

    async handleModelChange(event) {
        const modelId = event.target.value;
        this.resetYear();

        if (!modelId) return;

        try {
            const years = await SelectService.fetchYears(modelId);
            const yearChoices = years.map(year => {
                const label = year.year === 0 ? `0km` : `${year.year}`;
                return { value: year.year, label };
            });

            this.choices.year.setChoices(yearChoices, 'value', 'label', false);
            this.elements.year.disabled = false;
        } catch (error) {
            this.handleError('Erro ao carregar anos');
        }
    }

    resetModelAndYear() {
        this.elements.model.disabled = true;
        this.elements.year.disabled = true;
        this.choices.model.clearChoices();
        this.choices.year.clearChoices();
    }

    resetYear() {
        this.elements.year.disabled = true;
        this.choices.year.clearChoices();
    }

    handleError(message) {
        console.error(message);
        // Você pode implementar uma maneira mais elegante de mostrar erros ao usuário
        alert(message);
    }
}

// Exporta para uso global
window.SelectManager = SelectManager;

// Inicializa quando o DOM estiver pronto
document.addEventListener('DOMContentLoaded', () => {
    new SelectManager();
});