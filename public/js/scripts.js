window.onload = function() {
    var months = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
                  'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
    var currentDate = new Date();
    var month = months[currentDate.getMonth()];
    var year = currentDate.getFullYear();

    document.getElementById('currentDateCommon').textContent = month + ' / ' + year;
    document.getElementById('currentDateCode').textContent = month + ' / ' + year;

    const btnCommonSearch = document.querySelectorAll('.btnCommonSearch');
    const btnCodeSearch = document.querySelectorAll('.btnCodeSearch');
    const commonSearchSection = document.getElementById('commonSearchSection');
    const codeSearchSection = document.getElementById('codeSearchSection');

    btnCommonSearch.forEach(button => {
        button.addEventListener('click', function() {
            commonSearchSection.style.display = '';
            codeSearchSection.style.display = 'none';
            toggleActiveClass('btnCommonSearch');
        });
    });

    btnCodeSearch.forEach(button => {
        button.addEventListener('click', function() {
            commonSearchSection.style.display = 'none';
            codeSearchSection.style.display = '';
            toggleActiveClass('btnCodeSearch');
        });
    });

    function toggleActiveClass(buttonClass) {
        btnCommonSearch.forEach(btn => btn.classList.remove('active'));
        btnCodeSearch.forEach(btn => btn.classList.remove('active'));
        document.querySelectorAll('.' + buttonClass).forEach(btn => btn.classList.add('active'));
    }
};


