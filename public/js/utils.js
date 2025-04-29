const Utils = {
    formatDateBr(dateString) {
        if (!dateString) return '-';
        const parts = dateString.split('-');
        if (parts.length !== 3) return '-';
        const [year, month, day] = parts;
        return `${day}/${month}/${year}`;
    },

    formatDateDb(dateString) {
        if (!dateString) return '-';
        const parts = dateString.split('/');
        if (parts.length !== 3) return '-';
        const [day, month, year] = parts;
        return `${year}-${month}-${day}`;
    }
};
