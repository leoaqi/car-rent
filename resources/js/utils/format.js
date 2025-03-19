export const formatDate = (date) => {
    if(!date) return ''
    return new Date(date).toLocaleDateString('id-ID', {
        day: 'numeric',
        month: '2-digit',
        year: 'numeric'
    })
}

export const formatDateForDB = (date) => {
    if (!date) return '';
    const d = new Date(date);
    return d.getFullYear() + '-' + 
           String(d.getMonth() + 1).padStart(2, '0') + '-' + 
           String(d.getDate()).padStart(2, '0');
}

export const calculateDaysDifference = (startDate, endDate) => {
    if (!startDate || !endDate) return 0;
    const start = new Date(startDate);
    const end = new Date(endDate);
    const diffTime = Math.abs(end - start);
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
    return diffDays+1;
};

export const formatCurrency = (amount) => {
    if(!amount) return 'Rp 0'
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(amount)
}

export const formatToIDR = (value) => {
    if (!value) return 'Rp 0';
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