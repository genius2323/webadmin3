// Inisialisasi flatpickr untuk input tanggal lahir dengan format dd/mm/yyyy
if (window.flatpickr) {
    flatpickr('#inputBirthday', {
        dateFormat: 'd/m/Y',
        allowInput: true,
        maxDate: 'today',
        locale: 'id'
    });
}
