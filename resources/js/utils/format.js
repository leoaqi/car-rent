export const formatDate = (date) => {
    if(!date) return ''
    return new Date(date).toLocaleDateString('id-ID', {
        day: 'numeric',
        month: '2-digit',
        year: 'numeric'
    })
}

export const formatCurrency = (amount) => {
    if(!amount) return 'Rp 0'
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(amount)
}

export const formatToIDR = (value) => {
    if (!value) return '';
    const number = parseInt(value.toString().replace(/\D/g, ''));
    return isNaN(number) ? '' : new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(number);
};

export const onlyNumber = (e) => {
    const charCode = e.which ? e.which : e.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        e.preventDefault();
    }
};